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

            </div>


            <div class="flex justify-center items-start flex-grow p-4 w-full">

                <div class="flex space-x-8 w-full">

                    <!-- Form Section (Only for Admin and Guru roles) -->
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <div class="bg-white p-6 rounded shadow-lg w-1/2">
                            <h2 class="text-xl font-bold mb-4">Tambah Soal Kuis</h2>
                            <form action="{{ route('questions.store', $kuis->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="question" class="block text-gray-700">Pertanyaan</label>
                                    <input type="text" id="question" name="question" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <!-- New Image Upload Field -->
                                <div class="mb-4">
                                    <label for="image" class="block text-gray-700">Gambar Soal (Opsional)</label>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <!-- Options and Correct Answer Fields... -->
                                <div class="mb-4">
                                    <label for="option_a" class="block text-gray-700">Pilihan A</label>
                                    <input type="text" id="option_a" name="option_a" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label for="option_b" class="block text-gray-700">Pilihan B</label>
                                    <input type="text" id="option_b" name="option_b" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label for="option_c" class="block text-gray-700">Pilihan C</label>
                                    <input type="text" id="option_c" name="option_c" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label for="option_d" class="block text-gray-700">Pilihan D</label>
                                    <input type="text" id="option_d" name="option_d" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label for="option_e" class="block text-gray-700">Pilihan E</label>
                                    <input type="text" id="option_e" name="option_e" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label for="correct_answer" class="block text-gray-700">Jawaban Benar</label>
                                    <select id="correct_answer" name="correct_answer" required
                                        class="w-full border border-gray-300 p-2 rounded">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button"
                                        onclick="document.getElementById('addQuestionModal').classList.add('hidden')"
                                        class="btn btn-secondary">Batal</button>
                                    <button type="submit" class="btn btn-success">Tambah Soal</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Questions List Section (for Users) -->
                    <div class="bg-white p-6 rounded shadow-lg w-full max-w-14xl">
                        <a href="{{ route('kuisv2.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar Kuis</a>
                        <h2 class="text-xl font-bold mb-4">Soal Kuis yang Telah Ditambahkan</h2>
                        @if ($questions->count() > 0)
                            <form id="answerForm" action="{{ route('answers_v2.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kuis_id" value="{{ $kuis->id }}">
                                <!-- Daftar Soal -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                                    @foreach ($questions as $question)
                                        <div class="border p-4 rounded shadow">
                                            <!-- Keterangan Nomor Soal -->
                                            <strong class="block mb-2">Soal nomor {{ $loop->iteration }}</strong>
                                            <!-- Gambar dan Soal -->
                                            @if ($question->image)
                                                <img src="{{ asset('storage/' . $question->image) }}"
                                                    alt="Gambar Soal" class="w-full h-auto mb-4">
                                            @endif
                                            <strong class="block mb-2">{{ $question->question }}</strong>

                                            <!-- Pilihan Jawaban -->
                                            <div class="text-sm text-gray-600 space-y-2">
                                                <label class="block">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="A" required>
                                                    <strong>A:</strong> {{ $question->option_a }}
                                                </label>
                                                <label class="block">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="B">
                                                    <strong>B:</strong> {{ $question->option_b }}
                                                </label>
                                                <label class="block">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="C">
                                                    <strong>C:</strong> {{ $question->option_c }}
                                                </label>
                                                <label class="block">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="D">
                                                    <strong>D:</strong> {{ $question->option_d }}
                                                </label>
                                                <label class="block">
                                                    <input type="radio" name="answers[{{ $question->id }}]"
                                                        value="E">
                                                    <strong>E:</strong> {{ $question->option_e }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if (auth()->user()->role == '2')
                                    <div class="flex justify-end mt-4">
                                        <button type="button" id="confirmSubmit" class="btn btn-success">Submit
                                            Jawaban</button>
                                    </div>
                                @endif
                            </form>

                            <!-- SweetAlert2 CDN + Script Konfirmasi Submit -->
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.getElementById('confirmSubmit')?.addEventListener('click', function() {
                                    Swal.fire({
                                        title: 'Yakin ingin submit jawaban?',
                                        text: "Jawaban kamu akan disimpan dan tidak bisa diubah.",
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
                        @else
                            <p class="text-gray-600">Belum ada soal yang ditambahkan.</p>
                        @endif
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
