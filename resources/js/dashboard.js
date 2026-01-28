import { initDashboardChart, initCategoryChart } from './charts';

document.addEventListener("DOMContentLoaded", function () {
    const cashFlowEl = document.querySelector("#chart-arus-kas");
    const categoryEl = document.querySelector("#chart-kategori");

    if (cashFlowEl) {
        initDashboardChart(
            JSON.parse(cashFlowEl.dataset.income || '[]'),
            JSON.parse(cashFlowEl.dataset.expense || '[]'),
            JSON.parse(cashFlowEl.dataset.labels || '[]'),
            cashFlowEl.dataset.currency,
            cashFlowEl.dataset.labelIncome,
            cashFlowEl.dataset.labelExpense
        );
    }

    if (categoryEl) {
        initCategoryChart(
            JSON.parse(categoryEl.dataset.values || '[]'),
            JSON.parse(categoryEl.dataset.labels || '[]'),
            categoryEl.dataset.total,
            categoryEl.dataset.currency
        );
    }
});