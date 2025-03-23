@extends('layouts.app')

@section('title', 'Ajuan Masuk')

@section('content')

<div class="main-content">

    <div class="button-container">
        <button id="new-button" class="btn btn-custom active" style="border-radius:50px; margin-right:5px;" onclick="showNew(); toggleActive('new-button')">Baru</button>
        <button id="in-progress-button" class="btn btn-custom" style="border-radius:50px;" onclick="showInProgress(); toggleActive('in-progress-button')">Diproses</button>
    </div>

    <!-- Tabel Ajuan Baru -->
    <div id="new-requests" class="request-section">
        <div class="container-table" style="margin-top: 0;">
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
                    @foreach ($ajuan as $pengajuan)
                    @if (!$pengajuan->is_approved && !$pengajuan->is_rejected && !$pengajuan->is_banding && !$pengajuan->is_review)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class) }}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('detailajuan.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Ajuan Diproses -->
    <div id="in-progress-requests" class="request-section" style="display: none;">
        <div class="container-table" style="margin-top: 0;">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Penyelenggara</th>
                        <th>Status</th>
                        <th>Jadwal Meeting</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @php $number = 1; @endphp
                    @foreach ($ajuan as $pengajuan)
                    @if ($pengajuan->is_approved || $pengajuan->is_banding || $pengajuan->is_review)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $pengajuan->id }}</td>
                        <td>{{ $pengajuan->event_name }}</td>
                        <td>{{ $pengajuan->organizer_name }}</td>
                        <td>
                            <a class="status {{ strtolower($pengajuan->status_class) }}">
                                {{ $pengajuan->status }}
                            </a>
                        </td>
                        <td>
                            @if($pengajuan->meeting_date && $pengajuan->meeting_time && $pengajuan->meeting_location)
                            <div>
                                <strong>{{ $pengajuan->pr->name }}</strong><br>
                                {{ \Carbon\Carbon::parse($pengajuan->meeting_date)->translatedFormat('d M Y') }}<br>
                                {{ \Carbon\Carbon::parse($pengajuan->meeting_time)->translatedFormat('H:i') }}<br>
                                {{ $pengajuan->meeting_location}}
                            </div>
                            @else
                            Tidak ada jadwal
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('detailajuan.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showNew() {
        document.getElementById('new-requests').style.display = 'block';
        document.getElementById('in-progress-requests').style.display = 'none';
    }

    function showInProgress() {
        document.getElementById('new-requests').style.display = 'none';
        document.getElementById('in-progress-requests').style.display = 'block';
    }

    window.onload = function() {
        showNew();
    };

    function toggleActive(buttonId) {
        const buttons = document.querySelectorAll('.btn-custom');
        buttons.forEach(button => {
            button.classList.remove('active');
        });

        const activeButton = document.getElementById(buttonId);
        activeButton.classList.add('active');
    }
</script>
@endsection