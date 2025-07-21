@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-users me-2"></i>Daftar Pasien</h3>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Pasien
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Pacemaker</th>
                                    <th>Source</th>
                                    <th>Worklist</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                <tr>
                                    <td>{{ $patient->id }}</td>
                                    <td>{{ $patient->name }}</td>
                                    <td>{{ $patient->age }}</td>
                                    <td>
                                        <span class="badge bg-{{ $patient->gender == 'Male' ? 'primary' : ($patient->gender == 'Female' ? 'danger' : 'secondary') }}">
                                            {{ $patient->gender }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $patient->pacemaker == 'Yes' ? 'warning' : 'success' }}">
                                            {{ $patient->pacemaker }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $patient->source }}</span>
                                    </td>
                                    <td>
                                    @if ($patient->isInWorklist === 1)
                                        <span class="badge bg-success">Yes</span>
                                        @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @if ($patient->isInWorklist === 0)
                                        <button class="btn btn-sm btn-outline-primary send-to-worklist" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Send to Worklist" data-id="{{ $patient->id }}">
                                            <i class="fas fa-share"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pasien</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  // Enable tooltips on all elements with data-bs-toggle="tooltip"
  document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
  })
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltip Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Handler untuk tombol kirim
    document.querySelectorAll('.send-to-worklist').forEach(function(button) {
        button.addEventListener('click', function() {
            const patientId = this.getAttribute('data-id');

            fetch(`/send-to-worklist/${patientId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token untuk keamanan
                },
                body: JSON.stringify({ id: patientId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pasien berhasil dikirim ke worklist.');
                    location.reload(); // Reload untuk update badge 'isInWorklist'
                } else {
                    alert('Gagal mengirim pasien: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim.');
            });
        });
    });
});
</script>

@endsection