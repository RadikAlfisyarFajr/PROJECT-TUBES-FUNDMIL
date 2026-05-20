@include('admin.partials.simple-page', [
    'title' => 'Detail Harga Beras',
    'description' => 'Detail harga beras memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'harga-beras',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.harga-beras.index',
])
