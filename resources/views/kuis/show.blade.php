<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Add Question Form (only for Admin and Guru roles) -->
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    @if ($kuis->questions->count() < 5)
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h2 class="text-2xl font-bold mb-4">{{ $kuis->nama_kuis }}</h2>
                            <h3 class="text-xl font-semibold mb-4">Add Multiple Choice Question</h3>
                            <form action="{{ route('questions.store', $kuis->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="question"
                                        class="block text-sm font-medium text-gray-700">Question</label>
                                    <input type="text" id="question" name="question"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Options</label>
                                    @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                                        <div class="flex items-center mb-2">
                                            <input type="text" name="options[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                                placeholder="Option {{ $option }}" required>
                                            <input type="radio" name="correct_option" value="{{ $loop->index }}"
                                                class="ml-2">
                                            <span class="ml-1">Correct</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-500 text-black px-4 py-2 rounded-lg">Save</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-500">You have reached the limit of 5 questions.
                            </h3>
                        </div>

                        <!-- Display Students' Correct Answers -->
                        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
                            <h3 class="text-2xl font-semibold mb-4">Student Answers</h3>
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2 text-left">Student Name</th>
                                        <th class="px-4 py-2 text-left">Correct Answers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $student->name }}</td>
                                            <td class="border px-4 py-2">
                                                {{ $student->correct_answers_count }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif

                <!-- Display Questions and Options -->
                <form action="{{ route('questions.submit', ['kuis' => $kuis->id]) }}" method="POST">
                    @csrf
                    @forelse($kuis->questions as $question)
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $question->question }}</h3>
                            <ul class="list-disc pl-5">
                                @foreach ($question->options as $option)
                                    <li>
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $option->id }}" id="option_{{ $option->id }}"
                                            class="mr-2">
                                        <label for="option_{{ $option->id }}">{{ $option->option }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-gray-500">No questions available.</p>
                    @endforelse

                    @if (auth()->user()->role == '2')
                        <!-- Only show for 'user' role -->
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="btn btn-primary">Submit Answers</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
