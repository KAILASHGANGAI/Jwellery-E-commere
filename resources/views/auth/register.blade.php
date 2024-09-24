<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
    body {
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .toggle-password {
        position: absolute;
        top: 55%;
        right: 10px;
        cursor: pointer;
        font-size: 1.2rem;
        color: #aaa;
    }

    .bg-light {
        background-color: #f1f1f1;
    }

    .btn i {
        margin-right: 10px;
    }
    a{
        text-decoration: none;
        color: black;
    }
    a:hover{
        text-decoration: none;
        color: #a8741a;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card mt-5">
                    <div class="row g-0">
                        <!-- Left side: Registration Form -->
                        <div class="col-md-6 p-5">
                            <h3 class="text-center">Register</h3>
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter full name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="Enter phone number" required>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" id="password" placeholder="Password"
                                        required>
                                    <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" id="confirmPassword"
                                        placeholder="Confirm password" required>
                                    <i class="fa fa-eye toggle-password" id="toggleConfirmPassword"></i>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>

                        <!-- Right side: Social Media Register -->
                        <div class="col-md-6 bg-light p-5">
                            <h3 class="text-center">Register with Social Media</h3>
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-outline-danger"><i class="fa-brands fa-google"></i> Login with
                                    Google</button>
                                <button class="btn btn-outline-primary"><i class="fa-brands fa-facebook-f"></i> Login with
                                    Facebook</button>
                            </div>
                            <hr>
                            <div class="text-center mt-3">
                                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirmPassword');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
