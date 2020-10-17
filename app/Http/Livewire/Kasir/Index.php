<?php

namespace App\Http\Livewire\Kasir;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderProduct;


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

    public function save()
    {
        // dd($this->pembayaran);
        $transaction = Transaction::get();

        $order = Order::create([
            'no_order' => 'OD-'.date('Ymd').rand(1111,9999),
            'nama_kasir' => auth()->user()->name,
            'grand_total' => $transaction->sum('total'),
            'pembayaran' => $this->pembayaran,
            'kembalian' => $this->pembayaran-$transaction->sum('total')
        ]);


        foreach ($transaction as $key => $value) {
            $product = array(
                'order_id' => $order->id,
                'product_id' => $value->product_id,
                'qty' => $value->qty,
                'total' => $value->total,
                'created_at' => \Carbon\carbon::now(),
                'updated_at' => \Carbon\carbon::now()
            );

            $orderProduct = OrderProduct::insert($product);

            $deleteTransaction = Transaction::where('id', $value->id)->delete();
        }

        // session()->flash('message', 'Transaction berhasil disimpan');
        return redirect()->to('/invoice/'.$order->no_order);
    }

    public function render()
    {
        return view('livewire.kasir.index', [
            'products' => Product::orderBY('nama_product', 'asc')->get(),
            'transactions' => Transaction::get()
        ]);
    }
}
