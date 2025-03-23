<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    use Queueable;

    public $otp;

    // Konstruktor untuk menerima OTP
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Mengirimkan notifikasi melalui email
    }

    /**
     * Kirim email verifikasi.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verifikasi Email Anda')
                    ->greeting('Halo ' . $notifiable->name)
                    ->line('Kode OTP untuk verifikasi email Anda adalah: ' . $this->otp)
                    ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.')
                    ->action('Verifikasi Email', url('/verify-email/' . $this->otp))
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Kirim notifikasi ke database (opsional).
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function toDatabase($notifiable)
    {
        return [
            'otp' => $this->otp,
        ];
    }
}
