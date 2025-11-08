# MediaAccred

Проект для управления аккредитацией медиа.

## Структура проекта

Проект разделен на две основные части:

- **backend/** - Laravel API (PHP)
- **frontend/** - Vue.js приложение

## Технологии

### Backend
- **Framework**: Laravel 12
- **База данных**: PostgreSQL
- **API**: RESTful API

### Frontend
- **Framework**: Vue 3
- **UI Library**: Vuetify 3
- **Build Tool**: Vite
- **State Management**: Pinia
- **Router**: Vue Router

## Установка и запуск

### Backend (Laravel)

1. Перейдите в директорию backend:
```bash
cd backend
```

2. Установите зависимости:
```bash
composer install
```

3. Настройте файл `.env`:
```bash
cp .env.example .env
```

Обновите настройки базы данных в `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mediaaccred
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

4. Сгенерируйте ключ приложения:
```bash
php artisan key:generate
```

5. Запустите миграции:
```bash
php artisan migrate
```

6. Запустите сервер разработки:
```bash
php artisan serve
```

API будет доступен по адресу: `http://localhost:8000`

### Frontend (Vue)

1. Перейдите в директорию frontend:
```bash
cd frontend
```

2. Установите зависимости:
```bash
pnpm install
```

3. Настройте переменные окружения (если необходимо):
```bash
cp .env.example .env
```

4. Запустите сервер разработки:
```bash
pnpm dev
```

Приложение будет доступно по адресу: `http://localhost:5173`

## Настройка API

Frontend обращается к API через переменную окружения. Убедитесь, что в `frontend/.env` указан правильный URL API:

```env
VITE_API_URL=http://localhost:8000/api
```

## Разработка

### Backend

- API endpoints находятся в `backend/routes/api.php`
- Контроллеры в `backend/app/Http/Controllers`
- Модели в `backend/app/Models`
- Миграции в `backend/database/migrations`

### Frontend

- Компоненты в `frontend/src/components`
- Страницы в `frontend/src/pages`
- Роутинг настроен автоматически через `vue-router/auto`
- API вызовы через `frontend/src/utils/api.ts`

## База данных

Проект использует PostgreSQL. Убедитесь, что PostgreSQL установлен и запущен на вашей системе.

### Настройка PostgreSQL

1. Создайте базу данных:
```sql
CREATE DATABASE mediaaccred;
```

2. Создайте пользователя (если необходимо):
```sql
CREATE USER your_username WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE mediaaccred TO your_username;
```

3. Обновите настройки в `backend/.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mediaaccred
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. Запустите миграции:
```bash
cd backend
php artisan migrate
```

5. Создайте тестового пользователя:
```bash
php artisan user:create-test
```

По умолчанию создается пользователь:
- Email: `admin@demo.com`
- Password: `admin`
- Name: `Admin`

Вы можете указать свои параметры:
```bash
php artisan user:create-test --email=user@example.com --password=password123 --name="Test User"
```

## Аутентификация

### Backend API Endpoints

- `POST /api/auth/register` - Регистрация нового пользователя
- `POST /api/auth/login` - Вход в систему
- `POST /api/auth/logout` - Выход из системы (требует аутентификации)
- `GET /api/auth/user` - Получить данные текущего пользователя (требует аутентификации)

### Frontend

Frontend автоматически отправляет токен аутентификации в заголовке `Authorization: Bearer {token}` для всех запросов к API.

Токен сохраняется в cookie и автоматически добавляется к каждому запросу через `frontend/src/utils/api.ts`.

## Тестирование

1. Запустите backend:
```bash
cd backend
php artisan serve
```

2. Запустите frontend:
```bash
cd frontend
pnpm dev
```

3. Откройте браузер и перейдите на `http://localhost:5173/login`

4. Войдите используя тестовые данные:
   - Email: `admin@demo.com`
   - Password: `admin`

## Лицензия

Proprietary

