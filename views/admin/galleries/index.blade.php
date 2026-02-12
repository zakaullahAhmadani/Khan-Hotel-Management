<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Khan Hotel</title>
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
        
        .gallery-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
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
                        <a class="nav-link active" href="{{ route('admin.galleries.index') }}">
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
                    <h2>Gallery Management</h2>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Image
                    </a>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row">
                    @foreach($galleries as $gallery)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="gallery-img" alt="{{ $gallery->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $gallery->title }}</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $gallery->is_active ? 'success' : 'secondary' }}">
                                        {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <div class="btn-group">
                                        <form action="{{ route('admin.galleries.toggle-status', $gallery) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $gallery->is_active ? 'warning' : 'success' }}">
                                                <i class="fas fa-{{ $gallery->is_active ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this image?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>