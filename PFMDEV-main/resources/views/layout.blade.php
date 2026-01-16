<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter </title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🖥️</text></svg>">
</head>
<body>

    <nav>
      <div class="nav-left">
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="{{ asset('images/logo.jpg') }}" 
                     alt="DataCenter Logo" 
                     style="height: 70px; width: 150px; border-radius: 50%; border: 0 solid white;">
                
                
            </a>
        </div>

        <div class="nav-center">
            <a href="{{ route('home') }}" 
               style="{{ request()->routeIs('home') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
               {{ __('Home') }}
            </a>

            <a href="{{ route('rules') }}" 
               style="{{ request()->routeIs('rules') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
               {{ __('Rules') }}
            </a>

            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       style="{{ request()->routeIs('admin.dashboard') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                       {{ __('Users') }} </a>
                    <a href="{{ route('admin.resources.index') }}" 
                       style="{{ request()->routeIs('admin.resources.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                       {{ __('Resources') }}
                    </a>
                
                @elseif(Auth::user()->role == 'manager')
                    <a href="{{ route('manager.dashboard') }}" 
                       style="{{ request()->routeIs('manager.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                       {{ __('Manager Area') }}
                    </a>
                
                @elseif(Auth::user()->role == 'internal')
                    <a href="{{ route('internal.dashboard') }}" 
                       style="{{ request()->routeIs('internal.*') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }}">
                       {{ __('My Area') }}
                    </a>
                @endif
            @endauth
        </div>

        <div class="nav-right">
            
            <div style="margin-right: 20px; font-size: 0.9em; display:flex; align-items:center;">
                <a href="{{ route('lang.switch', 'fr') }}" style="margin: 0; padding:0; border:none; {{ app()->getLocale() == 'fr' ? 'font-weight:bold; color:white;' : 'color:#bdc3c7; font-weight:normal;' }}">FR</a>
                <span style="color: white; opacity: 0.3; margin: 0 5px;">|</span>
                <a href="{{ route('lang.switch', 'en') }}" style="margin: 0; padding:0; border:none; {{ app()->getLocale() == 'en' ? 'font-weight:bold; color:white;' : 'color:#bdc3c7; font-weight:normal;' }}">EN</a>
            </div>

            @auth
                <a href="{{ route('profile') }}" 
                   style="{{ request()->routeIs('profile') ? 'border-bottom: 2px solid #3498db; color: #3498db;' : '' }} display: flex; align-items: center; gap: 8px;">
                   
                   @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="Profile"
                             style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid #ecf0f1;">
                   @endif
                   <span>{{ __('My Profile') }}</span>
                </a>

               <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        {{ __('Logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="{{ request()->routeIs('login') ? 'color: #3498db;' : '' }}">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" style="background: #3498db; color: white; padding: 8px 15px; border-radius: 4px; border:none; margin-left: 10px; {{ request()->routeIs('register') ? 'background: #2980b9;' : '' }}">
                    {{ __('Register') }}
                </a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer style="background: #2c3e50; color: #ecf0f1; padding: 20px 0; margin-top: auto; text-align: center;">
        <div class="container">
            <p>&copy; {{ date('Y') }} DataCenter Management System. {{ __('All rights reserved.') }}</p>
            <p style="font-size: 0.8em; color: #bdc3c7;">
                <a href="{{ route('rules') }}" style="color: #3498db; text-decoration: none;">{{ __('Usage Charter') }}</a>
            </p>
        </div>
    </footer>

</body>
</html>