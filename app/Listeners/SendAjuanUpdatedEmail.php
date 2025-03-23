<?php

namespace App\Listeners;

use App\Events\AjuanUpdated;
use App\Mail\AjuanUpdatedEmail;
use Illuminate\Support\Facades\Mail;

class SendAjuanUpdatedEmail
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AjuanUpdated  $event
     * @return void
     */
    public function handle(AjuanUpdated $event)
    {
        $ajuan = $event->ajuan;

        // Kirim email kepada pengaju tentang perubahan status atau jadwal
        Mail::to($ajuan->id_pengaju)->send(new AjuanUpdatedEmail($ajuan));
    }
}
