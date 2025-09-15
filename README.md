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
composer install
npm install && npm run build
cp .env.example .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_e_commerce
DB_USERNAME=root
DB_PASSWORD=your_password
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
