<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Details - Khan Hotel</title>
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
                        <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                            <i class="fas fa-calendar-check me-2"></i>Bookings
                        </a>
                        <a class="nav-link" href="{{ route('admin.services.index') }}">
                            <i class="fas fa-concierge-bell me-2"></i>Services
                        </a>
                        <a class="nav-link" href="{{ route('admin.galleries.index') }}">
                            <i class="fas fa-images me-2"></i>Gallery
                        </a>
                        <a class="nav-link active" href="{{ route('admin.contacts.index') }}">
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
                    <h2>Message Details</h2>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Messages
                    </a>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Name:</strong> {{ $contact->name }}
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong> {{ $contact->email }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Phone:</strong> {{ $contact->phone }}
                            </div>
                            <div class="col-md-6">
                                <strong>Date:</strong> {{ $contact->created_at->format('F d, Y \a\t h:i A') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Message:</strong>
                            <div class="border p-3 mt-2 bg-light rounded">
                                {{ $contact->message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>