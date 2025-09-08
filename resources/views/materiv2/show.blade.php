<x-app-layout>

    |

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
                            <div class="p-6">
                                <div class="bg-white shadow p-6 rounded">
                                    <h2 class="text-xl font-semibold">{{ $materi->nama_materi }}</h2>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Tanggal:
                                        {{ \Carbon\Carbon::parse($materi->tanggal)->translatedFormat('d F Y') }}
                                    </p>
                                    <a href="{{ route('materiv2.index') }}"
                                        class="inline-block mt-4 px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                                        Kembali ke Daftar Materi
                                    </a>


                                </div>


                                @if (session('success'))
                                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                                @endif

                                @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                                    <div class="bg-white mt-6 p-6 rounded shadow">
                                        <h3 class="text-lg font-bold mb-4">Edit Detail Materi</h3>
                                        <form action="{{ route('materiv2.update', $materi->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block font-semibold">Deskripsi</label>
                                                <textarea name="deskripsi" id="editor" class="w-full">{{ old('deskripsi', $materi->deskripsi) }}</textarea>



                                            </div>
                                            <div class="mb-4">
                                                <label class="block font-semibold">Tujuan Pembelajaran</label>
                                                <textarea name="tujuan" rows="3" class="w-full border rounded px-3 py-2">{{ old('tujuan', $materi->tujuan) }}</textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block font-semibold">Capaian Pembelajaran</label>
                                                <textarea name="capaian" rows="3" class="w-full border rounded px-3 py-2">{{ old('capaian', $materi->capaian) }}</textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block font-semibold">Upload File PDF</label>
                                                <input type="file" name="file_pdf" class="border rounded px-3 py-2">
                                                @if ($materi->file_pdf)
                                                    <p class="text-sm text-green-600 mt-2">File saat ini: <a
                                                            href="{{ asset('storage/' . $materi->file_pdf) }}"
                                                            target="_blank" class="underline text-blue-600">Lihat
                                                            PDF</a></p>
                                                @endif
                                            </div>
                                            <div class="mb-4">
                                                <label class="block font-semibold">Link YouTube</label>
                                                <div id="link-container">
                                                    @php
                                                        $links = json_decode($materi->link, true) ?? [''];
                                                    @endphp

                                                    @foreach ($links as $link)
                                                        <input type="url" name="links[]"
                                                            value="{{ $link }}"
                                                            class="w-full border px-3 py-2 rounded mb-2"
                                                            placeholder="https://youtube.com/..." />
                                                    @endforeach
                                                </div>
                                                <button type="button" onclick="addLinkField()"
                                                    class="text-blue-600 underline text-sm">+ Tambah Link</button>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                @if (auth()->user()->role === 2)
                                    <div class="mt-6 bg-white p-6 rounded shadow">
                                        <h3 class="font-bold mb-2">Deskripsi</h3>
                                        <div class="prose max-w-none mb-4">{!! $materi->deskripsi ?? '-' !!}</div>

                                        <h3 class="font-bold mb-2">Tujuan Pembelajaran</h3>
                                        <p class="mb-4">{{ $materi->tujuan ?? '-' }}</p>

                                        <h3 class="font-bold mb-2">Capaian Pembelajaran</h3>
                                        <p class="mb-4">{{ $materi->capaian ?? '-' }}</p>

                                        @if ($materi->file_pdf)
                                            <h3 class="font-bold mb-2">File PDF</h3>

                                            <div class="mb-4">
                                                <iframe src="{{ asset('storage/' . $materi->file_pdf) }}"
                                                    width="100%" height="600px"
                                                    style="border: 1px solid #ccc;"></iframe>
                                            </div>

                                            <a href="{{ asset('storage/' . $materi->file_pdf) }}" target="_blank"
                                                class="text-blue-600 underline">
                                                Buka di Tab Baru
                                            </a>
                                        @endif

                                        @if ($materi->link)
                                            <h3 class="font-bold mb-2 mt-6">Video Pembelajaran</h3>
                                            @foreach (json_decode($materi->link, true) as $youtubeLink)
                                                @php
                                                    preg_match(
                                                        '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu.be\/)([\w\-]+)/',
                                                        $youtubeLink,
                                                        $matches,
                                                    );
                                                    $videoId = $matches[1] ?? null;
                                                @endphp

                                                @if ($videoId)
                                                    <div class="mb-4">
                                                        <iframe width="100%" height="315"
                                                            src="https://www.youtube.com/embed/{{ $videoId }}"
                                                            frameborder="0" allowfullscreen></iframe>
                                                    </div>
                                                @else
                                                    <p class="text-red-600 text-sm">Link tidak valid:
                                                        {{ $youtubeLink }}</p>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                @endif



                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '{{ route('materiv2.upload') }}?_token={{ csrf_token() }}'
                }

            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function addLinkField() {
            const container = document.getElementById('link-container');
            const input = document.createElement('input');
            input.type = 'url';
            input.name = 'links[]';
            input.placeholder = 'https://youtube.com/...';
            input.className = 'w-full border px-3 py-2 rounded mb-2';
            container.appendChild(input);
        }
    </script>






    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
    </div>
</x-app-layout>
