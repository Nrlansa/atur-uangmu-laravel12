// Grafik 
document.addEventListener("DOMContentLoaded", function () {
    const chartEl = document.querySelector("#chart-arus-kas");
    if (chartEl && typeof window.initDashboardChart === 'function') {
        window.initDashboardChart(
            JSON.parse(chartEl.dataset.income || '[]'),
            JSON.parse(chartEl.dataset.expense || '[]'),
            JSON.parse(chartEl.dataset.labels || '[]'),
            chartEl.dataset.currency
        );
    }
});