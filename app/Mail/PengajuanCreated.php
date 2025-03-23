<?php

namespace App\Mail;

use App\Models\Pengaju\AjuanSponsorship; // Ganti dengan namespace model yang sesuai
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanCreated extends Mailable
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
                    ->view('emails.pengajuan_created')
                    ->subject('Pengajuan Baru Diajukan')
                    ->with(['pengajuan' => $this->pengajuan]);
    }
}
