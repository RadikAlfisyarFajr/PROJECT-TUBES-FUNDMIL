@include('admin.partials.simple-page', [
    'title' => 'Detail Approval Program Penyaluran',
    'description' => 'Detail approval program penyaluran memakai antarmuka yang sama dengan admin instansi.',
    'active' => 'approval-program',
    'roleLabel' => 'Super Admin',
    'sidebar' => 'superadmin.partials.sidebar',
    'backRoute' => 'superadmin.approval-program-penyaluran.index',
])
