<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="py-12 flex-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Title -->
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                        <p class="mt-4 text-gray-700 font-semibold">AKTIVITAS SISWA</p>
                    </div>
                </div>

                <!-- Aktivitas Table -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                        @if ($aktivitas->isEmpty())
                            <p class="text-gray-600">Belum ada aktivitas siswa untuk learning ini.</p>
                        @else
                            @php
                                $tahapNames = [
                                    '1' => 'Identifikasi Masalah',
                                    '2' => 'Gabung Kelompok & Penugasan',
                                    '3' => 'Catatan',
                                    '4' => 'Laporan Kelompok',
                                    '5' => 'Refleksi',
                                ];
                            @endphp
                            <table class="min-w-full border border-gray-300 rounded-md">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border-b text-left">No</th>
                                        <th class="px-4 py-2 border-b text-left">Nama Siswa</th>
                                        <th class="px-4 py-2 border-b text-left">Tahap</th> <!-- kolom baru -->
                                        <th class="px-4 py-2 border-b text-left">Aktivitas</th>
                                        <th class="px-4 py-2 border-b text-left">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aktivitas as $index => $item)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ $item->user->name ?? 'User tidak ditemukan' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $item->tahap }}</td>
                                            <!-- tampilkan tahap -->
                                            <td class="px-4 py-2 border-b">{{ $item->jenis_aktivitas }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ \Carbon\Carbon::parse($item->waktu_aktivitas)->format('d M Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
