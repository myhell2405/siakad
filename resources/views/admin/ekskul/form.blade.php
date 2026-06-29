<div class="space-y-6">

<div>
    <label class="block text-sm font-medium mb-2">
        Nama Ekskul
    </label>

    <input type="text"
           name="nama_ekskul"
           value="{{ old('nama_ekskul', $ekskul->nama_ekskul ?? '') }}"
           class="w-full border rounded-lg px-4 py-2"
           required>
</div>

<div>
    <label class="block text-sm font-medium mb-2">
        Guru Pembina
    </label>

    <select name="id_guru"
            class="w-full border rounded-lg px-4 py-2">

        <option value="">
            -- Pilih Guru --
        </option>

        @foreach($guru as $g)

            <option value="{{ $g->id }}"
                {{ old('id_guru', $ekskul->id_guru ?? '') == $g->id ? 'selected' : '' }}>

                {{ $g->nama_lengkap }} ({{ $g->nip }})

            </option>

        @endforeach

    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-2">
        Keterangan
    </label>

    <textarea name="keterangan"
              rows="4"
              class="w-full border rounded-lg px-4 py-2">{{ old('keterangan', $ekskul->keterangan ?? '') }}</textarea>
</div>


</div>
