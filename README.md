# 💰 AturUangmu - Personal Finance Management

Built with the cutting-edge **Laravel 12**, this application is designed for efficient personal financial tracking with a focus on clean architecture, real-time data integration, and professional UI/UX.

## 🚀 Key Features

* **Modern Tech Stack:** Leveraging the latest features of **Laravel 12** for enhanced performance and security.
* **Smart Budget Monitoring:** Real-time budget tracking with "Health Status" indicators (Healthy, Warning, Danger) to prevent overspending.
* **Professional Reporting:** Generate and download comprehensive financial reports in **PDF format** with localized naming.
* **Real-time Multi-currency:** Integrated with **ExchangeRate-API** to provide live currency conversion (IDR to USD) with **Smart Caching**.
* **Dynamic Localization:** Full support for **English** and **Indonesian** interfaces using Laravel's localization system.
* **Interactive UI:** Modern dashboard with interactive modals and floating "Toast" notifications built using **Tailwind CSS** and **Alpine.js**.
* **Interactive Data Visualization:** Dynamic line charts for cash flow trends and doughnut charts for category-based expense distribution, powered by **Chart.js**.

## 🛠 Technical Implementation

* **Service Layer Pattern:** Heavy logic for Exports and Finance is decoupled into dedicated Service classes to maintain a slim Controller.
* **Component-Based Design:** Reusable Blade components for notifications and UI elements to maintain clean code.
* **Helper Functions:** Custom `CurrencyHelper` registered via Composer for global access to formatting logic.
* **Optimized Queries:** Implementation of Eager Loading to prevent N+1 query issues during report generation.
* **Asynchronous Data Visualization:** Integrated **Chart.js** with backend datasets to provide real-time cash flow trends and category distribution, managed through a clean separation of concerns in JavaScript assets.
* **Modular Asset Management:** Organized frontend logic using dedicated JS modules (`charts.js`, `dashboard.js`) to ensure the dashboard remains performant and easy to maintain.

## 🗺 Upcoming Updates (Roadmap)
* [ ] **Intelligent Category Alerts:** Automated notifications triggered when a specific category reaches a "Warning" or "Danger" health status based on its budget limit.
* [ ] **Dynamic Theme Engine:** Support for **Dark Mode** and customizable color presets using Tailwind CSS
* [ ] User Authentication & Profile Management.


---
*Current Status: Active Development*
