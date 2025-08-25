@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-users me-2"></i>Tambah Pasien</h3>
                </div>
                <div class="card-body">
                    <form id="patientForm" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="medical_record_id" class="form-label">Medical Record ID <span class="text-danger">*</span></label>
                            <input type="text" name="medical_record_id" class="form-control" id="medical_record_id">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth<span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth" class="form-control" id="date_of_birth">
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-end">
                                <button type="button" onclick="sendPrintLabel()" class="btn btn-success me-2">
                                    <i class="fas fa-print me-1"></i> Print
                                </button>
                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
async function sendPrintLabel() {
    var cmd = gpTSC.createNew();

    // Set size for wristband
    cmd.setSize(25, 275);
    cmd.setGap(0);
    cmd.setCls();

    // Get values from form
    let medicalRecordId = document.getElementById('medical_record_id').value;
    let name = document.getElementById('name').value;
    let dob = document.getElementById('date_of_birth').value;

    // Example QR + Text
    cmd.setQR(152, 406, "L", 7, "A", 90, medicalRecordId);
    cmd.setText(162, 609, "TSS24.BF2", 90, 2, 2, medicalRecordId);
    cmd.setText(102, 609, "TSS24.BF2", 90, 2, 2, name);
    cmd.setText(42, 609, "TSS24.BF2", 90, 2, 2, dob);

    cmd.setPagePrint();

    // Send to printer
    await gpTool.writePrintData(gpTool.getDataView(cmd.getData()));
}
</script>
@endsection