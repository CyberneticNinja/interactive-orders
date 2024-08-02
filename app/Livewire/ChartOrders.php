<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ChartOrders extends Component
{
    public $selectedYear;
    public $thisYearOrders;
    public $lastYearOrders;

    public function mount()
    {
        $this->selectedYear = date('Y');
        $this->updateOrdersCount();
    }

    public function updatedSelectedYear()
    {
        $this->updateOrdersCount();
    }

    public function updateOrdersCount()
    {
        // Initialize an array with all months set to 0
        $months = array_fill(1, 12, 0);

        $thisYearOrdersQuery = Order::select(DB::raw("strftime('%m', order_date) as month, COUNT(*) as count"))
            ->whereYear('order_date', $this->selectedYear)
            ->groupBy(DB::raw("strftime('%m', order_date)"))
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        foreach ($thisYearOrdersQuery as $month => $count) {
            $months[intval($month)] = $count;
        }
        $this->thisYearOrders = array_values($months);

        // Reset for last year orders
        $months = array_fill(1, 12, 0);
        $lastYearOrdersQuery = Order::select(DB::raw("strftime('%m', order_date) as month, COUNT(*) as count"))
            ->whereYear('order_date', (string)($this->selectedYear - 1))
            ->groupBy(DB::raw("strftime('%m', order_date)"))
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        foreach ($lastYearOrdersQuery as $month => $count) {
            $months[intval($month)] = $count;
        }
        $this->lastYearOrders = array_values($months);

        $this->dispatch('updateTheChart');
    }

    public function render()
    {
        //generate array of years
        $years = range(date('Y'), 2020);

        return view('livewire.chart-orders', [
            'availableYears' => $years,
        ]);
    }
}
