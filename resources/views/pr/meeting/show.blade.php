@extends('layouts.app')

@section('title', 'Meeting')

@section('content')
<!-- konten utama -->
<!-- MENAMPILKAN DETAIL AJUAN -->
<div class="main-content">
    <div class="card" style="border-radius: 10px; padding: 20px;">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">
                <a href="{{ route('meeting.index') }}">
                    <img src="/image/btn-back.svg" alt="Back Button" class="btn-back" style="margin-right:20px;">
                </a> {{ $pengajuan->event_name }}
            </h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                @php
                $status = is_null($pengajuan->catatan_meeting) && is_null($pengajuan->dokumen_tambahan) && is_null($pengajuan->benefit)
                ? 'Menunggu'
                : 'Review';
                $status_class = strtolower($status);
                @endphp
                <span class="status {{ $status_class }}" style="padding: 5px 10px; font-size: 14px;">{{ $status }}</span>
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

    <!-- INPUTAN HASIL MEETING/ NOTULENSI -->
    <form id="meeting-form" method="POST" action="{{ route('meeting.update', ['id' => $pengajuan->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="card" style="border-radius: 10px; padding: 20px; margin-top:0;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">Hasil Meeting</h2>
            </div>

            <div class="card-body" style="margin-top: 10px;">

                <div style="margin-bottom: 15px;">
                    <label for="catatan"><strong>Catatan Meeting:</strong></label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan meeting di sini..." required>{{ $pengajuan->catatan_meeting }}</textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="dokumen_tambahan"><strong>Dokumen Tambahan:</strong></label>
                    <input type="file" name="dokumen_tambahan" id="dokumen_tambahan" class="form-control">
                    <p style="font-size: 12px; color: gray;">Unggah file dalam format PDF, DOCX, atau lainnya (maksimal 2MB).</p>
                    @if ($pengajuan->dokumen_tambahan)
                    <a href="{{ asset('storage/' . $pengajuan->dokumen_tambahan) }}" target="_blank">Lihat Dokumen</a>
                    @endif
                </div>

                <div class="card-separator"></div>

                <div style="margin-bottom: 15px;">
                    <label for="benefit"><strong>Benefit:</strong></label>
                    <div>
                        <label>
                            <input type="checkbox" name="benefit[]" value="Fresh Money"
                                {{ in_array('Fresh Money', json_decode($pengajuan->benefit ?? '[]')) ? 'checked' : '' }}>
                            Fresh Money
                        </label>
                        <div id="benefit_inputs_0" style="display: none; margin-top: 5px;">
                            <input type="number" name="benefit_details[Fresh Money][total]" placeholder="Total Jumlah" class="form-control">
                            <input type="text" name="benefit_details[Fresh Money][description]" placeholder="Keterangan" class="form-control">
                        </div>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="benefit[]" value="Cetak Banner"
                                {{ in_array('Cetak Banner', json_decode($pengajuan->benefit ?? '[]')) ? 'checked' : '' }}>
                            Cetak Banner
                        </label>
                        <div id="benefit_inputs_1" style="display: none; margin-top: 5px;">
                            <input type="number" name="benefit_details[Cetak Banner][total]" placeholder="Total Jumlah" class="form-control">
                            <input type="text" name="benefit_details[Cetak Banner][description]" placeholder="Keterangan" class="form-control">
                        </div>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="benefit[]" value="Keuntungan Penjualan By.U"
                                {{ in_array('Keuntungan Penjualan By.U', json_decode($pengajuan->benefit ?? '[]')) ? 'checked' : '' }}>
                            Keuntungan Penjualan By.U
                        </label>
                        <div id="benefit_inputs_2" style="display: none; margin-top: 5px;">
                            <input type="number" name="benefit_details[Keuntungan Penjualan By.U][total]" placeholder="Total Jumlah" class="form-control">
                            <input type="text" name="benefit_details[Keuntungan Penjualan By.U][description]" placeholder="Keterangan" class="form-control">
                        </div>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="benefit[]" value="Merchandise"
                                {{ in_array('Merchandise', json_decode($pengajuan->benefit ?? '[]')) ? 'checked' : '' }}>
                            Merchandise
                        </label>
                        <div id="benefit_inputs_3" style="display: none; margin-top: 5px;">
                            <input type="number" name="benefit_details[Merchandise][total]" placeholder="Total Jumlah" class="form-control">
                            <input type="text" name="benefit_details[Merchandise][description]" placeholder="Keterangan" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-left:30px;">
            <p style="color:red; font-size:12px; font-Weight:bold;">*Periksa kembali saat ingin mengirimkan data Anda!</p>
            <input type="hidden" name="status" id="status" value="">
            <button type="button" onclick="rejectSubmission()" class="btn btn-custom" style="background-color: #FF0000;">Tolak</button>
            <button type="submit" onclick="approveSubmission()" class="btn btn-custom" style="background-color: #4CAF50;">Terima</button>
        </div>
    </form>

</div>

<script>
    // Menambahkan event listener untuk menangani fokus pada textarea
    document.getElementById('catatan').addEventListener('focus', function() {
        this.setSelectionRange(0, 0); // Memastikan kursor berada di baris paling atas
    });

    document.querySelectorAll('input[name="benefit[]"]').forEach((checkbox, index) => {
        checkbox.addEventListener('change', function() {
            const inputsDiv = document.getElementById('benefit_inputs_' + index);
            console.log(`Checkbox for ${this.value} is now ${this.checked ? 'checked' : 'unchecked'}`);
            if (this.checked) {
                inputsDiv.style.display = 'block';
                console.log(`Showing inputs for ${this.value}`);
            } else {
                inputsDiv.style.display = 'none';
                inputsDiv.querySelectorAll('input').forEach(input => input.value = '');
                console.log(`Hiding inputs for ${this.value}`);
            }
        });
    });

    function approveSubmission() {
        // Periksa apakah ada checkbox Benefit yang dicentang
        const benefits = document.querySelectorAll('input[name="benefit[]"]:checked');
        if (benefits.length === 0) {
            alert("Harap pilih setidaknya satu opsi Benefit untuk menerima ajuan!");
            return; // Mencegah form dikirim
        }

        // Validasi Catatan Meeting
        const catatan = document.getElementById('catatan').value.trim(); // Menghapus spasi di awal dan akhir
        if (!catatan) { // Jika kosong
            alert("Harap isi Catatan Meeting sebelum menyetujui ajuan!");
            return; // Mencegah form dikirim
        }

        // Jika validasi lulus, ubah status dan submit form
        document.getElementById('status').value = 'is_review';
        document.getElementById('meeting-form').submit();
    }

    function rejectSubmission() {
        // Validasi Catatan Meeting
        const catatan = document.getElementById('catatan').value.trim(); // Menghapus spasi di awal dan akhir
        if (!catatan) { // Jika kosong
            alert("Harap isi Catatan Meeting sebelum menolak ajuan!");
            return; // Mencegah form dikirim
        }

        document.getElementById('status').value = 'is_rejected';
        document.getElementById('meeting-form').submit();
    }
</script>
@endsection
