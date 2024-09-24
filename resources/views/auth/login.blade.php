<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    .btn-outline-danger,
    .btn-outline-primary,
    .btn-outline-dark {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn i {
        margin-right: 10px;
    }

    .toggle-password {
        position: absolute;
        top: 55%;
        right: 10px;
        cursor: pointer;
        font-size: 1.2rem;
        color: #aaa;
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
            <div class="col-md-5 mx-auto">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="text-center">Login</h3>
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="Enter email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>  
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" value="{{ old('password') }}" class="form-control" id="password" placeholder="Password">
                        
                                <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}  id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">or login with</div>
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-outline-danger"><i class="fa-brands fa-google"></i> Login with
                                Google</button>
                            <button class="btn btn-outline-primary"><i class="fa-brands fa-facebook-f"></i> Login with
                                Facebook</button>
                        </div>
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
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
            // Toggle the type attribute of the password field
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon between eye and eye-slash
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>
