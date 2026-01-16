@extends('layout')

@section('content')
<style>
  /* CONFIGURATION DES COULEURS (Thème Blanc) */
  :root {
    --bg-color: #f4f6f9;       /* Fond de la page (gris très clair) */
    --card-bg: #ffffff;        /* Fond du formulaire (blanc pur) */
    --text-color: #333333;     /* Texte noir */
    --label-color: #666666;    /* Texte des labels */
    --input-bg: #f8f9fa;       /* Fond des inputs */
    --input-border: #dddddd;   /* Bordure des inputs */
    --primary-color: #2ea44f;  /* Le vert exact du bouton GitHub/Image */
    --primary-hover: #2c974b;
    --link-color: #0366d6;     /* Bleu des liens */
  }

  body {
    background-color: var(--bg-color);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
  }

  /* LE CONTENEUR CENTRAL */
  .login-card {
    background-color: var(--card-bg);
    width: 100%;
    max-width: 400px;
    margin: 60px auto;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  /* LABELS */
  .form-label {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: var(--text-color);
  }

  /* CHAMPS INPUT (Arrondis comme sur l'image) */
  .form-input {
    width: 100%;
    padding: 10px 15px;
    background-color: var(--input-bg);
    border: 1px solid var(--input-border);
    border-radius: 6px;
    font-size: 0.95rem;
    color: var(--text-color);
    box-sizing: border-box; /* Important pour ne pas casser la largeur */
    margin-bottom: 20px;
    transition: border-color 0.2s;
  }

  .form-input:focus {
    outline: none;
    border-color: var(--link-color);
    background-color: #fff;
  }

  /* LIGNE "SE SOUVENIR" & "MDP OUBLIÉ" */
  .options-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    margin-bottom: 20px;
  }

  .options-row a {
    color: var(--link-color);
    text-decoration: none;
  }

  /* BOUTON SIGN IN (Vert) */
  .btn-submit {
    width: 100%;
    padding: 10px;
    background-color: var(--primary-color);
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-submit:hover {
    background-color: var(--primary-hover);
  }

  /* LIEN S'INSCRIRE */
  .register-link {
    text-align: center;
    margin-top: 15px;
    font-size: 0.9rem;
    color: var(--label-color);
  }
  .register-link a {
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
  .divider::before, .divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e1e4e8;
  }
  .divider::before { margin-right: 10px; }
  .divider::after { margin-left: 10px; }

  /* BOUTONS SOCIAUX (Alignés) */
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
    background-color: #ffffff; /* Fond blanc */
    border: 1px solid #d1d5da; /* Bordure grise */
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
  .social-btn img, .social-btn svg {
    margin-right: 8px;
  }
</style>

<div class="login-card">
    
    @if ($errors->any())
        <div style="background: #ffebe9; color: #cf222e; padding: 10px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #ff818266; font-size: 0.9em;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="Enter your Email" value="{{ old('email') }}" required autofocus>

        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input" placeholder="Enter your Password" required>

        <div class="options-row">
            <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; color: #555;">
                <input type="checkbox" name="remember"> Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            @else
                <a href="#">Forgot your password?</a>
            @endif
        </div>

        <button type="submit" class="btn-submit">Sign In</button>

        <div class="register-link">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>

        <div class="divider">Or With</div>

        <div class="social-buttons">
            <a href="{{ route('social.redirect', 'google') }}" class="social-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.221,0-9.652-3.343-11.303-8l-6.571,4.819C9.656,39.663,16.318,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                Google
            </a>

            <a href="{{ route('social.redirect', 'github') }}" class="social-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                Github
            </a>
        </div>

    </form>
</div>
@endsection