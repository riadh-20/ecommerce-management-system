
# 🛒 E‑Commerce Management System

## 📌 Project Overview
This project is a **complete multi‑role e‑commerce web application** developed as a **Bachelor’s Degree Final Project** at the **University of Parma**.

The system covers the **entire business workflow** of an online shopping platform — from user registration and product management to ordering, payment, delivery, and feedback — using **native PHP** with a smooth **UI/UX design**.

---

## 🎯 Objectives
- Design a real‑world e‑commerce platform
- Implement role‑based access control
- Manage orders from creation to delivery
- Provide a scalable and modular architecture
- Apply UML modeling (Use Case & Class diagrams)

---

## 👥 User Roles

### 👀 Visitor
- Browse products
- Register as Client, Store Partner, or Delivery Agent

### 🛍️ Client
- Search and browse products
- Add products to cart
- Place orders and make payments
- Track order status
- Evaluate products and delivery service

### 🏪 Store Partner (Magasin)
- Add, update, and delete products
- Manage stock and prices
- View customer orders
- Manage delivery agents

### 🚚 Delivery Agent (Livreur)
- View available orders
- Accept and validate deliveries
- Update delivery status
- Report delivery problems

### 🔐 Administrator
- Manage all users (clients, stores, delivery agents)
- Approve or refuse registration requests
- Block or deactivate accounts
- Monitor system activity

---

## 🔄 System Workflow
1. Visitor registers on the platform
2. Admin validates registration requests
3. Store partners add products
4. Clients browse products and place orders
5. Payment is processed
6. Delivery agents accept and deliver orders
7. Clients provide feedback and evaluations

---

## 🧩 UML Diagrams

### 📘 Class Diagram
This diagram represents the system’s structure, including:
- Accounts and authentication
- Users (Client, Livreur, Magasin, Admin)
- Orders, carts, products, and payments
- Evaluations and problem reporting

📌 **File:** `docs/class-diagram.png`

---

### 📗 Use Case Diagram
This diagram illustrates:
- All system actors
- Interactions between users and the system
- Included and extended functionalities
- Integration with mobile apps and GPS services

📌 **File:** `docs/usecase-diagram.png`

---

## 🛠️ Technologies Used
- **Backend:** Native PHP
- **Frontend:** HTML5, CSS3, JavaScript
- **Database:** MySQL
- **UI/UX:** Responsive and smooth interface
- **Modeling:** UML (Class & Use Case Diagrams)

---

## 📂 Project Structure
```
/admin        → Admin dashboard
/client       → Client interface
/guest        → Visitor pages
/magasin      → Store partner interface
/livreur      → Delivery agent interface
/assets       → CSS, JS, images
/config       → Database configuration
/includes    → Shared PHP logic
/docs         → UML diagrams
```

---

## 🎓 Academic Context
This project demonstrates:
- Full‑stack web development skills
- System analysis and UML modeling
- Real‑world business logic implementation
- Secure role‑based architecture

---

## 📜 License
This project is licensed under the **MIT License**.
