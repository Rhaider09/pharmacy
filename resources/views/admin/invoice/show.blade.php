<!DOCTYPE html>
<html>
<title>Global Surgical Mart - Invoice</title>
<!-- Favicon-->
<link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
<style>
  @media screen {
    .footer { display: none; } /* footer will show only printing */
    }
  @media print{
    .no-print{ visibility: hidden;}
  }
    html, body {
        height: 100%;
      }

      #wrap {
        min-height: 100%;
      }

      #main {
        overflow:auto;
        padding-bottom: 150px; /* this needs to be bigger than footer height*/
      }

      /*.footer {
        position: relative;
        margin-top: -20px; // negative value of footer height
        height: 50px;
        clear:both;
        width: 100%;
        padding-top: 60%; //resize footer for signature area
      }*/
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        //background-color: red;
        //color: white;
        //text-align: center;
        }
      .signature {
        //border: 0;
        //border-bottom: 1px solid #000;
        float: left;
        margin: 20px 10px;
        border-top: 1px solid #000;
        width: 200px;
        text-align: center;
      }
</style>
<body>
 <div class="container" id="wrap">
        <div class="row" id="main">
                <div class="col-12">

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                          <!-- title row -->
                          <div class="row">
                            <div class="col-12">
                              <h4>
                                <i class="fa fa-globe"></i> Haider Medical & General Store
                                {{-- <small class="float-right">Date: {{ date("d/m/Y", strtotime('+6 hours')) }}</small> --}}
                                <small class="float-right">Date: {{ date("d/m/Y") }}</small>
                              </h4>
                              {{-- <img src="{{ assets('assets/backend/images/Green Medicine Logo.jpg')}}"> --}}
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- info row -->
                          <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                              From
                              <address>
                                <strong>Admin, Inc.</strong><br>
                                St #147A H #20 Shai road <br>
                                baghbanpura lahore<br>
                                Phone: (+92) 3230436771 <br>
                                Email: haidermedical13@gmail.com
                              </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              To
                              <address>
                                <strong>{{ $invoice->customer->name }}</strong><br>
                                {{ $invoice->customer->organization }}<br>
                                {{ $invoice->customer->address }}<br>
                                Phone: {{ $invoice->customer->phone }}<br>
                              </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              {{--  <b>Invoice: {{ 'INV-' . $invoice->invoice_no }}</b><br>  --}}
                              <br>
                              <b>Invoice: {{ 'INV-' . $invoice->invoice_no }}</b><br><br>
                              {{--  <b>Order ID:</b> 4F3S8J<br>  --}}
                              <b>Invoice Date:</b> {{ Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}<br>
                              {{--  <b>Account:</b> 968-34567  --}}
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->

                          <!-- Table row -->
                          <div class="row">
                            <div class="col-12 table-responsive">
                              <table class="table table-striped">
                                <thead>
                                <tr>
                                  <th>Serial#</th>
                                  <th>Category</th>
                                  <th>Product</th>
                                  <th>Qty</th>
                                  <th>Unit Price</th>
                                  <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoiceDetails as $key=>$invoiceDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $invoiceDetail->product->category->name }}</td>
                                    <td>{{ $invoiceDetail->product->name }}</td>
                                    <td>{{ $invoiceDetail->quantity }}</td>
                                    <td>{{ number_format(round($invoiceDetail->selling_price, 2), 2) }}</td>
                                    <td>{{ number_format($invoiceDetail->quantity * round($invoiceDetail->selling_price, 2), 2) }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                              </table>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->

                          <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                              <p class="lead">Payment Method:</p>
                               {{-- <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/visa.png" alt="Visa"> --}}
                              {{-- <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/mastercard.png" alt="Mastercard"> --}}
                              {{-- <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/american-express.png" alt="American Express"> --}}
                              {{-- <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/paypal2.png" alt="Paypal"> --}}
                                <b>{{ $invoice->payment_type }}</b><br><br><br>

                                <b>{{ $invoice->description }}</b>

                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                              {{--  <p class="lead">Amount Due 2/22/2014</p>  --}}

                              <div class="table-responsive">
                                <table class="table">
                                  <tbody><tr>
                                    <th style="width:50%">Subtotal</th>
                                    <td>{{ number_format(round($invoice->amount, 2), 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Discount</th>
                                    <td>{{ number_format(round($invoice->discount, 2), 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Total</th>
                                    <td>{{ number_format(round($invoice->total_amount, 2), 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Paid</th>
                                    <td>{{ number_format(round($invoice->paid, 2), 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th>Due</th>
                                    <td>{{ number_format(round($invoice->due, 2), 2) }}</td>
                                  </tr>
                                </tbody></table>
                              </div>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                          <div>
                            {{-- <img src="{{ assets('assets/backend/images/Red and White Minimalist Christmas Circle Sticker.jpg')}}"> --}}
                          </div>

                          <!-- this row will not appear when printing -->
                          <div class="row no-print">
                            <div class="col-12">

                              <a href="" onclick="printme()" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
                              {{--  <button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.print()">
                                <i class="fa fa-download"></i> Generate PDF
                              </button>  --}}
                              {{--  <button type="button" class="btn btn-success float-right">
                                  <i class="fa fa-credit-card"></i>
                                  Submit Payment
                              </button>  --}}

                              {{--  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> Generate PDF
                              </button>  --}}

                            </div>
                          </div>

                        </div>
                        <!-- /.invoice -->
                      </div>
                    <footer class="footer">
                        <span class ="signature">Buyer Signature</span>
                        <span class ="signature float-right">Seller Signature</span>
                    </footer>
        </div>
    </div>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script>
    function printme(){
      event.preventDefault();
      window.print();
    }
 </script>
</body>
</html>
