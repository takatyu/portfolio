<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    // index
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
}
