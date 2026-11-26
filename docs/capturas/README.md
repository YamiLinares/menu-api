# Capturas de evidencia

La sesión de desarrollo no dispone de control de navegador/escritorio para guardar capturas verificables. Para mantener evidencia auténtica, toma las imágenes desde tu navegador después de iniciar la aplicación con `php artisan serve --host=127.0.0.1 --port=8012` y la base de datos activa. Guarda los archivos PNG aquí, sin credenciales ni tokens:

| Archivo | URL / acción | Resultado que debe verse |
|---|---|---|
| `inicio.png` | `http://127.0.0.1:8012/` | Portada editorial de La Buena Mesa |
| `menu.png` | Desplázate a “La carta” | Platillos, precios y disponibilidad obtenidos desde la API |
| `filtro-categoria.png` | Selecciona “Postres” | Solo los platillos de la categoría elegida |
| `documentacion-api.png` | `http://127.0.0.1:8012/docs` | Swagger UI con los endpoints y “Try it out” |
| `get-menu-items.png` | Swagger: `GET /api/menu-items`, “Try it out” y “Execute” | HTTP 200 y lista paginada |
| `post-menu-item.png` | Swagger: `POST /api/menu-items` con un cuerpo JSON válido | HTTP 201 y recurso creado |
| `put-menu-item.png` | Swagger: `PUT /api/menu-items/{id}` | HTTP 200 y recurso actualizado |
| `patch-menu-item.png` | Swagger: `PATCH /api/menu-items/{id}` | HTTP 200 y solo los campos enviados actualizados |
| `delete-menu-item.png` | Swagger: `DELETE /api/menu-items/{id}` | HTTP 204 |
| `validacion-422.png` | Swagger: `POST /api/menu-items` con precio negativo | HTTP 422 y errores por campo |
| `pruebas-exitosas.png` | Ejecuta `php artisan test` en VS Code | Resumen real de pruebas aprobadas |

En Windows puedes guardar desde Edge/Chrome con `Ctrl+Shift+S` o la herramienta Recortes (`Win+Shift+S`); usa exactamente los nombres de la tabla y comprueba que el recorte no incluya información personal.
