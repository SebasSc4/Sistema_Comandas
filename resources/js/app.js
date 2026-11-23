import './bootstrap';

// Navegación entre módulos: los botones [data-go] muestran el panel [data-panel] con el mismo nombre
document.querySelectorAll('[data-go]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const destino = btn.dataset.go;
        document.querySelectorAll('[data-panel]').forEach((p) => (p.hidden = p.dataset.panel !== destino));
        document.querySelectorAll('.nav-item[data-go]').forEach((n) => n.classList.toggle('is-active', n.dataset.go === destino));
        const titulo = document.querySelector('[data-panel="' + destino + '"]')?.dataset.titulo;
        if (titulo) document.getElementById('titulo').textContent = titulo;
    });
});