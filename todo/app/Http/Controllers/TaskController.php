<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\CreateTask;

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
     * タスク作成画面
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showCreateForm(int $id) {

        return view('tasks/create', [
            'folder_id' => $id,
        ]);
    }

    public function create(int $id, CreateTask $request) {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }
}
