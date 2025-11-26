<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# 🚀 Proyecto Laravel API

Este proyecto está basado en **Laravel**, un framework de PHP moderno y expresivo que facilita el desarrollo de APIs y aplicaciones web robustas.

---

## 🧰 Requisitos previos

-   PHP 8.2 o superior
-   Composer
-   MySQL o MariaDB
-   XAMPP / Valet / Laravel Sail (opcional)

---

## ⚙️ Instalación del proyecto

1. **Clonar el repositorio:**

    ```bash
    git clone <url-del-repo>
    cd <carpeta-del-proyecto>
    ```

2. **Instalar dependencias:**

    ```bash
    composer install
    ```

3. **Configurar entorno:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configurar base de datos y migrar:**

    ```bash
    php artisan migrate
    ```

5. **Iniciar servidor local:**
    ```bash
    php artisan serve
    ```

---

## 💾 Conexión con la base de datos

Debemos editar el fichero .env de nuestro proyecto, modificando la siguiente configuración como corresponda:

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sacristan_db // nombre de la base de datos
DB_USERNAME=sacdbuser // usuario de conexión a la base de datos
DB_PASSWORD=password // contraseña de conexión a la base de datos
```

Si necesitamos limpiar la información de la conexión de la caché, utilizar el siguiente comando en el terminal:

```bash
php artisan config:clear 
```

## 🧱 Generación de código con Artisan

### Crear nuevos modelos

Ejemplo con el modelo **Task**:

```bash
php artisan make:model Task -mcr
```

**Significado de las opciones:**

| Opción | Descripción                                                                                      |
| ------ | ------------------------------------------------------------------------------------------------ |
| `-m`   | Crea la **migración** (`create_tasks_table.php`)                                                 |
| `-c`   | Crea el **controlador** (`TaskController.php`)                                                   |
| `-r`   | Genera un **controlador RESTful** con los métodos `index`, `store`, `show`, `update` y `destroy` |

---

## 🗄️ Definición del esquema de migración

El archivo de migración se genera en `database/migrations/`.

Ejemplo básico:

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();  // Identificador principal
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relación con usuarios
    $table->string('title');  // Campo de texto corto
    $table->text('notes')->nullable(); // Campo de texto largo
    $table->boolean('done')->default(false); // Estado booleano
    $table->timestamps();
});
```

Aplicar las migraciones:

```bash
php artisan migrate
```

En Laravel, las relaciones en migraciones se definen usando foreignId y constrained(). Esto crea una columna con clave foránea y la enlaza automáticamente con la tabla correspondiente.

Ejemplo:

```php
Schema::create('producto', function (Blueprint $table) {
    $table->id();  // Identificador principal
    $table->foreignId('categoria_id')->constrained('categorias', 'id')->cascadeOnDelete();
    $table->string('title');  // Campo de texto corto
    $table->decimal('precio', 10, 2);
    $table->timestamps();
});

```
Significa:

```foreignId('categoria_id'):``` crea una columna categoria_id tipo BIGINT sin signo.

```constrained('categorias', 'id'):``` asume que la tabla relacionada es categorias y la columna es id.

```cascadeOnDelete():``` si el usuario se borra, también se borran las secuencias asociadas.

```$table->decimal('precio', 10, 2);``` 10 = dígitos totales, 2 = decimales. 

## TIPOS NUMÉRICOS EN MIGRACIONES

### Decimales / precisión fija

```decimal(precision, scale)``` → perfecto para dinero.

### Números en coma flotante

```float(total, decimals)```

```double(total, decimals)``` → igual que float pero más precisión.

### Booleanos

```boolean()``` → se almacena como TINYINT(1).

### Otros menos usados
```unsignedBigInteger()```, ```mediumInteger()```, ```unsignedTinyInteger()```, etc.

Si trabajas con cantidades económicas → decimal.

Si necesitas enteros → cualquier integer.

Si necesitas aproximación → float o double.

## TIPOS FECHAS Y TIEMPO EN MIGRACIONES

```date()``` → solo fecha (YYYY-MM-DD)

```datetime()``` → fecha y hora

```timestamp()``` → marca de tiempo (usado para created_at, updated_at)

```time()``` → solo hora

```year()``` → solo año

dateTimeTz() / timestampTz() → versiones con zona horaria

### Otros útiles:

```softDeletes()``` → crea deleted_at tipo timestamp

```timestamps()``` → crea created_at y updated_at

## TIPOS TEXTOS EN MIGRACIONES

```string()``` → VARCHAR (hasta 255 chars)

```text()``` → TEXT (hasta ~64 KB)

```mediumText()``` → MEDIUMTEXT (hasta ~16 MB)

```longText()``` → LONGTEXT (hasta ~4 GB)

```char()``` → CHAR de longitud fija

Ejemplos:
```php
$table->string('titulo');
$table->text('descripcion');
$table->mediumText('contenido_largo');
$table->longText('json_grande');
```

---

## 🧩 Generador de código con Blueprint

Blueprint permite generar **modelos, controladores, migraciones y rutas** a partir de un archivo YAML sencillo.

### Instalación

```bash
composer require --dev laravel-shift/blueprint
```

### Definir el esquema (`draft.yaml`)

Ejemplo:

```yaml
models:
    Task:
        title: string
        notes: text nullable
        done: boolean default:false
        user_id: id:user

controllers:
    Task:
        resource: api
```

### Generar el código

```bash
php artisan blueprint:build
```

Blueprint creará automáticamente:

-   `app/Models/Task.php`
-   `database/migrations/...create_tasks_table.php`
-   `app/Http/Controllers/TaskController.php`
-   y añadirá la ruta:
    ```php
    Route::apiResource('tasks', TaskController::class);
    ```
    en `routes/api.php`.

---

## ✅ Recomendaciones

-   Usa `php artisan route:list` para revisar tus endpoints.
-   Añade autenticación con **Laravel Sanctum** si tu API necesita protección.
-   Usa **Postman** o **Insomnia** para probar tus endpoints fácilmente.

---
