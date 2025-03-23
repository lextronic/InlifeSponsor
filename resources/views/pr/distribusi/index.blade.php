@extends('layouts.app')

@section('title', 'distribusi')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="container-table">
        <table class="table-custom" style="background-color: white;">
            <thead>
                <tr>
                <th>No.</th>
                    <th>ID</th>
                    <th>Nama Event</th>
                    <th>Distribusi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php $number = 1; @endphp
                @foreach($distribusi as $kerjasama)
                <tr>
                <td>{{ $number++ }}</td>
                    <td>{{ $kerjasama->id }}</td>
                    <td>{{ $kerjasama->event_name }}</td>
                    <td>

                        <div style="display: flex; align-items: center;">
                            <div style="width: 100%; background-color: #f3f3f3; border-radius: 5px; overflow: hidden; position: relative;">
                                <div style="background-color: #4caf50; height: 20px; width:<?php echo $kerjasama->progress; ?>%;"></div>
                            </div>
                            <span style="margin-left: 10px;">{{ $kerjasama->progress }}%</span>
                        </div>
                    </td>
                    <td>
                        <a class="status {{ strtolower($kerjasama->status_class )}}">
                            {{ $kerjasama->status }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('distribusi.show', ['id' => $kerjasama->id]) }}" class="btn-detail">Review</a>
                        <a type="button" data-url="{{ route('mou.preview', ['id' => $kerjasama->id]) }}" data-id="{{ $kerjasama->id }}" class="btn-detail" onclick="showMouPreview(event)" style="cursor: pointer;">MOU</a>
                        @if($kerjasama->progress == 100)
                        <button type="button" onclick="showSelesaiPopup(event)" class="btn btn-detail" style="background-color:#0FC821; margin-left:10px;">Selesai</button>
                        @else
                        <button type="button" onclick="showSelesaiPopup(event)" class="btn btn-custom" style="background-color: #C5C5CF;" disabled>Selesai</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($distribusi as $kerjasama)
    <div id="popupKonfirmasiSelesai" class="popup">
        <div class="popup-content">
            <p>Apakah semua distribusi benefit sudah diberikan kepada PIC?</p>
            <div class="popup-buttons">
                <button class="btn-kembali" onclick="closePopup()">Kembali</button>
                <form action="{{ route('distribusi.selesai', ['id' => $kerjasama->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" class="btn-ya">Ya</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <div id="popupMouPreview" class="popup-preview">
        <div class="popup-content-preview">
            <h3>Preview MOU</h3>
            <iframe id="mouPreviewIframe" src="" width="500px" height="500px" style="border: none;"></iframe>
            <div class="popup-buttons">
                <button class="btn-kembali" onclick="closePreviewPopup()">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk menutup popup
    function closePopup() {
        document.getElementById('popupKonfirmasiSelesai').style.display = 'none';
        document.getElementById('popup-overlay').style.display = 'none';
        document.getElementById('popupMouPreview').style.display = 'none';

    }

    function showSelesaiPopup(event) {
        event.preventDefault();
        document.getElementById('popupKonfirmasiSelesai').style.display = 'block';
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