<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Management - Khan Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #34495e;
            color: #3498db;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="sidebar-sticky">
                    <div class="text-center text-white py-4">
                        <h4><i class="fas fa-hotel"></i> Khan Hotel</h4>
                        <small>Admin Panel</small>
                    </div>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('admin.bookings.index') }}">
                            <i class="fas fa-calendar-check me-2"></i>Bookings
                        </a>
                        <a class="nav-link" href="{{ route('admin.reports.index') }}">
                            <i class="fas fa-chart-line me-2"></i>Reports
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
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-2"></i>View Website
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Bookings Management</h2>
                    <div class="text-muted">
                        @php
                            $totalRevenue = 0;
                            foreach($bookings as $booking) {
                                if(in_array($booking->status, ['accepted', 'confirmed'])) {
                                    $totalRevenue += $booking->total_price ?: $this->calculateBookingPrice($booking);
                                }
                            }
                        @endphp
                        Total Revenue: ${{ number_format($totalRevenue, 2) }}
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Guest Name</th>
                                        <th>Email</th>
                                        <th>Room Type</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Nights</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    @php
                                        $nights = $booking->check_in->diffInDays($booking->check_out);
                                        $roomRates = [
                                            'standard' => 100,
                                            'deluxe' => 150,
                                            'suite' => 250,
                                            'presidential' => 500
                                        ];
                                        $rate = $roomRates[$booking->room_type] ?? 100;
                                        $calculatedPrice = $rate * $nights;
                                        $displayPrice = $booking->total_price ?: $calculatedPrice;
                                    @endphp
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ ucfirst($booking->room_type) }}</td>
                                        <td>{{ $booking->check_in->format('M d, Y') }}</td>
                                        <td>{{ $booking->check_out->format('M d, Y') }}</td>
                                        <td>{{ $nights }}</td>
                                        <td>
                                            ${{ number_format($displayPrice, 2) }}
                                            @if(!$booking->total_price)
                                                <small class="text-muted d-block">*Calculated</small>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <span class="badge 
                                                @if($booking->status=='pending') bg-warning 
                                                @elseif($booking->status=='accepted') bg-success 
                                                @else bg-danger @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($booking->status == 'pending')
                                                <form action="{{ route('admin.bookings.accept', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>