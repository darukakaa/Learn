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
                <a href="{{ route('modul.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i>
                    <span>Modul</span>
                </a>
            </div>

            <div class="flex-1">

                <!-- Success Alert -->
                @if (session('success'))
                    <div id="success-alert" class="bg-green-500 text-black p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="text-2xl font-bold mb-4">Modul List</h1>

                <!-- Add Modul Button (Visible to Admin and Guru) -->
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <button onclick="openAddModal()" class="btn btn-primary">
                        Add Modul
                    </button>
                @endif

                <!-- Card container to display moduls -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($moduls as $index => $modul)
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $modul->nama_modul }}</h2>
                            <div class="mt-4">
                                @if ($modul->file_pdf)
                                    <a href="{{ asset('storage/' . $modul->file_pdf) }}" class="text-blue-500"
                                        target="_blank">View PDF</a>
                                @else
                                    <span class="text-gray-500">No PDF</span>
                                @endif
                            </div>
                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                <div class="flex justify-between items-center mt-6">
                                    <!-- Edit button -->
                                    <button
                                        onclick="openEditModal({{ $modul->id }}, '{{ $modul->nama_modul }}', '{{ asset('storage/' . $modul->file_pdf) }}')"
                                        class="text-blue-500 hover:text-blue-700">
                                        Edit
                                    </button>
                                    <!-- Delete button -->
                                    <button type="button" onclick="openDeleteModal({{ $modul->id }})"
                                        class="text-red-500 hover:text-red-700">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal Background for Add Modul -->
            <div id="add-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <!-- Add Modul Modal Content -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-xl font-bold mb-4">Add New Modul</h2>
                    <form action="{{ route('modul.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_modul" class="block text-sm font-medium text-gray-700">Nama Modul</label>
                            <input type="text" name="nama_modul" id="nama_modul" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="file_pdf" class="block text-sm font-medium text-gray-700">Upload PDF</label>
                            <input type="file" name="file_pdf" id="file_pdf" accept="application/pdf" required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" onclick="closeAddModal()" class="btn btn-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Background for Edit Modul -->
            <div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <!-- Edit Modul Modal Content -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-xl font-bold mb-4">Edit Modul</h2>
                    <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="edit_nama_modul" class="block text-sm font-medium text-gray-700">Nama
                                Modul</label>
                            <input type="text" name="nama_modul" id="edit_nama_modul" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="edit_file_pdf" class="block text-sm font-medium text-gray-700">Upload
                                PDF</label>
                            <input type="file" name="file_pdf" id="edit_file_pdf" accept="application/pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" onclick="closeEditModal()" class="btn btn-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="delete-modal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                    <p>Are you sure you want to delete this modul?</p>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary">
                            No
                        </button>
                        <form id="delete-form" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openAddModal() {
                    document.getElementById('add-modal').classList.remove('hidden');
                }

                function closeAddModal() {
                    document.getElementById('add-modal').classList.add('hidden');
                }

                function openEditModal(id, namaModul, filePdfUrl) {
                    document.getElementById('edit-form').action = `/modul/${id}`;
                    document.getElementById('edit_nama_modul').value = namaModul;
                    document.getElementById('edit_file_pdf').value = ''; // Clear previous file input
                    document.getElementById('edit-modal').classList.remove('hidden');
                }

                function closeEditModal() {
                    document.getElementById('edit-modal').classList.add('hidden');
                }

                function openDeleteModal(modulId) {
                    document.getElementById('delete-form').action = `/modul/${modulId}`;
                    document.getElementById('delete-modal').classList.remove('hidden');
                }

                function closeDeleteModal() {
                    document.getElementById('delete-modal').classList.add('hidden');
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const successAlert = document.getElementById('success-alert');
                    if (successAlert) {
                        setTimeout(() => {
                            successAlert.classList.add('hidden');
                        }, 3000); // Hide after 3 seconds
                    }
                });
            </script>
        </div>
    </div>
    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
