<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use App\Models\Product;
use App\Models\OrderProduct;

class Index extends Component
{

    public $productId = [];

    public $firstRun = true;

    protected $listeners = [
        'onPointClick' => 'handleOnPointClick',
        'onSliceClick' => 'handleOnSliceClick',
        'onColumnClick' => 'handleOnColumnClick',
    ];

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnSliceClick($slice)
    {
        dd($slice);
    }

    public function render()
    {
        // dd($this->colors());
        $product = Product::get();
        foreach ($product as $key => $value) {
            $product_id[] = $value->id;
            if ($this->productId) {
                $order = OrderProduct::whereIn('product_id', $this->productId)->get();
            } else {
                $order = OrderProduct::whereIn('product_id', $product_id)->get();
            }
        }

        $columnChartModel = $order->groupBy('product_id')
            ->reduce(function (ColumnChartModel $columnChartModel, $data) {
                $product_name = $data->first()->namaProduct->nama_product;
                $value = $data->sum('total');
                $warna[$data->first()->namaProduct->nama_product] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $columnChartModel->addColumn($product_name, $value, $warna[$product_name]);
            }, (new ColumnChartModel())
                ->setTitle('Order Product')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
            );

        $pieChartModel = $order->groupBy('product_id')
            ->reduce(function (PieChartModel $pieChartModel, $data) {
                $product_name = $data->first()->namaProduct->nama_product;
                $value = $data->sum('total');
                $warna[$data->first()->namaProduct->nama_product] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $pieChartModel->addSlice($product_name, $value, $warna[$product_name]);
            }, (new PieChartModel())
                ->setTitle('Order Product')
                ->setAnimated($this->firstRun)
                ->withOnSliceClickEvent('onSliceClick')
            );

        return view('livewire.chart.index')
                ->with([
                    'columnChartModel' => $columnChartModel,
                    'pieChartModel' => $pieChartModel,
                    'products'  => $product
                ]);
    }
}
