<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Nilai Siswa - {{ $tes->nama_tes }}</h1>
        <a href="{{ route('tes_soal.index') }}" class="btn btn-secondary mb-4 inline-block">← Kembali ke Daftar Tes</a>

        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">No</th>
                    <th class="px-4 py-2 border-b">Nama Siswa</th>
                    <th class="px-4 py-2 border-b">Jumlah Soal</th>
                    <th class="px-4 py-2 border-b">Jawaban Benar</th>
                    <th class="px-4 py-2 border-b">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($dataNilai as $userId => $jawabanGroup)
                    @php
                        $user = $jawabanGroup->first()->user;
                        $jumlahSoal = $jawabanGroup->count();
                        $jumlahBenar = 0;
                        $totalNilai = 0;
                    @endphp
                    @foreach ($jawabanGroup as $jawaban)
                        @if ($jawaban->pilihan_jawaban === $jawaban->soal->jawaban_benar)
                            @php
                                $jumlahBenar++;
                                $totalNilai += $jawaban->soal->bobot_nilai;
                            @endphp
                        @endif
                    @endforeach

                    <tr>
                        <td class="px-4 py-2 border-b text-center">{{ $no++ }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $jumlahSoal }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $jumlahBenar }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $totalNilai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
