@include('admin.program.partials.form', [
    'title' => 'Tambah Program Penyaluran Baru',
    'action' => route('program-penyaluran.store'),
    'method' => 'POST',
    'program' => null,
    'selectedKategori' => old('kategori_dana_ids', []),
])
