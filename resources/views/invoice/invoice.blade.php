@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- invoice functionality start -->
    <section class="invoice-print mb-1">
        <div class="row">
            <div class="col-12 col-md-12 d-flex flex-column flex-md-row justify-content-end">
                <button class="btn btn-primary btn-print mb-1 mb-md-0"> <i class="feather icon-file-text"></i> Print</button>
            </div>
        </div>
    </section>
    <!-- invoice functionality end -->
    <!-- invoice page -->
    <section class="card invoice-page">
        <div id="invoice-template" class="card-body">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-sm-6 col-12 text-left pt-1">
                    <div class="media pt-1">
                        <img src="{{asset('storage/logo.png')}}" alt="company logo" class="w-32 h-32" />
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h1 class="font-bold text-3xl">Receipt</h1>
                    <div class="invoice-details mt-2">
                        <h6 class="font-bold">RECEIPT NO.</h6>
                        <p>{{ $invoice->invoice_no }}</p>
                        <h6 class="mt-2 font-bold">RECEIPT DATE</h6>
                        <p>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}</p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Recipient Details -->
            <div id="invoice-customer-details" class="row pt-2">
                <div class="col-sm-6 col-12 text-left">
                    <h5>Recipient</h5>
                    <div class="recipient-info my-2">
                        <p>{{ $invoice->user->name }}</p>
                        <p>{{ $invoice->user->shippingInfo->address }}</p>
                        <p>{{ $invoice->user->shippingInfo->city.", ".$invoice->user->shippingInfo->state }}</p>
                        <p>{{ $invoice->user->shippingInfo->zip_code }}</p>
                    </div>
                    <div class="recipient-contact pb-2">
                        <p>
                            <i class="feather icon-mail"></i>
                            {{ $invoice->user->email }}
                        </p>
                        <p>
                            <i class="feather icon-phone"></i>
                            {{ $invoice->user->phone_no }}
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-12 text-right">
                    <h5 class="font-semibold text-xl">Better Globe Forestry LTD.</h5>
                    <div class="company-info my-2">
                        <p>Total Petrol Station Building, 2nd Floor,</p>
                        <p> Kileleshwa</p>
                        <p>Nairobi, Kenya</p>
                        <p>823-00606</p>
                    </div>
                    <div class="company-contact">
                        <h5 class="font-semibold">Contact Person</h5>
                        <p>
                            <i class="feather icon-mail"></i>
                            lawrence@betterglobeforestry.com
                        </p>
                        <p>
                            <i class="feather icon-phone"></i>
                            +254724374483
                        </p>
                    </div>
                </div>
            </div>
            <!--/ Invoice Recipient Details -->

            <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-1 invoice-items-table">
                <div class="row">
                    <div class="table-responsive col-12">
                        <table class="table table-borderless">
                            <thead>
                                @if($invoice->transaction == "Subscription")
                                    <tr>
                                        <th>ITEM DESCRIPTION</th>
                                        <th>QUANTITY TO RECEIVE PER ISSUE</th>
                                        <th>AMOUNT</th>
                                    </tr>
                                @endif
                                @if($invoice->transaction == "Cart Order")
                                    <tr>
                                        <th>ITEM DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>UNIT PRICE</th>
                                        <th>SUB-TOTAL</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @if($invoice->transaction == "Subscription")
                                    <tr>
                                        <td>{{ "From issue: ".$invoice->items->first()->issue." to issue: ".$invoice->items->last()->issue }}</td>
                                        <td>{{ $invoice->items->first()->quantity }}</td>
                                        <td>{{ $invoice->getTotalAmount() }}</td>
                                    </tr>
                                @endif
                                @if($invoice->transaction == "Cart Order")
                                    @foreach($invoice->items as $item)
                                        <tr>
                                            <td>{{ $item->issue }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $invoice->currency." ".$item->amount }}</td>
                                            <td>{{ (int)$item->quantity * (int)$item->amount }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="invoice-total-details" class="invoice-total-table">
                <div class="row">
                    <div class="col-7 offset-5">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td>{{ $invoice->currency." ".((int)$invoice->getTotalAmount() - (int)$invoice->discount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>DISCOUNT</th>
                                        <td>{{ $invoice->currency." ".$invoice->discount }}</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td>{{ $invoice->currency." ".$invoice->getTotalAmount() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Footer -->
            <div id="invoice-footer" class="text-right pt-3">
                <p><span class="font-bold">Tel:</span> +254(02)3594200 <span class="font-bold ml-2">Email:</span> accounts@betterglobeforestry.com
                    <span class="font-bold ml-2">Website: </span>www.betterglobeforestry.com
                </p>
                <p class="bank-details mb-0 mr-4">
                    <span class="mr-4">KRA PIN: <strong>P051167447E</strong></span>
                </p>
            </div>
            <!--/ Invoice Footer -->

        </div>
    </section>
    <!-- invoice page end -->

</div>
@endsection