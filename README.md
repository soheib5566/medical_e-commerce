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
npm install && npm run build
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
Generate app key
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
Run local server
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

