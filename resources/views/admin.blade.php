@extends('layouts.panel')
@section('rol', 'Administrador')
@section('usuario', 'Carlos Mendoza')
@section('iniciales', 'CM')
@section('titulo-inicial', 'Resumen del día')

@php
    $semana = ['L' => 55, 'M' => 62, 'X' => 48, 'J' => 70, 'V' => 100, 'S' => 92, 'D' => 74];
    $menu = [['Tacos de Ribeye (3x)', 'Platos fuertes', 220, true], ['Costillas BBQ', 'Platos fuertes', 260, true], ['Limonada mineral', 'Bebidas', 55, false]];
    $turnos = [['Pedro Gómez', 'Mesas 1, 4', 'Matutino'], ['Ana Ruiz', 'Mesas 2, 5, 6', 'Vespertino']];
    // Datos simulados del plano. Cuando exista la base, esto vendrá de una consulta.
    $mesasPlano = [
        ['id' => 1, 'nombre' => 'Mesa 1', 'personas' => 2, 'zona' => 'Salón',   'estado' => 'libre',   'x' => 40,  'y' => 40],
        ['id' => 2, 'nombre' => 'Mesa 2', 'personas' => 4, 'zona' => 'Salón',   'estado' => 'libre',   'x' => 200, 'y' => 40],
        ['id' => 3, 'nombre' => 'Mesa 3', 'personas' => 3, 'zona' => 'Salón',   'estado' => 'cobrar',  'x' => 360, 'y' => 40],
        ['id' => 4, 'nombre' => 'Mesa 4', 'personas' => 4, 'zona' => 'Salón',   'estado' => 'ocupada', 'x' => 40,  'y' => 180],
        ['id' => 5, 'nombre' => 'Mesa 5', 'personas' => 2, 'zona' => 'Terraza', 'estado' => 'cobrar',  'x' => 200, 'y' => 180],
        ['id' => 6, 'nombre' => 'Mesa 6', 'personas' => 6, 'zona' => 'Terraza', 'estado' => 'ocupada', 'x' => 360, 'y' => 180],
    ];
@endphp

@section('nav')
    <button class="nav-item is-active" data-go="dash">Resumen</button>
    <button class="nav-item" data-go="menu">Menú</button>
    <button class="nav-item" data-go="mesas">Mesas y meseros</button>
@endsection

