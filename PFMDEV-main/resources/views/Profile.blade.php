@extends('layout')

@section('content')
<div style="max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    
    <h2 style="text-align: center; color: #2c3e50;">Mon Profil</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH') <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 150px; height: 150px; margin: 0 auto 15px; border-radius: 50%; overflow: hidden; border: 3px solid #3498db; background: #ecf0f1;">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Photo de profil" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3498db&color=fff&size=150" alt="Avatar par défaut" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>

            <label for="photo" style="cursor: pointer; background: #ecf0f1; padding: 8px 15px; border-radius: 20px; font-size: 0.9em; font-weight: bold; color: #7f8c8d;">
                📷 Changer la photo
            </label>
            <input type="file" name="photo" id="photo" style="display: none;" onchange="this.form.submit()"> @error('photo')
                <p style="color: red; font-size: 0.8em;">{{ $message }}</p>
            @enderror
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <div style="margin-bottom: 15px;">
            <label>Nom complet :</label>
            <input type="text" name="name" value="{{ $user->name }}" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label>Email :</label>
            <input type="email" name="email" value="{{ $user->email }}" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <button type="submit" style="width: 100%; background: #3498db; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            Mettre à jour mes informations
        </button>
    </form>
</div>
@endsection