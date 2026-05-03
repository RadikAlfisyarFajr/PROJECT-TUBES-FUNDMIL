@include('admin.program.partials.form', [
    'title' => 'Edit Program Penyaluran',
    'action' => route('program-penyaluran.update', $program->id),
    'method' => 'PUT',
    'program' => $program,
    'selectedKategori' => old('kategori_dana_ids', $selectedKategori),
])
