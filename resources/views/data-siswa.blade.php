<x-app-layout>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 4rem;
            transition: width 0.3s ease;
            overflow-x: hidden;
            z-index: 50;
            background-color: #ffffff;
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
                position: static;
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }

            .sidebar-link {
                flex-shrink: 0;
                justify-content: center !important;
                width: auto !important;
            }

            .sidebar-link span {
                display: none !important;
            }
        }

        .main-content {
            margin-left: 4rem;
            transition: margin-left 0.3s ease;
            padding-top: 0rem;
            z-index: 10;
            min-height: calc(100vh - 40px);
        }

        .sidebar:hover~.main-content {
            margin-left: 14rem;
        }

        @media (max-width: 767px) {
            .main-content {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }
        }

        footer {
            width: 100%;
        }

        #modalPenugasan {
            z-index: 9999;
        }
    </style>

    <div class="min-h-screen bg-customGrayLight">
        <!-- Sidebar -->
        <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-16">
            <a href="{{ route('dashboard') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fa-solid fa-house w-6 text-center"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('materiv2.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-book-open w-6 text-center"></i><span>Materi</span>
            </a>
            <a href="{{ route('learning.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-chalkboard-teacher w-6 text-center"></i><span>Learning</span>
            </a>
            <a href="{{ route('tes_soal.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-tasks w-6 text-center"></i><span>Tes Soal</span>
            </a>
            <a href="{{ route('kuis-tugas.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-folder w-6 text-center"></i><span>Tugas</span>
            </a>
            @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                <a href="{{ route('data-siswa') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                </a>
            @endif
        </div>

        {{-- Konten Utama --}}
        <div class="main-content py-12 flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h1 class="text-2xl font-bold mb-4">Data Siswa (Total: {{ $users->count() }})</h1>

                            <!-- Table to display user data -->
                            <div class="overflow-x-auto max-h-[500px] border rounded shadow-inner">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                                    <thead class="bg-gray-50 sticky top-0 z-10">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                                Email
                                            </th>
                                            @if (auth()->user()->role === 0)
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                                    Role
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-300">
                                                    Aksi
                                                </th>
                                            @endif
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

                                                    @if (auth()->user()->role === 0)
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-300">
                                                            @if ($user->role === 0)
                                                                Admin
                                                            @elseif ($user->role === 1)
                                                                Guru
                                                            @else
                                                                Siswa
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-300">
                                                            <button
                                                                onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm ml-2">
                                                                Hapus
                                                            </button>
                                                            <button
                                                                onclick="openRoleModal({{ $user->id }}, {{ $user->role }}, '{{ $user->name }}')"
                                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                                Edit Role
                                                            </button>
                                                        </td>
                                                    @endif

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
        </div>
    </div>
    </div>
    <!-- Modal Ubah Role -->
    <div id="editRoleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button onclick="closeRoleModal()" class="absolute top-2 right-3 text-gray-600 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Ubah Role untuk <span id="modalUserName"></span></h2>

            <form id="editRoleForm" method="POST" action="{{ route('update-user-role') }}">
                @csrf
                <input type="hidden" name="user_id" id="modalUserId">
                <label for="new_role" class="block text-sm font-medium text-gray-700 mb-1">Pilih Role Baru:</label>
                <select name="new_role" id="modalUserRole" required
                    class="w-full border border-gray-300 rounded p-2 mb-4">
                    <option value="2">Siswa</option>
                    <option value="1">Guru</option>
                </select>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openRoleModal(userId, role, name) {
            document.getElementById('modalUserId').value = userId;
            document.getElementById('modalUserRole').value = role;
            document.getElementById('modalUserName').textContent = name;
            document.getElementById('editRoleModal').classList.remove('hidden');
        }

        function closeRoleModal() {
            document.getElementById('editRoleModal').classList.add('hidden');
        }
    </script>
    <script>
        function confirmDeleteUser(userId, userName) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `User "${userName}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat dan kirimkan form DELETE
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/users/' + userId;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>


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
