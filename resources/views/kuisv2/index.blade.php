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
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 text-gray-900">
            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                <!-- Button to trigger the Add Modal -->
                <button onclick="document.getElementById('kuisv2Modal').classList.remove('hidden')"
                    class="btn btn-primary">
                    Tambah Kuis
                </button>
            @endif

            <!-- Display each Kuisv2 entry -->
            <table class="min-w-full bg-white border border-gray-300 mt-4">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Tanggal Kuis Dibuat</th>
                        <th class="py-2 px-4 border-b">Nama Kuis</th>
                        <th class="py-2 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <tbody>
                    @foreach ($kuisv2 as $kuis)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $kuis->tanggal_kuis }}</td>
                            <td class="py-2 px-4 border-b">{{ $kuis->nama_kuis }}</td>
                            <td class="py-2 px-4 border-b flex justify-center space-x-2">
                                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                    <!-- Edit Button -->
                                    <button
                                        onclick="openEditModal({{ $kuis->id }}, '{{ $kuis->nama_kuis }}', '{{ $kuis->tanggal_kuis }}')"
                                        class="btn btn-warning">
                                        Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('kuisv2.destroy', $kuis->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>

                                    <!-- Hasil Button -->
                                    <a href="{{ route('results.show', $kuis->id) }}" class="btn btn-info">Hasil</a>
                                @endif

                                <!-- Tombol "Masuk Kuis" -->
                                @if (in_array(auth()->user()->role, ['0', '1', '2']))
                                    @if (auth()->user()->role == '2' && $submittedKuisIds->contains($kuis->id))
                                        <span class="text-green-600 font-semibold">Anda sudah menyelesaikan kuis
                                            ini</span>

                                        <div class="mt-2 d-flex gap-2">
                                            <a href="{{ route('kuisv2.nilai', $kuis->id) }}"
                                                class="btn btn-success">Nilai V3</a>

                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal{{ $kuis->id }}">
                                                Review Soal
                                            </button>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="reviewModal{{ $kuis->id }}" tabindex="-1"
                                            aria-labelledby="reviewModalLabel{{ $kuis->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="reviewModalLabel{{ $kuis->id }}">
                                                            Review Soal: {{ $kuis->nama_kuis }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @foreach ($kuis->questionsV2 as $question)
                                                            @php
                                                                $isCorrect = false;
                                                                if ($question->userAnswer) {
                                                                    $isCorrect =
                                                                        strtoupper(
                                                                            $question->userAnswer->selected_answer,
                                                                        ) === strtoupper($question->correct_answer);
                                                                }
                                                            @endphp

                                                            <div class="mb-4">
                                                                <strong>
                                                                    Soal Nomor {{ $loop->iteration }}
                                                                    @if ($question->userAnswer)
                                                                        @if ($isCorrect)
                                                                            <span style="color:green;">&#10003;</span>
                                                                        @else
                                                                            <span style="color:red;">&#10007;</span>
                                                                        @endif
                                                                    @endif
                                                                </strong><br>

                                                                <strong>Pertanyaan:</strong>
                                                                {{ $question->question }}<br>

                                                                <ul>
                                                                    <li>A. {{ $question->option_a }}</li>
                                                                    <li>B. {{ $question->option_b }}</li>
                                                                    <li>C. {{ $question->option_c }}</li>
                                                                    <li>D. {{ $question->option_d }}</li>
                                                                    @if ($question->option_e)
                                                                        <li>E. {{ $question->option_e }}</li>
                                                                    @endif
                                                                </ul>

                                                                <strong>Jawaban Benar:</strong>
                                                                <span
                                                                    class="text-success">{{ strtoupper($question->correct_answer) }}</span><br>

                                                                <strong>Jawaban Anda:</strong>
                                                                @if ($question->userAnswer)
                                                                    <span
                                                                        class="{{ $isCorrect ? 'text-success' : 'text-danger' }}">
                                                                        {{ strtoupper($question->userAnswer->selected_answer) }}
                                                                        @if ($isCorrect)
                                                                            &#10003;
                                                                        @else
                                                                            &#10007;
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="text-danger">Belum dijawab</span>
                                                                @endif

                                                                <hr>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('questions.show', $kuis->id) }}"
                                            class="btn btn-primary">Masuk Kuis</a>
                                    @endif
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


            <!-- Add Kuis Modal -->
            <div id="kuisv2Modal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white p-6 rounded shadow-lg w-1/3">
                    <h2 class="text-xl font-bold mb-4">Tambah Kuis</h2>
                    <form action="{{ route('kuisv2.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kuis" class="block text-gray-700">Nama Kuis</label>
                            <input type="text" id="nama_kuis" name="nama_kuis" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_kuis" class="block text-gray-700">Tanggal Kuis Dibuat</label>
                            <input type="date" id="tanggal_kuis" name="tanggal_kuis" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="flex justify-end">
                            <button type="button"
                                onclick="document.getElementById('kuisv2Modal').classList.add('hidden')"
                                class="btn btn-secondary">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Kuis Modal -->
            <div id="editKuisModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white p-6 rounded shadow-lg w-1/3">
                    <h2 class="text-xl font-bold mb-4">Edit Kuis</h2>
                    <form id="editKuisForm" method="POST">
                        @csrf
                        @method('PUT') <!-- Ensure the form uses PUT method -->
                        <div class="mb-4">
                            <label for="edit_nama_kuis" class="block text-gray-700">Nama Kuis</label>
                            <input type="text" id="edit_nama_kuis" name="nama_kuis" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="edit_tanggal_kuis" class="block text-gray-700">Tanggal Kuis Dibuat</label>
                            <input type="date" id="edit_tanggal_kuis" name="tanggal_kuis" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="flex justify-end">
                            <button type="button"
                                onclick="document.getElementById('editKuisModal').classList.add('hidden')"
                                class="btn btn-secondary">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to open the Edit Modal with the data of the selected quiz
        function openEditModal(id, nama, tanggal) {
            document.getElementById('editKuisModal').classList.remove('hidden');
            document.getElementById('edit_nama_kuis').value = nama;
            document.getElementById('edit_tanggal_kuis').value = tanggal;
            document.getElementById('editKuisForm').action = `/kuisv2/${id}`;
            document.getElementById('editKuisForm').action = `/kuisv2/${id}`;
        }
    </script>
</x-app-layout>
