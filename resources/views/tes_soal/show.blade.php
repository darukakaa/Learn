<x-app-layout>
    <style>
        /* Sidebar dan responsive style tetap sama */
        .sidebar {
            width: 4rem;
            transition: width 0.3s ease;
            overflow-x: hidden;
            height: 100vh;
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
                width: 100%;
                height: auto;
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
            }

            .sidebar-link {
                flex-shrink: 0;
                display: inline-flex !important;
                justify-content: center !important;
                width: auto !important;
            }

            .sidebar-link span {
                display: none !important;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            integrity="sha512-papmHCE9W8Me6iXKgp8n+HF8rhITxu6mA49wA2Yp3RxReD8BjOXQqePh1vN5R1+DoCdPQU09UugV1i5lFGY4Rw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <!-- Container utama full height, flex column -->
    <div class="min-h-screen flex flex-col bg-customGrayLight">
        <!-- Bagian isi utama (sidebar + content) flex row dan flexible height -->
        <div class="flex flex-1 flex-col md:flex-row">

            <!-- Sidebar -->
            <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2">
                <!-- link sidebar -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fa-solid fa-house w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('materi.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-book w-6 text-center"></i>
                    <span>Materi</span>
                </a>
                <a href="{{ route('learning.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                    <span>Learning</span>
                </a>
                <a href="{{ route('tes_soal.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i>
                    <span>Tes Soal</span>
                </a>
                <a href="{{ route('kuis-tugas.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-tasks w-6 text-center"></i>
                    <span>Kuis/Tugas</span>
                </a>
                @php
                    $role = auth()->user()->role;
                @endphp
                @if ($role === 0 || $role === 1)
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                @endif
                <a href="{{ route('modul.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i>
                    <span>Modul</span>
                </a>
            </div>

            <div class="flex justify-center items-start flex-grow p-4 w-full">
                <div class="flex space-x-8 w-full">

                    <!-- Form Tambah Soal (Admin & Guru) -->
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <div class="bg-white p-6 rounded shadow-lg w-1/2">
                            <h2 class="text-xl font-bold mb-4">Tambah Soal</h2>
                            <form action="{{ route('soal.store', $tes->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="pertanyaan" class="block text-gray-700">Pertanyaan</label>
                                    <input type="text" id="pertanyaan" name="pertanyaan" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <!-- Gambar -->
                                <div class="mb-4">
                                    <label for="gambar" class="block text-gray-700">Gambar Soal (Opsional)</label>
                                    <input type="file" id="gambar" name="gambar" accept="image/*"
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <!-- Pilihan A–E -->
                                @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                                    <div class="mb-4">
                                        <label for="pilihan_{{ $opt }}" class="block text-gray-700">Pilihan
                                            {{ strtoupper($opt) }}</label>
                                        <input type="text" id="pilihan_{{ $opt }}"
                                            name="pilihan_{{ $opt }}" required
                                            class="w-full border border-gray-300 p-2 rounded">
                                    </div>
                                @endforeach

                                <!-- Jawaban Benar -->
                                <div class="mb-4">
                                    <label for="jawaban_benar" class="block text-gray-700">Jawaban Benar</label>
                                    <select id="jawaban_benar" name="jawaban_benar" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                        @foreach (['A', 'B', 'C', 'D', 'E'] as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Bobot Nilai -->
                                <div class="mb-4">
                                    <label for="bobot_nilai" class="block text-gray-700">Bobot Nilai</label>
                                    <select id="bobot_nilai" name="bobot_nilai" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-success">Tambah Soal</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- List Soal -->
                    <div class="bg-white p-6 rounded shadow-lg w-full max-w-14xl">
                        <a href="{{ route('tes_soal.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar Tes</a>
                        <h2 class="text-xl font-bold mb-4">Soal yang Telah Ditambahkan</h2>
                        @if (auth()->user()->role == 2)
                            <div class="text-right mb-4">
                                <p class="text-red-600 font-bold text-lg">Sisa Waktu: <span id="timer">--:--</span>
                                </p>
                            </div>
                        @endif
                        @if ($soals->count() > 0)

                            @if (auth()->user()->role == '2')
                                {{-- FORM UNTUK USER --}}
                                <form id="answerForm" action="{{ route('jawaban.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tes_id" value="{{ $tes->id }}">

                                    <div id="soal-container">
                                        @foreach ($soals as $index => $soal)
                                            <div class="soal-item border p-4 rounded shadow hidden"
                                                id="soal-{{ $index }}">
                                                <strong class="block mb-2">Soal nomor {{ $loop->iteration }}</strong>

                                                @if ($soal->gambar)
                                                    <img src="{{ asset('storage/' . $soal->gambar) }}"
                                                        alt="Gambar Soal" class="max-w-full h-auto rounded mb-2">
                                                @endif

                                                <strong class="block text-sm mb-2">{{ $soal->pertanyaan }}</strong>

                                                <div class="text-sm text-gray-600 space-y-1">
                                                    @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                                                        <label class="block">
                                                            <input type="radio" name="jawaban[{{ $soal->id }}]"
                                                                value="{{ strtoupper($opt) }}" required>
                                                            <strong>{{ strtoupper($opt) }}:</strong>
                                                            {{ $soal->{'pilihan_' . $opt} }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="flex justify-between items-center mt-4">
                                        <div class="flex space-x-2">
                                            @foreach ($soals as $index => $soal)
                                                <button type="button" id="nav-soal-{{ $index }}"
                                                    class="btn btn-sm btn-outline-secondary soal-nav"
                                                    data-index="{{ $index }}"
                                                    onclick="showSoal({{ $index }})">Soal
                                                    {{ $loop->iteration }}</button>
                                            @endforeach
                                        </div>
                                        <div>
                                            <button type="button" onclick="nextSoal()"
                                                class="btn btn-sm btn-info">Selanjutnya</button>
                                            <button type="button" id="confirmSubmit" class="btn btn-success">Submit
                                                Jawaban</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                                    @foreach ($soals as $soal)
                                        <div
                                            class="border p-4 rounded shadow min-h-[350px] h-full flex flex-col justify-between">
                                            <strong class="block mb-2">
                                                Soal nomor {{ $loop->iteration }}
                                                <span class="text-sm text-gray-500 font-normal">(Bobot:
                                                    {{ $soal->bobot_nilai }})</span>
                                            </strong>

                                            <div class="flex justify-center space-x-2 mt-2">
                                                <button type="button" onclick="openEditModal(this)"
                                                    data-id="{{ $soal->id }}"
                                                    data-pertanyaan="{{ $soal->pertanyaan }}"
                                                    data-pilihan_a="{{ $soal->pilihan_a }}"
                                                    data-pilihan_b="{{ $soal->pilihan_b }}"
                                                    data-pilihan_c="{{ $soal->pilihan_c }}"
                                                    data-pilihan_d="{{ $soal->pilihan_d }}"
                                                    data-pilihan_e="{{ $soal->pilihan_e }}"
                                                    data-jawaban_benar="{{ $soal->jawaban_benar }}"
                                                    data-bobot_nilai="{{ $soal->bobot_nilai }}"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </button>

                                                <form id="delete-form-{{ $soal->id }}"
                                                    action="{{ route('soal.destroy', $soal->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete({{ $soal->id }})">Hapus</button>
                                                </form>
                                            </div>

                                            @if ($soal->gambar)
                                                <img src="{{ asset('storage/' . $soal->gambar) }}" alt="Gambar Soal"
                                                    class="w-full h-32 object-cover rounded mb-2">
                                            @endif

                                            <strong
                                                class="block text-sm mb-2 line-clamp-2">{{ $soal->pertanyaan }}</strong>

                                            <div class="text-sm text-gray-600 space-y-1 mt-auto">
                                                @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                                                    <label class="block">
                                                        <input type="radio" disabled>
                                                        <strong>{{ strtoupper($opt) }}:</strong>
                                                        {{ $soal->{'pilihan_' . $opt} }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            @endif
                        @else
                            <p class="text-gray-600">Belum ada soal yang ditambahkan.</p>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 relative">
            <button onclick="closeEditModal()"
                class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl font-bold">&times;</button>

            <h2 class="text-xl font-semibold mb-4">Edit Soal</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="edit_soal_id">

                <div class="mb-4">
                    <label class="block">Pertanyaan</label>
                    <input type="text" id="edit_pertanyaan" name="pertanyaan" class="w-full border rounded p-2">
                </div>

                @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                    <div class="mb-4">
                        <label class="block">Pilihan {{ strtoupper($opt) }}</label>
                        <input type="text" id="edit_pilihan_{{ $opt }}"
                            name="pilihan_{{ $opt }}" class="w-full border rounded p-2">
                    </div>
                @endforeach

                <div class="mb-4">
                    <label class="block">Jawaban Benar</label>
                    <select id="edit_jawaban_benar" name="jawaban_benar" class="w-full border rounded p-2">
                        @foreach (['A', 'B', 'C', 'D', 'E'] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block">Bobot Nilai</label>
                    <input type="number" id="edit_bobot_nilai" name="bobot_nilai" min="1" max="10"
                        class="w-full border rounded p-2">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        let currentSoal = 0;
        const totalSoal = {{ $soals->count() }};

        function showSoal(index) {
            // Sembunyikan semua soal
            document.querySelectorAll('.soal-item').forEach((el) => el.classList.add('hidden'));
            // Tampilkan soal yang dipilih
            const target = document.getElementById(`soal-${index}`);
            if (target) target.classList.remove('hidden');
            currentSoal = index;

            // Reset semua tombol navigasi ke default
            document.querySelectorAll('.soal-nav').forEach((btn) => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-secondary');
            });

            // Tambahkan warna aktif ke tombol navigasi saat ini
            const activeBtn = document.getElementById(`nav-soal-${index}`);
            if (activeBtn) {
                activeBtn.classList.remove('btn-outline-secondary');
                activeBtn.classList.add('btn-primary');
            }
        }

        function nextSoal() {
            if (currentSoal + 1 < totalSoal) {
                showSoal(currentSoal + 1);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSoal(0);
        });

        document.getElementById('confirmSubmit').addEventListener('click', function() {
            Swal.fire({
                title: 'Yakin ingin submit jawaban?',
                text: "Setelah submit kamu tidak bisa mengubah jawaban.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('answerForm').submit();
                }
            });
        });
    </script>
    <script>
        function openEditModal(button) {
            const id = button.getAttribute('data-id');

            document.getElementById('edit_soal_id').value = id;
            document.getElementById('edit_pertanyaan').value = button.getAttribute('data-pertanyaan');
            document.getElementById('edit_pilihan_a').value = button.getAttribute('data-pilihan_a');
            document.getElementById('edit_pilihan_b').value = button.getAttribute('data-pilihan_b');
            document.getElementById('edit_pilihan_c').value = button.getAttribute('data-pilihan_c');
            document.getElementById('edit_pilihan_d').value = button.getAttribute('data-pilihan_d');
            document.getElementById('edit_pilihan_e').value = button.getAttribute('data-pilihan_e');
            document.getElementById('edit_jawaban_benar').value = button.getAttribute('data-jawaban_benar');
            document.getElementById('edit_bobot_nilai').value = button.getAttribute('data-bobot_nilai');

            // Set action URL
            document.getElementById('editForm').action = `/soal/${id}`;

            // Tampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(soalId) {
            Swal.fire({
                title: 'Yakin ingin menghapus soal ini?',
                text: "Aksi ini tidak bisa dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + soalId).submit();
                }
            });
        }
    </script>


    @if (auth()->user()->role == 2)
        <script>
            let waktu = {{ $waktuDalamDetik }}; // waktu dari controller
            const timerDisplay = document.getElementById('timer');

            function updateTimer() {
                const minutes = Math.floor(waktu / 60);
                const seconds = waktu % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                waktu--;

                if (waktu < 0) {
                    clearInterval(timerInterval);
                    Swal.fire({
                        title: 'Waktu Habis!',
                        text: 'Jawabanmu akan disubmit otomatis.',
                        icon: 'warning',
                        confirmButtonText: 'Oke'
                    }).then(() => {
                        document.getElementById('answerForm').submit();
                    });
                }
            }

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // Jalankan pertama kali
        </script>
    @endif

    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
