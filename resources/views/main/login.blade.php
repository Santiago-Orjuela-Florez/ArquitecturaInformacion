<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Scripts & Styles (Tailwind via CDN para prototipado rápido) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="glass-card w-full max-w-md rounded-3xl p-8 md:p-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl logo-text italic mb-2">Coca-Cola</h1>
            <p class="text-gray-500 font-medium text-sm">Panel de Gestión Corporativa</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
         @csrf
  

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="usuario@cocacola.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 input-focus transition-all @error('email') border-red-500 @enderror"
                    required
                    autofocus
                >
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between mb-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-red-400 hover:text-red-600 transition-colors">¿Olvidaste tu clave?</a>
                    @endif
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 input-focus transition-all @error('password') border-red-500 @enderror"
                    required
                >
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-400" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 text-sm text-gray-600">Mantener sesión activa</label>
            </div>

            <!-- Submit -->
            <button 
                type="submit" 
                class="w-full py-4 btn-gradient text-white font-bold rounded-xl shadow-lg uppercase tracking-wider text-sm"
            >
                Acceder al Portal
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-gray-400 text-xs">
                © {{ date('Y') }} The Coca-Cola Company. <br> Acceso restringido a personal autorizado.
            </p>
        </div>
    </div>

    <!-- Credenciales Mock para Pruebas Locales -->
    <script>
        console.log("Credenciales de acceso: admin@cocacola.com / Coke2024!");
    </script>
</body>
</html>