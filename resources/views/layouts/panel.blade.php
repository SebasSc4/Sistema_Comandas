<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('rol') | ComandaPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex">
    <aside class="w-60 shrink-0 bg-panel border-r border-line p-5 flex flex-col justify-between">
        <div>
            <div class="mb-8 px-3"><span class="font-display text-2xl font-bold">ComandaPro</span></div>
            <nav class="space-y-1">@yield('nav')</nav>
        </div>
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="size-9 rounded-full bg-raised grid place-items-center font-display font-bold">@yield('iniciales')</div>
            <div class="text-sm leading-tight">
                <p class="font-medium">@yield('usuario')</p>
                <p class="text-humo text-xs">@yield('rol')</p>
            </div>
        </div>
    </aside>
    <main class="flex-1 p-8 min-w-0">
        <header class="flex items-center justify-between mb-8">
            <h1 id="titulo" class="text-3xl font-semibold">@yield('titulo-inicial')</h1>
            <a href="{{ route('login') }}" class="btn">Cerrar sesión</a>
        </header>
        @yield('contenido')
    </main>
</body>
</html>