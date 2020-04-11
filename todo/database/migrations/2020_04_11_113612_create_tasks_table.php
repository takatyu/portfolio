<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * タスクテーブル
 * @author tk
 */
class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('folder_id')->unsigned();
            $table->string('title', 100);
            $table->integer('status')->default(1);
            $table->date('due_date');
            $table->timestamps();

            // 外部キー制約を設定する
            // タスクT.フォルダID +<-> フォルダT.ID
            $table->foreign('folder_id')->references('id')->on('folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
