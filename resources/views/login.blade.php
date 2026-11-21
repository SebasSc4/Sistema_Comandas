<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | ComandaPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen grid md:grid-cols-2">
    <section class="hidden md:flex flex-col justify-between bg-panel border-r border-line p-12">
        <span class="font-display text-2xl font-bold">ComandaPro</span>
        <div class="max-w-sm">
            <h2 class="text-5xl font-bold leading-none mb-4">Del salón a la cocina, sin papelitos perdidos.</h2>
            <p class="text-humo mb-10">Meseros y administración trabajando sobre la misma cuenta.</p>
            <div class="ticket p-5">
                <div class="flex justify-between items-center mb-3">
                    <span class="num text-2xl font-semibold">Mesa 12 · #302</span>
                    <span class="chip" data-estado="ocupada">En cocina</span>
                </div>
                <p class="font-medium">3x Tacos de Ribeye</p>
                <p class="text-humo text-sm">Sin cebolla · enviada hace 2 min</p>
            </div>
        </div>
        <span class="text-xs text-humo">© 2026 ComandaPro</span>
    </section>

    <section class="relative flex items-center justify-center p-8">
        <span id="puesto-titulo" class="puesto-titulo" aria-hidden="true"></span>

        <form action="{{ route('login.post') }}" method="POST" class="w-full max-w-sm space-y-6">
            @csrf
            <div>
                <h1 class="text-4xl font-semibold">Iniciar sesión</h1>
                <p class="text-humo text-sm mt-1">Elige tu puesto para continuar.</p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                @foreach (['mesero' => ['Mesero', 'Toma pedidos y gestiona sus mesas'], 'admin' => ['Administrador', 'Menú, mesas, ventas y usuarios']] as $valor => [$nombre, $desc])
                    <label class="cursor-pointer">
                        <input type="radio" name="puesto" value="{{ $valor }}" data-nombre="{{ $nombre }}" class="peer sr-only" {{ $valor === 'mesero' ? 'checked' : '' }}>
                        <div class="card p-4 h-full transition-colors peer-focus-visible:outline-2 peer-focus-visible:outline-hueso">
                            <p class="font-medium">{{ $nombre }}</p>
                            <p class="text-xs text-humo mt-1">{{ $desc }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm mb-1.5">Usuario o correo</label>
                    <input id="email" type="text" name="email" required class="input" placeholder="pedro@comandapro.com">
                </div>
                <div>
                    <label for="password" class="block text-sm mb-1.5">Contraseña</label>
                    <input id="password" type="password" name="password" required class="input" placeholder="Tu contraseña">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-full py-3">Entrar</button>
        </form>
    </section>

    <script>
        // Al cambiar de puesto, muestra su nombre con el efecto de degradado
        const titulo = document.getElementById('puesto-titulo');
        document.querySelectorAll('input[name="puesto"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                titulo.textContent = radio.dataset.nombre;
                titulo.classList.remove('is-animando');
                void titulo.offsetWidth; // reinicia la animación si se vuelve a elegir
                titulo.classList.add('is-animando');
            });
        });
    </script>
</body>
</html>