<?php

namespace App\Mail;

use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalMeetingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(AjuanSponsorship $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function build()
    {
        return $this->from('no-reply@example.com') // Set the sender's email
                    ->subject('Jadwal Meeting Sponsorship')
                    ->view('emails.jadwal_meeting');
    }
}
