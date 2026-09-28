@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg rounded">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0 font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i>Create New Room
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Room Name -->
                    <div class="form-group mb-4">
                        <label for="name" class="form-label font-weight-bold text-dark">Room Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-door-open text-primary"></i>
                                </span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control" 
                                   placeholder="Enter room name" required />
                        </div>
                    </div>

                    <!-- Room Image -->
                    <div class="form-group mb-4">
                        <label for="image" class="form-label font-weight-bold text-dark">Room Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" id="image" class="custom-file-input" required />
                            <label class="custom-file-label" for="image">Choose room image...</label>
                        </div>
                        <small class="form-text text-muted">Recommended size: 800x600px</small>
                    </div>

                    <!-- Price -->
                    <div class="form-group mb-4">
                        <label for="price" class="form-label font-weight-bold text-dark">Price per Night</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light">
                                    <span class="text-primary font-weight-bold">Rs.</span>
                                </span>
                            </div>
                            <input type="text" name="price" id="price" class="form-control" 
                                   placeholder="Enter price per night" required />
                        </div>
                    </div>

                    <!-- Room Details Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="max_persons" class="form-label font-weight-bold text-dark">Max Persons</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-users text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="max_persons" id="max_persons" class="form-control" 
                                           placeholder="Max persons" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="num_beds" class="form-label font-weight-bold text-dark">Number of Beds</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-bed text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="num_beds" id="num_beds" class="form-control" 
                                           placeholder="Number of beds" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Size and View Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="size" class="form-label font-weight-bold text-dark">Room Size</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-arrows-alt text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="size" id="size" class="form-control" 
                                           placeholder="Room size (sq. ft)" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="view" class="form-label font-weight-bold text-dark">Room View</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-binoculars text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="view" id="view" class="form-control" 
                                           placeholder="Room view" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hotel Selection -->
                    <div class="form-group mb-4">
                        <label for="hotel_id" class="form-label font-weight-bold text-dark">Select Hotel</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-hotel text-primary"></i>
                                </span>
                            </div>
                            <select name="hotel_id" id="hotel_id" class="form-control" required>
                                <option value="">Choose Hotel Name</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block font-weight-bold py-3">
                            <i class="fas fa-save mr-2"></i>Create Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Bootstrap custom file input
    document.addEventListener('DOMContentLoaded', function() {
        // File input functionality
        const fileInput = document.getElementById('image');
        const fileLabel = document.querySelector('.custom-file-label');
        
        if (fileInput && fileLabel) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileLabel.textContent = this.files[0].name;
                } else {
                    fileLabel.textContent = 'Choose room image...';
                }
            });
        }
    });
</script>

<style>
    .custom-file-label {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    
    .custom-file:hover .custom-file-label {
        border-color: #007bff;
        cursor: pointer;
    }
</style>
@endsection