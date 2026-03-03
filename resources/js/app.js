import './bootstrap';
import { initDashboardChart, initCategoryChart } from './charts';
import './budget';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

import Alpine from 'alpinejs';

window.Alpine = Alpine;




Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const cashFlowEl = document.querySelector("#chart-arus-kas");
    const categoryEl = document.querySelector("#chart-kategori");

    // Logic to Area Chart
    if (cashFlowEl) {
        initDashboardChart(
            JSON.parse(cashFlowEl.dataset.income || '[]').map(Number),
            JSON.parse(cashFlowEl.dataset.expense || '[]').map(Number),
            JSON.parse(cashFlowEl.dataset.labels || '[]'),
            cashFlowEl.dataset.currency || 'IDR'
        );
    }

    // Logic to Donut Chart 
    if (categoryEl) {
    const total = parseFloat(categoryEl.dataset.total) || 0;
    const values = JSON.parse(categoryEl.dataset.values || '[]').map(Number);
    initCategoryChart(values, JSON.parse(categoryEl.dataset.labels), total, categoryEl.dataset.currency);
}
});