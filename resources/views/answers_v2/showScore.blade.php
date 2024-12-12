<x-app-layout>
    <div class="p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Hasil Kuis: {{ $quiz->nama_kuis }}</h2>
        <table class="min-w-full bg-white border border-gray-300 mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nama User</th>
                    <th class="py-2 px-4 border-b">Jawaban</th>
                    <th class="py-2 px-4 border-b">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers as $answer)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $answer->user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $answer->jawaban }}</td>
                        <td class="py-2 px-4 border-b">{{ $answer->nilai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
