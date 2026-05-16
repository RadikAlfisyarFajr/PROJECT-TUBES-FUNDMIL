@include('admin.partials.simple-page', [
    'title' => 'Tambah Pengguna',
    'description' => 'Form tambah pengguna memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'pengguna',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.pengguna.index',
])
