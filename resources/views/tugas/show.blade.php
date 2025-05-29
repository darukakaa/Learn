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
                <a href="{{ route('modul.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i>
                    <span>Modul</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <h3 class="text-lg font-semibold">{{ $task->nama_tugas }}</h3>
                            <p class="text-gray-600">Tanggal Dibuat: {{ $task->tanggal_dibuat->format('d-m-Y') }}</p>
                            <!-- Display validation status for User role -->
                            @if (auth()->user()->role == '2')
                                @if ($task->uploadedFiles->contains(fn($file) => $file->is_validated))
                                    <p class="badge bg-success">Telah Divalidasi</p>
                                @else
                                    <p class="text-gray-500 italic mt-2">Menunggu Validasi</p>
                                @endif
                            @endif
                            <a href="{{ route('tugas.index') }}" class="btn btn-info">Kembali ke Daftar Tugas</a>

                            @if (auth()->user()->role == '2' && !$task->uploadedFiles->contains(fn($file) => $file->is_validated))
                                <!-- For User role -->
                                <form id="fileUploadForm" action="{{ route('tugas.upload', $task->id) }}" method="POST"
                                    enctype="multipart/form-data" class="mt-6">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Upload File Tugas</label>
                                        <input type="file" name="file" class="w-full p-2 border rounded" required>
                                    </div>
                                    <button type="button" onclick="confirmUpload()"
                                        class="btn btn-primary">Submit</button>
                                </form>
                            @endif

                            @if (session()->has('message'))
                                <div class="mt-4 text-green-500">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <!-- File Upload Table for Admin and Guru -->
                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                <div class="mt-8">
                                    <h4 class="text-lg font-semibold mb-4">File Tugas yang Diunggah</h4>
                                    <table class="min-w-full bg-white rounded-lg shadow-md">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border-b">Nama User</th>
                                                <th class="py-2 px-4 border-b">Tanggal Upload</th>
                                                <th class="py-2 px-4 border-b">File</th>
                                                <th class="py-2 px-4 border-b">Aksi</th> <!-- New column for actions -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($task->uploadedFiles as $file)
                                                <tr id="file-row-{{ $file->id }}">
                                                    <td class="py-2 px-4 border-b">{{ $file->user->name }}</td>
                                                    <td class="py-2 px-4 border-b">
                                                        {{ \Carbon\Carbon::parse($file->uploaded_at)->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td class="py-2 px-4 border-b">
                                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                                                            class="text-blue-500 hover:underline">Download</a>
                                                    </td>
                                                    <td class="py-2 px-4 border-b">
                                                        <button class="validate-button text-green-500 hover:underline"
                                                            data-file-id="{{ $file->id }}"
                                                            data-validated="{{ $file->is_validated }}">
                                                            {{ $file->is_validated ? 'Unvalidasi' : 'Validasi' }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
                                    <button type="button" onclick="submitForm()" class="btn btn-success">Ya</button>
                                </div>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('.validate-button').click(function(e) {
                                    e.preventDefault();

                                    const button = $(this);
                                    const fileId = button.data('file-id');
                                    const isValidated = button.data('validated');
                                    const url = isValidated ?
                                        "{{ url('tugas/unvalidate') }}/" + fileId :
                                        "{{ url('tugas/validate') }}/" + fileId;

                                    $.ajax({
                                        type: 'POST',
                                        url: url,
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            // Update the button text and validation status
                                            if (response.is_validated) {
                                                button.text('Unvalidasi').data('validated', true);
                                            } else {
                                                button.text('Validasi').data('validated', false);
                                            }

                                            // Optionally, display a success message
                                            alert(response.message);
                                        },
                                        error: function(xhr) {
                                            // Handle error (optional)
                                            alert('Terjadi kesalahan. Silakan coba lagi.');
                                        }
                                    });
                                });
                            });
                        </script>

                        <script>
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
