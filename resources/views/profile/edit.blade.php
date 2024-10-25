@extends('layout.master')
@section('main-content')

<div class="container">
    <h2>Modifier le Profile</h2>@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div class="form-group">
    <label for="name">Nom:</label>
    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <!-- Email -->
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" class="form-control" required>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
    <label for="password_confirmation">Confirmer Password:</label>
    <input type="password" name="password_confirmation" class="form-control" required>
    @error('password_confirmation')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
</div>
@endsection
