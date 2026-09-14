<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - ComandaPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-800">

    <!-- Menú Lateral Admin -->
    <aside class="w-64 bg-white border-r border-slate-200 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-10">
                <div class="bg-blue-600 p-2 rounded-xl text-white font-bold">🍳</div>
                <span class="text-xl font-extrabold text-slate-900">ComandaPro</span>
            </div>

            <nav class="space-y-2">
                <button onclick="mostrarAdmin('dash')" id="abtn-dash" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-cyan-50 text-cyan-700 font-bold text-sm">
                    <span>📊</span> <span>Dashboard</span>
                </button>
                <button onclick="mostrarAdmin('menu')" id="abtn-menu" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm">
                    <span>📖</span> <span>Gestión de Menú</span>
                </button>
                <button onclick="mostrarAdmin('mesas')" id="abtn-mesas" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm">
                    <span>👥</span> <span>Mesas y Meseros</span>
                </button>
            </nav>
        </div>

        <div class="bg-slate-100 p-3 rounded-2xl flex items-center space-x-3">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200" class="w-10 h-10 rounded-full object-cover">
            <div>
                <h5 class="font-bold text-sm text-slate-900">Carlos Mendoza</h5>
                <p class="text-xs text-slate-500">Administrador</p>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8">

        <header class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-900">Panel de Administración</h1>
            <a href="{{ route('login') }}" class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 text-xs font-bold">🚪 Salir</a>
        </header>

        <!-- CAPTURA 5: DASHBOARD -->
        <div id="amod-dash" class="space-y-6">
            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Ventas del Día</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-2">$12,450.00</h3>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Comandas Activas</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-2">8 Activas</h3>
                </div>
            </div>
        </div>

        <!-- CAPTURA 6: GESTIÓN DE MENÚ -->
        <div id="amod-menu" class="hidden grid grid-cols-3 gap-8">
            <div class="col-span-2 bg-white rounded-2xl border border-slate-200 p-4">
                <h3 class="font-bold mb-4">Lista de Platillos</h3>
                <table class="w-full text-left text-xs">
                    <tbody class="divide-y">
                        <tr>
                            <td class="py-3 font-bold">Tacos de Ribeye (3x)</td>
                            <td class="text-slate-400">Platos Fuertes</td>
                            <td class="font-bold">$180.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="font-bold mb-4">Editar Producto</h3>
                <label class="block text-xs font-bold mb-1">Nombre</label>
                <input type="text" value="Tacos de Ribeye (3x)" class="w-full p-2 border rounded-xl text-xs mb-3">
                <button class="w-full bg-blue-600 text-white font-bold py-2 rounded-xl text-xs">Guardar Cambios</button>
            </div>
        </div>

        <!-- CAPTURA 7: MESAS Y MESEROS -->
        <div id="amod-mesas" class="hidden space-y-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200">
                <h3 class="font-bold text-slate-900 mb-2">Asignación de Meseros</h3>
                <p class="text-xs text-slate-500">Pedro Gomez -> Mesa 1, Mesa 4</p>
            </div>
        </div>

    </main>

    <script>
        function mostrarAdmin(nombre) {
            ['dash', 'menu', 'mesas'].forEach(m => {
                document.getElementById('amod-' + m).classList.add('hidden');
                document.getElementById('abtn-' + m).className = "w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm";
            });

            document.getElementById('amod-' + nombre).classList.remove('hidden');
            document.getElementById('abtn-' + nombre).className = "w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-cyan-50 text-cyan-700 font-bold text-sm";
        }
    </script>
</body>
</html>