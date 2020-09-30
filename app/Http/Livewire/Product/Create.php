<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Create extends Component
{

    public $nama_product;
    public $kode_product;
    public $harga_product;

    protected $rules = [
        'nama_product' => 'required|min:6',
        'kode_product' => 'required',
        'harga_product' => 'required'
    ];

    public function submit()
    {
        $this->validate();

        $product = Product::create([
            'nama_product' => $this->nama_product,
            'kode_product' => $this->kode_product,
            'harga_product' => $this->harga_product
        ]);

        $this->emit('StoreProduct', $product);

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
        return view('livewire.product.create');
    }
}
