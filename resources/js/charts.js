window.initDashboardChart = function(incomeData, expenseData, labels, currency = 'IDR', incomeLabel = 'Pemasukan', expenseLabel = 'Pengeluaran') {
    // Determine locale based on currency
    const locale = currency === 'USD' ? 'en-US' : 'id-ID';
    const fractionDigits = currency === 'USD' ? 2 : 0;

    var options = {
        series: [{
            name: incomeLabel,
            data: incomeData
        }, {
            name: expenseLabel,
            data: expenseData
        }],
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
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100]
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: labels,
            labels: { style: { colors: '#94a3b8', fontWeight: 600 } }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return new Intl.NumberFormat(locale, {
                        style: 'currency',
                        currency: currency,
                        minimumFractionDigits: fractionDigits
                    }).format(value);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return new Intl.NumberFormat(locale, {
                        style: 'currency',
                        currency: currency,
                        minimumFractionDigits: fractionDigits
                    }).format(val);
                }
            }
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        legend: { position: 'top', horizontalAlign: 'right', fontWeight: 700 }
    };

    // Clear the old chart before rendering a new one 
    const chartContainer = document.querySelector("#chart-arus-kas");
    if (chartContainer) {
        chartContainer.innerHTML = '';
        var chart = new ApexCharts(chartContainer, options);
        chart.render();
    }
}