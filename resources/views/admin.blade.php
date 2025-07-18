<x-app-layout>
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
            padding-top: 4rem;
            z-index: 10;
            min-height: calc(100vh - 40px);
            /* Sisakan untuk footer */
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
    </style>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <!-- Wrapper -->
    <div class="min-h-screen flex bg-white relative">
        <!-- Sidebar -->
        <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-20">
            <a href="{{ route('dashboard') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fa-solid fa-house w-6 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('materiv2.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-folder w-6 text-center"></i>
                <span>Materi</span>
            </a>
            <a href="{{ route('learning.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                <span>Learning</span>
            </a>
            <a href="{{ route('tes_soal.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-folder w-6 text-center"></i>
                <span>Tes Soal</span>
            </a>
            <a href="{{ route('kuis-tugas.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-tasks w-6 text-center"></i>
                <span>Tugas</span>
            </a>
            <a href="{{ route('data-siswa') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fas fa-users w-6 text-center"></i>
                <span>Data Siswa</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col bg-customGrayLight">
            <div class="p-4 border-b border-customGrayMedium bg-customGrayLight">
                <h2 class="font-semibold text-xl text-customBlack leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>

            <div class="py-12 flex-grow">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        @foreach ([['route' => 'learning.index', 'title' => 'Learning', 'count' => $jumlahLearning], ['route' => 'materiv2.index', 'title' => 'Jumlah Materi', 'count' => $jumlahMateriv2], ['route' => 'tugas.index', 'title' => 'Tugas', 'count' => $jumlahTugas], ['route' => 'data-siswa', 'title' => 'Jumlah Siswa', 'count' => $jumlahSiswa]] as $card)
                            <a href="{{ route($card['route']) }}"
                                class="relative bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200 hover:bg-customold transition flex flex-col items-center">
                                <h3 class="font-semibold text-lg text-customBlack">{{ $card['title'] }}</h3>
                                <p class="text-customBlack text-3xl mt-2">{{ $card['count'] }}</p>
                                <div
                                    class="w-full bg-customBlue p-2 mt-4 rounded-b-lg text-center text-customGrayLight font-semibold cursor-pointer">
                                    <span>Selengkapnya <i class="fas fa-chevron-right"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer: berada di luar wrapper agar full lebar -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
