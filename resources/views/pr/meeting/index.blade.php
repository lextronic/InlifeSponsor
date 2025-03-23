@extends('layouts.app')

@section('title', 'Meeting')

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
                    <th>Jadwal Meeting</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($meetings->isEmpty())
                <tr>
                    <td colspan="4">Libur dulu Ya...</td>
                </tr>
                @else
                @php $number = 1; @endphp
                @foreach($meetings as $meeting)
                <tr>
                <td>{{ $number++ }}</td>
                    <td>{{ $meeting->id }}</td>
                    <td>{{ $meeting->event_name }}</td>
                    <td>
                        @if($meeting->meeting_date && $meeting->meeting_time && $meeting->meeting_location)
                        <div>
                            {{ \Carbon\Carbon::parse($meeting->meeting_date)->translatedFormat('d F Y') }}<br>
                            {{ \Carbon\Carbon::parse($meeting->meeting_time)->translatedFormat('H:i') }}<br>
                            {{ $meeting->meeting_location }}
                        </div>
                        @else
                        Tidak ada jadwal
                        @endif
                    </td>
                    <td>
                        @php
                        // Tentukan status di sini
                        $status = is_null($meeting->catatan_meeting) && is_null($meeting->dokumen_tambahan) && is_null($meeting->benefit)
                        ? 'Menunggu'
                        : 'Review';
                        $status_class = strtolower($status);
                        @endphp
                        <a class="status {{ $status_class }}">
                            {{ $status }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('meeting.show', ['id' => $meeting->id]) }}" class="btn-detail">Review</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection