<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API — La Buena Mesa</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
    <link rel="stylesheet" href="/css/menu.css">
    <style>.docs-intro{max-width:1050px;margin:45px auto 28px;padding:0 24px}.docs-intro h1{font:48px var(--serif);color:#263b2c;margin:12px 0}.docs-intro p{line-height:1.8;color:#5e6058}.docs-intro code{background:#f0eee7;padding:3px 6px;border-radius:3px}.docs-intro a{color:#263b2c}.swagger-wrap{max-width:1100px;margin:0 auto 75px;padding:0 18px}.swagger-ui{font-family:var(--sans)}.swagger-ui .topbar{display:none}.swagger-ui .info .title,.swagger-ui .opblock-tag{font-family:var(--serif)}.swagger-ui .opblock.opblock-get{border-color:#607b61;background:rgba(96,123,97,.08)}.swagger-ui .opblock.opblock-post{border-color:#b17c51;background:rgba(177,124,81,.08)}</style>
</head>
<body>
    <header class="topbar"><a class="wordmark" href="/"><span class="seal">LBM</span><span>LA BUENA MESA<small>DOCUMENTACIÓN API</small></span></a><nav><a href="/">Volver a la carta</a></nav></header>
    <main>
        <section class="docs-intro"><p class="eyebrow">DOCUMENTACIÓN TÉCNICA · VERSIÓN 1.0.0</p><h1>API del menú</h1><p>API REST para consultar y administrar la carta de La Buena Mesa. Respuestas JSON y precios en dólares estadounidenses.</p><p>URL base: <code>{{ url('/api') }}</code> · <a href="/openapi.yaml">Descargar OpenAPI 3.1</a> · <a href="/postman/collection">Descargar colección Postman</a></p><p>Demostración académica local. Protege las operaciones de escritura con autenticación y autorización antes de producción.</p></section>
        <div class="swagger-wrap"><div id="swagger-ui"></div></div>
    </main>
    <footer><span>© 2026 La Buena Mesa</span><span>Laravel 12 · Eloquent ORM</span><a href="/">Volver a la carta</a></footer>
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script>window.onload = () => SwaggerUIBundle({ url: '/openapi.yaml', dom_id: '#swagger-ui', deepLinking: true, presets: [SwaggerUIBundle.presets.apis, SwaggerUIBundle.SwaggerUIStandalonePreset], layout: 'BaseLayout' });</script>
</body>
</html>
