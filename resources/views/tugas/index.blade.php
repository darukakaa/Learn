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

            <!-- Main Content -->
            <div class="flex-1">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <!-- Success message -->
                            @if (session('success'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '{{ session('success') }}',
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    });
                                </script>
                            @endif


                            <!-- "Tambah Tugas" Button -->
                            @if ((auth()->user()->role == '0' || auth()->user()->role == '1') && !isset($task))
                                <button onclick="openModal()" class="btn btn-primary">
                                    Tambah Tugas
                                </button>
                            @endif

                            @if (isset($task))
                                <!-- Single Task View -->
                                <div class="mt-6 bg-white p-4 rounded-lg shadow-md">
                                    <h3 class="text-lg font-semibold">{{ $task->nama_tugas }}</h3>
                                    <p class="text-gray-600">Tanggal Dibuat: {{ $task->tanggal_dibuat }}</p>
                                    <a href="{{ route('tugas.index') }}" class="text-blue-500 hover:underline">Kembali
                                        ke Daftar Tugas</a>

                                    <!-- File Upload Form for User Role -->
                                    @if (auth()->user()->role == '2')
                                        <!-- Assuming '2' represents 'User' role -->
                                        <form id="fileUploadForm" action="{{ route('tugas.upload', $task->id) }}"
                                            method="POST" enctype="multipart/form-data" class="mt-6">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Upload File
                                                    Tugas</label>
                                                <input type="file" name="file" class="w-full p-2 border rounded"
                                                    required>
                                            </div>
                                            <button type="button" onclick="confirmUpload()"
                                                class="btn btn-outline-primary">Submit</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($tugas as $item)
                                        <div
                                            class="relative bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200 hover:bg-customold transition flex flex-col">
                                            <a href="{{ route('tugas.show', $item->id) }}"
                                                class="block p-6 text-center">
                                                <h3 class="text-lg font-bold mb-2 text-blue-600 hover:underline">
                                                    {{ $item->nama_tugas }}</h3>
                                                <p class="text-sm text-gray-500">Tanggal Dibuat:
                                                    {{ $item->tanggal_dibuat->format('d-m-Y') }}</p>
                                            </a>

                                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                                <div class="bg-gray-200 text-center py-2 flex justify-around">
                                                    <form action="{{ route('tugas.destroy', $item->id) }}"
                                                        method="POST" class="w-full">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="w-full bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm delete-btn"
                                                            data-task-name="{{ $item->nama_tugas }}">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            @endif
                        </div>

                        <!-- Modal for Adding Tugas -->
                        <div id="tugasModal"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
                            <div class="bg-white rounded-lg w-1/3 p-6">
                                <h2 class="text-lg font-semibold mb-4">Tambah Tugas</h2>
                                <form action="{{ route('tugas.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Nama Tugas</label>
                                        <input type="text" name="nama_tugas" class="w-full p-2 border rounded"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                        <input type="date" name="tanggal_dibuat" class="w-full p-2 border rounded"
                                            required>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" onclick="closeModal()"
                                            class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Confirmation Modal for File Upload -->
                        <div id="confirmModal"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
                            <div class="bg-white rounded-lg w-1/3 p-6">
                                <h2 class="text-lg font-semibold mb-4">Konfirmasi</h2>
                                <p>Apakah anda yakin ingin mengupload file ini?</p>
                                <div class="flex justify-end mt-4">
                                    <button type="button" onclick="closeConfirmModal()"
                                        class="bg-gray-300 px-4 py-2 rounded mr-2">Tidak</button>
                                    <button type="button" onclick="submitForm()"
                                        class="bg-blue-500 px-4 py-2 text-white rounded">Ya</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openModal() {
                                document.getElementById('tugasModal').classList.remove('hidden');
                            }

                            function closeModal() {
                                document.getElementById('tugasModal').classList.add('hidden');
                            }

                            function confirmUpload() {
                                document.getElementById('confirmModal').classList.remove('hidden');
                            }

                            function closeConfirmModal() {
                                document.getElementById('confirmModal').classList.add('hidden');
                            }

                            function submitForm() {
                                document.getElementById('fileUploadForm').submit();
                                closeConfirmModal();
                                alert('File berhasil anda upload');
                            }
                        </script>
                        <script>
                            // Fungsi SweetAlert untuk tombol Hapus
                            document.querySelectorAll('.delete-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const form = this.closest('form');
                                    const taskName = this.getAttribute('data-task-name');

                                    Swal.fire({
                                        title: 'Apakah Anda yakin?',
                                        text: `Tugas "${taskName}" akan dihapus secara permanen!`,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    });
                                });
                            });
                        </script>

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
