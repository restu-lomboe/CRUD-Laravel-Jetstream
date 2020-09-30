<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Update extends Component
{

    public $productId;
    public $nama_product;
    public $kode_product;
    public $harga_product;

    protected $listeners = ['updateProduct'];

    protected $rules = [
        'nama_product' => 'required|min:6',
        'kode_product' => 'required',
        'harga_product' => 'required'
    ];

    public function updateProduct($product)
    {
        $this->productId = $product['id'];
        $this->nama_product = $product['nama_product'];
        $this->kode_product = $product['kode_product'];
        $this->harga_product = $product['harga_product'];
    }

    public function update()
    {
        $this->validate();

        if ($this->productId) {
            $product = Product::where('id', $this->productId)->first();
            $product->update([
                'nama_product' => $this->nama_product,
                'kode_product' => $this->kode_product,
                'harga_product' => $this->harga_product
            ]);
        }

        $this->emit('newUpdateProduct', $product);

        $this->deleteInput();
    }

    public function deleteInput()
    {
        $this->nama_product = null;
        $this->kode_product = null;
        $this->harga_product = null;
    }

    public function render()
    {
        return view('livewire.product.update');
    }
}
