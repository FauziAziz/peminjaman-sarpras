@extends('layouts.auth')

@section('content')
<p class="login-box-msg text-muted">Silakan login untuk masuk ke aplikasi</p>

@if ($errors->any())
    <div class="alert alert-danger py-2 small mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required autofocus>
        <div class="input-group-text"><span class="bi bi-person"></span></div>
    </div>
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </div>
</form>
@endsection
