<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Khan Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #2c3e50, #34495e);
        }
        .user-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .welcome-section {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hotel me-2"></i>Khan Hotel
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Welcome back, {{ Auth::user()->name }}! 👋</h1>
                    <p class="mb-0">We're glad to see you again at Khan Hotel</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-user-circle fa-6x opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="user-card">
            <h4><i class="fas fa-info-circle me-2 text-primary"></i>Your Information</h4>
            <div class="row mt-4">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Account Type:</strong> 
                        <span class="badge bg-{{ Auth::user()->isAdmin() ? 'danger' : 'primary' }}">
                            {{ Auth::user()->user_type }}
                        </span>
                    </p>
                    <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                        <h5>Book a Room</h5>
                        <p class="text-muted">Reserve your stay with us</p>
                        <a href="/" class="btn btn-outline-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-history fa-3x text-success mb-3"></i>
                        <h5>Booking History</h5>
                        <p class="text-muted">View your past reservations</p>
                        <a href="#" class="btn btn-outline-success">View History</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                        <h5>Account Settings</h5>
                        <p class="text-muted">Manage your account</p>
                        <a href="#" class="btn btn-outline-warning">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>