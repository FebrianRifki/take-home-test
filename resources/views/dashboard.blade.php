@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-cards">
    <div class="stat-card glass">
        <div class="stat-icon members">
            <i class='bx bx-user'></i>
        </div>
        <div class="stat-details">
            <h3>Total Anggota</h3>
            <p>{{ $totalMembers }}</p>
        </div>
    </div>

    <div class="stat-card glass">
        <div class="stat-icon books">
            <i class='bx bx-book'></i>
        </div>
        <div class="stat-details">
            <h3>Total Buku</h3>
            <p>{{ $totalBooks }}</p>
        </div>
    </div>

    <div class="stat-card glass">
        <div class="stat-icon borrowings">
            <i class='bx bx-transfer'></i>
        </div>
        <div class="stat-details">
            <h3>Total Peminjaman</h3>
            <p>{{ $totalBorrowings }}</p>
        </div>
    </div>
</div>

<div class="chart-container glass">
    <div class="chart-header">
        <h2>Grafik Peminjaman (4 Minggu Terakhir)</h2>
    </div>
    <canvas id="borrowingChart"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('borrowingChart').getContext('2d');

        // Gradient for chart
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($borrowingData),
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ec4899',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5],
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection