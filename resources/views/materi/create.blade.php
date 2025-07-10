<!-- resources/views/materi/create.blade.php -->
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

            <!-- Main Content -->
            <div class="flex-1">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">

                                <h1 class="text-2xl font-bold mb-4">Tambah Materi</h1>
                                <a href="{{ route('materi.index') }}" class="btn btn-primary">
                                    <i class="fas fa-book w-6 text-center"></i>
                                    <span>Kembali</span>
                                </a>

                                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Nama Materi -->
                                    <div class="mb-4">
                                        <label for="nama_materi" class="block text-sm font-medium text-gray-700">Nama
                                            Materi</label>
                                        <input type="text" id="nama_materi" name="nama_materi"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            required>
                                        @error('nama_materi')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- File PPT -->
                                    <div class="mb-4">
                                        <label for="file_ppt" class="block text-sm font-medium text-gray-700">File
                                            PPT</label>
                                        <input type="file" id="file_ppt" name="file_ppt"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('file_ppt')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- File PDF -->
                                    <div class="mb-4">
                                        <label for="file_pdf" class="block text-sm font-medium text-gray-700">File
                                            PDF</label>
                                        <input type="file" id="file_pdf" name="file_pdf"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('file_pdf')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex items-center justify-end">
                                        <button type="submit"
                                            class="bg-blue-500 text-green px-4 py-2 rounded">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
