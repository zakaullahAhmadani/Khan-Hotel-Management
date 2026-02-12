@extends('layouts.app')

@section('content')

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-hotel"></i> Khan Hotel Jampur
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
               @auth
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu">
            @if(Auth::user()->isAdmin())
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                </a></li>
            @else
                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-user me-2"></i>My Dashboard
                </a></li>
            @endif
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
    </li>
@else
    <li class="nav-item">
        <a class="nav-link btn btn-primary-custom text-white ms-2" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
    </li>
@endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section with Booking Form -->
<!-- HERO / BOOKING FORM -->
<section id="home" class="hero-section"
    style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80'); background-size: cover; background-position: center; min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="display-4 fw-bold mb-4">Welcome to Khan Hotel Jampur</h1>
                <p class="lead mb-4">Experience luxury and comfort in the heart of Jampur. Your perfect getaway awaits.</p>
                <div class="d-flex gap-3">
                    <span><i class="fas fa-wifi me-2"></i> Free WiFi</span>
                    <span><i class="fas fa-swimming-pool me-2"></i> Swimming Pool</span>
                    <span><i class="fas fa-utensils me-2"></i> Restaurant</span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary-custom text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Book Your Stay</h4>
                    </div>

                    <div class="card-body">
                        <form id="bookingForm" method="POST" action="{{ route('book.room') }}">
                            @csrf

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Room Type</label>
                                    <select class="form-select" name="room_type" id="roomType" required onchange="updatePrice()">
                                        <option value="">Select Room Type</option>
                                        <option value="standard" data-price="100">Standard Room - $100/night</option>
                                        <option value="deluxe" data-price="150">Deluxe Room - $150/night</option>
                                        <option value="suite" data-price="250">Executive Suite - $250/night</option>
                                        <option value="presidential" data-price="500">Presidential Suite - $500/night</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in Date</label>
                                    <input type="date" class="form-control" name="check_in" value="{{ old('check_in') }}" required onchange="updatePrice()">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-out Date</label>
                                    <input type="date" class="form-control" name="check_out" value="{{ old('check_out') }}" required onchange="updatePrice()">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Guests</label>
                                    <select class="form-select" name="guests" required>
                                        <option value="1">1 Guest</option>
                                        <option value="2">2 Guests</option>
                                        <option value="3">3 Guests</option>
                                        <option value="4">4 Guests</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estimated Total</label>
                                    <div class="form-control bg-light" id="totalPriceDisplay">$0</div>
                                    <small class="text-muted">Price calculated based on room type and duration</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Special Requests</label>
                                    <textarea class="form-control" name="special_requests" placeholder="Any special requirements?">{{ old('special_requests') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-3">
                                <i class="fas fa-paper-plane me-2"></i>Book Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function updatePrice() {
    const roomType = document.getElementById('roomType');
    const checkIn = document.querySelector('input[name="check_in"]');
    const checkOut = document.querySelector('input[name="check_out"]');
    const totalDisplay = document.getElementById('totalPriceDisplay');
    
    const roomPrice = roomType.options[roomType.selectedIndex]?.getAttribute('data-price') || 0;
    
    if (checkIn.value && checkOut.value && roomPrice > 0) {
        const checkInDate = new Date(checkIn.value);
        const checkOutDate = new Date(checkOut.value);
        
        // Calculate nights (ensure at least 1 night)
        const timeDiff = checkOutDate - checkInDate;
        const nights = Math.max(1, Math.ceil(timeDiff / (1000 * 60 * 60 * 24)));
        
        const total = roomPrice * nights;
        totalDisplay.textContent = '$' + total;
        totalDisplay.className = 'form-control bg-light text-success fw-bold';
    } else {
        totalDisplay.textContent = '$' + roomPrice + ' per night';
        totalDisplay.className = 'form-control bg-light';
    }
}

// Initialize price calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
});
</script>


<!-- About Section -->
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-primary-custom mb-4">About Khan Hotel Jampur</h2>
                <p class="lead">Established with a vision to provide unparalleled hospitality, Khan Hotel Jampur stands as a beacon of luxury and comfort in the region.</p>
                <p>Our hotel combines traditional hospitality with modern amenities to create a memorable experience for every guest. From business travelers to vacationing families, we cater to all your needs with exceptional service and attention to detail.</p>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary-custom me-3 fa-lg"></i>
                            <span>24/7 Room Service</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary-custom me-3 fa-lg"></i>
                            <span>Free Parking</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary-custom me-3 fa-lg"></i>
                            <span>Conference Facilities</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-primary-custom me-3 fa-lg"></i>
                            <span>Airport Transfer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="img-fluid rounded shadow" alt="Hotel Lobby">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-primary-custom">Our Services</h2>
            <p class="lead">Experience world-class amenities and services designed for your comfort</p>
        </div>

        <div class="row">
            @php
                $defaultServices = [
                    ['icon' => 'fas fa-swimming-pool', 'title' => 'Luxury Swimming Pool', 'description' => 'Relax in our beautifully designed pool area.', 'image' => 'images/gallery8.webp'],
                    ['icon' => 'fas fa-spa', 'title' => 'Spa & Wellness', 'description' => 'Enjoy world-class spa and massage services.', 'image' => 'images/gallery10.webp'],
                    ['icon' => 'fas fa-utensils', 'title' => 'Fine Dining Restaurant', 'description' => 'Experience gourmet dining with diverse cuisines.', 'image' => 'images/gallery9.webp'],
                    ['icon' => 'fas fa-wifi', 'title' => 'High-Speed Internet', 'description' => '24/7 free high-speed Wi-Fi for guests.', 'image' => 'images/gallery11.webp'],
                    ['icon' => 'fas fa-concierge-bell', 'title' => '24/7 Room Service', 'description' => 'Round-the-clock room service for your comfort.', 'image' => 'images/gallery12.webp'],
                    ['icon' => 'fas fa-car', 'title' => 'Free Parking', 'description' => 'Secure and spacious parking facility.', 'image' => 'images/gallery13.webp'],
                ];
            @endphp

            {{-- Static Services (Shown first) --}}
            @foreach($defaultServices as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm text-center">
                    <img src="{{ asset($service['image']) }}" class="card-img-top" alt="{{ $service['title'] }}" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <i class="{{ $service['icon'] }} fa-3x text-primary-custom mb-3"></i>
                        <h5 class="card-title">{{ $service['title'] }}</h5>
                        <p class="card-text">{{ $service['description'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Dynamic Services (From Database) --}}
        <div class="row mt-4">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm text-center">
                    
                    {{-- Dynamic Image OR fallback to static --}}
                    @php
                        $imagePath = $service->image ? asset('storage/' . $service->image) : asset('images/static/default.jpg');
                    @endphp
                    <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $service->title }}" style="height:200px; object-fit:cover;">

                    <div class="card-body">

                        {{-- Dynamic icon OR default icon --}}
                        <i class="{{ $service->icon ?? 'fas fa-star' }} fa-3x text-primary-custom mb-3"></i>

                        {{-- Dynamic Title --}}
                        <h5 class="card-title">{{ $service->title }}</h5>

                        {{-- Dynamic description --}}
                        <p class="card-text">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>


<!-- Gallery Section -->
<section id="gallery" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-primary-custom">Photo Gallery</h2>
            <p class="lead">Take a tour of our luxurious facilities and accommodations</p>
        </div>
        <div class="row">
            {{-- Dynamic Galleries --}}
            @foreach($galleries as $gallery)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             class="card-img-top" 
                             alt="{{ $gallery->title }}" 
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text text-center">{{ $gallery->title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Static Galleries --}}
            @php
                $staticImages = [
                    ['image' => 'images/gallery1.webp', 'title' => 'Luxury Lobby'],
                    ['image' => 'images/gallery2.webp', 'title' => 'Deluxe Room'],
                    ['image' => 'images/gallery3.webp', 'title' => 'Spa & Wellness'],
                    ['image' => 'images/gallery4.webp', 'title' => 'Swimming Pool'],
                    ['image' => 'images/gallery5.webp', 'title' => 'Restaurant Area'],
                    ['image' => 'images/gallery6.webp', 'title' => 'Conference Hall'],
                    ['image' => 'images/gallery7.webp', 'title' => 'Khan Hotel'] // Added Khan Hotel image
                ];
            @endphp

            @foreach($staticImages as $static)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{ asset($static['image']) }}" 
                             class="card-img-top" 
                             alt="{{ $static['title'] }}" 
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text text-center">{{ $static['title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Contact & Location Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-primary-custom mb-4">Contact Us</h2>
                @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

               <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
        </div>
        <div class="col-md-6 mb-3">
            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
        </div>
    </div>
    <div class="mb-3">
        <input type="tel" class="form-control" name="phone" placeholder="Your Phone" required>
    </div>
    <div class="mb-3">
        <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary-custom px-4">
        <i class="fas fa-paper-plane me-2"></i>Send Message
    </button>
</form>

            </div>
            <div class="col-lg-6">
                <h2 class="text-primary-custom mb-4">Our Location</h2>
                <div class="card">
                    <div class="card-body">
                        <h5><i class="fas fa-map-marker-alt text-primary-custom me-2"></i>Address</h5>
                        <p class="mb-3">Main Bazaar, Jampur City<br>Punjab, Pakistan</p>
                        
                        <h5><i class="fas fa-phone text-primary-custom me-2"></i>Phone</h5>
                        <p class="mb-3">+92 300 1234567</p>
                        
                        <h5><i class="fas fa-envelope text-primary-custom me-2"></i>Email</h5>
                        <p class="mb-3">info@khanhoteljampur.com</p>
                        
                        <div class="mt-4">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3477.427456238238!2d70.61731531509917!3d29.64254358204094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x393ff2b255555555%3A0x6a5e5d5b5e5d5e5d!2sJampur%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1640000000000!5m2!1sen!2s" 
                                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">

            <!-- About -->
            <div class="col-md-3 mb-4">
                <h5><i class="fas fa-hotel me-2"></i>Khan Hotel Jampur</h5>
                <p>Experience comfort, luxury, and peace. Your perfect stay with exceptional hospitality and 24/7 support.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#home" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="#about" class="text-white text-decoration-none">About Us</a></li>
                    <li><a href="#gallery" class="text-white text-decoration-none">Gallery</a></li>
                    <li><a href="#contact" class="text-white text-decoration-none">Contact</a></li>
                    <li><a href="#booking" class="text-white text-decoration-none">Book Now</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-md-3 mb-4">
                <h5>Our Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">Deluxe Rooms</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Conference Hall</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Restaurant & Dining</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Event Hosting</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Car Parking</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-3 mb-4">
                <h5>Contact Us</h5>
                <p class="mb-1"><i class="fas fa-envelope me-2"></i>info@khanhotel.com</p>
                <p class="mb-1"><i class="fab fa-whatsapp me-2"></i>+92 300 1234567</p>
                <p class="mb-1"><i class="fas fa-phone me-2"></i>+92 321 9876543</p>
                <p><i class="fas fa-clock me-2"></i>24/7 Customer Support Available</p>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center">
            <p class="mb-0">&copy; 2024 Khan Hotel Jampur. All rights reserved.</p>
        </div>
    </div>
</footer>


<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Booking Form Submission
    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "{{ route('bookings.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#successMessage').text(response.message);
                $('#successModal').modal('show');
                $('#bookingForm')[0].reset();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Contact Form Submission
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "{{ route('contacts.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#successMessage').text(response.message);
                $('#successModal').modal('show');
                $('#contactForm')[0].reset();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Smooth scrolling for navigation links
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 70
        }, 500);
    });
});
</script>

@endsection