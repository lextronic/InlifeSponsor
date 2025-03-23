@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="flex-container" style="margin: 30px; margin-bottom:0; padding:0;">
        <a href="{{ route('ajuan.index') }}"><img src="/image/btn-back.svg" alt="Back Button" class="btn-back"></a>
        <h2 style="font-size: 18px;">Lengkapi data pengajuan sponsorship di bawah ini!</h2>
    </div>

    <div class="form" style="padding: 20px;">
        <form id="ajuanForm" action="{{ route('ajuan.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmSubmission()">
            @csrf
            <div class="form-row" style="display: flex; gap: 20px;">
                <!-- Left Column -->
                <div class="form-column" style="flex: 1;">
                    <div class="form-group">
                        <label for="event_name">Nama Event</label>
                        <input type="text" name="event_name" id="event_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Event</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="event_date">Tanggal Pelaksanaan</label>
                        <div class="date-row" style="display: flex; gap: 10px;">
                            <div class="date-column" style="flex: 1;">
                                <small class="form-text">Mulai</small>
                                <input type="date" name="event_date" id="event_date" class="form-control" required>
                            </div>
                            <div class="date-column" style="flex: 1;">
                                <small class="form-text">Selesai</small>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokasi Acara</label>
                        <input type="text" name="location" id="location" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="estimated_participants">Estimasi Partisipan</label>
                        <input type="number" name="estimated_participants" id="estimated_participants" class="form-control" min="1" required>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column" style="flex: 1;">
                    <div class="form-group">
                        <label for="organizer_name">Nama Penyelenggara</label>
                        <input type="text" name="organizer_name" id="organizer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="proposal">Upload Proposal</label>
                        <input type="file" name="proposal" id="proposal" class="form-control" onchange="validateFileSizeAndType(this)" accept=".pdf,.docx" required>
                        @if(isset($ajuanSponsorship) && $ajuanSponsorship->proposal)
                        <p>Proposal Saat Ini: <a href="{{ asset('storage/' . $ajuanSponsorship->proposal) }}" target="_blank">Lihat Proposal</a></p>
                        @endif
                        <p style="font-size: 12px; color: gray;">Unggah file dalam format PDF atau DOCX (maksimal 2MB).</p>
                        <p id="fileTypeError" style="font-size: 12px; color: red; display: none;">*Format file tidak valid. Hanya PDF atau DOCX.</p>
                        <p id="fileError" style="font-size: 12px; color: red; display: none;">*Ukuran file terlalu besar. Maksimal 2MB.</p>
                    </div>
                    <div class="form-group">
                        <label for="pic_name">Nama PIC Panitia</label>
                        <input type="text" name="pic_name" id="pic_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" required pattern="^\d+$" title="Hanya angka yang diperbolehkan">
                    </div>
                    <div class="form-group">
                        <label for="pic_email">Email PIC</label>
                        <input type="email" name="pic_email" id="pic_email" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-custom" style="background-color:#2D60FF; margin: 20px; width:100%;">Ajukan</button>
        </form>
    </div>
</div>

<script>
    function validateFileSizeAndType(input) {
        const maxSize = 2 * 1024 * 1024; // 2MB dalam byte
        const allowedExtensions = ['pdf', 'docx']; // Ekstensi yang diizinkan
        const file = input.files[0];
        const fileErrorElement = document.getElementById('fileError');
        const fileTypeErrorElement = document.getElementById('fileTypeError');

        // Reset error message
        fileErrorElement.style.display = 'none';
        fileTypeErrorElement.style.display = 'none';

        if (file) {
            // Periksa ukuran file
            if (file.size > maxSize) {
                fileErrorElement.style.display = 'block'; // Tampilkan pesan error ukuran
                input.value = ''; // Reset input file
                return false;
            }

            // Periksa tipe file
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                fileTypeErrorElement.style.display = 'block'; // Tampilkan pesan error tipe
                input.value = ''; // Reset input file
                return false;
            }
        }

        return true; // Lanjutkan jika file valid
    }

    function confirmSubmission() {
        const fileInput = document.getElementById('proposal');
        if (!validateFileSizeAndType(fileInput)) {
            return false; // Batalkan pengiriman jika file tidak valid
        }
        return confirm("Apakah Anda yakin ingin mengajukan sponsorship?"); // Konfirmasi sebelum submit
    }
</script>
@endsection
