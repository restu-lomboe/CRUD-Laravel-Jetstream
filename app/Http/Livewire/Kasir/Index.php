<?php

namespace App\Http\Livewire\Kasir;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;


class Index extends Component
{
    public $product_id;
    public $pembayaran;

    protected $rules = [
        'product_id' => 'required|unique:transactions'
    ];

    public function submit()
    {
        $this->validate();

        $transaction = Transaction::create([
            'product_id' => $this->product_id,
            'qty' => 1
        ]);
        $transaction->total = $transaction->product->harga_product;
        $transaction->save();

        session()->flash('message', 'product berhasil di tambah');
    }

    public function increment($id)
    {
        // dd($id);
        $transaction = Transaction::find($id);
        $transaction->update([
            'qty' => $transaction->qty + 1,
            'total' => $transaction->product->harga_product*($transaction->qty + 1)
        ]);

        session()->flash('message', 'qty product berhasil di tambah');

        // return redirect()->to('/kasir');
    }

    public function decrement($id)
    {
        // dd($id);
        $transaction = Transaction::find($id);
        $transaction->update([
            'qty' => $transaction->qty - 1,
            'total' => $transaction->product->harga_product*($transaction->qty - 1)
        ]);

        session()->flash('message', 'qty product berhasil di kurang');

        // return redirect()->to('/kasir');
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        session()->flash('message', 'Transaction berhasil di hapus');
    }

    public function render()
    {
        return view('livewire.kasir.index', [
            'products' => Product::orderBY('nama_product', 'asc')->get(),
            'transactions' => Transaction::get()
        ]);
    }
}
