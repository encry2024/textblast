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
  - GOIP_DEFAULT
- Generate new application key: **php artisan key:generate**
- Run migration and seeder: **php artisan migrate --seed**
- Run queue listener daemon: **php artisan queue:work --daemon**
- Run GoIP Listener: **php artisan goip:listener**
- Edit crontab and add these line: ** * * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1**