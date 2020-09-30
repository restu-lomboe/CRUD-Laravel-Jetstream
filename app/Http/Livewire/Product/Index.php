<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Index extends Component
{

    protected $listeners = ['StoreProduct', 'newUpdateProduct'];
    public $updateProduct = false;

    public function getProduct($id)
    {
        $this->updateProduct = true;
        $product = Product::find($id);
        $this->emit('updateProduct', $product);
    }

    public function render()
    {
        return view('livewire.product.index', [
            'products' => Product::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function StoreProduct($product)
    {
        session()->flash('message', 'Product '. $product['nama_product'] .' berhasil di tambahkan');
    }

    public function newUpdateProduct($product)
    {
        session()->flash('message', 'Product '. $product['nama_product'] .' berhasil di update');
        $this->updateProduct = false;
    }
}
