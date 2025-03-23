@extends('layouts.app')

@section('title', 'Akun')

@section('content')
<!-- konten utama -->
<div class="main-content">
    <div class="card" style="border-radius: 10px; padding: 30px;">
        <!-- Form untuk update akun -->
        <form action="{{ route('akun.update') }}" method="POST" id="formAkun">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ $user->name ?? '' }}" required>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" id="address" name="address" class="form-control"
                    value="{{ $user->address ?? '' }}" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ $user->email ?? '' }}" required>
            </div>

            <!-- Tombol Submit -->
            <div class="d-flex align-items-center mb-3" id="buttonContainer" style="display: none;">
                <button type="submit" class="btn btn-detail">Simpan</button>
                <button type="button" class="btn btn-detail" style="margin-left: 20px; background-color:gray;" id="cancelButton">Cancel</button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    // Ambil elemen-elemen form
    const form = document.getElementById('formAkun');
    const buttonContainer = document.getElementById('buttonContainer');
    const cancelButton = document.getElementById('cancelButton');
    const initialData = new FormData(form);

    // Fungsi untuk memeriksa apakah ada perubahan
    function hasFormChanged() {
        const currentData = new FormData(form);
        for (let [key, value] of currentData.entries()) {
            if (value !== initialData.get(key)) {
                return true; // Ada perubahan
            }
        }
        return false; // Tidak ada perubahan
    }

    // Reset form ke data awal
    function resetForm() {
        for (let [key, value] of initialData.entries()) {
            const input = form.elements[key];
            if (input) {
                input.value = value;
            }
        }
    }

    // Event listener untuk mendeteksi perubahan di input
    form.addEventListener('input', () => {
        if (hasFormChanged()) {
            buttonContainer.style.display = 'flex'; // Tampilkan tombol
        } else {
            buttonContainer.style.display = 'none'; // Sembunyikan tombol
        }
    });

    // Fungsi untuk cancel
    cancelButton.addEventListener('click', () => {
        resetForm(); // Kembalikan form ke data awal
        buttonContainer.style.display = 'none'; // Sembunyikan tombol
    });
</script>
@endsection