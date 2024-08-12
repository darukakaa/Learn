<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
            </nav>
        </div>
        <div class="p-6 text-gray-900">
            <h1 class="text-2xl font-bold mb-4">Modul List</h1>
            <!-- Button to open the Add Modul modal -->
            <button onclick="openAddModal()"
                class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded mb-4">
                Add Modul
            </button>

            <!-- Table to display moduls -->
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Modul</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File
                            PDF</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($moduls as $index => $modul)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $modul->nama_modul }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($modul->file_pdf)
                            <a href="{{ asset('storage/' . $modul->file_pdf) }}" class="text-blue-500"
                                target="_blank">View PDF</a>
                            @else
                            <span class="text-gray-500">No PDF</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <!-- Edit button -->
                            <button
                                onclick="openEditModal({{ $modul->id }}, '{{ $modul->nama_modul }}', '{{ asset('storage/' . $modul->file_pdf) }}')"
                                class="text-blue-500 hover:text-blue-700">Edit</button> |
                            <!-- Delete button -->
                            <form action="{{ route('modul.destroy', $modul->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Background for Add Modul -->
        <div id="add-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
            <!-- Add Modul Modal Content -->
            <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
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
                        <button type="button" onclick="closeAddModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Background for Edit Modul -->
        <div id="edit-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
            <!-- Edit Modul Modal Content -->
            <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Edit Modul</h2>
                <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_nama_modul" class="block text-sm font-medium text-gray-700">Nama Modul</label>
                        <input type="text" name="nama_modul" id="edit_nama_modul" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="edit_file_pdf" class="block text-sm font-medium text-gray-700">Upload PDF</label>
                        <input type="file" name="file_pdf" id="edit_file_pdf" accept="application/pdf"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeEditModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                            Save
                        </button>
                    </div>
                </form>
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

        </script>
    </div>
</x-app-layout>
