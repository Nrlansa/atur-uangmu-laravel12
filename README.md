# 💰 AturUangmu - Personal Finance Management

Built with the cutting-edge **Laravel 12**, this application is designed for efficient personal financial tracking with a focus on clean architecture, real-time data integration, and professional UI/UX.

## 🚀 Key Features

* **Modern Tech Stack:** Leveraging the latest features of **Laravel 12** for enhanced performance and security.
* **Smart Budget Monitoring:** Real-time budget tracking with "Health Status" indicators (Healthy, Warning, Danger) to prevent overspending.
* **Professional Reporting:** Generate and download comprehensive financial reports in **PDF format** with localized naming.
* **Real-time Multi-currency:** Integrated with **ExchangeRate-API** to provide live currency conversion (IDR to USD) with **Smart Caching**.
* **Dynamic Localization:** Full support for **English** and **Indonesian** interfaces using Laravel's localization system.
* **Interactive UI:** Modern dashboard with interactive modals and floating "Toast" notifications built using **Tailwind CSS** and **Alpine.js**.

## 🛠 Technical Implementation

* **Service Layer Pattern:** Heavy logic for Exports and Finance is decoupled into dedicated Service classes to maintain a slim Controller.
* **Component-Based Design:** Reusable Blade components for notifications and UI elements to maintain clean code.
* **Helper Functions:** Custom `CurrencyHelper` registered via Composer for global access to formatting logic.
* **Optimized Queries:** Implementation of Eager Loading to prevent N+1 query issues during report generation.

## 🗺 Upcoming Updates (Roadmap)

* [ ] Advanced Charts for Expense Analytics using Chart.js.
* [ ] User Authentication & Profile Management.

---
*Current Status: Active Development*
