<!-- Kelompok Cards (Menampilkan Kelompok yang sudah ditambahkan) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($kelompok as $k)
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
            <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>
            <p class="text-sm mt-2">Tahap: {{ $k->stage_id }}</p>

            <!-- Delete Button -->
            <form action="{{ route('kelompok.destroy', $k->id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
                <script>
                    setTimeout(function() {
                        document.getElementById('error-notification').style.display = 'none';
                    }, 1000); // 1000ms = 1 detik
                </script>
            </form>
        </div>
    @endforeach
</div>
