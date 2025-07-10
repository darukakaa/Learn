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
                            <div class="p-6 text-gray-900">

                                <h1 class="text-2xl font-bold mb-4">List Materi</h1>
                                <!-- Only show the "Add Materi" button to admin and guru roles -->
                                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                    <a href="{{ route('materi.create') }}" class="btn btn-primary">Tambah Materi</a>
                                @endif

                                <table
                                    class="min-w-full divide-y divide-gray-200 border border-gray-200 table table-hover">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                No</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Materi</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                File PDF</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                File PPT</th>

                                            <!-- Only show the "Aksi" header to admin and guru roles -->
                                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($materis as $index => $materi)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $materi->nama_materi }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($materi->file_pdf)
                                                        <a href="{{ asset('storage/' . $materi->file_pdf) }}"
                                                            class="text-blue-500" target="_blank">View PDF</a>
                                                    @else
                                                        <span class="text-gray-500">No PDF</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($materi->file_ppt)
                                                        <a href="{{ asset('storage/' . $materi->file_ppt) }}"
                                                            class="text-blue-500" target="_blank">View PPT</a>
                                                    @else
                                                        <span class="text-gray-500">No PPT</span>
                                                    @endif
                                                </td>

                                                <!-- Only show the "Aksi" column to admin and guru roles -->
                                                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <a href="{{ route('materi.edit', $materi->id) }}"
                                                            class="btn btn-warning">Edit</a> |
                                                        <form id="delete-form-{{ $materi->id }}"
                                                            action="{{ route('materi.destroy', $materi->id) }}"
                                                            method="POST" class="inline-block delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger delete-button"
                                                                data-id="{{ $materi->id }}">
                                                                Delete
                                                            </button>
                                                        </form>


                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: "Data tidak bisa dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('delete-form-' + id).submit();
                            }
                        });
                    });
                });
            });
        </script>

        <!-- Footer: di luar container flex-row, full width -->
        <footer class="bg-customBlack text-center py-2 px-4 text-sm">
            <p class="text-customGrayLight">&copy; Learnify 2024</p>
        </footer>
</x-app-layout>
