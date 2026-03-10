# GarageAuto — API

REST API backend for the GarageAuto platform, a full-stack appointment booking system for garages inspired by Doctolib.  
This repository contains the Laravel API, consumed by the [GarageAuto Frontend](https://github.com/gargeAuto/garage-auto-web).

---

## Tech Stack

- **PHP** + **Laravel**
- **MySQL 8** — database
- **JWT** — stateless authentication
- **Docker** + **Docker Compose** — containerized environment
- **Laravel Mailables** — email validation flow

---

## Features

### Auth
- User registration & login (`/api/signup`, `/api/login`)
- Email verification flow
- JWT-based authentication
- Role-based access control — `user`, `technician`, `admin`

### Vehicles
- Create, read, update, delete user vehicles
- Search vehicles
- External car API integration (make, model, year)

### Appointments
- Book an appointment
- View appointments (filtered by role)
- Assign a technician to an appointment (admin only)
- Get appointments per day (admin/technician)
- Search appointments

### Admin
- Add / remove engineers
- Full user management (CRUD via `apiResource`)
- View recent users
- Search users and vehicles

---

## API Endpoints

### Public
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/signup` | Register a new user |
| POST | `/api/login` | Login and receive JWT token |
| GET | `/api/verify-email` | Verify email address |
| GET | `/api/make` | Get car makes |
| GET | `/api/model` | Get car models |
| GET | `/api/year` | Get car years |

### Protected (JWT required + email verified)
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/logout` | Logout |
| GET | `/api/user` | Get authenticated user |
| POST | `/api/cars` | Add a vehicle |
| GET | `/api/cars` | Get all vehicles |
| GET | `/api/cars/{id}` | Get vehicles by user ID |
| PATCH | `/api/cars/{id}` | Update a vehicle |
| DELETE | `/api/cars/{id}` | Delete a vehicle |
| POST | `/api/appointments` | Book an appointment |
| GET | `/api/appointments` | Get appointments (by role) |
| DELETE | `/api/appointments/{id}` | Cancel an appointment |

### Admin only
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/admin` | Add an engineer |
| DELETE | `/api/admin` | Remove an engineer |
| PATCH | `/api/appointments/{id}/assign` | Assign engineer to appointment |
| GET/POST/PUT/DELETE | `/api/users` | Full user management |

### Admin + Technician
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/newusers` | Get recent users |
| GET | `/api/appointments-per-day` | Get today's appointments |
| GET | `/api/AppointementSearch` | Search appointments |
| GET | `/api/cars-search` | Search vehicles |
| GET | `/api/users-search` | Search users |

---

## Prerequisites

- Docker & Docker Compose

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/gargeAuto/grage-auto-api.git
cd grage-auto-api
```

### 2. Configure environment variables

Copy the example file and fill in your values:

```bash
cp .env.example .env
```

Edit `.env` with your values:

```env
APP_KEY=base64:your_generated_key

DB_DATABASE=garageauto
DB_USERNAME=garageauto_user
DB_PASSWORD=secret
FORWARD_DB_PORT=3301

DEFAULT_ADMIN_EMAIL=admin@garage.com
DEFAULT_ADMIN_PASSWORD=yourpassword

DEFAULT_ENGINEER_EMAIL=engineer@garage.com
DEFAULT_ENGINEER_PASSWORD=yourpassword

DEFAULT_USER_EMAIL=user@garage.com
DEFAULT_USER_PASSWORD=yourpassword
```

> ⚠️ Never commit your `.env` file to GitHub

### 3. Start the containers

```bash
docker compose up -d
```

This starts two containers:
- `laravel-app` — the Laravel API on port **8085**
- `laravel-mysql` — MySQL 8 on port **3301**

### 4. Run migrations & seeders

```bash
docker exec laravel-app php artisan migrate --seed
```

The API is now available at:

```
http://localhost:8085/api
```

---

## Useful Docker Commands

| Command | Description |
|---------|-------------|
| `docker compose up -d` | Start containers in background |
| `docker compose down` | Stop and remove containers |
| `docker compose logs -f` | Follow container logs |
| `docker exec laravel-app php artisan migrate` | Run migrations |
| `docker exec laravel-app php artisan migrate:fresh --seed` | Reset database and seed |
| `docker exec laravel-app php artisan make:controller MyController` | Generate a controller |

---

## Collaborators

- [alexandre-delsol](https://github.com/alexandre-delsol)
- [norstroph](https://github.com/norstroph)

---

## License

Educational project — training purpose only.
