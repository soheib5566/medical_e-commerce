# 🏥 MedStore - Medical E-Commerce Platform

A Laravel-based e-commerce platform for selling and managing medical products.  
It includes **customer pages** (browse, cart, checkout) and an **admin panel** (products, orders, product logs).  

---

## 🚀 Features
- Customer side:
  - Browse products by category, price filter, and search
  - Add to cart (AJAX, no reload)
  - Checkout with delivery information
  - Order confirmation page
- Admin side:
  - Product management (create, edit, delete, stock)
  - Orders management with status (Processing, Delivered, Shipped)
  - Product logs to track changes
  - Authentication system

---

## 📦 Installation

1. **Clone repository**
   ```bash
   git clone https://github.com/soheib5566/medical_e-commerce.git
   cd medical-e-commerce

2. **Install dependencies**
```bash
composer install
npm install && npm run dev
```
3. **Setup environment & DataBase**
```bash
cp .env.example .env
```
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_e_commerce
DB_USERNAME=root
DB_PASSWORD=your_password
```
4. **Generate app key**
```bash
php artisan key:generate
```
5. **Run migrations and seeders**
```bash
php artisan migrate:fresh --seed
```
6. **Storage link**
```bash
php artisan storage:link
```
7. **Run local server**
```bash
php artisan serve
```
## 👨‍💻 Admin Test Credentials
Email: admin@gmail.com
Password: 555666

## Key Components

Customer Side

resources/views/website – Product listing, cart, checkout

Admin Side

resources/views/admin – Dashboard, products, orders, product logs

Controllers

ProductController, OrderController, CartController

## 🌐 Website (Customer) Routes

| Method | URL                     | Description                                |
|--------|-------------------------|--------------------------------------------|
| GET    | /                       | Show all products (homepage)               |
| POST   | /products/{product}/cart| Add a product to the cart                  |
| GET    | /cart                   | View cart items                            |
| GET    | /cart/count             | Get cart item count (AJAX)                 |
| PUT    | /cart/{product}         | Update quantity of a product in the cart   |
| DELETE | /cart/{product}         | Remove a product from the cart             |
| GET    | /checkout               | Show checkout form                         |
| POST   | /checkout               | Place order                                |
| GET    | /orders/{order}         | Show order confirmation/details            |

---
## 🔑 Admin Auth Routes

| Method | URL      | Description            |
|--------|----------|------------------------|
| GET    | /login   | Show login form        |
| POST   | /login   | Process login request  |
| POST   | /logout  | Logout the user        |

---

## 🛠️ Admin Routes

(All routes are prefixed with `/admin` and protected by `auth` middleware)

| Method | URL                     | Description                                |
|--------|-------------------------|--------------------------------------------|
| GET    | /admin/dashboard        | Admin dashboard (stats overview)           |
| GET    | /admin/products         | List products                              |
| GET    | /admin/products/create  | Show create product form                   |
| POST   | /admin/products         | Store a new product                        |
| GET    | /admin/products/{id}/edit | Edit a product                           |
| PUT    | /admin/products/{id}    | Update a product                           |
| DELETE | /admin/products/{id}    | Delete a product                           |
| GET    | /admin/orders           | List orders                                |
| GET    | /admin/orders/{id}      | Show a specific order                      |
| PUT    | /admin/orders/{id}      | Update order status                        |
| GET    | /admin/product-logs     | View product logs (changes history)        |
---
## 🛠️ Tech Stack

- Laravel 11 (Backend)

- MySQL / PostgreSQL (Database)

- TailwindCSS (Styling)

- Alpine.js (Frontend interactivity)

- Vite (Asset bundling)

- Render (Deployment)

-Clever Cloud (Database Deployment)
