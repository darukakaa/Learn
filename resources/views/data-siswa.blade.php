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
        <div class="flex-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Data Siswa (Total: {{ $users->count() }})</h1>

                    <!-- Table to display user data -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                        Email
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-center text-sm text-gray-500 border-b border-gray-300">
                                            No users found.
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-300">
                                                {{ $user->name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-300">
                                                {{ $user->email }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function togglePassword(index, password) {
        const passwordElement = document.getElementById(`password-${index}`);
        if (passwordElement.innerText === '********') {
            passwordElement.innerText = password; // Consider using a different approach to handle password display.
        } else {
            passwordElement.innerText = '********';
        }
    }
</script>
