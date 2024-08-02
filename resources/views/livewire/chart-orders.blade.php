<div
     wire:ignore
     class="mt-4 bg-black text-white p-4 rounded-lg"
     x-data="{
         selectedYear: $wire.entangle('selectedYear').live,
         lastYearOrders: $wire.entangle('lastYearOrders').live,
         thisYearOrders: $wire.entangle('thisYearOrders').live,
         init() {
             const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
             const data = {
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

             const config = {
                 type: 'bar',
                 data: data,
                 options: {
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
             const myChart = new Chart(
                 this.$refs.canvas,
                 config
             );

             Livewire.on('updateTheChart', () => {
                this.lastYearOrders = $wire.get('lastYearOrders');
                this.thisYearOrders = $wire.get('thisYearOrders');

                 myChart.data.datasets[0].label = `${this.selectedYear - 1} Orders`;
                 myChart.data.datasets[1].label = `${this.selectedYear} Orders`;
                 myChart.data.datasets[0].data = this.lastYearOrders;
                 myChart.data.datasets[1].data = this.thisYearOrders;
                 myChart.update();
             })
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

    <canvas id="myChart" x-ref="canvas"></canvas>
</div>
