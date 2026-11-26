# API RESTful — La Buena Mesa

API para centralizar el menú de un restaurante de cocina fusión contemporánea. Permite consultar y administrar platillos, precios, categorías y disponibilidad mediante endpoints REST con Laravel 12 y Eloquent ORM. Incluye una página editorial que consume la API, especificación OpenAPI navegable, colección Postman y pruebas automatizadas.

## Objetivo

Centralizar la carta de La Buena Mesa en un backend que facilite actualizar los platillos y compartir información consistente con futuras aplicaciones web, móviles y sistemas de punto de venta. Las categorías se guardan como identificadores controlados (`entradas`, `platos-fuertes`, `ensaladas`, `postres`, `bebidas`); para el alcance actual esta solución evita una tabla de categorías adicional y conserva una estructura fácil de ampliar.

## Funcionalidades

- Listado paginado y consulta individual de platillos.
- Creación, actualización completa con PUT, actualización parcial con PATCH y eliminación.
- Filtro por categoría y gestión de disponibilidad.
- Validación en español, recursos JSON consistentes y códigos HTTP apropiados.
- Migración, factory y seeder idempotente con 18 platillos de demostración.
- Interfaz responsive que obtiene la carta desde la API.
- Documentación OpenAPI 3.1 y colección exportable de Postman.

## Tecnologías

- Laravel 12.74, PHP 8.2 o superior y Eloquent ORM.
- MySQL 8 o MariaDB 10.4 o superior.
- Composer, PHPUnit 11 y Laravel Pint.
- Blade, HTML, CSS y JavaScript nativo; Swagger UI para explorar OpenAPI.

## Requisitos previos

PHP 8.2+ con extensiones `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `pdo_mysql`, `Tokenizer`, `XML`; Composer 2; Git; y un servidor MySQL/MariaDB accesible. No es necesario Node.js para ejecutar esta aplicación.

## Instalación en Windows / PowerShell

```powershell
git clone https://github.com/YamiLinares/menu-api.git
Set-Location menu-api
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Crea una base de datos vacía llamada `la_buena_mesa_api` en tu instancia MySQL/MariaDB y configura las variables de conexión en `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=la_buena_mesa_api
DB_USERNAME=root
DB_PASSWORD=
```

Usa las credenciales locales de tu equipo; no las añadas a Git. Luego:

```powershell
php artisan migrate --seed
php artisan route:list --path=api
php artisan test
php artisan serve --host=127.0.0.1 --port=8012
```

Comprueba que el puerto elegido esté libre antes de iniciar el servidor. Si está ocupado, selecciona uno disponible y actualiza `APP_URL` y `base_url` en la colección de Postman. La URL de desarrollo habitual es `http://127.0.0.1:8012`.

## Base de datos

El motor de desarrollo es MySQL/MariaDB. La migración de `menu_items` crea `id`, `name`, `description`, `price DECIMAL(10,2)`, `category`, `is_available` y marcas de tiempo; incluye un índice para categoría. La base de datos de las pruebas es SQLite en memoria, aislada de los datos locales. El seeder utiliza `updateOrCreate` por nombre: ejecutarlo más de una vez no duplica los 18 platos de ejemplo.

## Uso de la API

URL base: `http://127.0.0.1:8012/api`. Las solicitudes y respuestas usan JSON. El listado acepta `per_page` (1–100, predeterminado 12) y `page`.

| Método | Ruta | Descripción | Parámetros | Respuesta |
|---|---|---|---|---|
| GET | `/menu-items` | Listar platillos, paginados | `per_page`, `page` (query) | 200 |
| GET | `/menu-items/{id}` | Consultar un platillo | `id` (ruta) | 200, 404 |
| POST | `/menu-items` | Crear un platillo | JSON completo | 201, 422 |
| PUT | `/menu-items/{id}` | Reemplazar todos los campos | `id` y JSON completo | 200, 404, 422 |
| PATCH | `/menu-items/{id}` | Modificar campos enviados | `id` y uno o más campos | 200, 404, 422 |
| DELETE | `/menu-items/{id}` | Eliminar platillo | `id` (ruta) | 204, 404 |
| GET | `/menu-items/category/{category}` | Filtrar por categoría | `category` (ruta) | 200, 422 |

Categorías válidas: `entradas`, `platos-fuertes`, `ensaladas`, `postres` y `bebidas`. Una categoría válida sin resultados devuelve una lista vacía (200); una categoría no reconocida devuelve 422.

Los campos de escritura son `name` (obligatorio, máximo 120 caracteres), `description` (obligatorio), `price` (número no negativo, máximo dos decimales), `category` (valor permitido) e `is_available` (booleano). PUT requiere todos; PATCH valida solamente los enviados. Los atributos adicionales no se guardan. El precio se representa como cadena decimal de dos posiciones.

### Ejemplos

Listar y filtrar (PowerShell):

```powershell
Invoke-RestMethod -Uri 'http://127.0.0.1:8012/api/menu-items?per_page=12' -Headers @{ Accept = 'application/json' }
Invoke-RestMethod -Uri 'http://127.0.0.1:8012/api/menu-items/category/entradas' -Headers @{ Accept = 'application/json' }
```

