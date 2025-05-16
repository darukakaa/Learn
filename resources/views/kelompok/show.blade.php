<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="flex">
        {{-- Sidebar --}}
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        {{-- Konten utama --}}
        <div class="flex flex-wrap justify-start gap-4">
            <div class="bg-white shadow-sm rounded-lg p-6 w-full md:max-w-md">
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

                <h1 class="mt-2">Nama Kelompok: {{ $kelompok->nama_kelompok }}</h1>
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#deskripsi" role="button"
                    aria-expanded="false" aria-controls="deskripsi">lebih lanjut</a>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="deskripsi">
                            <div class="card card-body">
                                <p class="mt-2">Jumlah Kelompok: {{ $kelompok->jumlah_kelompok }}</p>
                                <p class="mt-2">Terisi: {{ $kelompok->anggota->count() }} dari
                                    {{ $kelompok->jumlah_kelompok }}
                                </p>
                                <p class="mt-2">Tahap: {{ $kelompok->stage_id }}</p>
                                <h2 class="text-xl font-semibold mt-6 mb-2">Anggota Kelompok:</h2>
                                <ul class="list-disc ml-5">
                                    @forelse($kelompok->anggota as $anggota)
                                        <li>{{ $anggota->user->name }}</li>
                                    @empty
                                        <li>Belum ada anggota.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Gabung untuk User --}}
                @if (auth()->user()->role == '2' && $kelompok->anggota->count() < $kelompok->jumlah_kelompok)
                    <form action="{{ route('kelompok.storeUser', ['kelompokId' => $kelompok->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="learning_id" value="{{ $learning->id }}">
                        <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                        <button type="submit" class="btn btn-primary mt-4">
                            Gabung Kelompok
                        </button>
                    </form>
                @elseif(auth()->user()->role == '2' && $kelompok->anggota->count() == $kelompok->jumlah_kelompok)
                    <p class="mt-4 text-red-500">Kelompok ini sudah penuh.</p>
                @endif

                {{-- Tombol Kelola Anggota untuk Admin / Guru --}}
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('kelompok.manage', ['learningId' => $learning->id, 'kelompokId' => $kelompok->id]) }}"
                        class="btn btn-primary mt-4 inline-block">
                        Kelola Anggota
                    </a>
                @endif

                {{-- Tombol Kembali --}}
                <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                    class="btn btn-secondary mt-4 inline-block ml-2">
                    Kembali ke Daftar Kelompok
                </a>
            </div>
        </div>

        {{-- Card Penugasan --}}
        <div class="bg-white shadow-sm rounded-lg p-6 w-full md:max-w-md">
            <h1 class="mt-2">Card Tambahan</h1>
            @if (auth()->user()->role == '2')
                <!-- Tombol untuk membuka modal -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalPenugasan" class="btn btn-primary">
                    Tambah Penugasan
                </button>
            @endif
            <!-- Modal -->
            <div class="modal fade" id="modalPenugasan" tabindex="-1" aria-labelledby="modalPenugasanLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('penugasan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPenugasanLabel">Tambah Penugasan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_penugasan" class="form-label">Nama Penugasan</label>
                                    <input type="text" class="form-control" id="nama_penugasan" name="nama_penugasan"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="file" class="form-label">Upload File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>

                                <!-- Hidden fields -->
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="learning_id" value="{{ $learning->id }}">
                                <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <h2 class="mt-4 font-bold text-lg">Daftar Penugasan Anda</h2>
            <table class="table table-bordered mt-2">
                <thead class="bg-gray-100">
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
                            <td><a href="{{ asset('storage/' . $penugasan->file) }}" target="_blank">Lihat File</a>
                            </td>
                            <td>{{ $penugasan->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada penugasan untuk Anda.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="flex justify-between mt-6">
                <form method="GET" action="{{ route('learning.stage3', ['learningId' => $learning->id]) }}">
                    <button type="submit"
                        class="bg-gray-500 text-white font-bold py-2 px-6 rounded-full hover:bg-gray-600">
                        Selanjutnya
                    </button>
                </form>
            </div>






        </div>
</x-app-layout>
