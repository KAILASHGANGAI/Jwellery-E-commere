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
    </style>
@endsection
@section('content')
    <h5>Analytics charts </h5>
    <!-- Graphs Section -->
    <div class="row g-4 mt-2">
        <!-- Line Chart -->
        <div class="col-sm-6 col-md-6">
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
        <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Weekly Revenue
                </div>
                <div class="card-body">
                    <canvas id="weeklyRevenueChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Sales Trend
                </div>
                <div class="card-body">
                    <canvas id="salesTradesChart"></canvas>
                </div>
            </div>
        </div>
    
        {{-- <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Order Funnel
                </div>
                <div class="card-body">
                    <canvas id="orderFunnelChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Top Products Performance
                </div>
                <div class="card-body">
                    <canvas id="productPerformanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Marketing Traffic
                </div>
                <div class="card-body">
                    <canvas id="marketingTrafficChart"></canvas>
                </div>
            </div>
        </div> --}}

    </div>
    </div>
@endsection
@section('script')
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

        async function salesTradesChart() {
            var url = "{{ route('salesTrend') }}";
            const data = await fetchData(url);

            if (data) {
                const ctx = document.getElementById('salesTradesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Sales ($)',
                            data: data.sales,
                            borderColor: '#3e95cd',
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                    }

                })
            }
        }



        async function renderOrderFunnelChart() {
            var url = "{{ route('order-funnel') }}";
            const data = await fetchData(url);

            if (data) {
                const ctx = document.getElementById('orderFunnelChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Order Funnel'
                            }
                        }
                    }
                });
            }
        }


        document.addEventListener('DOMContentLoaded', renderChart);
        document.addEventListener('DOMContentLoaded', renderWeeklyRevenueChart);
        document.addEventListener('DOMContentLoaded', salesTradesChart);
        // document.addEventListener('DOMContentLoaded', renderOrderFunnelChart);
    </script>
@endsection
