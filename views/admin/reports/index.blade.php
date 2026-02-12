<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reports - Khan Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-color: #ecf0f1;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--primary-color);
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
        
        .main-content {
            background: var(--light-color);
            min-height: 100vh;
        }
        
        .stat-card {
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
        
        .revenue-chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: none;
        }
        
        .profit-positive {
            color: var(--success-color);
            font-weight: 600;
        }
        
        .profit-negative {
            color: var(--danger-color);
            font-weight: 600;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-bottom: none;
            padding: 20px;
        }
        
        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-color), #2980b9);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .expense-form-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .badge-revenue { background-color: var(--accent-color); }
        .badge-expense { background-color: var(--danger-color); }
        .badge-profit { background-color: var(--success-color); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="sidebar-sticky">
                    <div class="text-center text-white py-4" style="background: var(--secondary-color);">
                        <h4><i class="fas fa-hotel me-2"></i>Khan Hotel</h4>
                        <small>Admin Panel</small>
                    </div>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
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
                        <a class="nav-link active" href="{{ route('admin.reports.index') }}">
                            <i class="fas fa-chart-line me-2"></i>Reports
                        </a>
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-2"></i>View Website
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Financial Reports</h2>
                            <p class="text-muted mb-0">Track your hotel's financial performance and manage expenses</p>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-calendar me-2"></i>{{ now()->format('F d, Y') }}
                        </div>
                    </div>

                    <!-- Add Expense Form -->
                    <div class="expense-form-container">
                        <div class="row">
                            <div class="col-md-8">
                                <h4><i class="fas fa-plus-circle me-2 text-primary"></i>Add New Expense</h4>
                                <p class="text-muted">Record your monthly expenses to calculate accurate profits</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#expenseModal">
                                    <i class="fas fa-plus me-2"></i>Add Expense
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <!-- Simplified Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-2">Total Revenue</h6>
                        <h3 class="mb-0 text-primary">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        <small class="text-success">From Bookings</small>
                    </div>
                    <div class="bg-primary rounded-circle p-3">
                        <i class="fas fa-dollar-sign fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-2">Total Expenses</h6>
                        <h3 class="mb-0 text-danger">${{ number_format($totalExpenses ?? 0, 2) }}</h3>
                        <small class="text-muted">Operational Costs</small>
                    </div>
                    <div class="bg-danger rounded-circle p-3">
                        <i class="fas fa-receipt fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-2">Net Profit</h6>
                        <h3 class="mb-0 {{ ($netProfit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            ${{ number_format($netProfit ?? 0, 2) }}
                        </h3>
                        <small class="{{ ($netProfit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ ($totalRevenue ?? 0) > 0 ? number_format((($netProfit ?? 0)/($totalRevenue ?? 0))*100, 1) : 0 }}% Margin
                        </small>
                    </div>
                    <div class="bg-success rounded-circle p-3">
                        <i class="fas fa-chart-line fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-muted mb-2">Current Month</h6>
                        <h3 class="mb-0 text-info">{{ now()->format('F Y') }}</h3>
                        <small class="text-info">Active Period</small>
                    </div>
                    <div class="bg-info rounded-circle p-3">
                        <i class="fas fa-calendar-alt fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    <!-- Revenue Chart -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="revenue-chart-container">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h4 class="mb-1">Annual Financial Overview - {{ $currentYear }}</h4>
                                        <p class="text-muted mb-0">Revenue vs Expenses with Profit/Loss tracking</p>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.reports.export') }}?year={{ $currentYear }}" class="btn btn-outline-primary">
                                            <i class="fas fa-download me-2"></i>Export Report
                                        </a>
                                    </div>
                                </div>
                                
                                <canvas id="annualChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Breakdown -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow border-0">
                                <div class="card-header text-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0"><i class="fas fa-table me-2"></i>Monthly Breakdown - {{ $currentYear }}</h6>
                                        <div>
                                            <span class="badge badge-revenue me-1">Revenue</span>
                                            <span class="badge badge-expense me-1">Expenses</span>
                                            <span class="badge badge-profit">Profit</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Revenue</th>
                                                    <th>Expenses</th>
                                                    <th>Profit/Loss</th>
                                                    <th>Margin</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                                                              'July', 'August', 'September', 'October', 'November', 'December'];
                                                    $grandTotalRevenue = 0;
                                                    $grandTotalExpenses = 0;
                                                    $grandTotalProfit = 0;
                                                @endphp
                                                @foreach($months as $index => $month)
                                                @php
                                                    $revenue = $monthlyRevenue[$index] ?? 0;
                                                    $expenses = $monthlyExpenses[$index] ?? 0;
                                                    $profit = $revenue - $expenses;
                                                    $margin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;
                                                    
                                                    $grandTotalRevenue += $revenue;
                                                    $grandTotalExpenses += $expenses;
                                                    $grandTotalProfit += $profit;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <strong>{{ $month }}</strong>
                                                        @if($index == now()->month - 1)
                                                            <span class="badge bg-info">Current</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-dollar-sign text-success me-2"></i>
                                                            <span>${{ number_format($revenue, 2) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-receipt text-danger me-2"></i>
                                                            <span>${{ number_format($expenses, 2) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="{{ $profit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas {{ $profit >= 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }} me-2"></i>
                                                            <strong>${{ number_format($profit, 2) }}</strong>
                                                        </div>
                                                    </td>
                                                    <td class="{{ $margin >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                        <strong>{{ number_format($margin, 1) }}%</strong>
                                                    </td>
                                                    <td>
                                                        @if($profit > 0)
                                                            <span class="badge bg-success">Profitable</span>
                                                        @elseif($profit < 0)
                                                            <span class="badge bg-danger">Loss</span>
                                                        @else
                                                            <span class="badge bg-warning">Break Even</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td><strong>Annual Total</strong></td>
                                                    <td><strong>${{ number_format($grandTotalRevenue, 2) }}</strong></td>
                                                    <td><strong>${{ number_format($grandTotalExpenses, 2) }}</strong></td>
                                                    <td class="{{ $grandTotalProfit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                                                        <strong>${{ number_format($grandTotalProfit, 2) }}</strong>
                                                    </td>
                                                    <td class="{{ ($grandTotalRevenue > 0 && ($grandTotalProfit / $grandTotalRevenue) >= 0) ? 'profit-positive' : 'profit-negative' }}">
                                                        <strong>{{ $grandTotalRevenue > 0 ? number_format(($grandTotalProfit / $grandTotalRevenue) * 100, 1) : 0 }}%</strong>
                                                    </td>
                                                    <td>
                                                        @if($grandTotalProfit > 0)
                                                            <span class="badge bg-success">Overall Profit</span>
                                                        @else
                                                            <span class="badge bg-danger">Overall Loss</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="expenseModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Expense
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.expenses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Expense Category</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                <option value="staff">Staff Salaries</option>
                                <option value="utilities">Utilities</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="supplies">Supplies</option>
                                <option value="marketing">Marketing</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Enter expense description" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount ($)</label>
                            <input type="number" class="form-control" name="amount" step="0.01" placeholder="0.00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Month</label>
                            <select class="form-select" name="month" required>
                                @foreach($months as $index => $month)
                                    <option value="{{ $index + 1 }}" {{ $index + 1 == now()->month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i>Save Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Annual Chart
        const annualCtx = document.getElementById('annualChart').getContext('2d');
        
        // Calculate profit data
        const monthlyRevenue = @json($monthlyRevenue);
        const monthlyExpenses = @json($monthlyExpenses);
        const monthlyProfit = monthlyRevenue.map((revenue, index) => {
            return revenue - monthlyExpenses[index];
        });

        const annualChart = new Chart(annualCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Revenue',
                        data: monthlyRevenue,
                        backgroundColor: 'rgba(52, 152, 219, 0.8)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                    },
                    {
                        label: 'Expenses',
                        data: monthlyExpenses,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                    },
                    {
                        label: 'Net Profit',
                        data: monthlyProfit,
                        type: 'line',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(46, 204, 113, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
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
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 15,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
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

        // Auto-open modal if there's an error in expense form
        @if($errors->has('amount') || $errors->has('description'))
            document.addEventListener('DOMContentLoaded', function() {
                var expenseModal = new bootstrap.Modal(document.getElementById('expenseModal'));
                expenseModal.show();
            });
        @endif
    </script>
</body>
</html>