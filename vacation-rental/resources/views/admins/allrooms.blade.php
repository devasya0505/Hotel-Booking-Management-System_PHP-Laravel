@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0 font-weight-bold">
                        <i class="fas fa-door-open mr-2"></i>Rooms Management
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Success Messages with Progress Bars -->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="successAlert">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">{{ session()->get('success') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="progress mt-2" style="height: 4px; background-color: #e9ecef;">
                                <div class="progress-bar bg-success" id="countdownBar"
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
                        <h5 class="card-title mb-0 font-weight-bold text-primary">All Rooms</h5>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-2"></i>Create Room
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col" class="text-center">Image</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Persons</th>
                                    <th scope="col" class="text-center">Size</th>
                                    <th scope="col" class="text-center">View</th>
                                    <th scope="col" class="text-center">Beds</th>
                                    <th scope="col" class="text-center">Hotel ID</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $room->id }}</th>
                                        <td class="font-weight-bold text-primary">{{ $room->name }}</td>
                                        <td class="text-center">
                                            <img width="70" height="70"
                                                src="{{ asset('assets/images/' . $room->image . '') }}"
                                                class="rounded shadow-sm" alt="{{ $room->name }}">
                                        </td>
                                        <td class="text-center font-weight-bold text-success">
                                            Rs. {{ $room->price }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary py-2 px-3">
                                                <i class="fas fa-users mr-1"></i>{{ $room->max_persons }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-muted">{{ $room->size }} sq.ft</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info py-2 px-3">
                                                {{ $room->view }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary py-2 px-3">
                                                <i class="fas fa-bed mr-1"></i>{{ $room->num_beds }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning py-2 px-3">
                                                #{{ $room->hotel_id }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-room-id="{{ $room->id }}" data-room-name="{{ $room->name }}">
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
                            Showing {{ $rooms->count() }} rooms
                        </div>
                        <!-- If you have pagination, uncomment this -->
                        {{-- <!-- {{ $rooms->links() }} --> --}}
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
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Room Deletion
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete room "<strong id="roomName"></strong>"?</p>
                    <p class="text-danger mb-0">
                        <i class="fas fa-info-circle mr-1"></i>This action cannot be undone.
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

            // Setup countdown for success alert (room created)
            const successAlert = document.getElementById('successAlert');
            const countdownBar = document.getElementById('countdownBar');
            if (successAlert && countdownBar) setupCountdown(successAlert, countdownBar);

            // Setup countdown for delete alert (room deleted)
            const deleteAlert = document.getElementById('deleteAlert');
            const countdownBarDelete = document.getElementById('countdownBarDelete');
            if (deleteAlert && countdownBarDelete) setupCountdown(deleteAlert, countdownBarDelete);

            // Delete Confirmation Modal for Rooms
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = document.getElementById('deleteModal');
            const roomNameElement = document.getElementById('roomName');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const roomId = this.getAttribute('data-room-id');
                    const roomName = this.getAttribute('data-room-name');

                    // Set room name in modal
                    roomNameElement.textContent = roomName;

                    // Set form action
                    deleteForm.action = `/admin/delete-rooms/${roomId}`;

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
    </style>
@endsection
