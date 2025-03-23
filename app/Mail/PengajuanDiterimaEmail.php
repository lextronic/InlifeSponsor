<?php

namespace App\Mail;

use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanDiterimaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(AjuanSponsorship $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function build()
    {
        return $this->subject('Pengajuan Sponsorship Anda Diterima')
                    ->view('emails.pengajuan_diterima'); // Sesuaikan dengan nama view email Anda
    }
}
