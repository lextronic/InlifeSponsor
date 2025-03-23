<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use SerializesModels;

    public $user;

    // Konstruktor untuk menerima user
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Menentukan tampilan email
    public function build()
    {
        return $this->subject('Welcome to Our Platform!')
                    ->view('emails.welcome');  // Tampilan email yang akan digunakan
    }
}
