@include('admin.partials.simple-page', [
    'title' => 'Edit Instansi',
    'description' => 'Form edit instansi memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'instansi',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.instansi.index',
])
