
# Proyecto Laravel 10 - Métricas

Este proyecto es una aplicación web desarrollada en Laravel 10 que permite obtener y guardar métricas de rendimiento de sitios web utilizando la API de Google PageSpeed Insights.

## Requisitos

- PHP >= 8.1
- Composer
- Node.js >= 12
- NPM o Yarn
- Base de datos MySQL (o cualquier otra compatible con Laravel)

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto localmente.

### Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
```

### Instalar Dependencias de PHP

```bash
composer install
```

### Instalar Dependencias de Node.js

```bash
npm install
```

O si prefieres Yarn:

```bash
yarn install
```

### Configurar el Archivo `.env`

Copia el archivo `.env.example` y renómbralo a `.env`. Luego, configura tus credenciales de base de datos y otros parámetros necesarios.

```bash
cp .env.example .env
```


### Cree la base de datos broobe

```bash
create database broobe
```


### Generar la Clave de la Aplicación

```bash
php artisan key:generate
```

### Ejecutar las Migraciones

```bash
php artisan migrate
```

### Ejecutar los Seeders

```bash
php artisan db:seed
```

### Compilar los Activos

```bash
npm run build
```

O si prefieres Yarn:

```bash
yarn build
```

### Iniciar el Servidor de Desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`.

