@extends('layout.app')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                   @if(auth()->user()->role == "Cashier")
                   <div class="col">
                    <div class="py-4 px-3">
                        <h5 class="text-muted text-uppercase fs-13">My Balance</h5>
                        <div class="d-flex align-items-center">
                            {{-- <div class="flex-shrink-0">
                                <i class="ri-space-ship-line display-6 text-muted cfs-22"></i>
                            </div> --}}
                            <div class="flex-grow-1 ms-3">
                                <h2 class="mb-0 cfs-22"><span class="counter-value" data-target="{{getUserAccountBalance(auth()->user()->id)}}">0</span></h2>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->
                   @endif
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
@endsection
@section('page-css')

@endsection
@section('page-js')

@endsection

