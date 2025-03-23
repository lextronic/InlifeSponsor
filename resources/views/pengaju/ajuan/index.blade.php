@extends('layouts.app')

@section('content')
<div class="main-content">
    <a href="{{ route('ajuan.create') }}" class="btn btn-custom" style="background-color:#2D60FF; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        + Buat Ajuan
    </a>

    <div class="container-table">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID</th>
                    <th>Nama Event</th>
                    <th>Jadwal Meeting</th>
                    <th>Hasil Meeting</th>
                    <th>Status</th>
                    <th>Email PIC</th>
                    <th>Estimasi Partisipan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $number = 1; @endphp
                @foreach($ajuan as $pengajuan)
                <tr>
                    <td>{{ $number++ }}</td>
                    <td>{{ $pengajuan->id }}</td>
                    <td>{{ $pengajuan->event_name }}</td>
                    <td>
                        @if($pengajuan->meeting_date && $pengajuan->meeting_time && $pengajuan->meeting_location)
                        <div>
                            <strong>{{ $pengajuan->pr->name ?? 'N/A' }}</strong><br>
                            {{ \Carbon\Carbon::parse($pengajuan->meeting_date)->translatedFormat('d M Y') }}<br>
                            {{ \Carbon\Carbon::parse($pengajuan->meeting_time)->translatedFormat('H:i') }}<br>
                            {{ $pengajuan->meeting_location }}
                        </div>
                        @else
                        <span class="text-muted">Tidak ada jadwal</span>
                        @endif
                    </td>
                    <td>
                        @if(!empty($pengajuan->catatan_meeting))
                        <span style="color: green; font-weight: bold;">&#10004;</span> <!-- Checklist Hijau -->
                        @else
                        <span style="color: red;">&#10008;</span> <!-- Silang Merah -->
                        @endif
                    </td>
                    <td>
                        <span class="status {{ strtolower($pengajuan->status_class) }}">
                            {{ $pengajuan->status }}
                        </span>
                    </td>
                    <td>{{ $pengajuan->pic_email ?? 'N/A' }}</td>
                    <td>{{ $pengajuan->estimated_participants ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('ajuan.show', $pengajuan->id) }}" class="btn-detail">Lihat Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
