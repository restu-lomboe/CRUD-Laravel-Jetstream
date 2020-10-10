<?php

namespace App\Http\Livewire\Admin\Transaksi;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;

class Index extends Component
{

    public $count = 0;
    public $product;
    public $qty;

    public $bayar;

    public function submit()
    {
       $product = Transaction::create([
            'product_id' => $this->product,
            'qty' => 1,
        ]);

        $product->total = $product->product->harga_product;
        $product->save();

        session()->flash('message', 'Product berhasil di tambahkan');
    }

    public function increment($id)
    {
        // dd($id);
        $transaction = Transaction::with('product')->find($id);
        $transaction->update([
            'qty' => $transaction->qty + 1,
            'total' => $transaction->product->harga_product*($transaction->qty + 1)
        ]);

        session()->flash('message', 'Qty product berhasil di tambahkan');

        return redirect()->to('/transaksi');

    }

    public function decrement($id)
    {
        $transaction = Transaction::find($id);
        $transaction->update([
            'qty' => $transaction->qty - 1,
            'total' => $transaction->product->harga_product*($transaction->qty - 1)
        ]);

        session()->flash('message', 'Qty product berhasil di kurang');

        return redirect()->to('/transaksi');
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        session()->flash('message', 'product berhasil di hapus');

        return redirect()->to('/transaksi');
    }

    public function render()
    {
        return view('livewire.admin.transaksi.index', [
            'products' => Product::orderBy('created_at', 'desc')->get(),
            'transactions' => Transaction::orderBy('created_at', 'desc')->get()
        ]);
    }
}