Crear, consultar y modificar (PowerShell):

```powershell
$base = 'http://127.0.0.1:8012/api/menu-items'
$headers = @{ Accept = 'application/json' }
$body = @{ name = 'Salmón al limón'; description = 'Salmón a la plancha con vegetales'; price = '15.50'; category = 'platos-fuertes'; is_available = $true } | ConvertTo-Json
$created = Invoke-RestMethod -Method Post -Uri $base -Headers $headers -ContentType 'application/json' -Body $body
$id = $created.data.id
Invoke-RestMethod -Uri "$base/$id" -Headers $headers
$replacement = @{ name = 'Salmón cítrico'; description = 'Salmón con vegetales de temporada'; price = '16.00'; category = 'platos-fuertes'; is_available = $true } | ConvertTo-Json
Invoke-RestMethod -Method Put -Uri "$base/$id" -Headers $headers -ContentType 'application/json' -Body $replacement
$patch = @{ is_available = $false } | ConvertTo-Json
Invoke-RestMethod -Method Patch -Uri "$base/$id" -Headers $headers -ContentType 'application/json' -Body $patch
Invoke-WebRequest -Method Delete -Uri "$base/$id" -Headers $headers # HTTP 204
```

Validación con HTTP 422:

```powershell
$invalid = @{ name = ''; description = 'Prueba'; price = -2; category = 'otra'; is_available = $true } | ConvertTo-Json
try { Invoke-RestMethod -Method Post -Uri $base -Headers $headers -ContentType 'application/json' -Body $invalid } catch { $_.ErrorDetails.Message }
```

Respuesta individual: `{"data":{"id":1,"name":"Salmón al limón","description":"Salmón a la plancha con vegetales","price":"15.50","category":"platos-fuertes","is_available":true,"created_at":"…","updated_at":"…"}}`.

Respuesta 404: `{"message":"El elemento del menú no existe."}`. Respuesta 422: `{"message":"Los datos proporcionados no son válidos.","errors":{"price":["El precio debe ser mayor o igual a cero."]}}`. DELETE responde 204 sin contenido. Un método no permitido en `/api` devuelve JSON 405.

## Documentación interactiva y Postman

Con el servidor activo, visita `http://127.0.0.1:8012/docs` para explorar y probar todos los endpoints con Swagger UI. La especificación de OpenAPI 3.1 está en `public/openapi.yaml` y disponible en `/openapi.yaml`.

Importa `docs/postman/La-Buena-Mesa.postman_collection.json` en Postman. Ajusta `base_url` si cambiaste el puerto. La colección incluye listado, consulta individual, creación, PUT, PATCH, DELETE, filtro, validación 422 y consulta 404; las pruebas verifican estados HTTP y guardan el identificador creado para las siguientes solicitudes.

## Estructura y arquitectura

```text
app/Http/Controllers/Api/   Controlador REST del menú
app/Http/Requests/          Validaciones de creación y actualización
app/Http/Resources/         Representación estable de la respuesta JSON
app/Models/MenuItem.php     Entidad Eloquent, casts y categorías permitidas
database/migrations/        Esquema reproducible
database/factories/         Datos sintéticos para pruebas
database/seeders/           18 platillos de demostración
resources/views/            Portada y documentación Swagger UI
public/css, public/js/      Presentación responsive y cliente Fetch API
public/openapi.yaml         Especificación OpenAPI 3.1
docs/postman/               Colección Postman exportable
tests/Feature/              Pruebas de los endpoints y errores
```

El controlador recibe solicitudes y coordina la consulta Eloquent; Form Requests validan y filtran los atributos autorizados; el modelo administra la persistencia y sus casts; el API Resource fija la forma JSON. La capa de servicios no se introduce porque el CRUD actual no contiene lógica de negocio que justifique otra abstracción. Flujo: cliente → ruta API → controlador → Form Request → Eloquent → MySQL → API Resource → JSON.

La página de inicio (`/`) consume realmente `/api/menu-items` y `/api/menu-items/category/{category}` mediante Fetch API; admite navegación por páginas y estado de disponibilidad.

## Pruebas y calidad

```powershell
php artisan test
vendor\bin\pint --test
php artisan route:list --path=api
```

Las pruebas de integración usan SQLite en memoria y cubren listado vacío/paginado, lectura y 404, creación y reglas de validación, asignación masiva, PUT, PATCH, eliminación, filtrado, respuesta JSON ante excepciones y HTTP 405. Ejecuta las pruebas en tu copia local para obtener el resultado de esa instalación.

## Seguridad

`.env` y credenciales locales están excluidos de Git; `.env.example` contiene valores de ejemplo sin secretos. Laravel valida los datos, limita atributos de asignación masiva y no expone trazas mediante el formato JSON de la API. Esta API es una demostración académica local: antes de producción, añade autenticación/autorización a las operaciones de escritura, configura HTTPS, `APP_DEBUG=false`, restricciones CORS y límites de solicitudes acordes al despliegue. No expongas el servidor local a Internet.

## Autoría

Kenia Yamileth Landaverde Linares

GitHub: [YamiLinares](https://github.com/YamiLinares)
Actividad práctica de Kodigo.
