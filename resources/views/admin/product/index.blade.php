@extends('layouts.backend.app')

@section('title', 'Product')

@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <style>
        img:hover {
            transform: scale(2);
            }
    </style>
@endpush

@section('content')
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pull-right" style="margin-bottom: 20px;">
    <button class="btn bg-teal btn-lg btn-block waves-effect" type="button" style="height: 50px; font-size: 14px; cursor: default; pointer-events: none;">Total Amount
        <span class="badge" style="font-size: 18px;">{{ number_format($total_amount->total_amount, 2) }}</span>
    </button>
</div>
<div class="container-fluid">
    <div class="block-header">
        <a class="btn btn-success waves-effect" href="{{ route('admin.product.create') }}">
            <i class="material-icons">add</i>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ALL PRODUCTS
                        <span class="badge bg-red">{{ $products->count() }}</span>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($products as $key=>$product)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->supplier->organization }}</td>
                                        <td><span class="badge {{ $product->quantity <= $product->low_quantity_alert ? 'bg-pink' : 'bg-green' }}">{{ $product->quantity }}</span></td>
                                        <td>{{ number_format(round($product->price, 2), 2) }}</td>
                                        <td>{{ number_format(round($product->price, 2) * $product->quantity, 2) }}</td>
                                        <td class="align-center">
                                            <img src="{{ asset($product->image) }}" alt="images" height="37" width="44" />
                                            {{-- <img src="{{ asset($product->image) }}"
                                                alt="{{ $product->name }}" height="37" width="44"> --}}
                                        </td>
                                        <td class="text-center" style="white-space:nowrap;">
                                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-info waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect" type="button"
                                                onclick="deleteProduct({{ $product->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $product->id }}" method="POST"
                                                action="{{ route('admin.product.destroy', $product->id) }}"
                                                style="display: none;">
                                                    @csrf
                                                    @method('DELETE')

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
        function deleteProduct(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
              })

              swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {

                  event.preventDefault();
                  document.getElementById('delete-form-' + id).submit();

                  swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                  )
                } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                  )
                }
              })
        }
    </script>
@endpush
