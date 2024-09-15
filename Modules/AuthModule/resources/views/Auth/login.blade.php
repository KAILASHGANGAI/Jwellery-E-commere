<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
    background-color: #f8f9fa;
}

.card {
    border-radius: 10px;
}

h2 {
    font-weight: bold;
}

p {
    color: #6c757d;
}

input {
    border: 2px solid #ced4da;
    border-radius: 0.25rem;
    padding: 0.75rem;
}

input:focus {
    border-color: #0056b3;
    box-shadow: none;
}

button {
    background-color: #0056b3;
    border: none;
    padding: 0.75rem;
    border-radius: 0.25rem;
}

button:hover {
    background-color: #004495;
}

</style>
<body>

    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="card p-5 shadow-lg" style="width: 100%; max-width: 400px;">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="your-logo.png" alt="Logo" width="50">

            </div>
            <!-- Welcome Text -->
            <div class="text-center mb-4">
                <h2>Welcome Back!</h2>
                <p>Please enter login details below</p>
            </div>
            <!-- Login Form -->
            @include('admin::includes.errors')
            <form action="{{ route('adminlogin') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter the email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Enter the Password" required>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a href="#" class="text-decoration-none">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
