@extends('layouts.app')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="card" style="border-radius: 10px; padding: 20px;">
        <!-- Header -->
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;"><a href="{{ route('distribusi.index') }}"><img src="/image/btn-back.svg" alt="Back Button" class="btn-back" style="margin-right:20px;"></a> {{ $pengajuan->event_name }}</h2>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="status {{ strtolower($pengajuan->status_class )}}" style="padding: 5px 10px; font-size: 14px;">{{ $pengajuan->status }}</span>
                <a href="{{ asset('storage/' . $pengajuan->proposal) }}" target="_blank" class="btn-proposal">
                    <img src="/image/lihat-proposal.svg" alt="Lihat Proposal" style="width: 25px; height: 25px; margin-right: 5px;">
                    Lihat Proposal
                </a>
                <a type="button" data-url="{{ route('mou.preview', ['id' => $pengajuan->id]) }}" data-id="{{ $pengajuan->id }}" onclick="showMouPreview(event)" class="btn-proposal" style="cursor:pointer;">
                    <img src="/image/lihat-proposal.svg" alt="Lihat Proposal" style="width: 25px; height: 25px; margin-right: 5px;">
                    Lihat MoU
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
        </div>
    </div>

    <div class="card" style="border-radius: 10px; padding: 20px; margin-top:0;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: bold; margin: 0; display:flex;">Benefit</h2>
        </div>

        <div class="card-body" style="margin-top: 10px;">
            @php
            $selected_benefits = json_decode($pengajuan->benefit ?? '[]');
            $uploaded_docs = json_decode($pengajuan->dokumentasi_distribusi ?? '[]', true);
            @endphp

            <div class="benefit-list">
                @if (!empty($selected_benefits))
                @foreach ($selected_benefits as $key => $benefit)
                <div class="card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        @php
                        $isUploaded = isset($uploaded_docs[$benefit]) && !empty($uploaded_docs[$benefit]);
                        @endphp

                        <div>
                            @if ($isUploaded)
                            <span style="color: green; font-size: 18px;">✔</span>
                            @else
                            <span style="color: red; font-size: 18px;">✖</span>
                            @endif
                            <label for="benefit_{{ $key }}" style="font-size: 16px; font-weight: bold;">{{ $benefit }}</label>
                        </div>

                        @if ($isUploaded)
                        <!-- Show "Lihat Dokumentasi" button if documentation is uploaded -->
                        <a href="{{ asset('storage/' . $uploaded_docs[$benefit]) }}" target="_blank" class="btn btn-success btn-sm" style="padding: 5px 10px;">
                            Lihat Dokumentasi
                        </a>
                        @else
                        <!-- Show "Upload Dokumentasi" button if no documentation is uploaded -->
                        <button class="btn btn-primary btn-sm" style="padding: 5px 10px;" onclick="uploadDokumentasi('{{ $benefit }}')">
                            Upload Dokumentasi
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                <p style="color: grey;">Tidak ada benefit yang dipilih</p>
                @endif
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

    <div id="popupMouPreview" class="popup-preview">
        <div class="popup-content-preview">
            <h3>Preview MOU</h3>
            <iframe id="mouPreviewIframe" src="" width="500px" height="500px" style="border: none;"></iframe>
            <div class="popup-buttons">
                <button class="btn-kembali" onclick="closePreviewPopup()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal untuk Input Nama Penerima dan Unggah Dokumen -->

    <div class="modal-custom" id="uploadDokumentasiModal">
        <div class="modal-dialog-custom">
            <div class="modal-content-custom">
                <div class="modal-header-custom">
                    <h5>Unggah Dokumentasi</h5>
                    <button class="close-btn" onclick="closeModal('uploadDokumentasiModal')">&times;</button>
                </div>
                <div class="modal-body-custom">
                    <form id="uploadDokumentasiForm" action="{{ route('pr.uploadDokumentasi') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group-custom">
                            <input type="file" id="dokumen" name="dokumen" accept=".pdf,.doc,.docx,.jpg,.png" required>
                        </div>
                        <input type="hidden" id="benefitKey" name="benefit_key">
                        <input type="hidden" id="pengajuanId" name="pengajuan_id" value="{{ $pengajuan->id }}">
                    </form>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-secondary" onclick="closeModal('uploadDokumentasiModal')">Batal</button>
                    <button type="submit" class="btn-primary" form="uploadDokumentasiForm">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "flex";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    function uploadDokumentasi(benefitKey) {
        document.getElementById('benefitKey').value = benefitKey;
        openModal('uploadDokumentasiModal');
    }

    function showMouPreview(event) {
        event.preventDefault();

        const target = event.currentTarget;
        const url = target.getAttribute('data-url');
        const id = target.getAttribute('data-id');

        document.getElementById('popupMouPreview').style.display = 'block';
        document.getElementById('mouPreviewIframe').src = url;
        document.getElementById('mouPreviewTitle').innerText = 'Preview MOU ID: ' + id;
    }

    function closePreviewPopup() {
        document.getElementById('popupMouPreview').style.display = 'none';
    }
</script>

@endsection