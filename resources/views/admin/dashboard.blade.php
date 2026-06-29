@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Judul -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Dashboard Admin
        </h1>
        <p class="text-gray-500 mt-1">
            Selamat datang di Sistem Informasi Pengolahan Nilai Rapor SD Negeri 01 Durian Gadang.
        </p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- =========================
             PROFIL SEKOLAH
        ========================== -->

        <div class="bg-white rounded-xl shadow border">

            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
                <h2 class="font-semibold text-lg">
                    Profil Sekolah
                </h2>
            </div>

            <div class="p-6">

                <table class="w-full text-sm">

                    <tbody class="divide-y divide-gray-100">

                        <tr>
                            <td class="py-3 font-medium w-48">
                                Nama
                            </td>
                            <td class="py-3">
                                SD NEGERI 01 DURIAN GADANG
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                NPSN
                            </td>
                            <td class="py-3">
                                <a href="#" class="text-blue-600 hover:underline">
                                    10304253
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Alamat
                            </td>
                            <td class="py-3">
                                Jorong Beringin Durian Gadang
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Desa / Kelurahan
                            </td>
                            <td class="py-3">
                                DURIAN GADANG
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Kecamatan
                            </td>
                            <td class="py-3">
                                KEC. AKABILURU
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Kabupaten
                            </td>
                            <td class="py-3">
                                KAB. LIMA PULUH KOTA
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Provinsi
                            </td>
                            <td class="py-3">
                                PROV. SUMATERA BARAT
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Status Sekolah
                            </td>
                            <td class="py-3">
                                NEGERI
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Bentuk Pendidikan
                            </td>
                            <td class="py-3">
                                SD
                            </td>
                        </tr>

                        <tr>
                            <td class="py-3 font-medium">
                                Jenjang Pendidikan
                            </td>
                            <td class="py-3">
                                DIKDAS
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- =========================
             MAP SEKOLAH
        ========================== -->

        <div class="bg-white rounded-xl shadow border">

            <div class="bg-green-600 text-white px-6 py-4 rounded-t-xl">
                <h2 class="font-semibold text-lg">
                    Lokasi Sekolah
                </h2>
            </div>

            <div class="p-6">

                <iframe
                    class="w-full h-[380px] rounded-lg"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q=-0.242900,100.556900&hl=id&z=15&output=embed">
                </iframe>

            </div>

        </div>

    </div>

</div>

@endsection

