<x-app-layout>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 4rem;
            transition: width 0.3s ease;
            overflow-x: hidden;
            z-index: 50;
            background-color: #ffffff;
        }

        .sidebar:hover {
            width: 14rem;
        }

        .sidebar-link span {
            opacity: 0;
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar:hover .sidebar-link span {
            opacity: 1;
            margin-left: 0.5rem;
        }

        @media (max-width: 767px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }

            .sidebar-link {
                flex-shrink: 0;
                justify-content: center !important;
                width: auto !important;
            }

            .sidebar-link span {
                display: none !important;
            }
        }

        .main-content {
            margin-left: 4rem;
            transition: margin-left 0.3s ease;
            padding-top: 1rem;
            z-index: 10;
            min-height: calc(100vh - 40px);
        }

        .sidebar:hover~.main-content {
            margin-left: 14rem;
        }

        @media (max-width: 767px) {
            .main-content {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }
        }

        footer {
            width: 100%;
        }

        #modalPenugasan {
            z-index: 9999;
        }
    </style>

    <div class="min-h-screen bg-customGrayLight">
        <!-- Sidebar -->
        <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-16">
            <a href="{{ route('dashboard') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fa-solid fa-house w-6 text-center"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('materiv2.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-folder w-6 text-center"></i><span>Materi</span>
            </a>
            <a href="{{ route('learning.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-chalkboard-teacher w-6 text-center"></i><span>Learning</span>
            </a>
            <a href="{{ route('tes_soal.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-folder w-6 text-center"></i><span>Tes Soal</span>
            </a>
            <a href="{{ route('kuis-tugas.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-tasks w-6 text-center"></i><span>Tugas</span>
            </a>
            @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                <a href="{{ route('data-siswa') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                </a>
            @endif
        </div>

        {{-- Konten Utama --}}
        <div class="main-content py-12 flex-1">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Kartu Informasi Kelompok --}}
                <div class="bg-customold shadow-sm rounded-lg p-6 w-full h-fit col-span-1">

                    {{-- SweetAlert success message --}}
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Berhasil!',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false
                            });
                        </script>
                    @endif

                    {{-- Error message --}}
                    @if (session('error'))
                        <div class="alert alert-danger mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h1 class="mt-2 font-bold text-xl">Nama Kelompok: {{ $kelompok->nama_kelompok }}</h1>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="btn btn-primary mt-4 inline-block">
                            <span x-text="open ? 'Tutup Detail' : 'Lihat Detail'"></span>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="mt-3">
                            <div class="card card-body">
                                <p>Jumlah Kelompok: {{ $kelompok->jumlah_kelompok }}</p>
                                <p>Terisi: {{ $kelompok->anggota->count() }} dari {{ $kelompok->jumlah_kelompok }}
                                </p>
                                <p>Tahap: {{ $kelompok->stage_id }}</p>

                                <h2 class="text-lg font-semibold mt-4">Anggota Kelompok:</h2>
                                <ul class="list-disc ms-3">
                                    @forelse ($kelompok->anggota as $anggota)
                                        <li>{{ $anggota->user->name }}</li>
                                    @empty
                                        <li>Belum ada anggota.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol untuk User --}}
                    @if (auth()->user()->role == '2')
                        @if ($kelompok->anggota->count() < $kelompok->jumlah_kelompok)
                            <form action="{{ route('kelompok.storeUser', ['kelompokId' => $kelompok->id]) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="learning_id" value="{{ $learning->id }}">
                                <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                                <button type="submit" class="btn btn-primary mt-4">Gabung Kelompok</button>
                            </form>
                        @else
                            <p class="mt-4 text-red-500">Kelompok ini sudah penuh.</p>
                        @endif
                    @endif

                    {{-- Tombol untuk Admin dan Guru --}}
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <a href="{{ route('kelompok.manage', ['learning' => $learning->id, 'kelompok' => $kelompok->id]) }}"
                            class="btn btn-primary mt-4 inline-block">Kelola Anggota</a>

                        <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                            class="btn btn-secondary mt-4 inline-block">Kembali ke Daftar Kelompok</a>
                    @endif
                </div>

                {{-- Kartu Penugasan --}}
                <div class="bg-customold shadow-sm rounded-lg p-6 w-full h-fit col-span-1 md:col-span-2">

                    @php
                        $user = auth()->user();
                        $isUserInKelompok = $kelompok->anggota->contains('user_id', $user->id);
                    @endphp

                    {{-- Tombol Tambah Penugasan --}}
                    @if ($user->role == 2 && $isUserInKelompok)
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalPenugasan"
                            class="btn btn-primary">
                            Tambah Penugasan
                        </button>
                    @endif

                    {{-- Modal Tambah Penugasan --}}
                    <div class="modal fade" id="modalPenugasan" tabindex="-1" aria-labelledby="modalPenugasanLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('penugasan.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalPenugasanLabel">Tambah Penugasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_penugasan" class="form-label">Nama Penugasan</label>
                                            <input type="text" class="form-control" id="nama_penugasan"
                                                name="nama_penugasan" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload File</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                required>
                                        </div>

                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="learning_id" value="{{ $learning->id }}">
                                        <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Penugasan --}}
                    <h2 class="mt-4 font-bold text-lg">
                        Daftar Penugasan{{ $user->role == 2 ? ' Anda' : '' }}
                    </h2>

                    <table class="min-w-full bg-white border border-gray-300 rounded-md">
                        <thead class="bg-custombone">
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Nama Penugasan</th>
                                <th>File</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penugasans ?? collect() as $penugasan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $penugasan->user->name ?? '-' }}</td>
                                    <td>{{ $penugasan->nama_penugasan }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $penugasan->file) }}" target="_blank">Lihat
                                            File</a>
                                    </td>
                                    <td>{{ $penugasan->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada penugasan untuk Anda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Tombol Navigasi --}}
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('learning.stage3', ['learningId' => $learning->id]) }}"
                            class="btn btn-primary rounded-full">
                            Selanjutnya
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
