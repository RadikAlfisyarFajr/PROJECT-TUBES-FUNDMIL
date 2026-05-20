@include('admin.program-penyaluran.partials.form', [
    'title' => 'Edit Program Penyaluran',
    'action' => route('program-penyaluran.update', $program),
    'method' => 'PUT',
    'buttonLabel' => 'Update',
])
