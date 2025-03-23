@extends('layouts.app')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="card" style="border-radius: 10px; padding: 20px;">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;"><a href="{{ route('arsip.index') }}"><img src="/image/btn-back.svg" alt="Back Button" class="btn-back" style="margin-right:20px;"></a> {{ $pengajuan->event_name }}</h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="status {{ strtolower($pengajuan->status_class )}}" style="padding: 5px 10px; font-size: 14px;">{{ $pengajuan->status }}</span>
                <a href="{{ asset('storage/' . $pengajuan->proposal) }}" target="_blank" class="btn-proposal">
                    <img src="/image/lihat-proposal.svg" alt="Lihat Proposal" style="width: 25px; height: 25px; margin-right: 5px;">
                    Lihat Proposal
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="card-body" style="margin-top: 10px;">
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Nama Penyelenggara:</strong>
                <p>{{ $pengajuan->organizer_name }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Tanggal Pelaksanaan:</strong>
                <p style="display:flex;">{{ \Carbon\Carbon::parse($pengajuan->event_date)->translatedFormat('d F Y') }}<strong style="margin-left: 10px; margin-right:10px;">s/d</strong>{{ \Carbon\Carbon::parse($pengajuan->end_date)->translatedFormat('d F Y') }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Lokasi:</strong>
                <p>{{ $pengajuan->location }}</p>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Deskripsi:</strong>
                <textarea class="description-box" readonly>{{ $pengajuan->description }}</textarea>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Nama PIC Panitia:</strong>
                <p>{{ $pengajuan->pic_name }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>No. Telepon:</strong>
                <p>{{ $pengajuan->phone_number }}</p>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Jadwal Meeting:</strong>
                @if($pengajuan->meeting_date && $pengajuan->meeting_time && $pengajuan->meeting_location)
                <p>
                    {{ \Carbon\Carbon::parse($pengajuan->meeting_date)->translatedFormat('d F Y') }},
                    {{ \Carbon\Carbon::parse($pengajuan->meeting_time)->translatedFormat('H:i') }} WIB
                </p>
                @else
                <p>Tidak ada jadwal meeting.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- CARD ALASAN BANDING -->
    @if (!empty($pengajuan->alasan_banding))
    <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
        <div style="margin-bottom: 15px;">
            <strong>Alasan Banding :</strong>
            <textarea class="description-box" readonly>{{ $pengajuan->alasan_banding }}</textarea>
        </div>
    </div>
    @endif

    <div class="card" style="border-radius: 10px; padding: 20px; margin-top:0;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">Hasil Meeting</h2>
        </div>

        <div class="card-body" style="margin-top: 10px;">
            <input type="hidden" name="status" id="status" value="{{ $pengajuan->is_review ? 'review' : '' }}">

            <div style="margin-bottom: 15px;">
                <label for="catatan"><strong>Catatan Meeting:</strong></label>
                @if ($pengajuan->is_banding)
                <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan meeting di sini..." required>{{ $pengajuan->catatan_meeting }}</textarea>
                @else
                <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan meeting di sini..." readonly>{{ $pengajuan->catatan_meeting }}</textarea>
                @endif
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong style="margin-right: 20px;"> Dokumen Tambahan :</strong>
                @if ($pengajuan->dokumen_tambahan)
                <p>
                    <a href="{{ asset('storage/' . $pengajuan->dokumen_tambahan) }}" target="_blank" class="btn btn-detail">Lihat Dokumen</a>
                </p>
                @else
                <p style="color:grey">Tidak ada dokumen tambahan</p>
                @endif
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px;">
                @php
                $selected_benefits = json_decode($pengajuan->benefit ?? '[]');
                @endphp

                <div style="margin: 15px;">
                    <strong>Benefit :</strong>
                    @if (!empty($selected_benefits))
                    @foreach ($selected_benefits as $benefit)
                    <p>{{ $benefit }}</p>
                    @endforeach
                    @else
                    <p style="color: grey;">Tidak ada benefit yang dipilih</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    @if (!empty($pengajuan->signature_path && $pengajuan->signature_path))
    <div style="display: flex; justify-content:space-between; gap: 10px; margin-right:30px; margin-left:30px">
        <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
            <div style="margin-bottom: 15px; align-items:center; text-align:center;">
                <strong>PR</strong>
                @if($pengajuan->signature_PR)
                <img src="{{ asset('storage/' . $pengajuan->signature_PR) }}" alt="Tanda Tangan PR" style="max-width: 100%; height: auto; display:block;">
                <strong>{{$pengajuan->pr->name}}</strong>
                @else
                <p style="color: grey;">Belum ada tanda tangan.</p>
                @endif
            </div>
        </div>

        <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
            <div style="margin-bottom: 15px; align-items:center; text-align:center;">
                <strong>PIC</strong>
                @if($pengajuan->signature_path)
                <img src="{{ asset('storage/' . $pengajuan->signature_path) }}" alt="Tanda Tangan PR" style="max-width: 100%; height: auto; display:block;">
                <strong>{{$pengajuan->pic_name}}</strong>
                @else
                <p style="color: grey;">Belum ada tanda tangan.</p>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection