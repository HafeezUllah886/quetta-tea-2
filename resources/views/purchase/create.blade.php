@extends('layout.popups')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><h3> Create Purchase </h3></div>
                                <div class="col-6 d-flex flex-row-reverse"><button onclick="window.close()" class="btn btn-danger">Close</button></div>
                            </div>

                        </div>
                    </div>
                </div><!--end row-->
                <div class="card-body">
                    <form action="{{ route('purchase.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="raw">Raw Materials</label>
                                    <select name="raw" class="selectize" id="raw">
                                        <option value="0"></option>
                                        @foreach ($raw_materials as $raw)
                                            <option value="{{ $raw->id }}">{{ $raw->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th width="30%">Item</th>
                                        <th class="text-center">Qty</th>
                                        <th width="10%" class="text-center">Unit</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Amount</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="products_list"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end">Total</th>
                                            <th class="text-end" id="totalAmount">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <select name="vendorID" id="vendor" class="selectize1">
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="account">Account</label>
                                    <select name="accountID" id="account" class="selectize1">
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 mt-2">
                                <div class="form-group">
                                    <label for="status">Payment Status</label>
                                    <select name="status" id="status" class="selectize1">
                                        <option value="paid">Paid</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Create Purchase</button>
                            </div>

                </div>
            </form>
            </div>

        </div>
        <!--end card-->
    </div>
    <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
    <style>
        .no-padding {
            padding: 5px 5px !important;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>
        $(".selectize1").selectize();
        $(".selectize").selectize({
            onChange: function(value) {
                if (!value.length) return;
                if (value != 0) {
                    getSingleProduct(value);
                    this.clear();
                    this.focus();
                }

            },
        });
        var units = @json($units);
        var existingProducts = [];

        function getSingleProduct(id) {
            $.ajax({
                url: "{{ url('get/raw_material/') }}/" + id,
                method: "GET",
                success: function(product) {
                    let found = $.grep(existingProducts, function(element) {
                        return element === product.id;
                    });
                    if (found.length > 0) {

                    } else {

                        var id = product.id;
                        var html = '<tr id="row_' + id + '">';
                        html += '<td class="no-padding">' + product.name + '</td>';
                        html += '<td class="no-padding"><input type="number" name="qty[]" oninput="updateChanges(' + id + ')" min="0" required step="any" value="0" class="form-control text-center no-padding" id="qty_' + id + '"></td>';
                        html += '<td class="no-padding"><select name="unit[]" class="form-control text-center no-padding" onchange="updateChanges(' + id +')" id="unit_' + id + '">';
                            units.forEach(function(unit) {
                                var isSelected = (unit.id == product.unitID);
                                html += '<option data-unit="'+unit.value+'" value="' + unit.id + '" ' + (isSelected ? 'selected' : '') + '>' + unit.name + '</option>';
                            });
                        html += '</select></td>';
                        html += '<td class="no-padding"><input type="number" name="price[]" required step="any" value="'+product.price+'" min="0" oninput="updateChanges(' + id + ')" class="form-control text-center no-padding" id="price_' + id + '"></td>';
                        html += '<td class="no-padding"><input type="number" name="amount[]" min="0.1" readonly required step="any" value="1" class="form-control text-center no-padding" id="amount_' + id + '"></td>';
                        html += '<td class="no-padding"> <span class="btn btn-sm btn-danger" onclick="deleteRow('+id+')">X</span> </td>';
                        html += '<input type="hidden" name="id[]" value="' + id + '">';
                        html += '</tr>';
                        $("#products_list").prepend(html);
                        existingProducts.push(id);
                        updateChanges(id);
                    }
                }
            });
        }

        function updateChanges(id) {
            var qty = parseFloat($('#qty_' + id).val());
            var price = parseFloat($('#price_' + id).val());

            var amount = qty * price;
            $("#amount_"+id).val(amount.toFixed(2));
            updateTotal();
        }

        function updateTotal() {
            var total = 0;
            $("input[id^='amount_']").each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $(this).val();
                total += parseFloat(inputValue);
            });

            $("#totalAmount").html(total.toFixed(2));

        }

        function deleteRow(id) {
            existingProducts = $.grep(existingProducts, function(value) {
                return value !== id;
            });
            $('#row_'+id).remove();
            updateTotal();
        }


    </script>
@endsection
