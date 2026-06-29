
<div class="space-y-6">

    {{-- Tahun Mulai --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Tahun Mulai
        </label>

        <input
            type="number"
            name="tahun_mulai"
            value="{{ old('tahun_mulai', $tahunAjaran->tahun_mulai ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200"
            required>
    </div>

    {{-- Tahun Selesai --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Tahun Selesai
        </label>

        <input
            type="number"
            name="tahun_selesai"
            value="{{ old('tahun_selesai', $tahunAjaran->tahun_selesai ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-200"
            required>
    </div>

    {{-- Semester --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Semester
        </label>

        <select
            name="semester"
            class="w-full rounded-lg border border-gray-300 px-4 py-2"
            required>

            <option value="">Pilih Semester</option>

            <option value="ganjil"
                {{ old('semester', $tahunAjaran->semester ?? '') == 'ganjil' ? 'selected' : '' }}>
                Ganjil
            </option>

            <option value="genap"
                {{ old('semester', $tahunAjaran->semester ?? '') == 'genap' ? 'selected' : '' }}>
                Genap
            </option>

        </select>
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border border-gray-300 px-4 py-2"
            required>
        
            <option value="aktif"
                {{ old('status', $tahunAjaran->status ?? '') == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>
        
            <option value="tidak_aktif"
                {{ old('status', $tahunAjaran->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>
                Tidak Aktif
            </option>
        
        </select>
    </div>

    {{-- Tombol --}}
    <div class="flex gap-3 pt-4">

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

            Simpan

        </button>

        <a href="{{ route('admin.tahun-ajaran.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

            Kembali

        </a>

    </div>

</div>

