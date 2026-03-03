import { initDashboardChart, initCategoryChart } from './charts';

document.addEventListener("DOMContentLoaded", function () {
    const cashFlowEl = document.querySelector("#chart-arus-kas");
    const categoryEl = document.querySelector("#chart-kategori");

    if (cashFlowEl) {
        initDashboardChart(
            JSON.parse(cashFlowEl.dataset.income || '[]').map(Number),
            JSON.parse(cashFlowEl.dataset.expense || '[]').map(Number),
            JSON.parse(cashFlowEl.dataset.labels || '[]'),
            cashFlowEl.dataset.currency || 'IDR',
            cashFlowEl.dataset.labelIncome,
            cashFlowEl.dataset.labelExpense
        );
    }

    if (categoryEl) {
        const totalValue = parseFloat(categoryEl.dataset.total || 0);
        const values = JSON.parse(categoryEl.dataset.values || '[]').map(Number);
        const labels = JSON.parse(categoryEl.dataset.labels || '[]');

        initCategoryChart(
            values,
            labels,
            totalValue,
            categoryEl.dataset.currency || 'IDR'
        );
    }
});