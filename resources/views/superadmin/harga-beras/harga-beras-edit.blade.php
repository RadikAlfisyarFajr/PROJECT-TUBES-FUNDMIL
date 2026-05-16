@include('admin.partials.simple-page', [
    'title' => 'Edit Harga Beras',
    'description' => 'Form edit harga beras memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'harga-beras',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.harga-beras.index',
])
