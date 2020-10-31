<div class="container mx-auto space-y-4 p-4 sm:p-0">
    <ul class="flex flex-col sm:flex-row sm:space-x-8 sm:items-center">
        @foreach ($products as $product)
            <li>
                <input type="checkbox" value="{{ $product->id }}" wire:model="productId"/>
                <span> {{ $product->nama_product }} </span>
            </li>
        @endforeach
    </ul>
    <div class="card-body">
        <div class="row">

            <div class="col" style="height: 300px !important;">
                <livewire:livewire-column-chart
                    key="{{ $columnChartModel->reactiveKey() }}"
                    :column-chart-model="$columnChartModel"
                />
            </div>
            <div class="col" style="height: 300px !important;">
                <livewire:livewire-pie-chart
                    key="{{ $pieChartModel->reactiveKey() }}"
                    :pie-chart-model="$pieChartModel"
                />
            </div>
            {{-- <div class="col" style="height: 300px !important;">
                <livewire:livewire-column-chart
                    :column-chart-model="$columnChartModel"
                />
            </div>
            <div class="col" style="height: 300px !important;">
                <livewire:livewire-pie-chart
                    :pie-chart-model="$pieChartModel"
                />
            </div> --}}
        </div>
    </div>
</div>
