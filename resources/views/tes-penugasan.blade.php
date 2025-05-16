<!DOCTYPE html>
<html>

<head>
    <title>Test Penugasan</title>
</head>

<body>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penugasan</th>
                <th>File</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penugasans as $penugasan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $penugasan->nama_penugasan }}</td>
                    <td>{{ $penugasan->file }}</td>
                    <td>{{ $penugasan->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
