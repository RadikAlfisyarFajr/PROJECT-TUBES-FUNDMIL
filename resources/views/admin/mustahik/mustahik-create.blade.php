@include('admin.mustahik.partials.form', [
    'title' => 'Tambah Mustahik',
    'action' => route('mustahik.store'),
    'method' => 'POST',
    'mustahik' => $mustahik,
    'kategoriAsnaf' => $kategoriAsnaf,
])
