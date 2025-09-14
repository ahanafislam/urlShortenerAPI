# URL Shortener API

This is a REST API for shortening URLs, built with Laravel. It includes user authentication, URL management, and bonus features like visit tracking.

## ✅ Features Checklist

This project successfully implements the following features:

### Core Features
- [x] **User Registration:** `POST /api/register` to create a new user account.
- [x] **User Login:** `POST /api/login` to authenticate and receive a Sanctum API token.
- [x] **URL Shortening:** `POST /api/shorten` for authenticated users to create short URLs.
- [x] **List User URLs:** `GET /api/urls` for authenticated users to retrieve their created URLs.
- [x] **Redirection:** `GET /{short_code}` to redirect users to the original URL.
- [x] **Visit Tracking:** Automatically counts visits for each redirect.

---

<a href="https://documenter.getpostman.com/view/48422144/2sB3HqGdFc" target="_blank" rel="noopener noreferrer">
  <button style="padding:10px 16px; border-radius:6px; border:none; cursor:pointer; font-weight:600; background-color:#f97316; color:#ffffff;">
    View Postman Collections
  </button>
</a>


## 📦 Installation Instructions

To set up this project locally, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/ahanafislam/urlShortenerAPI.git
    cd urlShortenerAPI
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your database:**
    Open the `.env` file and set your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

6.  **Run the database migrations:**
    This will create all the necessary tables (`users`, `urls`, `personal_access_tokens`, etc.).
    ```bash
    php artisan migrate
    ```

7.  **Start the local server:**
    ```bash
    php artisan serve
    ```
    Your application will be running at `http://127.0.0.1:8000`.

---

## 📖 API Documentation

All API endpoints expect and return JSON. Always include the following header in your requests:

`Accept: application/json`

### 1. User Registration

- **Endpoint:** `POST /api/register`
- **Description:** Creates a new user account.
- **Authentication:** Public

**Request Body:**
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Success Response (201 Created):**
```json
{
    "message": "User registered successfully",
    "user": {
        "name": "Test User",
        "email": "test@example.com",
        "updated_at": "2025-09-15T12:00:00.000000Z",
        "created_at": "2025-09-15T12:00:00.000000Z",
        "id": 1
    }
}
```

### 2. User Login

- **Endpoint:** `POST /api/login`
- **Description:** Authenticates a user and returns a Sanctum API token.
- **Authentication:** Public

**Request Body:**
```json
{
    "email": "test@example.com",
    "password": "password123"
}
```

**Success Response (200 OK):**
```json
{
    "message": "Login successful",
    "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890"
}
```

### 3. Shorten a New URL

- **Endpoint:** `POST /api/shorten`
- **Description:** Creates a new short URL for the authenticated user.
- **Authentication:** Required (`Bearer Token`)

**Headers:**
`Authorization: Bearer <your_token>`

**Request Body:**
```json
{
    "original_url": "https://www.google.com/search?q=laravel"
}
```
*Note: `expires_at` is optional.*

**Success Response (201 Created):**
```json
{
    "message": "URL shortened successfully",
    "data": {
        "original_url": "https://www.google.com/search?q=laravel",
        "short_code": "aBc123",
        "expires_at": "2026-12-31 00:00:00",
        "user_id": 1,
        "id": 1,
        "updated_at": "2025-09-15T12:05:00.000000Z",
        "created_at": "2025-09-15T12:05:00.000000Z"
    }
}
```

### 4. Get User's URLs

- **Endpoint:** `GET /api/urls`
- **Description:** Retrieves a list of all URLs shortened by the authenticated user.
- **Authentication:** Required (`Bearer Token`)

**Headers:**
`Authorization: Bearer <your_token>`

**Success Response (200 OK):**
```json
{
    "data": [
        {
            "id": 1,
            "original_url": "https://www.google.com/search?q=laravel",
            "short_code": "aBc123",
            "short_url": "http://localhost:8000/aBc123",
            "visit_count": 0,
            "created_at": "2025-09-15 12:05:00"
        }
    ]
}
```

### 5. Redirection

- **Endpoint:** `GET /{short_code}`
- **Description:** Redirects a user to the original URL. This is a web route, not an API route.
- **Authentication:** Public

**Usage:**
Simply visit the short URL in a web browser (e.g., `http://localhost:8000/aBc123`).

- If the link is valid and not expired, you will be redirected with a `301` status code.
- If the link has expired, you will receive a `410 Gone` response.
- If the link does not exist, you will receive a `404 Not Found` response.
