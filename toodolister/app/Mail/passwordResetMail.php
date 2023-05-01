<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class passwordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailarray)
    {
        $this->mailarray = $mailarray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->mailarray['mail']) //送信先アドレス
        ->subject('パスワード再設定のご連絡') //件名
        ->view('mail.password_mail') //本文　作成したブレード
        ->from('info@createengineer.sakura.ne.jp','') //メールの差出人テキスト（この人からメールが来ましたーの部分）
        ->with(['mailarray' => $this->mailarray]); //本文に送る値
    }
}
