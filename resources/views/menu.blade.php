<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Menú contemporáneo de La Buena Mesa, cocina fusión con ingredientes de temporada.">
    <title>La Buena Mesa — Cocina de temporada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/menu.css">
</head>
<body>
    <header class="topbar"><a class="wordmark" href="/" aria-label="La Buena Mesa, inicio"><span class="seal">LBM</span><span>LA BUENA MESA<small>COCINA DE TEMPORADA</small></span></a><nav><a href="#menu">La carta</a><a href="/docs">API &amp; documentación</a></nav></header>
    <main>
        <section class="hero"><div class="hero-copy"><p class="eyebrow">COCINA FUSIÓN · PRODUCTO LOCAL</p><h1>Un lugar para<br><em>saborear despacio.</em></h1><p class="intro">Una cocina contemporánea que reúne ingredientes de temporada, raíces locales y sabores de distintos lugares.</p><a class="text-link" href="#menu">Explorar la carta <span>↓</span></a></div><div class="hero-image" role="img" aria-label="Mesa de restaurante con ingredientes frescos"><div class="image-caption">Hecho con tiempo, servido con cariño.</div></div></section>
        <section id="menu" class="menu-section"><div class="section-heading"><div><p class="eyebrow">LA CARTA</p><h2>Del mercado <em>a la mesa.</em></h2></div><p class="muted">Cada plato cuenta una historia de ingredientes, estación y encuentro.</p></div><div id="filters" class="filters" aria-label="Filtrar por categoría"></div><p id="status" class="status" aria-live="polite">Cargando carta…</p><div id="menu-grid" class="menu-grid"></div><div id="pagination" class="pagination"></div></section>
        <section class="closing"><p class="eyebrow">LA BUENA MESA</p><p>La buena cocina empieza con<br><em>un buen encuentro.</em></p><a href="/docs">Conoce nuestra API <span>↗</span></a></section>
    </main>
    <footer><span>© 2026 La Buena Mesa</span><span>Una carta viva, hecha cada día.</span><a href="/docs">Documentación técnica</a></footer>
    <script src="/js/menu.js" defer></script>
</body>
</html>
