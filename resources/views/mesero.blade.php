<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesero - ComandaPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-800">

    <!-- Menú Lateral -->
    <aside class="w-64 bg-white border-r border-slate-200 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-10">
                <div class="bg-blue-600 p-2 rounded-xl text-white font-bold">🍳</div>
                <span class="text-xl font-extrabold text-slate-900">ComandaPro</span>
            </div>

            <nav class="space-y-2">
                <button onclick="mostrarModulo('mesas')" id="btn-mesas" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-cyan-50 text-cyan-700 font-bold text-sm">
                    <span>🪑</span> <span>Mis Mesas</span>
                </button>
                <button onclick="mostrarModulo('comanda')" id="btn-comanda" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm">
                    <span>➕</span> <span>Nueva Comanda</span>
                </button>
                <button onclick="mostrarModulo('activas')" id="btn-activas" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm">
                    <span>⏰</span> <span>Comandas Activas</span>
                </button>
            </nav>
        </div>

        <div class="bg-slate-100 p-3 rounded-2xl flex items-center space-x-3">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200" class="w-10 h-10 rounded-full object-cover">
            <div>
                <h5 class="font-bold text-sm text-slate-900">Mesero Pedro</h5>
                <p class="text-xs text-slate-500">Salón Principal</p>
                <span class="text-[10px] text-emerald-600 font-bold block mt-1">• Turno Activo</span>
            </div>
        </div>
    </aside>

    <!-- Área de Trabajo Principal -->
    <main class="flex-1 p-8">

        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 id="titulo" class="text-2xl font-extrabold text-slate-900">Mis Mesas Asignadas</h1>
                <p id="subtitulo" class="text-xs text-slate-500">Gestión de mesas en salón principal</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-emerald-100 text-emerald-700 text-xs px-3 py-1.5 rounded-full font-bold">• Cocina Conectada</span>
                <a href="{{ route('login') }}" class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 text-xs font-bold">🚪 Salir</a>
            </div>
        </header>

        <!-- CAPTURA 2: MIS MESAS -->
        <div id="mod-mesas" class="space-y-6">
            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Mesas Totales</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">6 Mesas</h3>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Activas (Ocupadas)</p>
                    <h3 class="text-2xl font-black text-red-500 mt-1">2 Activas</h3>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Por Cobrar</p>
                    <h3 class="text-2xl font-black text-blue-600 mt-1">2 Cuentas</h3>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-xs text-slate-400 font-bold">Libres</p>
                    <h3 class="text-2xl font-black text-emerald-500 mt-1">2 Libres</h3>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 pt-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-bold text-slate-800">Mesa 1</h4>
                        <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Libre</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-6">Comensales: 2 Personas</p>
                    <button onclick="mostrarModulo('comanda')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm">Nueva Comanda</button>
                </div>
                <div class="bg-white p-6 rounded-2xl border-2 border-blue-600 shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="font-bold text-slate-800">Mesa 4</h4>
                        <span class="bg-red-100 text-red-600 text-xs px-2.5 py-1 rounded-full font-bold">Ocupada</span>
                    </div>
                    <p class="text-xs text-slate-400">Comensales: 4 Personas</p>
                    <p class="text-xs font-bold text-slate-700 mt-1 mb-4">Consumo: $540.00</p>
                    <button onclick="mostrarModulo('activas')" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-sm">Ver Comanda</button>
                </div>
            </div>
        </div>

        <!-- CAPTURA 3: NUEVA COMANDA -->
        <div id="mod-comanda" class="hidden grid grid-cols-3 gap-8">
            <div class="col-span-2 space-y-4">
                <div class="flex space-x-3">
                    <button class="px-4 py-2 bg-slate-200 rounded-xl text-xs font-bold text-slate-600">Entradas</button>
                    <button class="px-4 py-2 bg-blue-600 rounded-xl text-xs font-bold text-white shadow-md">Platos Fuertes</button>
                    <button class="px-4 py-2 bg-slate-200 rounded-xl text-xs font-bold text-slate-600">Bebidas</button>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-slate-200 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Tacos de Ribeye (3 piezas)</h4>
                        <p class="text-xs text-slate-400">Corte premium de ribeye en tortilla de maíz taquera artesanal.</p>
                        <span class="text-xs font-bold text-blue-600 mt-1 block">$220.00</span>
                    </div>
                    <button class="w-8 h-8 bg-cyan-100 text-cyan-700 font-bold rounded-xl">+</button>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-slate-800 border-b pb-4 mb-4">Detalle del Pedido (Mesa 4)</h3>
                    <div class="flex justify-between text-xs font-bold text-slate-800 mb-2">
                        <span>2x Tacos de Ribeye</span>
                        <span>$440.00</span>
                    </div>
                    <textarea placeholder="Notas de la comanda..." class="w-full mt-4 p-3 border border-slate-200 rounded-xl bg-slate-50 text-xs outline-none"></textarea>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-sm font-extrabold text-slate-900 mb-4">
                        <span>Total Estimado</span>
                        <span class="text-blue-600">$649.60</span>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl text-sm">Enviar Comanda a Cocina</button>
                </div>
            </div>
        </div>

        <!-- CAPTURA 4: COMANDAS ACTIVAS -->
        <div id="mod-activas" class="hidden">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 font-bold border-b border-slate-200">
                        <tr>
                            <th class="p-4">Mesa</th>
                            <th class="p-4">Comanda</th>
                            <th class="p-4">Platillos</th>
                            <th class="p-4">Estado</th>
                            <th class="p-4">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        <tr>
                            <td class="p-4 font-bold">Mesa 12</td>
                            <td class="p-4 text-slate-400">#302</td>
                            <td class="p-4">3x Tacos de Ribeye • Sin cebolla</td>
                            <td class="p-4"><span class="bg-cyan-100 text-cyan-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Preparando</span></td>
                            <td class="p-4 font-bold">$220.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Script para alternar los módulos dinámicamente -->
    <script>
        function mostrarModulo(nombre) {
            ['mesas', 'comanda', 'activas'].forEach(m => {
                document.getElementById('mod-' + m).classList.add('hidden');
                document.getElementById('btn-' + m).className = "w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-100 text-slate-600 font-semibold text-sm";
            });

            document.getElementById('mod-' + nombre).classList.remove('hidden');
            document.getElementById('btn-' + nombre).className = "w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-cyan-50 text-cyan-700 font-bold text-sm";
        }
    </script>
</body>
</html>