<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{

    /**
     * 表示処理
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(int $id) {
        // 全てのフォルダデータを取得
        $folders = Folder::all();

        // 選ばられたフォルダを取得
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得
//         $tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成ページ表示
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showCreateForm(int $id) {

        // タスク作成表示
        return view('tasks/create', [
            'folder_id' => $id,
        ]);
    }

    /**
     * タスク作成処理
     * @param int $id
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(int $id, CreateTask $request) {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        // リダイレクト：タスク一覧ページ
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     *  タスク編集画面
     * @param int $id
     * @param int $task_id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showEditForm(int $id, int $task_id) {

        $task = Task::find($task_id);

        // タスク編集ページ表示
        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     *
     * @param int $id
     * @param int $task_id
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, int $task_id, Request $request) {
        $task = Task::find($task_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // DB更新登録
        $task->save();

        // リダイレクト：タスク一覧ページ
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
