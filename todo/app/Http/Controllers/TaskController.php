<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{

    /**
     * 表示処理
     * @param Folder $folder
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Folder $folder) {

        // 全てのフォルダデータを取得
        $folders = Auth::user()->folders()->get();

        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成ページ表示
     * @param Folder $folder
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showCreateForm() {

        // タスク作成表示
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    /**
     * タスク作成処理
     * @param int $id
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request) {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        // リダイレクト：タスク一覧ページ
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     *  タスク編集画面
     * @param int $id
     * @param int $task_id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showEditForm(Folder $folder, Task $task) {

        // 404エラーチェック
        $this->checkRelation($folder, $task);
        // タスク編集ページ表示
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集ポスト処理
     * @param int $id
     * @param int $task_id
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request) {
        // 404エラーチェック
        $this->checkRelation($folder, $task);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // DB更新登録
        $task->save();

        // リダイレクト：タスク一覧ページ
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    /**
     * フォルダーとタスクIDが違っていたら404エラー
     * @param Folder $folder
     * @param Task $task
     */
    private function checkRelation(Folder $folder, Task $task) {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
