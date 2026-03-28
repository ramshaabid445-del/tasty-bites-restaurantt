'use strict';

document.addEventListener('DOMContentLoaded', function () {
    // 500ms delay is good for safety, but make sure ApexCharts is loaded
    setTimeout(function () {
        if (typeof ApexCharts !== 'undefined') {
            floatchart();
        } else {
            console.error("Error: ApexCharts library not found.");
        }
    }, 500);
});

function floatchart() {
    // 1. Visitor Chart (Weekly)
    (function () {
        var options = {
            chart: { height: 450, type: 'area', toolbar: { show: false } },
            dataLabels: { enabled: false },
            colors: ['#1890ff', '#13c2c2'],
            series: [
                { name: 'Page Views', data: [31, 40, 28, 51, 42, 109, 100] },
                { name: 'Sessions', data: [11, 32, 45, 32, 34, 52, 41] }
            ],
            stroke: { curve: 'smooth', width: 2 },
            xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] }
        };
        var visitorChart = new ApexCharts(document.querySelector('#visitor-chart'), options);
        visitorChart.render();
    })();

    // 2. Visitor Chart (Monthly)
    (function () {
        if (document.querySelector('#visitor-chart-1')) {
            var options1 = {
                chart: { height: 450, type: 'area', toolbar: { show: false } },
                dataLabels: { enabled: false },
                colors: ['#1890ff', '#13c2c2'],
                series: [
                    { name: 'Page Views', data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 86, 115, 35] },
                    { name: 'Sessions', data: [110, 60, 150, 35, 60, 36, 26, 45, 65, 52, 53, 41] }
                ],
                stroke: { curve: 'smooth', width: 2 },
                xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] }
            };
            var visitorChart1 = new ApexCharts(document.querySelector('#visitor-chart-1'), options1);
            visitorChart1.render();
        }
    })();

    // 3. Income Overview Chart
    (function () {
        var options = {
            chart: { type: 'bar', height: 365, toolbar: { show: false } },
            colors: ['#13c2c2'],
            plotOptions: { bar: { columnWidth: '45%', borderRadius: 4 } },
            dataLabels: { enabled: false },
            series: [{ name: 'Income', data: [80, 95, 70, 42, 65, 55, 78] }],
            xaxis: { categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'] },
            yaxis: { show: false },
            grid: { show: false }
        };
        var incomeChart = new ApexCharts(document.querySelector('#income-overview-chart'), options);
        incomeChart.render();
    })();

    // 4. Analytics Report Chart
    (function () {
        var options = {
            chart: { type: 'line', height: 340, toolbar: { show: false } },
            colors: ['#faad14'],
            stroke: { curve: 'smooth', width: 1.5 },
            grid: { strokeDashArray: 4 },
            series: [{ name: 'Risk Cases', data: [58, 90, 38, 83, 63, 75, 35, 55] }],
            xaxis: {
                type: 'datetime',
                categories: ['2018-05-19T00:00:00.000Z', '2018-06-19T00:00:00.000Z', '2018-07-19T01:30:00.000Z', '2018-08-19T02:30:00.000Z', '2018-09-19T03:30:00.000Z', '2018-10-19T04:30:00.000Z', '2018-11-19T05:30:00.000Z', '2018-12-19T06:30:00.000Z'],
                labels: { format: 'MMM' }
            },
            yaxis: { show: false }
        };
        var analyticsChart = new ApexCharts(document.querySelector('#analytics-report-chart'), options);
        analyticsChart.render();
    })();

    // 5. Sales Report Chart
    (function () {
        var options = {
            chart: { type: 'bar', height: 430, toolbar: { show: false } },
            plotOptions: { bar: { columnWidth: '30%', borderRadius: 4 } },
            stroke: { show: true, width: 8, colors: ['transparent'] },
            dataLabels: { enabled: false },
            legend: { position: 'top', horizontalAlign: 'right', show: true, fontFamily: `'Public Sans', sans-serif` },
            colors: ['#faad14', '#1890ff'],
            series: [
                { name: 'Net Profit', data: [180, 90, 135, 114, 120, 145] },
                { name: 'Revenue', data: [120, 45, 78, 150, 168, 99] }
            ],
            xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'] }
        };
        var salesChart = new ApexCharts(document.querySelector('#sales-report-chart'), options);
        salesChart.render();
    })();
}