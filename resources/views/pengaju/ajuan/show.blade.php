@extends('layouts.app')

@section('content')
<div class="main-content">

    <div class="card" style="border-radius: 10px; padding: 20px;">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">
                <a href="{{ route('ajuan.index') }}">
                    <img src="/image/btn-back.svg" alt="Back Button" class="btn-back" style="margin-right:20px;">
                </a> {{ $ajuan->event_name }}
            </h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="status {{ strtolower($ajuan->status_class )}}" style="padding: 5px 10px; font-size: 14px;">{{ $ajuan->status }}</span>
                <a href="{{ asset('storage/' . $ajuan->proposal) }}" target="_blank" class="btn-proposal">
                    <img src="/image/lihat-proposal.svg" alt="Lihat Proposal" style="width: 25px; height: 25px; margin-right: 5px;">
                    Lihat Proposal
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="card-body" style="margin-top: 10px;">
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Nama Penyelenggara:</strong>
                <p>{{ $ajuan->organizer_name }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Tanggal Pelaksanaan:</strong>
                <p style="display:flex;">{{ \Carbon\Carbon::parse($ajuan->event_date)->translatedFormat('d F Y') }}<strong style="margin-left: 10px; margin-right:10px;">s/d</strong>{{ \Carbon\Carbon::parse($ajuan->end_date)->translatedFormat('d F Y') }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>Lokasi:</strong>
                <p>{{ $ajuan->location }}</p>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Deskripsi:</strong>
                <textarea class="description-box" readonly>{{ $ajuan->description }}</textarea>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Nama PIC Panitia:</strong>
                <p>{{ $ajuan->pic_name }}</p>
            </div>
            <div style="margin-bottom: 15px; display:flex;">
                <strong>No. Telepon:</strong>
                <p>{{ $ajuan->phone_number }}</p>
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex;">
                <strong>Jadwal Meeting:</strong>
                @if($ajuan->meeting_date && $ajuan->meeting_time && $ajuan->meeting_location)
                <p>
                    {{ \Carbon\Carbon::parse($ajuan->meeting_date)->translatedFormat('d F Y') }},
                    {{ \Carbon\Carbon::parse($ajuan->meeting_time)->translatedFormat('H:i') }} WIB
                </p>
                @else
                <p>-</p>
                @endif
            </div>
        </div>
    </div>

    <!-- CARD ALASAN BANDING -->
    @if (!empty($ajuan->alasan_banding))
    <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
        <div style="margin-bottom: 15px;">
            <strong>Alasan Banding :</strong>
            <textarea class="description-box" readonly>{{ $ajuan->alasan_banding }}</textarea>
        </div>
    </div>
    @endif

    @if ($ajuan->catatan_meeting || $ajuan->dokumen_tambahan || $ajuan->benefit)
    <div class="card" style="border-radius: 10px; padding: 20px; margin-top:0;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">Hasil Meeting</h2>
        </div>

        <div class="card-body" style="margin-top: 10px;">
            <div style="margin-bottom: 15px;">
                <label for="catatan"><strong>Catatan Meeting:</strong></label>
                @if($ajuan->catatan_meeting)
                <textarea class="description-box" readonly>{{ $ajuan->catatan_meeting }}</textarea>
                @else
                <p style="color:grey">Tidak ada catatan meeting</p>
                @endif
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px; display:flex; margin-top:15px; align-items:center;">
                <strong style="margin-right: 20px;"> Dokumen Tambahan :</strong>
                @if ($ajuan->dokumen_tambahan)
                <p>
                    <a href="{{ asset('storage/' . $ajuan->dokumen_tambahan) }}" target="_blank" class="btn btn-detail">Lihat Dokumen</a>
                </p>
                @else
                <p style="color:grey">Tidak ada dokumen tambahan</p>
                @endif
            </div>

            <div class="card-separator"></div>

            <div style="margin-bottom: 15px;">
                @php
                $selected_benefits = json_decode($ajuan->benefit ?? '[]');
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
    @endif

    <!-- TANDA TANGAN -->
    @if (!empty($ajuan->signature_path && $ajuan->signature_path))
    <div style="display: flex; justify-content:space-between; gap: 10px; margin-right:30px; margin-left:30px">
        <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
            <div style="margin-bottom: 15px; align-items:center; text-align:center;">
                <strong>PR</strong>
                @if($ajuan->signature_PR)
                <img src="{{ asset('storage/' . $ajuan->signature_PR) }}" alt="Tanda Tangan PR" style="max-width: 100%; height: auto; display:block;">
                <strong>{{$ajuan->pr->name}}</strong>
                @else
                <p style="color: grey;">Belum ada tanda tangan.</p>
                @endif
            </div>
        </div>

        <div class="card" style="margin-top:0; border-radius: 10px; padding: 20px;">
            <div style="margin-bottom: 15px; align-items:center; text-align:center;">
                <strong>PIC</strong>
                @if($ajuan->signature_path)
                <img src="{{ asset('storage/' . $ajuan->signature_path) }}" alt="Tanda Tangan PR" style="max-width: 100%; height: auto; display:block;">
                <strong>{{$ajuan->pic_name}}</strong>
                @else
                <p style="color: grey;">Belum ada tanda tangan.</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- BUTTON -->
    @if ($ajuan->catatan_meeting && $ajuan->benefit && !$ajuan->is_approved && !$ajuan->is_banding && !$ajuan->is_rejected)
    <div class="action-buttons" style="margin-left:20px; margin-bottom:30px;">
        <!-- Tombol Tolak -->
        <button class="btn btn-custom" onclick="showTolakPopup(event)" style="background-color:#FF0000; margin-right:0;">Tolak</button>

        <!-- Modal Tolak -->
        <div id="popupTolak" class="popup">
            <div class="popup-content">
                <p>Apakah Anda yakin ingin menolak sponsorship ini?</p>
                <div class="popup-buttons">
                    <button class="btn-kembali" onclick="closePopup()">Kembali</button>
                    <form action="{{ route('pengajuan.update.status', ['id' => $ajuan->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="status" value="ditolak">
                        <button type="submit" class="btn-ya">Ya</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tombol Terima -->
        <button type="button" onclick="showTTDPopup(event)" class="btn btn-custom" style="background-color:#0FC821; margin-right:0;">Terima</button>

        <!-- Modal Terima/TTD -->
        <div id="signature-modal" class="modal-ttd">
            <div style="display: flex; justify-content:space-between; background-color:#516BF4; padding:15px; border-radius: 5px; color:white;">
                <h2>Tanda Tangan</h2>
                <button onclick="closePopup()" style="background-color: transparent; border:none;"><img src="/image/btn-close.svg" style="width: 30px; height:30px; cursor:pointer;"></button>
            </div>
            <form action="{{ route('pengajuans.signature.store', $ajuan->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <canvas id="signatureCanvas"></canvas>
                    <input type="hidden" name="signature" id="signatureInput">
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="clearSignature()" style="margin-right: 15px;">Bersih</button>
                    <button type="submit" class="btn btn-success" onclick="saveSignature()" style="background-color: #0FC821;">Lanjut Terima</button>
                </div>
            </form>
        </div>

        <!-- Tombol Banding -->
        @if (!empty($ajuan->alasan_banding))
        <!-- button tidak ditampilkan jika alasan banding sudah ada/ pengaju sudah pernah banding -->
        @else
        <button type="button" onclick="showBandingPopup(event)" class="btn btn-custom" style="background-color:orange; margin-right:10px;">Banding</button>

        @endif

        <!-- Modal Alasan Banding -->
        <div id="banding-modal" class="modal-ttd">
            <form method="POST" action="{{ route('pengajuan.update.status', ['id' => $ajuan->id]) }}">
                @csrf
                <input type="hidden" name="status" value="banding">
                <div style="display: flex; justify-content:space-between; background-color:#516BF4; padding:15px; border-radius: 5px; color:white;">
                    <h2>Masukkan Alasan Banding Anda</h2>
                    <button onclick="closePopup()" style="background-color: transparent; border:none;"><img src="/image/btn-close.svg" style="width: 30px; height:30px; cursor:pointer;"></button>
                </div>
                <textarea name="alasan" rows="4" cols="50" placeholder="Tambahkan alasan banding di sini..." class="form-control" style="margin-top:30px;" required></textarea>
                <div class="form-buttons" style=" justify-content:center; background-color:transparent; padding:10px;">
                    <button type="submit" class="btn btn-custom" style="background-color:orange; width:100%;">Ajukan Banding</button>
                </div>
            </form>
        </div>
        <div id="popup-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
    </div>

    @endif
</div>


<script>
    // Tombol Banding
    function showBandingPopup(event) {
        event.preventDefault(); // Mencegah form dikirim
        document.getElementById('banding-modal').style.display = 'block';
        document.getElementById('popup-overlay').style.display = 'block';
    }

    // Klik pada overlay untuk menutup modal
    document.getElementById('popup-overlay').addEventListener('click', () => {
        document.getElementById('banding-modal').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('signature-modal').style.display = 'none';
    });

    //TTD
    function showTTDPopup(event) {
        event.preventDefault();
        const modal = document.getElementById('signature-modal');
        const overlay = document.getElementById('popup-overlay');
        modal.style.display = 'block';
        overlay.style.display = 'block';

        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');

        // Tetapkan ukuran kanvas secara eksplisit
        const fixedWidth = 500; // Lebar tetap
        const fixedHeight = 300; // Tinggi tetap
        canvas.width = fixedWidth;
        canvas.height = fixedHeight;
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Hapus konten lama
    }


    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    canvas.addEventListener('mousedown', () => {
        isDrawing = true;
    });
    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
        ctx.beginPath();
    });
    canvas.addEventListener('mousemove', draw);

    function draw(event) {
        if (!isDrawing) return;

        // Hitung posisi mouse relatif terhadap canvas
        const rect = canvas.getBoundingClientRect();
        const x = (event.clientX - rect.left) * (canvas.width / rect.width);
        const y = (event.clientY - rect.top) * (canvas.height / rect.height);

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = 'black';

        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }

    function saveSignature() {
        const signatureData = canvas.toDataURL('image/png');
        document.getElementById('signatureInput').value = signatureData;
    }

    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function showTolakPopup(event) {
        event.preventDefault();
        document.getElementById('popupTolak').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popupTolak').style.display = 'none';
        document.getElementById('signature-modal').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('banding-modal').style.display = 'none';
    }
</script>
@endsection