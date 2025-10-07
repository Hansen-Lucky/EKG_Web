@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-chart-line me-2"></i>Oximonitor</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- SpO2 -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>SpO₂</h6>
                                    <h2 id="spo2-value" class="text-primary">--</h2>
                                    <small>%</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Heart Rate -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>Heart Rate</h6>
                                    <h2 id="hr-value" class="text-danger">--</h2>
                                    <small>bpm</small>
                                </div>
                            </div>
                        </div>

                        <!-- Resp Rate -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>Resp Rate</h6>
                                    <h2 id="resp-value" class="text-success">--</h2>
                                    <small>/min</small>
                                </div>
                            </div>
                        </div>

                        <!-- PI -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>Perfusion Index</h6>
                                    <h2 id="pi-value" class="text-warning">--</h2>
                                    <small>&nbsp;</small> {{-- empty placeholder keeps height consistent --}}
                                </div>
                            </div>
                        </div>

                        <!-- Temp -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>Body Temp</h6>
                                    <h2 id="temp-value" class="text-info">--</h2>
                                    <small>°C</small>
                                </div>
                            </div>
                        </div>

                        <!-- Device Connection -->
                        <div class="col-md-2 d-flex">
                            <div class="card text-center bg-light h-100 w-100">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <h6>Device Connection</h6>
                                    <h2 id="connection" class="text-success">--</h2>
                                    <small id="device-addr">aa:bb:cc:dd:ee</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-heartbeat me-2"></i> Heart Rate</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="heartRateChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
    // keep a circular buffer of fixed length

const MAX_POINTS = 200; // number of samples to keep on screen
let waveformData = Array(MAX_POINTS).fill(0);

const ctx = document.getElementById('heartRateChart').getContext('2d');
const heartRateChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: Array.from({length: MAX_POINTS}, (_, i) => i),
        datasets: [{
            label: 'PPG Waveform',
            data: waveformData,
            borderColor: 'red',
            borderWidth: 2,
            pointRadius: 0, // cleaner, no dots
            fill: false
        }]
    },
    options: {
        responsive: true,
        animation: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                ticks: { display: false }
            },
            y: {
                suggestedMin: -40,
                suggestedMax: 40
            }
        }
    }
});

function streamWaveform(samples, delay = 10) 
    { 
        let i = 0; 
        const interval = setInterval(() => { 
            waveformData.push(samples[i]);
                
            if (waveformData.length > MAX_POINTS) { 
                    waveformData = waveformData.slice(-MAX_POINTS); 
                } 
                heartRateChart.data.datasets[0].data = waveformData; 
                heartRateChart.update('none'); 
                i++; 
                
            if (i >= samples.length) clearInterval(interval); 
        }, delay);  
    }

// Handle incoming data
window.addEventListener("HeartRateUpdated", (e) => {
    const data = e.detail;
    console.log("Received in Blade via DOM event:", data);

    // update numbers
    document.getElementById('spo2-value').innerText  = data.spo2 ?? '--';
    document.getElementById('hr-value').innerText    = data.heart_rate ?? '--';
    document.getElementById('resp-value').innerText  = data.resp_rate ?? '--';
    document.getElementById('pi-value').innerText    = data.ppg_pi ?? '--';
    document.getElementById('temp-value').innerText  = data.body_temp ?? '--';
    document.getElementById('device-addr').innerText = data.dev_addr ?? '--';

    // append waveform data
    if (data.waveform && data.waveform.length > 0) {
        streamWaveform(data.waveform);
    }
});
</script>
@endpush
