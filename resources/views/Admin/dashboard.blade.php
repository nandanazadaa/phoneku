@extends('layouts.main')

@section('title', 'Dashboard - Atlantis Lite')

@push('styles')
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a2035;
        }
        .stat-label {
            font-size: 1rem;
            color: #576574;
        }
        .chart-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                <h5 class="text-white op-7 mb-2">Welcome to Admin Dashboard</h5>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <h6 class="stat-label mb-2">Total Orders</h6>
                    <h3 class="stat-number">{{ number_format($totalOrders) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <h6 class="stat-label mb-2">Total Customers</h6>
                    <h3 class="stat-number">{{ number_format($totalCustomers) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body text-center">
                    <h6 class="stat-label mb-2">Total Transactions</h6>
                    <h3 class="stat-number">Rp {{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card chart-container">
                <div class="card-body">
                    <h6 class="fw-bold mb-4">Monthly Income</h6>
                    <canvas id="incomeChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($incomeLabels),
            datasets: [{
                label: 'Monthly Income',
                data: @json($incomeData),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection