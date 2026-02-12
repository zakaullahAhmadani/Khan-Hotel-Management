<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation - Khan Hotel Jampur</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #c19a6b; color: white; padding: 20px; text-align: center; }
        .content { background: #f4f4f4; padding: 20px; }
        .booking-details { background: white; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .footer { text-align: center; margin-top: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Khan Hotel Jampur</h1>
            <h2>Booking Confirmation</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $booking->name }},</p>
            <p>Thank you for choosing Khan Hotel Jampur! Your booking has been received and is being processed.</p>
            
            <div class="booking-details">
                <h3>Booking Details:</h3>
                <p><strong>Booking Reference:</strong> #{{ $booking->id }}</p>
                <p><strong>Check-in Date:</strong> {{ $booking->check_in->format('F d, Y') }}</p>
                <p><strong>Check-out Date:</strong> {{ $booking->check_out->format('F d, Y') }}</p>
                <p><strong>Room Type:</strong> {{ ucfirst($booking->room_type) }}</p>
                <p><strong>Number of Guests:</strong> {{ $booking->guests }}</p>
                @if($booking->special_requests)
                <p><strong>Special Requests:</strong> {{ $booking->special_requests }}</p>
                @endif
            </div>
            
            <p>We look forward to welcoming you to Khan Hotel Jampur. If you have any questions or need to modify your booking, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>
            The Khan Hotel Jampur Team<br>
            Phone: +92 300 1234567<br>
            Email: info@khanhoteljampur.com</p>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 Khan Hotel Jampur. All rights reserved.</p>
        </div>
    </div>
</body>
</html>