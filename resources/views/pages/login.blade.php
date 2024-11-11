@extends('layouts.layout')
@section('content')
<style>
    /* Background styling */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f0f4f8; /* Warna latar belakang yang lebih lembut */
        font-family: 'Arial', sans-serif;
    }

    /* Customize the card appearance */
    .card {
        background-color: #ffffff; /* Warna background card putih */
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        padding: 40px 30px;
        max-width: 400px;
        width: 100%;
    }

    /* Input field styling */
    .form-control {
        padding: 12px 20px;
        border: 1px solid #ced4da;
        border-radius: 50px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.2);
        outline: none;
    }

    /* Button styling */
    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 12px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(33, 136, 56, 0.3);
    }

    /* Error message styling */
    .text-danger {
        font-size: 0.85em;
        font-weight: 500;
    }

    /* Form heading styling */
    .card h3 {
        font-weight: bold;
        font-size: 1.6rem;
        color: #333;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .card-login {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card {
            padding: 30px 20px;
        }

        .btn-success {
            padding: 10px;
        }
    }
</style>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; width: 100%; position: relative;">
        <div class="card p-5 shadow-lg rounded-lg border-0 card-login">
            <h3 class="mb-4">Login</h3>
            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                @if (Session::get('failed'))
                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                @endif

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill shadow-sm" placeholder="Enter your email" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control rounded-pill shadow-sm" placeholder="Enter your password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success rounded-pill shadow-sm">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
