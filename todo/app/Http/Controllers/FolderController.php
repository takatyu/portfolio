<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Folder;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{

    // フォルダ追加入力画面表示
    public function showCreateForm() {
        return view('folders/create');
    }

    // 送信ボタン - 登録処理
    public function create(CreateFolder $request) {

        $folder = new Folder();
        // タイトルに入力値を代入する.
        $folder->title = $request->title;

        // ユーザに紐づけて保存
        Auth::user()->folders()->save($folder);
//         $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
