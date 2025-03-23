@extends('layouts.app')

@section('title', 'Data User')

@section('content')

<!-- konten utama -->
<div class="main-content">

    <div class="button-container" style="background-color: white; border-radius:20px; border-bottom: 2px solid #2D60FF;">
        <button id="admin-button" class="btn btn-custom active" style="border-radius:50px; margin-right:5px;" onclick="showAdmin(); toggleActive('admin-button')">Admin</button>
        <button id="pr-button" class="btn btn-custom" style="border-radius:50px; margin-right:5px;" onclick="showPR(); toggleActive('pr-button')">PR</button>
        <button id="pengaju-button" class="btn btn-custom" style="border-radius:50px; margin-right:5px;" onclick="showPengaju(); toggleActive('pengaju-button')">Pengaju</button>
    </div>

    <!-- Tabel Admin-->
    <div id="admin-requests" class="request-section">
        <div class="button-container-content">
            <button id="tambah-admin-button" class="btn btn-custom" style="background-color:#2D60FF; margin-right:50px; display:flex; gap:20px;" onclick="openModal('admin')">
                <svg width="20" height="20" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20 7.5C20 9.48912 19.2098 11.3968 17.8033 12.8033C16.3968 14.2098 14.4891 15 12.5 15C10.5109 15 8.60322 14.2098 7.1967 12.8033C5.79018 11.3968 5 9.48912 5 7.5C5 5.51088 5.79018 3.60322 7.1967 2.1967C8.60322 0.790176 10.5109 0 12.5 0C14.4891 0 16.3968 0.790176 17.8033 2.1967C19.2098 3.60322 20 5.51088 20 7.5ZM26.875 18.75C27.3723 18.75 27.8492 18.9475 28.2008 19.2992C28.5525 19.6508 28.75 20.1277 28.75 20.625V25H33.125C33.6223 25 34.0992 25.1975 34.4508 25.5492C34.8025 25.9008 35 26.3777 35 26.875C35 27.3723 34.8025 27.8492 34.4508 28.2008C34.0992 28.5525 33.6223 28.75 33.125 28.75H28.75V33.125C28.75 33.6223 28.5525 34.0992 28.2008 34.4508C27.8492 34.8025 27.3723 35 26.875 35C26.3777 35 25.9008 34.8025 25.5492 34.4508C25.1975 34.0992 25 33.6223 25 33.125V28.75H20.625C20.1277 28.75 19.6508 28.5525 19.2992 28.2008C18.9475 27.8492 18.75 27.3723 18.75 26.875C18.75 26.3777 18.9475 25.9008 19.2992 25.5492C19.6508 25.1975 20.1277 25 20.625 25H25V20.625C25 20.1277 25.1975 19.6508 25.5492 19.2992C25.9008 18.9475 26.3777 18.75 26.875 18.75ZM12.5 17.5C16.2325 17.5 19.585 19.1375 21.875 21.7325V21.875H20.625C19.5161 21.874 18.4384 22.2417 17.5614 22.9201C16.6843 23.5986 16.0576 24.5494 15.7799 25.6229C15.5022 26.6964 15.5893 27.8318 16.0274 28.8504C16.4655 29.8691 17.2298 30.7132 18.2 31.25H1.25C0.918479 31.25 0.600537 31.1183 0.366117 30.8839C0.131696 30.6495 0 30.3315 0 30C0 26.6848 1.31696 23.5054 3.66117 21.1612C6.00537 18.817 9.18479 17.5 12.5 17.5Z" fill="white" />
                </svg>
                Tambah
            </button>
        </div>

        <div class="container-table" style="margin-top: 0;">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataAdmin as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <button type="button" class="btn-delete" onclick="showDeletedPopupAdmin(event)">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.66431 7H20.6643M5.66431 7L6.66431 19C6.66431 19.5304 6.87502 20.0391 7.25009 20.4142C7.62517 20.7893 8.13387 21 8.66431 21H16.6643C17.1947 21 17.7034 20.7893 18.0785 20.4142C18.4536 20.0391 18.6643 19.5304 18.6643 19L19.6643 7M9.66431 7V4C9.66431 3.73478 9.76966 3.48043 9.9572 3.29289C10.1447 3.10536 10.3991 3 10.6643 3H14.6643C14.9295 3 15.1839 3.10536 15.3714 3.29289C15.5589 3.48043 15.6643 3.73478 15.6643 4V7M10.6643 12L14.6643 16M14.6643 12L10.6643 16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- modal tambah admin -->
        <div id="addAdminModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2 style="background-color: #2D60FF; text-align:center; padding: 30px; color:white; border-radius:5px">Tambah Admin</h2>
                <form action="{{ route('datauser.add') }}" method="POST">
                    @csrf
                    <div class="form-column" style="margin: 50px;">
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" id="role" class="form-control" style="font-weight: bold; color:black">
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="nameuser" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                    </div>

                    <div class="form-buttons" style="gap: 20px;">
                        <button type="button" class="btn btn-detail" style="background-color: #757575;" onclick="closeModal()" style="margin-right: 15px;">Batal</button>
                        <button type="submit" class="btn btn-detail" style="background-color: #0FC821;">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div id="popupDeletedAdmin" class="popup">
            <div class="popup-content">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="popup-buttons">
                    <button class="btn-kembali" onclick="closePopup()">Kembali</button>
                    <form action="{{ route('datauser.destroy', $admin->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-ya" style="background-color: red;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel PR -->
    <div id="pr-requests" class="request-section" style="display: none;">
        <div class="button-container-content">
            <button id="tambah-admin-button" class="btn btn-custom" style="background-color:#2D60FF; margin-right:50px; display:flex; gap:20px;" onclick="openModal('pr')">
                <svg width="20" height="20" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20 7.5C20 9.48912 19.2098 11.3968 17.8033 12.8033C16.3968 14.2098 14.4891 15 12.5 15C10.5109 15 8.60322 14.2098 7.1967 12.8033C5.79018 11.3968 5 9.48912 5 7.5C5 5.51088 5.79018 3.60322 7.1967 2.1967C8.60322 0.790176 10.5109 0 12.5 0C14.4891 0 16.3968 0.790176 17.8033 2.1967C19.2098 3.60322 20 5.51088 20 7.5ZM26.875 18.75C27.3723 18.75 27.8492 18.9475 28.2008 19.2992C28.5525 19.6508 28.75 20.1277 28.75 20.625V25H33.125C33.6223 25 34.0992 25.1975 34.4508 25.5492C34.8025 25.9008 35 26.3777 35 26.875C35 27.3723 34.8025 27.8492 34.4508 28.2008C34.0992 28.5525 33.6223 28.75 33.125 28.75H28.75V33.125C28.75 33.6223 28.5525 34.0992 28.2008 34.4508C27.8492 34.8025 27.3723 35 26.875 35C26.3777 35 25.9008 34.8025 25.5492 34.4508C25.1975 34.0992 25 33.6223 25 33.125V28.75H20.625C20.1277 28.75 19.6508 28.5525 19.2992 28.2008C18.9475 27.8492 18.75 27.3723 18.75 26.875C18.75 26.3777 18.9475 25.9008 19.2992 25.5492C19.6508 25.1975 20.1277 25 20.625 25H25V20.625C25 20.1277 25.1975 19.6508 25.5492 19.2992C25.9008 18.9475 26.3777 18.75 26.875 18.75ZM12.5 17.5C16.2325 17.5 19.585 19.1375 21.875 21.7325V21.875H20.625C19.5161 21.874 18.4384 22.2417 17.5614 22.9201C16.6843 23.5986 16.0576 24.5494 15.7799 25.6229C15.5022 26.6964 15.5893 27.8318 16.0274 28.8504C16.4655 29.8691 17.2298 30.7132 18.2 31.25H1.25C0.918479 31.25 0.600537 31.1183 0.366117 30.8839C0.131696 30.6495 0 30.3315 0 30C0 26.6848 1.31696 23.5054 3.66117 21.1612C6.00537 18.817 9.18479 17.5 12.5 17.5Z" fill="white" />
                </svg>
                Tambah
            </button>
        </div>

        <div class="container-table" style="margin-top: 0;">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPr as $pr)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pr->name }}</td>
                        <td>{{ $pr->email }}</td>
                        <td>
                            <button type="button" class="btn-delete" onclick="showDeletedPopupPR(event)">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.66431 7H20.6643M5.66431 7L6.66431 19C6.66431 19.5304 6.87502 20.0391 7.25009 20.4142C7.62517 20.7893 8.13387 21 8.66431 21H16.6643C17.1947 21 17.7034 20.7893 18.0785 20.4142C18.4536 20.0391 18.6643 19.5304 18.6643 19L19.6643 7M9.66431 7V4C9.66431 3.73478 9.76966 3.48043 9.9572 3.29289C10.1447 3.10536 10.3991 3 10.6643 3H14.6643C14.9295 3 15.1839 3.10536 15.3714 3.29289C15.5589 3.48043 15.6643 3.73478 15.6643 4V7M10.6643 12L14.6643 16M14.6643 12L10.6643 16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- modal tambah PR -->
        <div id="addPRModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2 style="background-color: #2D60FF; text-align:center; padding: 30px; color:white; border-radius:5px">Tambah PR</h2>
                <form action="{{ route('datauser.add') }}" method="POST">
                    @csrf
                    <div class="form-column" style="margin: 50px;">
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select name="role" id="role" class="form-control" style="font-weight: bold; color:black">
                                <option value="pr">PR</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="nameuser" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-buttons" style="gap: 20px;">
                        <button type="button" class="btn btn-detail" style="background-color: #757575;" onclick="closeModal()" style="margin-right: 15px;">Batal</button>
                        <button type="submit" class="btn btn-detail" style="background-color: #0FC821;">Tambah</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div id="popupDeletedPR" class="popup">
            <div class="popup-content">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="popup-buttons">
                    <button class="btn-kembali" onclick="closePopup()">Kembali</button>
                    <form action="{{ route('datauser.destroy', $pr->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-ya" style="background-color: red;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengaju -->
    <div id="pengaju-requests" class="request-section" style="display: none;">
        <div class="container-table">
            <table class="table-custom" style="background-color: white;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPengaju as $index => $pengaju)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pengaju->name }}</td>
                        <td>{{ $pengaju->email }}</td>
                        <td>{{ $pengaju->level }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showAdmin() {
        document.getElementById('admin-requests').style.display = 'block';
        document.getElementById('pr-requests').style.display = 'none';
        document.getElementById('pengaju-requests').style.display = 'none';
    }

    function showPR() {
        document.getElementById('admin-requests').style.display = 'none';
        document.getElementById('pr-requests').style.display = 'block';
        document.getElementById('pengaju-requests').style.display = 'none';
    }

    function showPengaju() {
        document.getElementById('admin-requests').style.display = 'none';
        document.getElementById('pr-requests').style.display = 'none';
        document.getElementById('pengaju-requests').style.display = 'block';
    }

    window.onload = function() {
        showAdmin();
    };

    function toggleActive(buttonId) {
        const buttons = document.querySelectorAll('.btn-custom');
        buttons.forEach(button => {
            button.classList.remove('active');
        });

        const activeButton = document.getElementById(buttonId);
        activeButton.classList.add('active');
    }

    function openModal(role) {
        const adminModal = document.getElementById('addAdminModal');
        const prModal = document.getElementById('addPRModal');

        // Sembunyikan semua modal terlebih dahulu
        adminModal.style.display = 'none';
        prModal.style.display = 'none';

        // Tampilkan modal yang sesuai
        if (role === 'admin') {
            adminModal.style.display = 'flex';
        } else if (role === 'pr') {
            prModal.style.display = 'flex';
        }
    }

    function closeModal() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
    }

    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    };

    function showDeletedPopupAdmin(event) {
        event.preventDefault();
        document.getElementById('popupDeletedAdmin').style.display = 'block';
    }

    function showDeletedPopupPR(event) {
        event.preventDefault();
        document.getElementById('popupDeletedPR').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popupDeletedAdmin').style.display = 'none';
        document.getElementById('popupDeletedPR').style.display = 'none';
    }
</script>
@endsection