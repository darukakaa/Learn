<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                @if(auth()->user()->role == '0' || auth()->user()->role == '1')
                <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>
        <div class="flex-1 p-6">
            <!-- Success message -->
            @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- "Tambah Tugas" Button -->
            @if((auth()->user()->role == '0' || auth()->user()->role == '1') && !isset($task))
            <button onclick="openModal()" class="btn btn-primary">
                Tambah Tugas
            </button>
            @endif

            @if(isset($task))
            <!-- Single Task View -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold">{{ $task->nama_tugas }}</h3>
                <p class="text-gray-600">Tanggal Dibuat: {{ $task->tanggal_dibuat }}</p>
                <a href="{{ route('tugas.index') }}" class="text-blue-500 hover:underline">Kembali ke Daftar Tugas</a>

                <!-- File Upload Form for User Role -->
                @if(auth()->user()->role == '2') <!-- Assuming '2' represents 'User' role -->
                <form id="fileUploadForm" action="{{ route('tugas.upload', $task->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Upload File Tugas</label>
                        <input type="file" name="file" class="w-full p-2 border rounded" required>
                    </div>
                    <button type="button" onclick="confirmUpload()" class="btn btn-outline-primary">Submit</button>
                </form>
                @endif
            </div>
            @else
            <!-- All Task Cards -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($tugas as $item)
                <a href="{{ route('tugas.show', $item->id) }}"
                    class="block bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <h3 class="text-lg font-semibold">{{ $item->nama_tugas }}</h3>
                    <p class="text-gray-600">Tanggal Dibuat: {{ $item->tanggal_dibuat->format('d-m-Y')}}</p>
                 <!-- Delete button only visible for Admin and Guru roles -->
                @if(auth()->user()->role == '0' || auth()->user()->role == '1')
                <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                @endif
                </a>

                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Modal for Adding Tugas -->
        <div id="tugasModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white rounded-lg w-1/3 p-6">
                <h2 class="text-lg font-semibold mb-4">Tambah Tugas</h2>
                <form action="{{ route('tugas.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Tugas</label>
                        <input type="text" name="nama_tugas" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" class="w-full p-2 border rounded" required>
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
        <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white rounded-lg w-1/3 p-6">
                <h2 class="text-lg font-semibold mb-4">Konfirmasi</h2>
                <p>Apakah anda yakin ingin mengupload file ini?</p>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeConfirmModal()" class="bg-gray-300 px-4 py-2 rounded mr-2">Tidak</button>
                    <button type="button" onclick="submitForm()" class="bg-blue-500 px-4 py-2 text-white rounded">Ya</button>
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
</x-app-layout>
