@include('admin.partials.simple-page', [
    'title' => 'Detail Approval Admin Instansi',
    'description' => 'Detail approval admin instansi memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'approval-admin',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.approval-admin-instansi.index',
])
