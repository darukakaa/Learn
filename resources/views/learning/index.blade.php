<!-- resources/views/learning/index.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 h-full bg-gray-200">
            <nav class="flex flex-col p-4 space-y-4">
                <a href="{{ route('dashboard') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Dashboard</a>
                <a href="{{ route('materi.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Materi</a>
                <a href="{{ route('learning.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Kuis/Tugas</a>
                <a href="{{ route('data-siswa') }}" class="block text-center py-3 rounded bg-gray-300 text-black">Data
                    Siswa</a>
                <a href="{{ route('modul.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Modul</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Button to add new Learning -->
                    <div class="flex justify mb-4">
                        @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                            <button class="btn btn-primary" onclick="openAddModal()">
                                Tambah Learning
                            </button>
                        @endif
                    </div>

                    <!-- Grid of Learning items as Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($learnings as $learning)
                            <a href="{{ route('learning.show', ['learning' => $learning->id]) }}" class="card-link">



                                <div
                                    class="block bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                                    <div class="p-6 text-center">
                                        <h3 class="text-lg font-bold mb-2">{{ $learning->name }}</h3>
                                        <p class="text-gray-600">Learning Description or any extra content.</p>
                                    </div>
                                    <div class="bg-gray-200 text-center py-2 flex justify-around">
                                        <!-- Delete Button -->
                                        @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                            <button type="button" class="btn btn-danger"
                                                onclick="event.preventDefault(); openDeleteModal({{ $learning->id }})">Hapus</button>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Learning Modal -->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl mb-4">Tambah Learning</h2>
            <form method="POST" action="{{ route('learning.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama Learning</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>
                <div class="flex justify-end">
                    <button type="button"
                        class="bg-gray-400 hover:bg-gray-500 text-black font-bold py-2 px-4 rounded mr-2"
                        onclick="closeAddModal()">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl mb-4">Hapus Learning</h2>
            <p>Apakah Anda yakin ingin menghapus learning ini?</p>
            <form method="POST" action="" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="flex justify-end mt-4">
                    <button type="button"
                        class="bg-gray-400 hover:bg-gray-500 text-black font-bold py-2 px-4 rounded mr-2"
                        onclick="closeDeleteModal()">Batal</button>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-black font-bold py-2 px-4 rounded">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for modals -->
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openDeleteModal(learningId) {
            document.getElementById('deleteForm').action = `/learning/${learningId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
