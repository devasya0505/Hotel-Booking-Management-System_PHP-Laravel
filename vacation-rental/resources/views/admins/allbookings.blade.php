@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0 font-weight-bold">
                        <i class="fas fa-calendar-check mr-2"></i>Bookings Management
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Success Messages with Progress Bars -->
                    @if (session()->has('update'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="updateAlert">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">{{ session()->get('update') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="progress mt-2" style="height: 4px; background-color: #e9ecef;">
                                <div class="progress-bar bg-success" id="countdownBarUpdate"
                                    style="width: 100%; transition: width 0.1s linear;"></div>
                            </div>
                        </div>
                    @endif

                    @if (session()->has('delete'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="deleteAlert">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">{{ session()->get('delete') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="progress mt-2" style="height: 4px; background-color: #e9ecef;">
                                <div class="progress-bar bg-success" id="countdownBarDelete"
                                    style="width: 100%; transition: width 0.1s linear;"></div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0 font-weight-bold text-primary">All Bookings</h5>
                        <div class="text-muted">
                            Total: {{ $bookings->count() }} bookings
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center">Check In</th>
                                    <th scope="col" class="text-center">Check Out</th>
                                    <th scope="col">Guest Name</th>
                                    <th scope="col">Hotel</th>
                                    <th scope="col">Room</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Payment</th>
                                    <th scope="col" class="text-center">Change Status</th>
                                    <th scope="col" class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="text-center">
                                            <span class="font-weight-bold text-primary">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="font-weight-bold text-primary">
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="font-weight-bold">{{ $booking->name }}</td>
                                        <td>
                                            <span class="text-muted">{{ $booking->hotel_name }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $booking->room_name }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($booking->status == 'confirmed')
                                                <span class="badge badge-success py-2 px-3">
                                                    <i class="fas fa-check mr-1"></i>Confirmed
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge badge-warning py-2 px-3">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="badge badge-danger py-2 px-3">
                                                    <i class="fas fa-times mr-1"></i>Cancelled
                                                </span>
                                            @else
                                                <span class="badge badge-info py-2 px-3">
                                                    {{ $booking->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center font-weight-bold text-success">
                                            Rs. {{ $booking->price }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('bookings.edit.status', $booking->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit mr-1"></i>Change Status
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-booking-id="{{ $booking->id }}"
                                                data-guest-name="{{ $booking->name }}"
                                                data-hotel-name="{{ $booking->hotel_name }}"> 
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Optional: Add pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $bookings->count() }} bookings
                        </div>
                        <!-- If you have pagination, uncomment this -->
                        {{-- <!-- {{ $bookings->links() }} --> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Booking Deletion
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete booking for "<strong id="guestName"></strong>" at "<strong
                            id="hotelName"></strong>"?</p>
                    <p class="text-danger mb-0">
                        <i class="fas fa-info-circle mr-1"></i>This action cannot be undone and will permanently remove the
                        booking record.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i>Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle countdown for any alert
            function setupCountdown(alertElement, barElement) {
                if (alertElement && barElement) {
                    let width = 100;
                    const duration = 4000; // 4 seconds
                    const intervalTime = 50; // Update every 50ms
                    const decrement = (intervalTime / duration) * 100;

                    const countdownInterval = setInterval(() => {
                        width -= decrement;
                        barElement.style.width = width + '%';

                        if (width <= 0) {
                            clearInterval(countdownInterval);
                            alertElement.style.opacity = '0';
                            setTimeout(() => {
                                alertElement.remove();
                            }, 300);
                        }
                    }, intervalTime);

                    // Also allow manual close
                    alertElement.querySelector('.close').addEventListener('click', function() {
                        clearInterval(countdownInterval);
                        alertElement.style.opacity = '0';
                        setTimeout(() => {
                            alertElement.remove();
                        }, 300);
                    });
                }
            }

            // Setup countdown for update alert
            const updateAlert = document.getElementById('updateAlert');
            const countdownBarUpdate = document.getElementById('countdownBarUpdate');
            if (updateAlert && countdownBarUpdate) setupCountdown(updateAlert, countdownBarUpdate);

            // Setup countdown for delete alert
            const deleteAlert = document.getElementById('deleteAlert');
            const countdownBarDelete = document.getElementById('countdownBarDelete');
            if (deleteAlert && countdownBarDelete) setupCountdown(deleteAlert, countdownBarDelete);

            // Delete Confirmation Modal for Bookings
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = document.getElementById('deleteModal');
            const guestNameElement = document.getElementById('guestName');
            const hotelNameElement = document.getElementById('hotelName');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    const guestName = this.getAttribute('data-guest-name');
                    const hotelName = this.getAttribute('data-hotel-name');

                    // Set guest and hotel names in modal
                    guestNameElement.textContent = guestName;
                    hotelNameElement.textContent = hotelName;

                    // Set form action
                    deleteForm.action = `/admin/delete-bookings/${bookingId}`;

                    // Show modal
                    $(deleteModal).modal('show');
                });
            });
        });
    </script>

    <style>
        .progress {
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 2px;
        }

        .delete-btn {
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            transform: scale(1.05);
        }

        .badge {
            font-size: 0.8rem;
        }
    </style>
@endsection
