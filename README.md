# AturUangmu - Personal Finance Management

Built with the cutting-edge **Laravel 12.44.0**, this application is designed for efficient personal financial tracking with a focus on clean architecture, real-time data integration, and professional UI/UX.

## 🚀 Key Features

* **Modern Tech Stack:** Leveraging the latest features of **Laravel 12** for enhanced performance and security.
* **Real-time Multi-currency:** Integrated with **ExchangeRate-API** to provide live currency conversion (IDR to USD).
* **Smart Caching:** Implemented **Laravel Cache** to store exchange rates for 1 hour, optimizing performance and reducing external API dependency.
* **Dynamic Localization:** Full support for **English** and **Indonesian** interfaces using Laravel's localization system.
* **Interactive UI:** Modern dashboard with floating "Toast" notifications built using **Tailwind CSS** and **Alpine.js**.
* **Transaction Tracking:** Easily manage income and expenses with detailed descriptions and categorized records.

## 🛠️ Technical Implementation

* **Helper Functions:** Custom `CurrencyHelper` registered via Composer for global access to formatting logic.
* **API Integration:** Utilizing Laravel's `Http` client for robust external data fetching with built-in error handling.
* **Component-Based Design:** Reusable Blade components for notifications and UI elements to maintain clean code.

## 🚀 Upcoming Updates (Roadmap)
* [ ] Advanced Charts for Expense Analytics.
* [ ] Export Reports to PDF/Excel.
* [ ] User Authentication & Profile Management.
---
*Current Status: Active Development*
