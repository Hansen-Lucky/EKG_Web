@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-chart-line me-2"></i>Daftar EKG Pasien</h3>
                    <a href="{{ route('ekg.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah EKG
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Source</th>
                                    <th>Result EKG</th>
                                    <th>Examination Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ekgResults as $ekg)
                                <tr>
                                    <td>{{ $ekg->patient->name }}</td>
                                    <td>{{ $ekg->patient->age }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ekg->patient->gender == 'Male' ? 'primary' : ($ekg->patient->gender == 'Female' ? 'danger' : 'secondary') }}">
                                            {{ $ekg->patient->gender }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $ekg->patient->source }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('ekg.download', $ekg->id) }}" 
                                           class="btn btn-sm btn-success" 
                                           target="_blank">
                                            <i class="fas fa-download me-1"></i>
                                            Download PDF
                                        </a>
                                    </td>
                                    <td>{{ $ekg->examination_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data EKG</td>
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