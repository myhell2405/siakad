@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- NISN --}}
    <div>
        <label class="block text-sm font-medium">NISN</label>
        <input type="text" name="nisn"
               value="{{ old('nisn', $siswa->nisn ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
    </div>

    {{-- NAMA --}}
    <div>
        <label class="block text-sm font-medium">Nama Siswa</label>
        <input type="text" name="nama_siswa"
               value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
    </div>

    {{-- TEMPAT LAHIR --}}
    <div>
        <label class="block text-sm font-medium">Tempat Lahir</label>
        <input type="text" name="tempat_lahir"
               value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
    </div>

    {{-- TANGGAL LAHIR --}}
    <div>
        <label class="block text-sm font-medium">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir"
               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
    </div>

    {{-- JENIS KELAMIN --}}
    <div>
        <label class="block text-sm font-medium">Jenis Kelamin</label>
        <select name="jenis_kelamin"
                class="w-full mt-1 p-2 border rounded-lg">
            <option value="">-- Pilih --</option>
            <option value="L" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    {{-- AGAMA --}}
    <div>
        <label class="block text-sm font-medium">Agama</label>
        <input type="text" name="agama"
               value="{{ old('agama', $siswa->agama ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

    {{-- STATUS KELUARGA --}}
    <div>
        <label class="block text-sm font-medium">Status Keluarga</label>
        <input type="text" name="status_keluarga"
               value="{{ old('status_keluarga', $siswa->status_keluarga ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

    {{-- ANAK KE --}}
    <div>
        <label class="block text-sm font-medium">Anak Ke</label>
        <input type="number" name="anak_ke"
               value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

    {{-- TELP --}}
    <div>
        <label class="block text-sm font-medium">No HP</label>
        <input type="text" name="telp_siswa"
               value="{{ old('telp_siswa', $siswa->telp_siswa ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

    {{-- SEKOLAH ASAL --}}
    <div>
        <label class="block text-sm font-medium">Sekolah Asal</label>
        <input type="text" name="sekolah_asal"
               value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

    {{-- TANGGAL DITERIMA --}}
    <div>
        <label class="block text-sm font-medium">Tanggal Diterima</label>
        <input type="date" name="tanggal_diterima"
               value="{{ old('tanggal_diterima', $siswa->tanggal_diterima ?? '') }}"
               class="w-full mt-1 p-2 border rounded-lg">
    </div>

</div>

{{-- ALAMAT --}}
<div class="mt-4">
    <label class="block text-sm font-medium">Alamat</label>
    <textarea name="alamat_siswa"
              class="w-full mt-1 p-2 border rounded-lg">{{ old('alamat_siswa', $siswa->alamat_siswa ?? '') }}</textarea>
</div>