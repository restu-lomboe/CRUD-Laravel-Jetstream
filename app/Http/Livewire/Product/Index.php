<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $paginate = 3;
    public $search;
    public $updateProduct = false;


    protected $queryString = ['search'];
    protected $listeners = ['StoreProduct', 'newUpdateProduct'];

    public function getProduct($id)
    {
        $this->updateProduct = true;
        $product = Product::find($id);
        $this->emit('updateProduct', $product);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        // session()->flash('message', 'Product berhasil di hapus');
    }

    public function render()
    {
        return view('livewire.product.index', [
            'products' => $this->paginate == null ?
            Product::where('nama_product', 'like', '%'.$this->search.'%')
                    ->orWhere('kode_product', 'like', '%'.$this->search.'%')
                    ->orderBy('created_at', 'desc')->paginate($this->paginate) :
            Product::where('nama_product', 'like', '%'.$this->search.'%')
                    ->orWhere('kode_product', 'like', '%'.$this->search.'%')
                    ->orderBy('created_at', 'desc')->paginate($this->paginate)
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
