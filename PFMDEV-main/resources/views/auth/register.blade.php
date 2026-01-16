@extends('layout')

@section('content')
    <style>
        /* CONFIGURATION DES COULEURS (Thème Blanc) */
        :root {
            --bg-color: #f4f6f9;
            /* Fond de la page (gris très clair) */
            --card-bg: #ffffff;
            /* Fond du formulaire (blanc pur) */
            --text-color: #333333;
            /* Texte noir */
            --label-color: #666666;
            /* Texte des labels */
            --input-bg: #f8f9fa;
            /* Fond des inputs */
            --input-border: #dddddd;
            /* Bordure des inputs */
            --primary-color: #2ea44f;
            /* Le vert exact du bouton GitHub/Image */
            --primary-hover: #2c974b;
            --link-color: #0366d6;
            /* Bleu des liens */
        }

        body {
            background-color: var(--bg-color);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
        }

        /* LE CONTENEUR CENTRAL */
        .register-card {
            background-color: var(--card-bg);
            width: 100%;
            max-width: 400px;
            margin: 60px auto;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* TITRE */
        .register-card h2 {
            text-align: center;
            color: var(--text-color);
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        /* LABELS */
        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--text-color);
            margin-top: 15px;
        }

        /* CHAMPS INPUT */
        .form-input {
            width: 100%;
            padding: 10px 15px;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--text-color);
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 164, 79, 0.1);
        }

        /* BOUTON SUBMIT */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        /* MESSAGE D'ERREUR */
        .error-message {
            background: #ffebe9;
            color: #cf222e;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #ff818266;
            font-size: 0.9em;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }

        /* MESSAGE DE SUCCÈS */
        .success-message {
            background: #dafbe1;
            color: #033a16;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #26a641;
            font-size: 0.9em;
        }

        /* LIEN DE LOGIN */
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--label-color);
        }

        .login-link a {
            color: var(--link-color);
            text-decoration: none;
            font-weight: 600;
        }

        /* DIVISEUR "Or With" */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: var(--label-color);
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e1e4e8;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        /* BOUTONS SOCIAUX */
        .social-buttons {
            display: flex;
            gap: 15px;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            background-color: #ffffff;
            border: 1px solid #d1d5da;
            border-radius: 6px;
            text-decoration: none;
            color: #24292e;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .social-btn:hover {
            background-color: #f3f4f6;
        }

        .social-btn img,
        .social-btn svg {
            margin-right: 8px;
            width: 18px;
            height: 18px;
        }
    </style>

    <div class="register-card">
        <h2>{{ __('Create Account') }}</h2>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label class="form-label" for="name">{{ __('Full Name') }}</label>
            <input type="text" id="name" name="name" class="form-input" placeholder="Your full name"
                value="{{ old('name') }}" required autofocus>

            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com"
                value="{{ old('email') }}" required>

            <label class="form-label" for="password">{{ __('Password') }}</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="At least 6 characters"
                required>

            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                placeholder="Confirm your password" required>

            <button type="submit" class="btn-submit">{{ __('Create Account') }}</button>

            <div class="login-link">
                {{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Sign in here') }}</a>
            </div>

            <div class="divider">{{ __('Or With') }}</div>

            <div class="social-buttons">
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#FFC107"
                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                        <path fill="#FF3D00"
                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                        <path fill="#4CAF50"
                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.221,0-9.652-3.343-11.303-8l-6.571,4.819C9.656,39.663,16.318,44,24,44z" />
                        <path fill="#1976D2"
                            d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                    </svg>
                    Google
                </a>

                <a href="{{ route('social.redirect', 'github') }}" class="social-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                    </svg>
                    GitHub
                </a>
            </div>

        </form>
    </div>
@endsection