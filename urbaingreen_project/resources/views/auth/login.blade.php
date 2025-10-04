<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror"
                   type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="Votre adresse email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror"
                   type="password" name="password"
                   required autocomplete="current-password"
                   placeholder="Votre mot de passe">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">
                Se souvenir de moi
            </label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </div>

        <div class="text-center mt-3">
            @if (Route::has('password.request'))
                <a class="text-decoration-none text-muted" href="{{ route('password.request') }}">
                    <small>Mot de passe oublié ?</small>
                </a>
            @endif
        </div>

        <!-- Comptes de test -->
        <div class="mt-4 p-3 bg-light rounded">
            <h6 class="text-muted mb-2">
                <i class="bi bi-info-circle"></i> Comptes de test
            </h6>
            <small class="text-muted">
                <strong>Admin:</strong> admin@urbangreen.fr<br>
                <strong>Chef de projet:</strong> marie.dubois@urbangreen.fr<br>
                <strong>Citoyen:</strong> sophie.leroy@example.com<br>
                <em>Mot de passe: password</em>
            </small>
        </div>
    </form>
</x-guest-layout>
