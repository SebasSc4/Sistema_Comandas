@extends('layouts.panel')
@section('rol', 'Mesero')
@section('usuario', 'Pedro Gómez')
@section('iniciales', 'PG')
@section('titulo-inicial', 'Mis mesas')

@php
    $mesas = [
        ['n' => 1, 'estado' => 'libre',   'personas' => 2, 'consumo' => null],
        ['n' => 2, 'estado' => 'libre',   'personas' => 4, 'consumo' => null],
        ['n' => 3, 'estado' => 'cobrar',  'personas' => 3, 'consumo' => 385],
        ['n' => 4, 'estado' => 'ocupada', 'personas' => 4, 'consumo' => 540],
        ['n' => 5, 'estado' => 'cobrar',  'personas' => 2, 'consumo' => 260],
        ['n' => 6, 'estado' => 'ocupada', 'personas' => 6, 'consumo' => 910],
    ];
    $etiqueta = ['libre' => 'Libre', 'ocupada' => 'Ocupada', 'cobrar' => 'Por cobrar'];
    $platillos = [['Tacos de Ribeye (3 piezas)', 'Ribeye en tortilla de maíz artesanal', 220], ['Costillas BBQ', 'Media tira con papas', 260], ['Quesadilla de arrachera', 'Queso Oaxaca y arrachera', 165]];
    $subtotal = 440; $iva = $subtotal * 0.16;
    // Datos simulados del plano (los mismos que usa el admin). Cuando exista la base, vendrán de una consulta.
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
    <button class="nav-item is-active" data-go="mesas">Mis mesas</button>
    <button class="nav-item" data-go="plano">Plano del salón</button>
    <button class="nav-item" data-go="comanda">Nueva comanda</button>
    <button class="nav-item" data-go="activas">Comandas activas</button>
@endsection

@section('contenido')
<section data-panel="mesas" data-titulo="Mis mesas" class="space-y-6">
    <div class="grid grid-cols-4 gap-4">
        @foreach ([['Mesas totales', count($mesas), ''], ['Ocupadas', 2, 'ocupada'], ['Por cobrar', 2, 'cobrar'], ['Libres', 2, 'libre']] as [$txt, $val, $est])
            <div class="card p-5" @if($est) data-estado="{{ $est }}" @endif>
                <p class="text-sm text-humo">{{ $txt }}</p>
                <p class="num text-5xl font-bold mt-1" @if($est) style="color: var(--c)" @endif>{{ $val }}</p>
            </div>
        @endforeach
    </div>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($mesas as $m)
            <article class="mesa" data-estado="{{ $m['estado'] }}">
                <div class="flex items-start justify-between">
                    <h3 class="num text-4xl font-bold leading-none">Mesa {{ $m['n'] }}</h3>
                    <span class="chip" data-estado="{{ $m['estado'] }}">{{ $etiqueta[$m['estado']] }}</span>
                </div>
                <p class="text-sm text-humo">{{ $m['personas'] }} comensales @if($m['consumo']) · <span class="text-hueso font-medium">${{ number_format($m['consumo'], 2) }}</span> @endif</p>
                <button class="btn {{ $m['estado'] === 'libre' ? 'btn-primary' : '' }}" data-go="{{ $m['estado'] === 'libre' ? 'comanda' : 'activas' }}">
                    {{ $m['estado'] === 'libre' ? 'Abrir mesa' : ($m['estado'] === 'cobrar' ? 'Cobrar cuenta' : 'Ver comanda') }}
                </button>
            </article>
        @endforeach
    </div>
</section>

<section data-panel="plano" data-titulo="Plano del salón" class="space-y-6" hidden>
    <div class="card p-4 flex flex-wrap items-center gap-3">
        <div class="mr-auto">
            <h3 class="text-2xl font-semibold">Plano del salón</h3>
            <p id="plano-ayuda" class="text-sm text-humo">Pulsa Reacomodar para mover o juntar mesas.</p>
        </div>
        <button id="btn-editar" class="btn btn-primary">Reacomodar</button>
        <div id="barra-edicion" class="flex flex-wrap gap-2" hidden>
            <button id="btn-juntar" class="btn">Juntar</button>
            <button id="btn-separar" class="btn">Separar</button>
            <button id="btn-cancelar" class="btn">Cancelar</button>
            <button id="btn-guardar" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-6">
        <div id="plano" class="col-span-3 card relative overflow-hidden touch-none"
             style="height: 460px; background-image: radial-gradient(circle, var(--color-line) 1px, transparent 1px); background-size: 20px 20px;"></div>
        <aside class="card p-5 space-y-3 self-start">
            <h3 class="text-2xl font-semibold">Estados</h3>
            <p><span class="chip" data-estado="libre">Libre</span></p>
            <p><span class="chip" data-estado="ocupada">Ocupada</span></p>
            <p><span class="chip" data-estado="cobrar">Por cobrar</span></p>
            <p class="text-xs text-humo pt-3 border-t border-line">Puedes mover y juntar mesas. Para agregar o quitar mesas, pídeselo al administrador.</p>
        </aside>
    </div>
</section>

