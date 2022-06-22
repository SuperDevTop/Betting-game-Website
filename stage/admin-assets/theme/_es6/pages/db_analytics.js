/*
 *  Document   : db_analytics.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Analytics Dashboard Page
 */

class pageDashboardAnalytics {
    /*
     * Chart.js, for more examples you can check out http://www.chartjs.org/docs
     *
     */
    static initChartsBars() {
        // Set Global Chart.js configuration
        Chart.defaults.global.defaultFontColor              = '#495057';
        Chart.defaults.scale.gridLines.color                = 'transparent';
        Chart.defaults.scale.gridLines.zeroLineColor        = 'transparent';
        Chart.defaults.scale.ticks.beginAtZero              = true;
        Chart.defaults.global.elements.line.borderWidth     = 1;
        Chart.defaults.global.legend.labels.boxWidth        = 12;

        // Get Chart Containers
        let chartBarsCon = jQuery('.js-chartjs-analytics-bars');

        // Set Chart and Chart Data variables
        let chartBars, chartLinesBarsData;

        // Bars Chart Data
        chartLinesBarsData = {
            labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
            datasets: [
                {
                    label: 'This Week',
                    fill: true,
                    backgroundColor: 'rgba(103, 114, 229, .75)',
                    borderColor: 'rgba(103, 114, 229, 1)',
                    pointBackgroundColor: 'rgba(103, 114, 229, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(103, 114, 229, 1)',
                    data: [500, 750, 650, 570, 582, 480, 680]
                },
                {
                    label: 'Last Week',
                    fill: true,
                    backgroundColor: 'rgba(108, 117, 125, .15)',
                    borderColor: 'rgba(108, 117, 125, .75)',
                    pointBackgroundColor: 'rgba(108, 117, 125, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(108, 117, 125, 1)',
                    data: [352, 530, 541, 521, 410, 395, 460]
                }
            ]
        };

        // Init Chart
        if (chartBarsCon.length) {
            chartBars  = new Chart(chartBarsCon, { type: 'bar', data: chartLinesBarsData });
        }
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.initChartsBars();
    }
}

// Initialize when page loads
jQuery(() => { pageDashboardAnalytics.init(); });
