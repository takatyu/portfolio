<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * フォルダーTBのリレーショナル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function folders() {
        return $this->hasMany('App\Folder');
    }

    /**
     * パスワード再生設定するメール送信メソッド
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\CanResetPassword::sendPasswordResetNotification()
     */
    public function sendPasswordResetNotification($token) {
        Mail::to($this)->send(new ResetPassword($token)) ;
    }
}
