export function reportsScreen(reportTypes, summaries, rows, comparisonSeries) {
    return {
        loading: true,
        reportType: 'sales-summary',
        startDate: '',
        endDate: '',
        dateError: '',
        reportTypes: reportTypes,
        summaries: summaries,
        rows: rows,
        comparisonSeries: comparisonSeries,
        chart: null,

        init() {
            const today = new Date();
            const sevenDaysAgo = new Date(today.getTime() - 6 * 24 * 60 * 60 * 1000);

            this.endDate = today.toISOString().slice(0, 10);
            this.startDate = sevenDaysAgo.toISOString().slice(0, 10);

            this.$watch('reportType', () => {
                this.applyFilters();
            });

            this.applyFilters();
        },

        applyFilters() {
            this.dateError = '';

            if (this.startDate && this.endDate && new Date(this.startDate) > new Date(this.endDate)) {
                this.dateError = 'Start date must be before end date.';
                return;
            }

            this.loading = true;

            window.setTimeout(() => {
                this.loading = false;

                this.$nextTick(() => {
                    this.renderChart();
                });
            }, 350);
        },

        resetFilters() {
            const today = new Date();
            const sevenDaysAgo = new Date(today.getTime() - 6 * 24 * 60 * 60 * 1000);

            this.endDate = today.toISOString().slice(0, 10);
            this.startDate = sevenDaysAgo.toISOString().slice(0, 10);
            this.reportType = 'sales-summary';
            this.dateError = '';
            this.applyFilters();
        },

        currentSummary() {
            return this.summaries[this.reportType] || [];
        },

        currentRows() {
            return this.rows[this.reportType] || [];
        },

        currentColumns() {
            const firstRow = this.currentRows()[0];

            if (!firstRow) {
                return [];
            }

            return Object.keys(firstRow).map((key) => {
                return key
                    .split(' ')
                    .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
                    .join(' ');
            });
        },

        renderChart() {
            if (!this.$refs.comparisonChart) {
                return;
            }

            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new window.Chart(this.$refs.comparisonChart, {
                type: 'line',
                data: {
                    labels: this.comparisonSeries.labels,
                    datasets: [
                        {
                            label: 'Current period',
                            data: this.comparisonSeries.current,
                            borderColor: '#111111',
                            backgroundColor: '#111111',
                            pointBackgroundColor: '#111111',
                            borderWidth: 2,
                            tension: 0,
                            fill: false,
                        },
                        {
                            label: 'Previous period',
                            data: this.comparisonSeries.previous,
                            borderColor: '#6B7280',
                            backgroundColor: '#6B7280',
                            pointBackgroundColor: '#6B7280',
                            borderWidth: 2,
                            borderDash: [5, 5],
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
                            labels: {
                                color: '#4B5563',
                                boxWidth: 12,
                                boxHeight: 12,
                            },
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

        exportCsv() {
            const table = document.getElementById('report-table');

            if (!table) {
                return;
            }

            const rows = Array.from(table.querySelectorAll('tr')).map((row) => {
                return Array.from(row.querySelectorAll('th, td')).map((cell) => {
                    return cell.textContent.trim();
                });
            });

            const csv = rows.map((row) => {
                return row.map((cell) => {
                    const value = String(cell ?? '');

                    if (/[",\n]/.test(value)) {
                        return '"' + value.replace(/"/g, '""') + '"';
                    }

                    return value;
                }).join(',');
            }).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = this.reportType + '-report.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        },

        printReport() {
            window.print();
        },
    };
}
