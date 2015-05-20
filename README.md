# Textblasting

## Installation
- Copy .env.example to .env
- Edit these variables in .env file
  - ADMIN_EMAIL
  - ADMIN_NAME
  - ADMIN_TYPE
  - ADMIN_PASSWORD
  - LOCAL_PORT
  - DB_HOST
  - DB_DATABASE
  - DB_USERNAME
  - DB_PASSWORD
- Run migration and seeder: **php artisan migrate --seed**
- Run queue listener daemon: **php artisan queue:work --daemon**
- Run GoIP Listener: **php artisan goip:listener**