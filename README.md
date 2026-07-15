# 🏛️ Citizen Issue Reporting System

A web-based platform that enables citizens to report public issues directly to the responsible authorities. The system helps government departments receive, manage, and track complaints efficiently while allowing citizens to monitor the status of their reports.

---

## 📌 Project Overview

The Citizen Issue Reporting System is developed as a **BSc CSIT Final Year Project** using PHP and MySQL. It provides a simple and transparent platform where citizens can report issues such as:

- 🛣️ Road Damage
- 💡 Street Light Problems
- 🚮 Garbage Management
- 🚰 Water Supply Issues
- 🌳 Environmental Problems
- 🏗️ Public Infrastructure Damage
- 🚦 Traffic-related Issues
- Other civic complaints

The system improves communication between citizens and local authorities by allowing real-time issue tracking and efficient complaint management.

---

## ✨ Features

### 👤 Citizen

- User Registration
- Secure Login
- Report New Issues
- Upload Issue Images
- Select Issue Category
- Pin Issue Location using Google Maps
- View Submitted Reports
- Track Issue Status
- Dashboard with Report Statistics
- Profile Management

### 👨‍💼 Administrator

- Secure Admin Login
- Dashboard Overview
- View All Reported Issues
- Filter Issues
- Assign Issues
- Update Issue Status
- Manage Categories
- Manage Users
- View Reporting Statistics

---

## 🛠️ Technologies Used

| Technology | Purpose |
|------------|----------|
| PHP | Backend Development |
| MySQL | Database |
| HTML5 | Structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Client-side Functionality |
| Google Maps API | Location Selection |
| XAMPP / PHP Built-in Server | Local Development |

---

## 📂 Project Structure

```
CitizenIssueReporting/
│
├── admin/
│   ├── dashboard.php
│   ├── manage_users.php
│   ├── manage_categories.php
│   ├── manage_reports.php
│
├── user/
│   ├── dashboard.php
│   ├── my_report.php
│   ├── view_issue.php
│
├── includes/
│   ├── db.php
│   ├── header.php
│   ├── footer.php
│   ├── navbar.php
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│
├── uploads/
│
├── login.php
├── register.php
├── report_issue.php
├── logout.php
├── index.php
│
└── README.md
```

---

## 🗄️ Database

Database Name:

```
citizen_issue_reporting
```

Main Tables

- users
- issues
- categories
- departments (optional)
- notifications (optional)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/CitizenIssueReporting.git
```

### 2. Move Project

Place the project inside your web server directory.

Example:

```
htdocs/
```

or run using PHP built-in server.

---

### 3. Create Database

Open MySQL and create the database:

```sql
CREATE DATABASE citizen_issue_reporting;
```

Import the provided SQL file.

---

### 4. Configure Database

Edit:

```
includes/db.php
```

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "citizen_issue_reporting";
```

---

### 5. Start Server

Using PHP

```bash
php -S localhost:8000
```

Visit

```
http://localhost:8000
```

---

## 📷 Screenshots

Add screenshots here.

Example:

```
screenshots/
    home.png
    login.png
    register.png
    dashboard.png
    report_issue.png
    admin_dashboard.png
```

---

## 🔐 User Roles

### Citizen

- Register
- Login
- Submit Issues
- Track Reports
- View Dashboard

### Administrator

- Login
- View Reports
- Manage Categories
- Update Status
- Manage Users

---

## 🔄 Workflow

1. Citizen registers.
2. Citizen logs in.
3. Citizen reports an issue.
4. Citizen selects category.
5. Citizen pins the issue location on Google Maps.
6. Issue is stored in the database.
7. Administrator reviews the report.
8. Administrator updates issue status.
9. Citizen tracks the progress through their dashboard.

---

## 🎯 Objectives

- Simplify public issue reporting.
- Improve communication between citizens and government.
- Increase transparency.
- Reduce response time.
- Digitize complaint management.
- Maintain centralized issue records.

---

## 🔮 Future Enhancements

- Email Notifications
- SMS Alerts
- Mobile Application
- AI-based Issue Categorization
- GIS Heat Maps
- Department-wise Analytics
- QR Code Tracking
- Multi-language Support
- Real-time Notifications

---

## 👨‍💻 Developed By

**Bibek Thapa**

BSc CSIT Final Year Project

---

## 📄 License

This project is developed for educational purposes as a BSc CSIT Final Year Project.

You may use and modify it for learning and academic purposes.

---

## ⭐ Acknowledgements

- Bootstrap
- Google Maps Platform
- PHP
- MySQL
- OpenAI ChatGPT (development assistance)

---

### If you found this project useful, consider giving it a ⭐ on GitHub.