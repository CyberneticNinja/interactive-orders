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

    public function updateOrdersCount()
    {
        $this->thisYearOrders = Order::select(DB::raw("strftime('%m', order_date) as month, COUNT(*) as count"))
        ->whereYear('order_date', $this->selectedYear)
        ->groupBy(DB::raw("strftime('%m', order_date)"))
        ->orderBy('month')
        ->pluck('count');

        $this->lastYearOrders = Order::select(DB::raw("strftime('%m', order_date) as month, COUNT(*) as count"))
        ->whereYear('order_date', $this->selectedYear - 1)
        ->groupBy(DB::raw("strftime('%m', order_date)"))
        ->orderBy('month')
        ->pluck('count');

        $this->dispatch('updateTheChart'); 
    }

    public function render()
    {
        $years = range(date('Y'), 2020);

        return view('livewire.chart-orders',compact('years'));
    }
}
