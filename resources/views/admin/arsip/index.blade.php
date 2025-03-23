@extends('layouts.app')

@section('title', 'Ajuan Masuk')

@section('content')

<div class="main-content">

    <div class="button-container">
        <button id="done-button" class="btn btn-custom active" style="border-radius:50px; margin-right:5px;" onclick="showDone(); toggleActive('done-button')">Selesai</button>
        <button id="rejected-button" class="btn btn-custom" style="border-radius:50px;" onclick="showRejected(); toggleActive('rejected-button')">Ditolak</button>
    </div>

    <!-- Tabel Ajuan selesai -->
    <div id="done-requests" class="request-section">
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
                    @foreach ($ajuanDone as $pengajuan)
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
                            <a href="{{ route('arsip.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Ajuan ditolak -->
    <div id="rejected-requests" class="request-section" style="display: none;">
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
                    @foreach ($ajuanDitolak as $pengajuan)
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
                            <a href="{{ route('arsip.show', ['id' => $pengajuan->id]) }}" class="btn-detail">Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showDone() {
        document.getElementById('done-requests').style.display = 'block';
        document.getElementById('rejected-requests').style.display = 'none';
    }

    function showRejected() {
        document.getElementById('done-requests').style.display = 'none';
        document.getElementById('rejected-requests').style.display = 'block';
    }

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