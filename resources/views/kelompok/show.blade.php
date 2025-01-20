<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($kelompok as $group)
        <div class="bg-white shadow-md rounded-md p-4">
            <h2 class="text-lg font-semibold text-gray-800">{{ $group->nama_kelompok }}</h2>
            <p class="text-sm text-gray-600">Jumlah Kelompok: {{ $group->jumlah_kelompok }}</p>
            <p class="text-sm text-gray-500">Learning ID: {{ $group->learning_id }}</p>
            <p class="text-sm text-gray-500">Stage ID: {{ $group->stage_id }}</p>
        </div>
    @empty
        <p class="text-gray-600">Belum ada kelompok yang dibuat.</p>
    @endforelse
</div>
