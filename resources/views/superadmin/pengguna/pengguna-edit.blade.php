@include('admin.partials.simple-page', [
    'title' => 'Edit Pengguna',
    'description' => 'Form edit pengguna memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'pengguna',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.pengguna.index',
])
