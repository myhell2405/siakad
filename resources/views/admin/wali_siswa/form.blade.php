<div class="space-y-6">

    <!-- NISN -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            NISN Siswa
        </label>

        <input
            type="text"
            name="nisn"
            id="nisn"
            value="{{ old('nisn', $waliSiswa->nisn ?? '') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            placeholder="Masukkan NISN Siswa"
            required>
    </div>

    <!-- Nama Siswa -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Siswa
        </label>

        <input
            type="text"
            id="nama_siswa"
            class="w-full border rounded-lg px-4 py-2 bg-gray-100"
            value="{{ $waliSiswa->siswa->nama_siswa ?? '' }}"
            readonly>
    </div>

    <!-- Nama Wali -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Wali
        </label>

        <input
            type="text"
            name="nama_wali"
            value="{{ old('nama_wali', $waliSiswa->nama_wali ?? '') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            required>
    </div>

    <!-- Hubungan -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Hubungan
        </label>

        <select
            name="hubungan"
            class="w-full border rounded-lg px-4 py-2"
            required>

            <option value="">Pilih Hubungan</option>

            <option value="AYAH"
                {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'AYAH' ? 'selected' : '' }}>
                AYAH
            </option>

            <option value="IBU"
                {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'IBU' ? 'selected' : '' }}>
                IBU
            </option>

            <option value="WALI"
                {{ old('hubungan', $waliSiswa->hubungan ?? '') == 'WALI' ? 'selected' : '' }}>
                WALI
            </option>

        </select>
    </div>

    <!-- Telepon -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Telepon
        </label>

        <input
            type="text"
            name="telepon"
            value="{{ old('telepon', $waliSiswa->telepon ?? '') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
    </div>

    <!-- Pekerjaan -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Pekerjaan
        </label>

        <input
            type="text"
            name="pekerjaan"
            value="{{ old('pekerjaan', $waliSiswa->pekerjaan ?? '') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
    </div>

    <!-- Alamat -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Alamat
        </label>

        <textarea
            name="alamat"
            rows="4"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">{{ old('alamat', $waliSiswa->alamat ?? '') }}</textarea>
    </div>

    <!-- Tombol -->
    <div class="flex gap-3 pt-4">

        <button
            type="submit"
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

            Simpan

        </button>

        <a href="{{ route('admin.wali-siswa.index') }}"
           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">

            Kembali

        </a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const nisnInput = document.getElementById('nisn');
    const namaSiswa = document.getElementById('nama_siswa');

    let timer;

    nisnInput.addEventListener('input', function () {

        clearTimeout(timer);

        const nisn = this.value.trim();

        if (nisn.length < 3) {
            namaSiswa.value = '';
            return;
        }

        timer = setTimeout(() => {

            fetch(`/admin/wali-siswa/cari-siswa/${nisn}`)
                .then(res => res.json())
                .then(data => {

                    if (data.success) {
                        namaSiswa.value = data.nama_siswa;
                    } else {
                        namaSiswa.value = 'Siswa tidak ditemukan';
                    }

                })
                .catch(() => {
                    namaSiswa.value = 'Error koneksi';
                });

        }, 300);

    });

});
</script>