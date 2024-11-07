@extends('admin::layouts.master')
@section('style')
    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header,
        .card-body {
            border-radius: 15px;
            background-color: #ffffff;
            padding: 1rem;
        }

        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .stat-box {
            text-align: center;
            padding: 1rem;
            border-radius: 10px;
            background-color: #eef2f7;
        }

        .stat-box p {
            margin: 0;
        }

        .stat-value {
            font-size: 1rem;
            font-weight: bold;
        }

        .chart {
            position: relative;
        }

        .box {
            position: relative;
        }

        .stat-box::after {
            content: "";
            position: absolute;
            left: 10%;
            top: 2px;
            height: 6px;
            width: 80%;
            background-color: #6a0dad;
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
   
    <div class="dashboard">
        <!-- Header Stats -->
        <div class="row g-2">
            @foreach ($data as $key => $value)
                <div class="col-sm-2 col-md-2 box">
                    <div class="stat-box">
                        <p> {{ $key }}</p>
                        <p class="stat-value">{{ $value }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Graphs Section -->
        <div class="row g-4 mt-4">
            <!-- Line Chart -->
            <div class="col-sm-7 col-md-7">
                <div class="card">
                    <div class="card-header">
                        <span>Yearly Orders and Earnings</span>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersEarningsChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Bar Chart -->
            <div class="col-sm-5 col-md-5">
                <div class="card">
                    <div class="card-header">
                        Weekly Revenue
                    </div>
                    <div class="card-body">
                        <canvas id="weeklyRevenueChart"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function fetchData(url) {
           
            try {
                const response = await fetch(url);
                return await response.json();
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function renderChart() {
            var url = "{{ route('yearly-orders-earnings') }}";
            const data = await fetchData(url);

            if (data) {
                const ctx = document.getElementById('ordersEarningsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                                label: 'Total Orders',
                                data: data.orders,
                                borderColor: '#4285F4',
                                backgroundColor: 'rgba(66, 133, 244, 0.2)',
                                fill: false,
                                yAxisID: 'y-axis-orders',
                            },
                            {
                                label: 'Total Earnings (रु)',
                                data: data.earnings,
                                borderColor: '#34A853',
                                backgroundColor: 'rgba(52, 168, 83, 0.2)',
                                fill: false,
                                yAxisID: 'y-axis-earnings',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            'y-axis-orders': {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Orders',
                                },
                            },
                            'y-axis-earnings': {
                                type: 'linear',
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Earnings (रु)',
                                },
                                grid: {
                                    drawOnChartArea: false, // Only show grid on left axis
                                },
                            }
                        }
                    }
                });
            }
        }
        async function renderWeeklyRevenueChart() {
            var url = "{{ route('weekly-revenue') }}";
            const data = await fetchData(url);

            if (data) {
                const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue (रु)',
                            data: data.revenues,
                            backgroundColor: '#6a0dad',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Revenue (रु)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            }
        }
      

        document.addEventListener('DOMContentLoaded', renderChart);
        document.addEventListener('DOMContentLoaded', renderWeeklyRevenueChart);

    </script>
@endsection
