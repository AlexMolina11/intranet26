Manual de Instalación – Intranet 2026
Requisitos del sistema

Antes de iniciar, asegúrate de tener instalado:

PHP 8.2 o superior
Composer 2.x
Node.js 18+ (recomendado 20+)
npm 9+
Git
XAMPP (o servidor con MySQL/MariaDB)

Verificar versiones:

php -v
composer -V
node -v
npm -v
git --version

1. Clonar el repositorio

git clone https://github.com/TU_USUARIO/intranet26.git
cd intranet26

2. Manejo de ramas

Si trabajas con develop:
git checkout develop

Si no aparece:
git fetch --all
git checkout develop

3. Instalar dependencias de PHP
composer install

Si da error, intenta:
composer install --ignore-platform-reqs

4. Configuración del entorno

Copiar archivo .env:
copy .env.example .env

5. Generar clave de la aplicación
php artisan key:generate

6. Configurar base de datos
Editar .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_intranet
DB_USERNAME=root
DB_PASSWORD=

Crear la base de datos en phpMyAdmin o MySQL:
CREATE DATABASE db_intranet;

7. Ejecutar migraciones
php artisan migrate

8. Ejecutar seeders
php artisan db:seed

Esto creará:

Sistema base (INTRANET)
Roles
Permisos
Usuario administrador

9. Usuario por defecto
Correo: admin@intranet.local
Contraseña: password (o la definida en el seeder)

10. Instalar dependencias frontend
npm install

11. Compilar assets

Modo desarrollo:
npm run dev

Modo producción:
npm run build

12. Levantar el servidor
php artisan serve

Acceder en:
http://127.0.0.1:8000