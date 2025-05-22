<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                    @endif
                </nav>
            </div>
            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 5 Pengevaluasian masalah dan Penyimpulan</p>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="mt-4 font-semibold text-lg">RELEKSI</p>

                            @if ($semuaRefleksi->isEmpty())
                                <p class="text-gray-500 mt-2">Belum ada refleksi yang ditambahkan.</p>
                            @else
                                <table class="w-full mt-4 table-auto border border-collapse">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border p-2 text-left">Nama</th>
                                            <th class="border p-2 text-left">Refleksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaRefleksi as $index => $refleksi)
                                            <tr>
                                                <td class="border p-2">{{ $refleksi->user->name }}</td>
                                                <td class="border p-2">
                                                    <button data-modal-target="modalRefleksi{{ $index }}"
                                                        data-modal-toggle="modalRefleksi{{ $index }}"
                                                        class="btn btn-primary">
                                                        Lihat Refleksi
                                                    </button>

                                                    <!-- Modal -->
                                                    <div id="modalRefleksi{{ $index }}" tabindex="-1"
                                                        class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex justify-center items-center">
                                                        <div
                                                            class="bg-white w-full max-w-xl rounded shadow-lg p-6 relative">
                                                            <h2 class="text-xl font-bold mb-4">Refleksi dari
                                                                {{ $refleksi->user->name }}</h2>
                                                            <p><strong>Apa yang telah dipelajari:</strong>
                                                                {{ $refleksi->apa_yang_dipelahari }}</p>
                                                            <p><strong>Kesulitan:</strong> {{ $refleksi->kesulitan }}
                                                            </p>
                                                            <p><strong>Kontribusi:</strong> {{ $refleksi->kontribusi }}
                                                            </p>
                                                            <p><strong>Saran:</strong> {{ $refleksi->saran }}</p>
                                                            <p class="text-sm text-gray-500 mt-4">Ditambahkan pada
                                                                {{ $refleksi->created_at->format('d M Y H:i') }}</p>

                                                            <button
                                                                onclick="document.getElementById('modalRefleksi{{ $index }}').classList.add('hidden')"
                                                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                                                                ✕
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <script>
                            document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
                                btn.addEventListener('click', () => {
                                    const target = btn.getAttribute('data-modal-target');
                                    const modal = document.getElementById(target);
                                    if (modal) modal.classList.remove('hidden');
                                });
                            });
                        </script>

                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @php
                        $kelompokDievaluasi = \App\Models\Evaluasi::where('learning_id', $learning->id)
                            ->pluck('kelompok_id')
                            ->toArray();
                    @endphp
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">

                            <p class="mt-4 font-semibold text-lg">EVALUASI</p>

                            <!-- Kelompok Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                                @if (session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                        role="alert">
                                        <strong class="font-bold">Berhasil!</strong>
                                        <span class="block sm:inline">{{ session('success') }}</span>
                                    </div>
                                @endif

                                @foreach ($kelompok as $k)
                                    <div
                                        class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                        <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
                                        <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>
                                        <p class="text-sm mt-2">Anggota yang Bergabung: {{ $k->anggota->count() }} /
                                            {{ $k->jumlah_kelompok }}</p>

                                        <p class="text-sm mt-2">Nama Anggota:</p>
                                        <ul class="list-disc ml-5 mb-2">
                                            @forelse($k->anggota as $anggota)
                                                <li>{{ $anggota->user->name }}</li>
                                            @empty
                                                <li>Belum ada anggota.</li>
                                            @endforelse
                                        </ul>

                                        <!-- Tombol Evaluasi -->
                                        @unless (in_array($k->id, $kelompokDievaluasi))
                                            <button data-modal-target="modal-evaluasi-{{ $k->id }}"
                                                data-modal-toggle="modal-evaluasi-{{ $k->id }}"
                                                class="btn btn-primary">
                                                Evaluasi
                                            </button>
                                        @endunless

                                    </div>

                                    <!-- Modal Evaluasi -->
                                    <div id="modal-evaluasi-{{ $k->id }}" tabindex="-1"
                                        class="hidden fixed top-0 left-0 right-0 z-50 flex justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
                                        <div class="relative bg-white rounded-lg shadow w-full max-w-md">
                                            <div class="p-4 border-b">
                                                <h3 class="text-lg font-semibold">Evaluasi - {{ $k->nama_kelompok }}
                                                </h3>
                                            </div>
                                            <form action="{{ route('evaluasi.store') }}" method="POST" class="p-4">
                                                @csrf
                                                <input type="hidden" name="kelompok_id" value="{{ $k->id }}">
                                                <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium">Deskripsi Evaluasi</label>
                                                    <textarea name="deskripsi" rows="4" class="w-full border rounded p-2" required></textarea>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        data-modal-hide="modal-evaluasi-{{ $k->id }}"
                                                        class="btn btn-secondary">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </form>
                                            <script>
                                                document.querySelectorAll('[data-modal-toggle]').forEach(button => {
                                                    button.addEventListener('click', () => {
                                                        const target = button.getAttribute('data-modal-target');
                                                        document.getElementById(target).classList.remove('hidden');
                                                    });
                                                });

                                                document.querySelectorAll('[data-modal-hide]').forEach(button => {
                                                    button.addEventListener('click', () => {
                                                        const target = button.getAttribute('data-modal-hide');
                                                        document.getElementById(target).classList.add('hidden');
                                                    });
                                                });
                                            </script>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>


        </div>
    @endif
    {{-- user --}}
    @if (auth()->user()->role == '2')
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                </nav>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 5 Pengevaluasian masalah dan Penyimpulan</p>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="mt-4">RELEKSI</p>
                            @if (!$existingRefleksi)
                                <form action="{{ route('refleksi.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                    <div class="mb-4">
                                        <label>Apa yang telah dipelajari:</label>
                                        <textarea name="apa_yang_dipelahari" class="w-full border p-2" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label>Kesulitan yang dialami:</label>
                                        <textarea name="kesulitan" class="w-full border p-2" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label>Kontribusi pribadi:</label>
                                        <textarea name="kontribusi" class="w-full border p-2" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label>Saran untuk perbaikan:</label>
                                        <textarea name="saran" class="w-full border p-2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Refleksi</button>
                                </form>
                            @else
                                <div class="p-4 bg-green-100 border border-green-400 rounded text-green-700">
                                    ✅ Anda telah menambahkan refleksi pada learning
                                    <strong>{{ $learning->name }}</strong>.
                                </div>
                            @endif

                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: '{{ session('success') }}',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                </script>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="mt-4">EVALUASI</p>
                            @php
                                $evaluasis = \App\Models\Evaluasi::where('learning_id', $learning->id)
                                    ->get()
                                    ->groupBy('kelompok_id');
                            @endphp

                            <div class="mt-4 space-y-8">
                                @foreach ($kelompok as $k)
                                    <h2>Nama Kelompok Anda: {{ $k->nama_kelompok }}</h2>

                                    @if (isset($evaluasi[$k->id]) && $evaluasi[$k->id]->count() > 0)
                                        @foreach ($evaluasi[$k->id] as $eval)
                                            <p>{{ $eval->deskripsi }}</p>
                                        @endforeach
                                    @else
                                        <p>Belum ada evaluasi.</p>
                                    @endif
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
            </div>
    @endif
</x-app-layout>
