# Tuxpan Test API

API RESTful para la gestión de tareas utilizando Laravel.

## Instalación

Estos son los pasos para configurar el proyecto localmente.

### Prerrequisitos

- Git
- PHP >= 7.3
- Composer
- MySQL o SQLite (según preferencia)
- Docker (opcional, si se desea usar contenedores)

### Clonar el repositorio

Primero, clona el repositorio de GitHub:

```bash
git clone https://github.com/jgarces86/tuxpanTest.git
cd tuxpanTest
```

### Instalar dependencias
Instala las dependencias de PHP con Composer:

```bash
composer install
```
### Configurar el entorno
Copia el archivo de entorno de ejemplo y genera la clave de aplicación:

```bash
cp .env.example .env
```

### Configurar la base de datos
Abre el archivo .env y configura las credenciales de tu base de datos.

Para MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

Para SQLite (crea un archivo database.sqlite en la carpeta database):

```env
DB_CONNECTION=sqlite
```

### Ejecutar migraciones

Ejecuta las migraciones para crear las tablas en la base de datos:

```bash
php artisan migrate
```

### Levantar el servidor local

Para iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

O si prefieres usar Docker, asegúrate de tener docker-compose y luego:

```bash
docker-compose up -d
```

### Endpoints de la API
Los endpoints disponibles en la API son los siguientes:

Usuario:
1. POST /user/register
2. POST /user/login
3. POST /user/logout


Tareas:
1. GET /task/mytasks
2. POST /task/new
3. POST /task/assign
4. PUT /task/update/{id}
5. PUT /task/status/{id}
6. DELETE /task/{id}

Recuerda reemplazar {id} con el ID real de la tarea que deseas actualizar o eliminar.