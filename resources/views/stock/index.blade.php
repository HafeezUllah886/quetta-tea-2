@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Raw Material Stock </h3>
                </div>
                <div class="card-body">
                    <table class="table" id="buttons-datatables">
                        <thead>
                            <th>#</th>
                            <th>Material</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($materials as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format(getStock($product->id) / $product->unit->value, 2) }} {{$product->unit->name}}</td>
                                    <td>
                                        <button class="btn btn-info" onclick="ViewDetails({{ $product->id }}, {{$product->unitID}})">
                                                Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="viewDetailsModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">View Stock Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="get" target="" id="form">
                  @csrf
                  <input type="hidden" name="materialID" id="materialID">
                         <div class="modal-body">
                           <div class="form-group">
                            <label for="">Select Dates</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroup-sizing-default">From</span>
                                <input type="date" id="from" name="from" value="{{ firstDayOfMonth() }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                <span class="input-group-text" id="inputGroup-sizing-default">To</span>
                                <input type="date" id="to" name="to" value="{{ lastDayOfMonth() }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>
                           </div>
                           <div class="form-group mt-2">
                            <label for="unit">Unit</label>
                            <select name="unit" class="form-control" id="unit">
                                @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                           </div>
                         </div>
                         <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="viewBtn" class="btn btn-primary">View</button>
                         </div>
                  </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script>
        function ViewDetails(material, unit)
        {
            $("#materialID").val(material);
            $('#unit').val(unit);
            $("#viewDetailsModal").modal('show');
        }

        $("#viewBtn").on("click", function (){
            var materialID = $("#materialID").val();
            var unit = $("#unit").find(":selected").val();
            var from = $("#from").val();
            var to = $("#to").val();
            var url = "{{ route('stockDetails', ['id' => ':materialID', 'unit' => ':unit', 'from' => ':from', 'to' => ':to']) }}"
        .replace(':materialID', materialID)
        .replace(':unit', unit)
        .replace(':from', from)
        .replace(':to', to);
            window.open(url, "_blank", "width=1000,height=800");
        });
    </script>
@endsection
