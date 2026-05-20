@include('admin.partials.simple-page', [
    'title' => 'Detail Nishab',
    'description' => 'Detail nishab memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'nishab',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.nishab.index',
])
