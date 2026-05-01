<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Dashboard Super Admin</h1>
                <p class="text-muted mb-0">Kelola permintaan registrasi instansi yang menunggu persetujuan.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <h2 class="h5 mb-1">Akun Pending</h2>
                        <p class="text-muted mb-0">Tinjau dan setujui admin instansi baru sebelum mereka dapat mengakses sistem.</p>
                    </div>
                    <div class="text-muted">
                        Total akun pending: <strong>{{ $pendingUsers->count() }}</strong>
                    </div>
                </div>

                @if($pendingUsers->isEmpty())
                    <div class="alert alert-info mb-0">
                        Tidak ada akun instansi yang menunggu persetujuan.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Instansi</th>
                                    <th>Desa</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Daftar</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingUsers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->nama_instansi }}</td>
                                        <td>{{ $user->desa }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('superadmin.approve', $user) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('superadmin.reject', $user) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
