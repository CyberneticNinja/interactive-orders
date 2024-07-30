<div>
    <select wire:model.live="selectedYear" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>

    <div class="mt-4">
        <p>Selected Year: {{ $selectedYear }}</p>
    </div>

    <canvas id="myChart" x-ref="canvas"></canvas>
</div>
