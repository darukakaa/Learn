<!-- resources/views/materi/create.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Add Materi</h1>

                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Materi -->
                        <div class="mb-4">
                            <label for="nama_materi" class="block text-sm font-medium text-gray-700">Nama Materi</label>
                            <input type="text" id="nama_materi" name="nama_materi" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('nama_materi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File PPT -->
                        <div class="mb-4">
                            <label for="file_ppt" class="block text-sm font-medium text-gray-700">File PPT</label>
                            <input type="file" id="file_ppt" name="file_ppt" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('file_ppt')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File PDF -->
                        <div class="mb-4">
                            <label for="file_pdf" class="block text-sm font-medium text-gray-700">File PDF</label>
                            <input type="file" id="file_pdf" name="file_pdf" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('file_pdf')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 text-green px-4 py-2 rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
