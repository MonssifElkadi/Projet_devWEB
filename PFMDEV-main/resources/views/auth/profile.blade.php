@extends('layout')

@section('content')
<div style="max-width: 600px; margin: auto;">
    <h2>Modifier mon Profil</h2>
    
    <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Rôle (Non modifiable)</label>
                <input type="text" value="{{ ucfirst($user->role) }}" disabled style="background-color: #e9ecef; cursor: not-allowed;">
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">Laisser vide si vous ne voulez pas changer de mot de passe.</p>

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password" placeholder="Nouveau mot de passe (optionnel)">
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe">
            </div>

            <button type="submit" class="success" style="width: 100%; margin-top: 10px;">Mettre à jour mes informations</button>
        </form>

    </div>
</div>
@endsection