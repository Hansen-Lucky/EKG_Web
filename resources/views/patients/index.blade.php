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
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
@endsection