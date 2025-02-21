<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" href="{{ asset('img/LGULogo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="container">
        <div class="cover">
            <div class="front">
                <img src="{{ asset('img/magallanes.png') }}" alt="Background">
                <div class="text">
                    <span class="text-1">Welcome Back</span>
                    <span class="text-2">Login to continue</span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="logo-container">
                        <img src="{{ asset('img/LGUlogo.png') }}" alt="Logo">
                    </div>

                    @if (session('status'))
                        <div class="success-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="title">Login</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-boxes">
                            @if ($errors->has('email'))
                                <div class="error-message">{{ $errors->first('email') }}</div>
                            @endif
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email" required autofocus autocomplete="username">
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required
                                    autocomplete="current-password">
                            </div>
                            @if ($errors->has('password'))
                                <div class="error-message">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="text">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input type="checkbox" id="remember_me" name="remember"
                                        class="rounded border-gray-300">
                                    <span class="ml-2">Remember me</span>
                                </label>
                            </div>
                            <div class="button input-box">
                                <input type="submit" value="Login">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
