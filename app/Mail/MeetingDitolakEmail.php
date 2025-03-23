<?php

namespace App\Mail;

use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingDitolakEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(AjuanSponsorship $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function build()
    {
        return $this->subject('Meeting Ditolak')
                    ->view('emails.meeting_ditolak')
                    ->with(['pengajuan' => $this->pengajuan]);
    }
}
