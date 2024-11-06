<!-- resources/views/materi/index.blade.php -->
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
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">

                            <h1 class="text-2xl font-bold mb-4">Materi List</h1>
                            <!-- Only show the "Add Materi" button to admin and guru roles -->
                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                <a href="{{ route('materi.create') }}" class="btn btn-primary">Add
                                    Materi</a>
                            @endif

                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 table table-hover">
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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
                                                    <form action="{{ route('materi.destroy', $materi->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
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
</x-app-layout>
