<div class="space-y-6">

    <!-- Nama Mapel -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Mapel
        </label>

        <input type="text"
               name="nama_mapel"
               value="{{ old('nama_mapel', $mapel->nama_mapel ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
               required>
    </div>

    <!-- KKM -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            KKM
        </label>

        <input type="number"
               name="kkm"
               value="{{ old('kkm', $mapel->kkm ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
               required>
    </div>

    <!-- Button -->
    <div class="flex gap-3 pt-4">

        <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

            Simpan

        </button>

        <a href="{{ route('admin.mapel.index') }}"
           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">

            Kembali

        </a>

    </div>

</div>