<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ComandaPro</title>
    <!-- Esta línea es propia de Laravel para cargar Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden grid grid-cols-1 md:grid-cols-2 min-h-[600px]">
        
        <!-- Panel Izquierdo Oscuro -->
        <div class="relative bg-slate-950 p-10 text-white flex flex-col justify-between overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000');"></div>
            
            <div class="relative z-10 flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-xl text-white font-bold text-xl">🍳</div>
                <span class="text-xl font-extrabold tracking-tight">ComandaPro</span>
            </div>

            <div class="relative z-10 space-y-4 my-auto">
                <h2 class="text-3xl font-extrabold leading-tight">Control total de tu cocina<br><span class="text-blue-500">y salón</span></h2>
                <p class="text-slate-400 text-sm">La plataforma que unifica meseros, cocina y administración para acelerar el servicio y optimizar tus ingresos.</p>
                
                <div class="bg-slate-900/80 backdrop-blur-md p-4 rounded-2xl border border-slate-800 shadow-xl max-w-sm">
                    <div class="flex justify-between items-center text-xs text-slate-400 mb-1">
                        <span class="flex items-center space-x-1 text-emerald-400 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>SERVICIO ACTIVO</span>
                        </span>
                        <span>Mesa 12 • Cmd #302</span>
                    </div>
                    <p class="font-bold text-sm text-white">3x Tacos de Ribeye • Sin cebolla</p>
                    <p class="text-xs text-slate-400 mt-1">Enviado a Cocina • Hace 2 min</p>
                </div>
            </div>

            <div class="relative z-10 flex justify-between items-center text-xs text-slate-500">
                <span>ComandaPro Enterprise • Versión 4.2.0</span>
                <span>© 2026 Todos los derechos reservados.</span>
            </div>
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <div class="p-10 flex flex-col justify-between bg-slate-50/50">
            <div>
                <h3 class="text-2xl font-bold text-slate-900">Bienvenido de nuevo</h3>
                <p class="text-sm text-slate-500 mt-1">Selecciona tu puesto para ingresar al punto de venta o administración.</p>

                <form action="{{ route('login.post') }}" method="POST" class="mt-8 space-y-6">
                    <!-- @csrf es obligatorio en Laravel para seguridad de formularios -->
                    @csrf
                    <input type="hidden" name="puesto" id="puesto_input" value="mesero">

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Puesto de Trabajo</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Opción Mesero -->
                            <div onclick="seleccionarPuesto('mesero')" id="card-mesero" class="cursor-pointer border-2 border-blue-600 bg-white p-4 rounded-2xl shadow-sm transition relative">
                                <div class="w-3 h-3 rounded-full bg-blue-600 absolute top-3 right-3" id="dot-mesero"></div>
                                <div class="bg-blue-100 text-blue-600 w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg mb-3">🪑</div>
                                <h4 class="font-bold text-slate-800 text-sm">Mesero</h4>
                                <p class="text-xs text-slate-400 mt-1">Toma pedidos desde salón, envía comandas y gestiona mesas en tiempo real.</p>
                            </div>

                            <!-- Opción Administrador -->
                            <div onclick="seleccionarPuesto('admin')" id="card-admin" class="cursor-pointer border-2 border-slate-200 bg-white p-4 rounded-2xl shadow-sm hover:border-slate-300 transition relative">
                                <div class="w-3 h-3 rounded-full border border-slate-300 absolute top-3 right-3 hidden" id="dot-admin"></div>
                                <div class="bg-slate-100 text-slate-600 w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg mb-3">⚙️</div>
                                <h4 class="font-bold text-slate-800 text-sm">Administrador</h4>
                                <p class="text-xs text-slate-400 mt-1">Configura el menú, controla finanzas, gestiona stock y analiza rendimiento.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">Usuario o Correo Electrónico</label>
                        <input type="text" name="email" value="mesero.pedro@comandapro.com" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm outline-none focus:border-blue-600">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-xs font-bold text-slate-600">Contraseña de Acceso</label>
                            <a href="#" class="text-xs font-bold text-blue-600 hover:underline">¿La olvidaste?</a>
                        </div>
                        <input type="password" name="password" value="••••••••••••" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm outline-none focus:border-blue-600">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-600/30 transition">
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function seleccionarPuesto(puesto) {
            document.getElementById('puesto_input').value = puesto;
            if (puesto === 'mesero') {
                document.getElementById('card-mesero').className = "cursor-pointer border-2 border-blue-600 bg-white p-4 rounded-2xl shadow-sm transition relative";
                document.getElementById('card-admin').className = "cursor-pointer border-2 border-slate-200 bg-white p-4 rounded-2xl shadow-sm transition relative";
                document.getElementById('dot-mesero').classList.remove('hidden');
                document.getElementById('dot-admin').classList.add('hidden');
            } else {
                document.getElementById('card-admin').className = "cursor-pointer border-2 border-blue-600 bg-white p-4 rounded-2xl shadow-sm transition relative";
                document.getElementById('card-mesero').className = "cursor-pointer border-2 border-slate-200 bg-white p-4 rounded-2xl shadow-sm transition relative";
                document.getElementById('dot-admin').classList.remove('hidden');
                document.getElementById('dot-mesero').classList.add('hidden');
            }
        }
    </script>
</body>
</html>