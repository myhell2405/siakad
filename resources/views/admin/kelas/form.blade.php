<div class="space-y-6">

    <!-- Tingkat Kelas -->
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Tingkat Kelas
        </label>

        <select
            name="tingkat_kelas"
            class="w-full border rounded-lg px-4 py-2"
            required>

            <option value="">Pilih Tingkat</option>

            @for($i = 1; $i <= 6; $i++)

                <option value="{{ $i }}"
                    {{ old('tingkat_kelas', $kelas->tingkat_kelas ?? '') == $i ? 'selected' : '' }}>

                    Kelas {{ $i }}

                </option>

            @endfor

        </select>

    </div>

    <!-- Nama Kelas -->
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Kelas
        </label>

        <input
            type="text"
            name="nama_kelas"
            value="{{ old('nama_kelas', $kelas->nama_kelas ?? '') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
            required>

    </div>

    <!-- Tombol -->
    <div class="flex gap-3 pt-4">

        <button
            type="submit"
            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

            Simpan

        </button>

        <a href="{{ route('admin.kelas.index') }}"
           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">

            Kembali

        </a>

    </div>

</div>