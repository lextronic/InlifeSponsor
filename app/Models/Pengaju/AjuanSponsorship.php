<?php

namespace App\Models\Pengaju;

use App\Models\Admin\MeetingSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjuanSponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pengaju',
        'event_name',
        'description',
        'event_date',
        'end_date',
        'location',
        'organizer_name',
        'pic_name',
        'pic_email',
        'estimated_participants',
        'phone_number',
        'proposal',
        'id_pr',
        'meeting_date',
        'meeting_time',
        'meeting_location',
        'catatan_meeting',
        'dokumen_tambahan',
        'benefit',
        'dokumen_dokumentasi',
        'alasan_banding',
        'signature_path',
        'signature_PR',
        'mou_path',
    ];

    // Untuk text
    public function getStatusAttribute()
    {
        if ($this->is_approved) {
            return 'Diterima';
        } elseif ($this->is_rejected) {
            return 'Ditolak';
        } elseif ($this->is_banding) {
            return 'Banding';
        } elseif ($this->is_review) {
            return 'Review';
        } elseif ($this->is_aktif) {
            return 'Aktif';
        } elseif ($this->is_done) {
            return 'Selesai';
        } else {
            return 'Menunggu';
        }
    }

    public function getStatusClassAttribute()
    {
        if ($this->is_approved) {
            return 'diterima';
        } elseif ($this->is_rejected) {
            return 'ditolak';
        } elseif ($this->is_banding) {
            return 'banding';
        } elseif ($this->is_review) {
            return 'review';
        } elseif ($this->is_aktif) {
            return 'aktif';
        } elseif ($this->is_done) {
            return 'menunggu';
        } else {
            return 'menunggu';
        }
    }

    // Relasi ke model Pengaju
    public function pengaju()
    {
        return $this->belongsTo(User::class, 'id_pengaju', 'id'); // Foreign key & owner key
    }

    public function pr()
    {
        return $this->belongsTo(User::class, 'id_pr', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengaju'); // sesuaikan dengan nama kolom yang menghubungkan pengaju
    }

    public function meetingSchedule()
{
    return $this->belongsTo(MeetingSchedule::class, 'meeting_schedule_id');
}

}
