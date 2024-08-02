<div
    wire:ignore
    class="mt-4 bg-black text-white p-4 rounded-lg"
    x-data="{
        selectedYear: $wire.get('selectedYear'),
        lastYearOrders: $wire.get('lastYearOrders'),
        thisYearOrders: $wire.get('thisYearOrders'),
        init() {
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const barData = {
                labels: labels,
                datasets: [{
                    label: `${this.selectedYear - 1} Orders`,
                    backgroundColor: '#FFE66D', // Color for the previous year
                    data: this.lastYearOrders,
                }, {
                    label: `${this.selectedYear} Orders`,
                    backgroundColor: '#E952DE', // Color for the current year
                    data: this.thisYearOrders,
                }]
            };

            const pieData = {
                labels: ['Previous Year', 'Current Year'],
                datasets: [{
                    label: 'Order Counts',
                    backgroundColor: ['#FFE66D', '#E952DE'],
                    data: [this.lastYearOrders.reduce((a, b) => a + b, 0), this.thisYearOrders.reduce((a, b) => a + b, 0)],
                }]
            };

            const barConfig = {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: {
                                color: 'white', // X-axis labels color
                            },
                        },
                        y: {
                            ticks: {
                                color: 'white', // Y-axis labels color
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' // Legend labels color
                            }
                        }
                    }
                }
            };

            const pieConfig = {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' // Legend labels color
                            }
                        }
                    }
                }
            };

            const barChart = new Chart(this.$refs.barCanvas, barConfig);
            const pieChart = new Chart(this.$refs.pieCanvas, pieConfig);

            Livewire.on('updateTheChart', () => {
                this.lastYearOrders = $wire.get('lastYearOrders');
                this.thisYearOrders = $wire.get('thisYearOrders');
                this.selectedYear = $wire.get('selectedYear')

                barChart.data.datasets[0].label = `${this.selectedYear - 1} Orders`;
                barChart.data.datasets[1].label = `${this.selectedYear} Orders`;
                barChart.data.datasets[0].data = this.lastYearOrders;
                barChart.data.datasets[1].data = this.thisYearOrders;
                barChart.update();

                pieChart.data.datasets[0].data = [this.lastYearOrders.reduce((a, b) => a + b, 0), this.thisYearOrders.reduce((a, b) => a + b, 0)];
                pieChart.update();
            });
        }
    }">
    <span class="block mb-2">Year:
        <select name="selectedYear" id="selectedYear" class="border bg-black text-white p-2 rounded mb-4" wire:model.live="selectedYear">
            @foreach ($availableYears as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </span>
    
    <div class="my-6">
        <div class="mb-2">
            <span x-text="selectedYear"></span> Orders:
            <span x-text="thisYearOrders.reduce((a, b) => a + b, 0)"></span>
        </div>
        <div>
            <span x-text="selectedYear - 1"></span> Orders:
            <span x-text="lastYearOrders.reduce((a, b) => a + b, 0)"></span>
        </div>
    </div>

    <div class="flex justify-center space-x-4">
        <div class="flex justify-center items-center" style="height: 400px; width: 500px;">
            <canvas id="barChart" x-ref="barCanvas"></canvas>
        </div>
        <div class="flex justify-center items-center" style="height: 400px; width: 500px;">
            <canvas id="pieChart" x-ref="pieCanvas"></canvas>
        </div>
    </div>
</div>
