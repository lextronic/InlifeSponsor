@extends('layouts.app')

@section('content')
<div class="main-content" style="margin: 20px;">
    <section>
        <div class="container-dash" style="display: flex; justify-content: space-between;">
            <h1 style="font-size: 18px; margin: 20px; color:#2D60FF;">Jadwal Meeting</h1>
            <a href="{{ route('meeting.index') }}" class="btn-dash" style="display: flex; align-items: center; padding: 10px;">Lihat Semua <img src="/image/panah-kiri.svg"></a>
        </div>
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Jadwal Meeting</th>
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
                            <a href="{{ route('meeting.show', ['id' => $meeting->id]) }}" class="btn-detail">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="container-dash" style="display: flex; justify-content: space-between;">
            <h1 style="font-size: 18px; margin: 20px; color:#2D60FF;">Kerja Sama Aktif</h1>
            <a href="{{ route('distribusi.index') }}" class="btn-dash" style="display: flex; align-items: center; padding: 10px;">Lihat Semua <img src="/image/panah-kiri.svg"></a>
        </div>
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                    <th>No.</th>
                        <th>ID</th>
                        <th>Nama Event</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    @php $number = 1; @endphp
                        @foreach($distribusi as $kerjasama)
                    <tr>
                    <td>{{ $number++ }}</td>
                        <td>{{ $kerjasama->id }}</td>
                        <td>{{ $kerjasama->event_name }}</td>

                        <td>
                            <a class="status {{ strtolower($kerjasama->status_class )}}">
                                {{ $kerjasama->status }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('distribusi.show', ['id' => $kerjasama->id]) }}" class="btn-detail">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection