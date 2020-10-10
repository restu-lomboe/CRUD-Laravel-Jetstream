<div>
    <div class="container">
        {{-- Form Create --}}
        <div class="card-body pb-5">

            @if ($updateProduct)
                <h1 class="h3 pb-3 mb-3 border-bottom">Form Update Product</h1>
                @if (session()->has('message'))
                    <script>
                        Swal.fire(
                            'Berhasil',
                            '{!! session('message') !!}',
                            'success'
                        )
                    </script>
                @endif
                @livewire('product.update')
            @else
                <h1 class="h3 pb-3 mb-3 border-bottom">Form Create Product</h1>
                @if (session()->has('message'))
                    <script>
                        Swal.fire(
                            'Berhasil',
                            '{!! session('message') !!}',
                            'success'
                        )
                    </script>
                @endif
                @livewire('product.create')
            @endif

        </div>


        {{-- Show data --}}
        <div class="card-body border-top pb-5">
            <nav class="navbar navbar-light bg-light">
                <div class="container-fluid p-0">
                    <div class="navbar-brand">
                        <select class="form-select" wire:model="paginate" aria-label="Default select example">
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <input class="form-control mr-2" wire:model="search" type="search" placeholder="Search" aria-label="Search">
                    </div>
                </div>
            </nav>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row"> {{ $loop->iteration }} </th>
                            <td> {{ $product->nama_product }} </td>
                            <td> {{ $product->kode_product }} </td>
                            <td>Rp. {{ number_format($product->harga_product) }} </td>
                            <td>
                                <button wire:click="getProduct({{$product->id}})" class="btn btn-warning btn-sm">EDIT</button>
                                <button wire:click="$emit('deleteProduct',{{$product->id}})" class="btn btn-danger btn-sm">HAPUS</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        @this.on('deleteProduct', idProduct => {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                    // calling destroy method to delete
                    @this.call('deleteProduct',idProduct)

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'File Tidak Jadi Dihapus :)',
                        'error'
                    )
                }
            });
        })
    })
</script>
@endpush
