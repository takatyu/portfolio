<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // index
    public function index(int $id) {

        $folders = Folder::all();

        return view('tasks/index',
            ['folders' => $folders,
                'current_folder_id' => $id,]);
//         return "Hello world";
    }
}
