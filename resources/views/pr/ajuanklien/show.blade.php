@extends('layouts.app')

@section('title', 'Ajuan Klien')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="card" style="border-radius: 10px; padding: 20px;">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">
                <a href="{{ route('ajuanklien.index') }}">
                    <img src="/image/btn-back.svg" alt="Back Button" class="btn-back" style="margin-right:20px;">
                </a>{{ $pengajuan->event_name }}
            </h2>

            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="status {{ strtolower($pengajuan->status_class )}}" style="padding: 5px 10px; font-size: 14px;">{{ $pengajuan->status }}</span>
                <a href="{{ asset('storage/' . $pengajuan->proposal) }}" target="_blank" class="btn-proposal">
                    <img src="/image/lihat-proposal.svg" alt="Lihat Proposal" style="width: 25px; height: 25px; margin-right: 5px;">
                    Lihat Proposal
                </a>
            </div>
        </div>

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
                @if($pengajuan)
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

    <form method="POST" action="{{ route('banding.setujui', ['id' => $pengajuan->id]) }}" enctype="multipart/form-data">
        @csrf
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
                    $all_benefits = ['Fresh Money', 'Cetak Banner', 'Keuntungan Penjualan By.U', 'Merchandise'];
                    $selected_benefits = json_decode($pengajuan->benefit ?? '[]', true);
                    @endphp
                    
                    <div style="margin: 15px;">
                        <strong>Benefit :</strong>
                    
                        @if ($pengajuan->is_banding)
                        @csrf
                        @foreach ($all_benefits as $benefit)
                        <div style="margin-bottom: 10px;">
                            <input
                                type="checkbox"
                                name="benefits[]"
                                value="{{ $benefit }}"
                                id="benefit_{{ $loop->index }}"
                                {{ in_array($benefit, array_column($selected_benefits, 'name')) ? 'checked' : '' }}
                                onclick="toggleBenefitInputs({{ $loop->index }})">
                            <label for="benefit_{{ $loop->index }}">{{ $benefit }}</label>
                            
                            <div id="benefit_inputs_{{ $loop->index }}" style="display: {{ in_array($benefit, array_column($selected_benefits, 'name')) ? 'block' : 'none' }}; margin-top: 5px;">
                                <input type="number" name="benefit_details[{{ $benefit }}][total]" placeholder="Total Jumlah" class="form-control" value="{{ $selected_benefits[$loop->index]['total'] ?? '' }}">
                                <input type="text" name="benefit_details[{{ $benefit }}][description]" placeholder="Keterangan" class="form-control" value="{{ $selected_benefits[$loop->index]['description'] ?? '' }}">
                            </div>
                        </div>
                        @endforeach
                        @else
                        <!-- Tampilkan daftar benefit jika is_banding = false -->
                        @if (!empty($selected_benefits))
                        @foreach ($selected_benefits as $benefit)
                        <p>{{ $benefit['name'] }} - {{ $benefit['total'] ?? 'N/A' }} ({{ $benefit['description'] ?? 'Tanpa Keterangan' }})</p>
                        @endforeach
                        @else
                        <p style="color: grey;">Tidak ada benefit yang dipilih</p>
                        @endif
                        @endif
                    </div>
                    
                    <script>
                        function toggleBenefitInputs(index) {
                            const checkbox = document.getElementById('benefit_' + index);
                            const inputsDiv = document.getElementById('benefit_inputs_' + index);
                            
                            if (checkbox.checked) {
                                inputsDiv.style.display = 'block';
                            } else {
                                inputsDiv.style.display = 'none';
                                inputsDiv.querySelectorAll('input').forEach(input => input.value = '');
                            }
                        }
                    </script>
        </div>
    </form>

    <div id="popupTolak" class="popup">
        <div class="popup-content">
            <p>Apakah Anda yakin ingin menolak banding sponsorship ini?</p>
            <form id="tolakForm" method="POST" action="{{ route('banding.ditolak', ['id' => $pengajuan->id]) }}">
                @csrf
                <input type="hidden" name="status" id="status" value="{{ $pengajuan->is_rejected ? 'ditolak' : '' }}">
                <textarea name="catatan" id="catatan" hidden>{{ $pengajuan->catatan_meeting }}</textarea>
                <div class="popup-buttons">
                    <button class="btn-kembali" onclick="closePopup()">Kembali</button>
                    <button type="submit" class="btn-ya">Ya</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal TTD -->
    <div id="signature-modal" class="modal-ttd">
        <div style="display: flex; justify-content:space-between; background-color:#516BF4; padding:15px; border-radius: 5px; color:white;">
            <h2>Tanda Tangan</h2>
            <button onclick="closePopup()" style="background-color: transparent; border:none;"><img src="/image/btn-close.svg" style="width: 30px; height:30px; cursor:pointer;"></button>
        </div>
        <form action="{{ route('ttd.store', $pengajuan->id) }}" method="POST">
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


</div>

<script>
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

    function openPopup() {
        document.getElementById('popupTolak').style.display = 'block';
    }


    // Fungsi untuk menutup popup
    function closePopup() {
        document.getElementById('popupTolak').style.display = 'none';
        document.getElementById('signature-modal').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
    }

    // Fungsi untuk submit form
    function submitTolakForm() {
        document.getElementById('tolakForm').submit(); // Form dengan ID "tolakForm"
    }
</script>
@endsection