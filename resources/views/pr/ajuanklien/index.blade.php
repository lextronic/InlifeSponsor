@extends('layouts.app')

@section('title', 'Ajuan Klien')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="button-container">
        <button id="review-button" class="btn-ajuan btn-review active" onclick="showReview(); toggleActive('review-button')">Review</button>
        <button id="banding-button" class="btn-ajuan btn-banding" onclick="showBanding(); toggleActive('banding-button')">Banding</button>
        <button id="diterima-button" class="btn-ajuan btn-diterima" onclick="showDiterima(); toggleActive('diterima-button')">Diterima</button>
        <button id="ditolak-button" class="btn-ajuan btn-ditolak" onclick="showDitolak(); toggleActive('ditolak-button')">Ditolak</button>
    </div>

    <!-- Tabel Ajuan Klien Review -->
    <div id="review-requests" class="request-section">
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $number = 1; @endphp
                    @foreach ($pengajuanReview as $pengajuan)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class )}}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('ajuanklien.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Ajuan Klien Banding-->
    <div id="banding-requests" class="request-section">
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $number = 1; @endphp
                    @foreach ($pengajuanBanding as $pengajuan)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class )}}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('ajuanklien.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Ajuan Klien Diterima-->
    <div id="diterima-requests" class="request-section">
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $number = 1; @endphp
                    @foreach ($pengajuanDiterima as $pengajuan)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class )}}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('ajuanklien.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                            <button type="button" onclick="showTTDPopup(event)" class="btn btn-detail" style="background-color:#0FC821; margin-left:10px;">TTD</button>

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
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <!-- Tabel Ajuan Klien Ditolak-->
    <div id="ditolak-requests" class="request-section">
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $number = 1; @endphp
                    @foreach ($pengajuanDitolak as $pengajuan)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class )}}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('ajuanklien.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showReview() {
        document.getElementById('review-requests').style.display = 'block';
        document.getElementById('banding-requests').style.display = 'none';
        document.getElementById('diterima-requests').style.display = 'none';
        document.getElementById('ditolak-requests').style.display = 'none';
    }

    function showBanding() {
        document.getElementById('review-requests').style.display = 'none';
        document.getElementById('banding-requests').style.display = 'block';
        document.getElementById('diterima-requests').style.display = 'none';
        document.getElementById('ditolak-requests').style.display = 'none';
    }

    function showDiterima() {
        document.getElementById('review-requests').style.display = 'none';
        document.getElementById('banding-requests').style.display = 'none';
        document.getElementById('diterima-requests').style.display = 'block';
        document.getElementById('ditolak-requests').style.display = 'none';
    }

    function showDitolak() {
        document.getElementById('review-requests').style.display = 'none';
        document.getElementById('banding-requests').style.display = 'none';
        document.getElementById('diterima-requests').style.display = 'none';
        document.getElementById('ditolak-requests').style.display = 'block';
    }

    window.onload = function() {
        showReview();
    };

    function toggleActive(buttonId) {
        const buttons = document.querySelectorAll('.btn-ajuan');
        buttons.forEach(button => {
            button.classList.remove('active');
        });

        // Mengaktifkan tombol yang dipilih
        const activeButton = document.getElementById(buttonId);
        document.getElementById(buttonId).classList.add('active');
    }

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

    // Fungsi untuk menutup popup
    function closePopup() {
        document.getElementById('signature-modal').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
    }
</script>
@endsection