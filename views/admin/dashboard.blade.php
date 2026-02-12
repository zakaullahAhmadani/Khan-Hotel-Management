<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Khan Hotel Jampur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-color: #ecf0f1;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--primary-color);
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: var(--light-color);
            padding: 15px 20px;
            border-bottom: 1px solid var(--secondary-color);
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: var(--secondary-color);
            color: var(--accent-color);
            padding-left: 25px;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            background: var(--light-color);
            min-height: 100vh;
        }
        
        .stat-card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .card-header {
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .dashboard-header {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        .revenue-chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        
        .activity-item {
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .activity-item:hover {
            border-left-color: var(--accent-color);
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }
        
        .hotel-brand {
            background: var(--secondary-color);
            padding: 20px 0;
        }
        
        .hotel-brand h4 {
            margin: 0;
            font-weight: 700;
        }
        
        .hotel-brand small {
            color: #bdc3c7;
            font-size: 0.8rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .main-content {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="sidebar-sticky">
                    <div class="hotel-brand text-center text-white">
                        <h4><i class="fas fa-hotel me-2"></i>Khan Hotel</h4>
                        <small>Admin Panel</small>
                    </div>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                            <i class="fas fa-calendar-check me-2"></i>Bookings
                        </a>
                        <a class="nav-link" href="{{ route('admin.services.index') }}">
                            <i class="fas fa-concierge-bell me-2"></i>Services
                        </a>
                        <a class="nav-link" href="{{ route('admin.galleries.index') }}">
                            <i class="fas fa-images me-2"></i>Gallery
                        </a>
                        <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                            <i class="fas fa-envelope me-2"></i>Messages
                        </a>
                        <a class="nav-link" href="{{ route('admin.reports.index') }}">
                            <i class="fas fa-chart-line me-2"></i>Reports
                        </a>
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-2"></i>View Website
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content p-0">
                <div class="p-4">
                    <!-- Dashboard Header -->
                    <div class="dashboard-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1">Dashboard Overview</h2>
                                <p class="text-muted mb-0">Welcome back! Here's what's happening with your hotel today.</p>
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-calendar me-2"></i>{{ now()->format('F d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-primary shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Bookings</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBookings }}</div>
                                            <div class="mt-2 text-success">
                                                <small><i class="fas fa-arrow-up me-1"></i> 12% from last month</small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-warning shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Bookings</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingBookings }}</div>
                                            <div class="mt-2 text-warning">
                                                <small>Need attention</small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-success shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Messages</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMessages }}</div>
                                            <div class="mt-2 text-info">
                                                <small><i class="fas fa-comments me-1"></i> 5 new today</small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card border-left-info shadow h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Unread Messages</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unreadMessages }}</div>
                                            <div class="mt-2 text-danger">
                                                <small>Require response</small>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue and Profit Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="revenue-chart-container">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Monthly Revenue & Profit</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="monthDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Month
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                                            <li><a class="dropdown-item" href="#" data-month="0">January</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="1">February</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="2">March</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="3">April</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="4">May</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="5">June</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="6">July</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="7">August</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="8">September</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="9">October</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="10">November</a></li>
                                            <li><a class="dropdown-item" href="#" data-month="11">December</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="revenueChart" height="250"></canvas>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light mb-3">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Monthly Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h5 id="currentMonth" class="text-primary">June 2023</h5>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Total Revenue:</span>
                                                    <strong id="totalRevenue">$12,450</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Total Expenses:</span>
                                                    <strong id="totalExpenses" class="text-danger">$8,230</strong>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <span>Net Profit:</span>
                                                    <strong id="netProfit" class="text-success">$4,220</strong>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="progress" style="height: 10px;">
                                                        <div id="profitPercentage" class="progress-bar bg-success" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="text-muted">Profit Margin: <span id="profitMargin">34%</span></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold"><i class="fas fa-calendar me-2"></i>Recent Bookings</h6>
                                    <a href="{{ route('admin.bookings.index') }}" class="text-white">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    @foreach($recentBookings as $booking)
                                    <div class="p-3 activity-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 bg-primary rounded-circle p-2 text-white">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $booking->name }}</h6>
                                                <small class="text-muted">
                                                    {{ $booking->room_type }} • 
                                                    {{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d') }}
                                                </small>
                                            </div>
                                            <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold"><i class="fas fa-envelope me-2"></i>Recent Messages</h6>
                                    <a href="{{ route('admin.contacts.index') }}" class="text-white">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    @foreach($recentMessages as $message)
                                    <div class="p-3 activity-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 bg-success rounded-circle p-2 text-white">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $message->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($message->message, 50) }}</small>
                                            </div>
                                            @if(!$message->is_read)
                                            <span class="badge bg-danger">New</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample data for the revenue chart (in a real app, this would come from your backend)
        const monthlyData = {
            0: { // January
                revenue: [8500, 9200, 10100, 11300, 12500, 13700, 14500, 13800, 12700, 11500, 10500, 9800],
                expenses: [6200, 6800, 7200, 7800, 8200, 8900, 9500, 9100, 8600, 7900, 7300, 6900]
            },
            1: { // February
                revenue: [9200, 10100, 11300, 12500, 13700, 14500, 13800, 12700, 11500, 10500, 9800, 8900],
                expenses: [6800, 7200, 7800, 8200, 8900, 9500, 9100, 8600, 7900, 7300, 6900, 6500]
            },
            2: { // March
                revenue: [10100, 11300, 12500, 13700, 14500, 13800, 12700, 11500, 10500, 9800, 8900, 8200],
                expenses: [7200, 7800, 8200, 8900, 9500, 9100, 8600, 7900, 7300, 6900, 6500, 6200]
            },
            3: { // April
                revenue: [11300, 12500, 13700, 14500, 13800, 12700, 11500, 10500, 9800, 8900, 8200, 7600],
                expenses: [7800, 8200, 8900, 9500, 9100, 8600, 7900, 7300, 6900, 6500, 6200, 5900]
            },
            4: { // May
                revenue: [12500, 13700, 14500, 13800, 12700, 11500, 10500, 9800, 8900, 8200, 7600, 7100],
                expenses: [8200, 8900, 9500, 9100, 8600, 7900, 7300, 6900, 6500, 6200, 5900, 5600]
            },
            5: { // June
                revenue: [13700, 14500, 13800, 12700, 11500, 10500, 9800, 8900, 8200, 7600, 7100, 6800],
                expenses: [8900, 9500, 9100, 8600, 7900, 7300, 6900, 6500, 6200, 5900, 5600, 5400]
            },
            6: { // July
                revenue: [14500, 13800, 12700, 11500, 10500, 9800, 8900, 8200, 7600, 7100, 6800, 6500],
                expenses: [9500, 9100, 8600, 7900, 7300, 6900, 6500, 6200, 5900, 5600, 5400, 5200]
            },
            7: { // August
                revenue: [13800, 12700, 11500, 10500, 9800, 8900, 8200, 7600, 7100, 6800, 6500, 6300],
                expenses: [9100, 8600, 7900, 7300, 6900, 6500, 6200, 5900, 5600, 5400, 5200, 5000]
            },
            8: { // September
                revenue: [12700, 11500, 10500, 9800, 8900, 8200, 7600, 7100, 6800, 6500, 6300, 6100],
                expenses: [8600, 7900, 7300, 6900, 6500, 6200, 5900, 5600, 5400, 5200, 5000, 4800]
            },
            9: { // October
                revenue: [11500, 10500, 9800, 8900, 8200, 7600, 7100, 6800, 6500, 6300, 6100, 5900],
                expenses: [7900, 7300, 6900, 6500, 6200, 5900, 5600, 5400, 5200, 5000, 4800, 4600]
            },
            10: { // November
                revenue: [10500, 9800, 8900, 8200, 7600, 7100, 6800, 6500, 6300, 6100, 5900, 5700],
                expenses: [7300, 6900, 6500, 6200, 5900, 5600, 5400, 5200, 5000, 4800, 4600, 4400]
            },
            11: { // December
                revenue: [9800, 8900, 8200, 7600, 7100, 6800, 6500, 6300, 6100, 5900, 5700, 5500],
                expenses: [6900, 6500, 6200, 5900, 5600, 5400, 5200, 5000, 4800, 4600, 4400, 4200]
            }
        };

        const monthNames = ["January", "February", "March", "April", "May", "June", 
                           "July", "August", "September", "October", "November", "December"];
        
        let currentMonth = 5; // Default to June
        
        // Initialize the chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Revenue',
                        data: monthlyData[currentMonth].revenue.slice(0, 4),
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Expenses',
                        data: monthlyData[currentMonth].expenses.slice(0, 4),
                        borderColor: '#e74c3c',
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Update summary information
        function updateSummary(monthIndex) {
            const data = monthlyData[monthIndex];
            const totalRevenue = data.revenue.reduce((a, b) => a + b, 0);
            const totalExpenses = data.expenses.reduce((a, b) => a + b, 0);
            const netProfit = totalRevenue - totalExpenses;
            const profitMargin = ((netProfit / totalRevenue) * 100).toFixed(1);
            
            document.getElementById('currentMonth').textContent = `${monthNames[monthIndex]} 2023`;
            document.getElementById('totalRevenue').textContent = `$${totalRevenue.toLocaleString()}`;
            document.getElementById('totalExpenses').textContent = `$${totalExpenses.toLocaleString()}`;
            document.getElementById('netProfit').textContent = `$${netProfit.toLocaleString()}`;
            document.getElementById('profitMargin').textContent = `${profitMargin}%`;
            document.getElementById('profitPercentage').style.width = `${profitMargin}%`;
        }
        
        // Initialize with current month data
        updateSummary(currentMonth);
        
        // Handle month selection
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const monthIndex = parseInt(this.getAttribute('data-month'));
                currentMonth = monthIndex;
                
                // Update chart data
                revenueChart.data.datasets[0].data = monthlyData[monthIndex].revenue.slice(0, 4);
                revenueChart.data.datasets[1].data = monthlyData[monthIndex].expenses.slice(0, 4);
                revenueChart.update();
                
                // Update summary
                updateSummary(monthIndex);
                
                // Update dropdown button text
                document.getElementById('monthDropdown').textContent = monthNames[monthIndex];
            });
        });
    </script>
</body>
</html>