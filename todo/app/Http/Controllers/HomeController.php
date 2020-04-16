<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index() {
        // ログインユーザ取得
        $user = Auth::user();

        // ログインユーザに紐づくフォルダを一つ取得
        $forder = $user->folders()->first();

        if (is_null($forder)) {
            // フォルダが0件の場合、フォルダ新規作成ページへ
            return view('home');
        }

        return redirect()->route('tasks.index', [
            'id' => $forder->id,
        ]);
    }
}
