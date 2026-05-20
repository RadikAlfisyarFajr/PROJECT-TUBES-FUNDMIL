@include('admin.partials.simple-page', [
    'title' => 'Tambah Instansi',
    'description' => 'Form tambah instansi memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'instansi',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.instansi.index',
])
