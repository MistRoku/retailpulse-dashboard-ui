export function dashboardHome() {
    return {
        loading: true,
        chartLoading: true,
        tableLoading: true,
        revenueChart: null,
        topProductsChart: null,

        init() {
            window.setTimeout(() => {
                this.loading = false;
                this.tableLoading = false;
            }, 350);

            window.setTimeout(() => {
                this.chartLoading = false;

                this.$nextTick(() => {
                    this.renderRevenueChart();
                    this.renderTopProductsChart();
                });
            }, 550);
        },

        renderRevenueChart() {
            const seed = window.dashboardSeed?.revenue;

            if (!seed || !this.$refs.revenueChart) {
                return;
            }

            if (this.revenueChart) {
                this.revenueChart.destroy();
            }

            this.revenueChart = new window.Chart(this.$refs.revenueChart, {
                type: 'line',
                data: {
                    labels: seed.labels,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: seed.values,
                            borderColor: '#111111',
                            backgroundColor: '#111111',
                            pointBackgroundColor: '#111111',
                            pointBorderColor: '#FFFFFF',
                            borderWidth: 2,
                            tension: 0,
                            fill: false,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#E5E7EB',
                            },
                            ticks: {
                                color: '#4B5563',
                            },
                        },
                        y: {
                            grid: {
                                color: '#E5E7EB',
                            },
                            ticks: {
                                color: '#4B5563',
                            },
                        },
                    },
                },
            });
        },

        renderTopProductsChart() {
            const seed = window.dashboardSeed?.topProducts;

            if (!seed || !this.$refs.topProductsChart) {
                return;
            }

            if (this.topProductsChart) {
                this.topProductsChart.destroy();
            }

            this.topProductsChart = new window.Chart(this.$refs.topProductsChart, {
                type: 'bar',
                data: {
                    labels: seed.map((item) => item.name),
                    datasets: [
                        {
                            label: 'Units sold',
                            data: seed.map((item) => item.quantity),
                            backgroundColor: '#111111',
                            borderColor: '#111111',
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#E5E7EB',
                            },
                            ticks: {
                                color: '#4B5563',
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#4B5563',
                            },
                        },
                    },
                },
            });
        },
    };
}