<section data-panel="comanda" data-titulo="Nueva comanda" class="grid grid-cols-3 gap-6" hidden>
    <div class="col-span-2 space-y-4">
        <div class="flex gap-2">
            <button class="btn">Entradas</button>
            <button class="btn btn-primary">Platos fuertes</button>
            <button class="btn">Bebidas</button>
        </div>
        @foreach ($platillos as [$nombre, $desc, $precio])
            <div class="card p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold">{{ $nombre }}</h3>
                    <p class="text-sm text-humo">{{ $desc }}</p>
                    <p class="num text-xl mt-1">${{ number_format($precio, 2) }}</p>
                </div>
                <button class="btn" aria-label="Agregar {{ $nombre }}">Agregar</button>
            </div>
        @endforeach
    </div>
    <aside class="card p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-2xl font-semibold border-b border-line pb-3 mb-4">Pedido de la mesa 4</h3>
            <div class="flex justify-between text-sm"><span>2x Tacos de Ribeye</span><span>${{ number_format($subtotal, 2) }}</span></div>
            <textarea class="input mt-4" rows="3" placeholder="Notas para cocina (sin cebolla, término de la carne…)"></textarea>
        </div>
        <div class="pt-4 mt-4 border-t border-line space-y-1 text-sm">
            <div class="flex justify-between text-humo"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
            <div class="flex justify-between text-humo"><span>IVA 16%</span><span>${{ number_format($iva, 2) }}</span></div>
            <div class="flex justify-between items-baseline pt-2"><span>Total</span><span class="num text-4xl font-bold">${{ number_format($subtotal + $iva, 2) }}</span></div>
            <button class="btn btn-primary w-full mt-4 py-3">Enviar a cocina</button>
        </div>
    </aside>
</section>

<section data-panel="activas" data-titulo="Comandas activas" hidden>
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-line"><tr><th class="th">Mesa</th><th class="th">Comanda</th><th class="th">Platillos</th><th class="th">Estado</th><th class="th">Total</th></tr></thead>
            <tbody class="divide-y divide-line">
                @foreach ([[12, 302, '3x Tacos de Ribeye · sin cebolla', 'ocupada', 'Preparando', 220], [4, 298, '2x Tacos de Ribeye', 'libre', 'Listo', 440]] as [$mesa, $folio, $detalle, $est, $txt, $total])
                    <tr><td class="px-4 py-3 font-medium">Mesa {{ $mesa }}</td><td class="px-4 py-3 text-humo">#{{ $folio }}</td><td class="px-4 py-3">{{ $detalle }}</td>
                        <td class="px-4 py-3"><span class="chip" data-estado="{{ $est }}">{{ $txt }}</span></td><td class="px-4 py-3">${{ number_format($total, 2) }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script>
    // ===== Plano de mesas (mesero: solo mover, juntar y separar) =====
    const inicial = @json($mesasPlano);
    const GRID = 20, W = 112, H = 84, CLAVE = 'comandapro.plano';

    const $ = (id) => document.getElementById(id);
    const plano = $('plano');
    const clonar = (o) => JSON.parse(JSON.stringify(o));
    const ajustar = (v) => Math.round(v / GRID) * GRID;
    const limitar = (v, min, max) => Math.max(min, Math.min(v, max));

    // TEMPORAL: se guarda en el navegador (el mismo plano que ve el admin en este equipo).
    // Cuando exista la base, aquí va la llamada al servidor.
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
        el.className = 'mesa absolute select-none' + (editando ? ' cursor-grab' : '');
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

    function resaltar() {
        document.querySelectorAll('#plano .mesa').forEach((n) => {
            const on = sel.has(Number(n.dataset.id));
            n.classList.toggle('ring-2', on);
            n.classList.toggle('ring-acento', on);
        });
    }

    function render() {
        plano.replaceChildren(...mesas.map(pintar));
        resaltar();
        $('btn-editar').hidden = editando;
        $('barra-edicion').hidden = !editando;
    }

    function terminarEdicion(texto) {
        editando = false;
        sel = new Set();
        render();
        ayuda(texto);
    }

    // Arrastrar (solo en modo reacomodar)
    plano.addEventListener('pointerdown', (e) => {
        if (!editando) return;
        const el = e.target.closest('.mesa');
        if (!el) { sel = new Set(); resaltar(); return; }
        const id = Number(el.dataset.id);
        if (e.shiftKey) { sel.has(id) ? sel.delete(id) : sel.add(id); }
        else if (!sel.has(id)) { sel = new Set([id]); }
        resaltar();
        const m = mesas.find((x) => x.id === id);
        const r = plano.getBoundingClientRect();
        arrastre = { m, el, dx: e.clientX - r.left - m.x, dy: e.clientY - r.top - m.y };
        el.setPointerCapture(e.pointerId);
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
        ayuda('Mesas juntadas.');
    });

    $('btn-separar').addEventListener('click', () => {
        const m = unica();
        if (!m || !m.unidas) { ayuda('Selecciona una mesa juntada para separarla.'); return; }
        mesas = mesas.filter((x) => x.id !== m.id);
        m.unidas.forEach((u, i) => { u.x = limitar(m.x + i * (W + 8), 0, plano.clientWidth - W); u.y = m.y; mesas.push(u); });
        sel = new Set();
        render();
        ayuda('Mesas separadas.');
    });

    render();
</script>
@endsection