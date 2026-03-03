import ApexCharts from 'apexcharts';

// Grafik 
export const initDashboardChart = function(incomeData, expenseData, labels, currency = 'IDR', incomeLabel = 'Pemasukan', expenseLabel = 'Pengeluaran') {
    const locale = currency === 'USD' ? 'en-US' : 'id-ID';
    const fractionDigits = currency === 'USD' ? 2 : 0;

    var options = {
        series: [{ name: incomeLabel, data: incomeData }, { name: expenseLabel, data: expenseData }],
        chart: {
            type: 'area',
            height: 300,
            fontFamily: 'Plus Jakarta Sans, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#10b981', '#f43f5e'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100] }
        },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: labels,
            labels: { style: { colors: '#94a3b8', fontWeight: 600 } }
        },
        dataLabels: {
            enabled: true,
            formatter: (val) => new Intl.NumberFormat(locale, { style: 'currency', currency: currency, minimumFractionDigits: fractionDigits }).format(val),
            offsetY: -10,
            style: { fontSize: '12px', fontWeight: 600 },
        },
        yaxis: {
            labels: {
                formatter: (value) => new Intl.NumberFormat(locale, { style: 'currency', currency: currency, minimumFractionDigits: fractionDigits }).format(value)
            }
        },
        tooltip: {
            y: {
                formatter: (val) => new Intl.NumberFormat(locale, { style: 'currency', currency: currency, minimumFractionDigits: fractionDigits }).format(val)
            }
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        legend: { position: 'top', horizontalAlign: 'right', fontWeight: 700 }
    };

    const container = document.querySelector("#chart-arus-kas");
    if (container) {
        container.innerHTML = '';
        new ApexCharts(container, options).render();
    }
}

//Fungsi Grafik Pie (Donut) 

export const initCategoryChart = function (values, labels, totalValue, currency = 'IDR') {
    const locale = currency === 'USD' ? 'en-US' : 'id-ID';
    
    const formatCurrency = (val) => new Intl.NumberFormat(locale, { 
        style: 'currency', 
        currency: currency,
        maximumFractionDigits: 0 
    }).format(val);

    var options = {
        series: values,
        chart: { type: 'donut', height: 300, fontFamily: 'Plus Jakarta Sans, sans-serif' },
        labels: labels,
        colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: { show: true, fontSize: '14px', color: '#64748b', offsetY: -10 },
                        value: { 
                            show: true, 
                            fontSize: '20px', 
                            fontWeight: 'bold', 
                            offsetY: 10,
                            formatter: (val) => formatCurrency(val) 
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#64748b',
                            formatter: function (w) {
                                return formatCurrency(totalValue);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        tooltip: {
            y: {
                formatter: (val) => formatCurrency(val)
            }
        },
        legend: { position: 'bottom', fontWeight: 600 }
    };

    const container = document.querySelector("#chart-kategori");
    if (container) {
        container.innerHTML = '';
        new ApexCharts(container, options).render();
    }
}