@section('contenido')
<section data-panel="dash" data-titulo="Resumen del día" class="space-y-6">
    <div class="grid grid-cols-4 gap-4">
        <div class="card p-5"><p class="text-sm text-humo">Ventas del día</p><p class="num text-5xl font-bold mt-1">$12,450</p></div>
        <div class="card p-5" data-estado="ocupada"><p class="text-sm text-humo">Comandas activas</p><p class="num text-5xl font-bold mt-1" style="color: var(--c)">8</p></div>
        <div class="card p-5" data-estado="cobrar"><p class="text-sm text-humo">Cuentas por cobrar</p><p class="num text-5xl font-bold mt-1" style="color: var(--c)">3</p></div>
        <div class="card p-5" data-estado="libre"><p class="text-sm text-humo">Mesas libres</p><p class="num text-5xl font-bold mt-1" style="color: var(--c)">4</p></div>
    </div>
    <div class="card p-6">
        <h3 class="text-2xl font-semibold mb-4">Ventas de la semana</h3>
        <div class="flex items-end gap-4 h-40">
            @foreach ($semana as $dia => $alto)
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                    <div class="w-full rounded-t-md {{ $alto === 100 ? 'bg-acento' : 'bg-raised' }}" style="height: {{ $alto }}%"></div>
                    <span class="text-xs text-humo">{{ $dia === 'X' ? 'M' : $dia }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section data-panel="menu" data-titulo="Menú" class="grid grid-cols-3 gap-6" hidden>
    <div class="col-span-2 card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-line"><tr><th class="th">Platillo</th><th class="th">Categoría</th><th class="th">Precio</th><th class="th">Stock</th></tr></thead>
            <tbody class="divide-y divide-line">
                @foreach ($menu as [$nombre, $cat, $precio, $hay])
                    <tr><td class="px-4 py-3 font-medium">{{ $nombre }}</td><td class="px-4 py-3 text-humo">{{ $cat }}</td><td class="px-4 py-3">${{ number_format($precio, 2) }}</td>
                        <td class="px-4 py-3"><span class="chip" data-estado="{{ $hay ? 'libre' : 'ocupada' }}">{{ $hay ? 'Disponible' : 'Agotado' }}</span></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <aside class="card p-6 space-y-4">
        <h3 class="text-2xl font-semibold">Editar platillo</h3>
        <div><label class="block text-sm mb-1.5" for="nombre">Nombre</label><input id="nombre" class="input" value="Tacos de Ribeye (3x)"></div>
        <div><label class="block text-sm mb-1.5" for="precio">Precio</label><input id="precio" class="input" value="220.00"></div>
        <button class="btn btn-primary w-full">Guardar cambios</button>
    </aside>
</section>

<section data-panel="mesas" data-titulo="Mesas y meseros" class="space-y-6" hidden>
    <div class="card p-4 flex flex-wrap items-center gap-3">
        <div class="mr-auto">
            <h3 class="text-2xl font-semibold">Plano del salón</h3>
            <p id="plano-ayuda" class="text-sm text-humo">Pulsa Editar plano para mover, juntar o agregar mesas.</p>
        </div>
        <button id="btn-editar" class="btn btn-primary">Editar plano</button>
        <div id="barra-edicion" class="flex flex-wrap gap-2" hidden>
            <button id="btn-agregar" class="btn">Agregar mesa</button>
            <button id="btn-juntar" class="btn">Juntar</button>
            <button id="btn-separar" class="btn">Separar</button>
            <button id="btn-cancelar" class="btn">Cancelar</button>
            <button id="btn-guardar" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-6">
        <div id="plano" class="col-span-3 card relative overflow-hidden touch-none"
             style="height: 460px; background-image: radial-gradient(circle, var(--color-line) 1px, transparent 1px); background-size: 20px 20px;"></div>

        <aside class="card p-5 space-y-4 self-start">
            <h3 class="text-2xl font-semibold">Propiedades</h3>
            <p id="props-vacio" class="text-sm text-humo">Selecciona una mesa del plano.</p>
            <div id="props-form" class="space-y-4" hidden>
                <div><label for="p-nombre" class="block text-sm mb-1.5">Nombre</label><input id="p-nombre" class="input"></div>
                <div><label for="p-personas" class="block text-sm mb-1.5">Comensales</label><input id="p-personas" type="number" min="1" class="input"></div>
                <div>
                    <label for="p-zona" class="block text-sm mb-1.5">Zona</label>
                    <select id="p-zona" class="input"><option>Salón</option><option>Terraza</option><option>Entrada</option></select>
                </div>
                <button id="btn-eliminar" class="btn w-full" style="color: var(--color-alerta)">Eliminar mesa</button>
            </div>
            <div class="pt-4 border-t border-line space-y-2 text-xs text-humo">
                <p><span class="chip" data-estado="libre">Libre</span></p>
                <p><span class="chip" data-estado="ocupada">Ocupada</span></p>
                <p><span class="chip" data-estado="cobrar">Por cobrar</span></p>
            </div>
        </aside>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-line"><tr><th class="th">Mesero</th><th class="th">Mesas asignadas</th><th class="th">Turno</th></tr></thead>
            <tbody class="divide-y divide-line">
                @foreach ($turnos as [$mesero, $asignadas, $turno])
                    <tr><td class="px-4 py-3 font-medium">{{ $mesero }}</td><td class="px-4 py-3">{{ $asignadas }}</td><td class="px-4 py-3 text-humo">{{ $turno }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script>
    // ===== Plano de mesas =====
    const inicial = @json($mesasPlano);
    const GRID = 20, W = 112, H = 84, CLAVE = 'comandapro.plano';

    const $ = (id) => document.getElementById(id);
    const plano = $('plano');
    const clonar = (o) => JSON.parse(JSON.stringify(o));
    const ajustar = (v) => Math.round(v / GRID) * GRID;
    const limitar = (v, min, max) => Math.max(min, Math.min(v, max));

    // TEMPORAL: se guarda en el navegador. Cuando exista la base, aquí va la llamada al servidor.
    function cargar() {
        try { const s = localStorage.getItem(CLAVE); if (s) return JSON.parse(s); } catch (e) {}
        return clonar(inicial);
    }
    function persistir() {
        try { localStorage.setItem(CLAVE, JSON.stringify(mesas)); } catch (e) {}
    }

    let mesas = cargar();
    let guardado = clonar(mesas);
    let editando = false;
    let sel = new Set();
    let arrastre = null;

    const ayuda = (t) => ($('plano-ayuda').textContent = t);
    const unica = () => (sel.size === 1 ? mesas.find((m) => m.id === [...sel][0]) : null);
    const siguienteId = () => Math.max(0, ...mesas.map((m) => m.id)) + 1;

    function pintar(m) {
        const el = document.createElement('div');
        el.className = 'mesa absolute select-none' + (editando ? ' cursor-grab' : '') + (sel.has(m.id) ? ' ring-2 ring-acento' : '');
        el.dataset.estado = m.estado;
        el.dataset.id = m.id;
        Object.assign(el.style, { left: m.x + 'px', top: m.y + 'px', width: (m.w || W) + 'px', height: H + 'px', padding: '10px', gap: '4px' });
        const titulo = document.createElement('h4');
        titulo.className = 'num text-2xl font-bold leading-none';
        titulo.textContent = m.nombre;
        const detalle = document.createElement('p');
        detalle.className = 'text-xs text-humo';
        detalle.textContent = m.personas + ' pers. · ' + m.zona;
        el.append(titulo, detalle);
        return el;
    }

    function render() {
        plano.replaceChildren(...mesas.map(pintar));
        $('btn-editar').hidden = editando;
        $('barra-edicion').hidden = !editando;
    }

    function panel() {
        const m = unica();
        $('props-form').hidden = !m;
        $('props-vacio').hidden = !!m;
        $('props-vacio').textContent = sel.size > 1 ? sel.size + ' mesas seleccionadas. Pulsa Juntar.' : 'Selecciona una mesa del plano.';
        if (m) {
            $('p-nombre').value = m.nombre;
            $('p-personas').value = m.personas;
            $('p-zona').value = m.zona;
        }
    }

    function terminarEdicion(texto) {
        editando = false;
        sel = new Set();
        render();
        panel();
        ayuda(texto);
    }

    // Arrastrar (solo en modo edición)
    plano.addEventListener('pointerdown', (e) => {
        if (!editando) return;
        const el = e.target.closest('.mesa');
        if (!el) { sel = new Set(); render(); panel(); return; }
        const id = Number(el.dataset.id);
        if (e.shiftKey) { sel.has(id) ? sel.delete(id) : sel.add(id); }
        else if (!sel.has(id)) { sel = new Set([id]); }
        const m = mesas.find((x) => x.id === id);
        const r = plano.getBoundingClientRect();
        arrastre = { m, el, dx: e.clientX - r.left - m.x, dy: e.clientY - r.top - m.y };
        el.classList.toggle('ring-2', sel.has(id));
        el.classList.toggle('ring-acento', sel.has(id));
        el.setPointerCapture(e.pointerId);
        document.querySelectorAll('#plano .mesa').forEach((n) => {
            const on = sel.has(Number(n.dataset.id));
            n.classList.toggle('ring-2', on);
            n.classList.toggle('ring-acento', on);
        });
        panel();
    });
    plano.addEventListener('pointermove', (e) => {
        if (!arrastre) return;
        const r = plano.getBoundingClientRect();
        const { m, el, dx, dy } = arrastre;
        m.x = limitar(ajustar(e.clientX - r.left - dx), 0, r.width - (m.w || W));
        m.y = limitar(ajustar(e.clientY - r.top - dy), 0, r.height - H);
        el.style.left = m.x + 'px';
        el.style.top = m.y + 'px';
    });
    plano.addEventListener('pointerup', () => { arrastre = null; });

    // Botones
    $('btn-editar').addEventListener('click', () => {
        editando = true;
        render();
        ayuda('Arrastra las mesas. Con Shift + clic seleccionas varias para juntarlas.');
    });
    $('btn-guardar').addEventListener('click', () => { guardado = clonar(mesas); persistir(); terminarEdicion('Plano guardado.'); });
    $('btn-cancelar').addEventListener('click', () => { mesas = clonar(guardado); terminarEdicion('Cambios descartados.'); });

    $('btn-agregar').addEventListener('click', () => {
        const id = siguienteId();
        mesas.push({ id, nombre: 'Mesa ' + id, personas: 2, zona: 'Salón', estado: 'libre', x: 40, y: 40 });
        sel = new Set([id]);
        render();
        panel();
    });

    $('btn-juntar').addEventListener('click', () => {
        const grupo = mesas.filter((m) => sel.has(m.id));
        if (grupo.length < 2) { ayuda('Selecciona 2 o más mesas con Shift + clic para juntarlas.'); return; }
        const id = siguienteId();
        const estado = grupo.some((m) => m.estado === 'ocupada') ? 'ocupada' : grupo.some((m) => m.estado === 'cobrar') ? 'cobrar' : 'libre';
        mesas = mesas.filter((m) => !sel.has(m.id));
        mesas.push({
            id, estado, zona: grupo[0].zona,
            nombre: 'Mesa ' + grupo.map((m) => m.nombre.replace(/^Mesa\s*/i, '')).join('+'),
            personas: grupo.reduce((t, m) => t + Number(m.personas), 0),
            x: Math.min(...grupo.map((m) => m.x)), y: Math.min(...grupo.map((m) => m.y)),
            w: W * grupo.length, unidas: grupo,
        });
        sel = new Set([id]);
        render();
        panel();
        ayuda('Mesas juntadas.');
    });

    $('btn-separar').addEventListener('click', () => {
        const m = unica();
        if (!m || !m.unidas) { ayuda('Selecciona una mesa juntada para separarla.'); return; }
        mesas = mesas.filter((x) => x.id !== m.id);
        m.unidas.forEach((u, i) => { u.x = limitar(m.x + i * (W + 8), 0, plano.clientWidth - W); u.y = m.y; mesas.push(u); });
        sel = new Set();
        render();
        panel();
        ayuda('Mesas separadas.');
    });

    $('btn-eliminar').addEventListener('click', () => {
        mesas = mesas.filter((m) => !sel.has(m.id));
        sel = new Set();
        render();
        panel();
    });

    // Propiedades
    $('p-nombre').addEventListener('input', (e) => { const m = unica(); if (m) { m.nombre = e.target.value; render(); } });
    $('p-personas').addEventListener('input', (e) => { const m = unica(); if (m) { m.personas = Math.max(1, Number(e.target.value) || 1); render(); } });
    $('p-zona').addEventListener('change', (e) => { const m = unica(); if (m) { m.zona = e.target.value; render(); } });

    render();
    panel();
</script>
@endsection