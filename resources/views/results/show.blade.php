<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Hasil Kuis: {{ $kuis->nama_kuis }}</h1>
    <a href="{{ route('kuisv2.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar Kuis</a>
    <table class="min-w-full bg-white border border-gray-300 mt-4">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nama Peserta</th>
                <th class="py-2 px-4 border-b">Skor</th>
                <th class="py-2 px-4 border-b">Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $result->user->name }}</td> <!-- Nama Peserta -->
                    <td class="py-2 px-4 border-b">{{ $result->score }}</td> <!-- Skor -->
                    <td class="py-2 px-4 border-b">{{ $result->created_at->format('d-m-Y') }}</td>
                    <!-- Tanggal Selesai -->
                </tr>
            @endforeach
        </tbody>

    </table>
</x-app-layout>
