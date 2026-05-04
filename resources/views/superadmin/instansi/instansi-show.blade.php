@include('admin.partials.simple-page', [
    'title' => 'Detail Instansi',
    'description' => 'Detail instansi memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'instansi',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.instansi.index',
])
