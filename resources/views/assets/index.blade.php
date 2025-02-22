@extends('layout.app')
@section('content')
<div class="row">
       <div class="col-12">
              <div class="card">
                     <div class="card-header d-flex justify-content-between">
                            <h3>Restaurant Assets</h3>
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#new">Create New</button>
                     </div>
                     <div class="card-body">
                            <table class="table">
                                   <thead>
                                          <th>#</th>
                                          <th>Name</th>
                                          <th>Location</th>
                                          <th>Qty</th>
                                          <th>Action</th>
                                   </thead>
                                   <tbody>
                                          @foreach ($assets as $key => $asset)
                                                 <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$asset->name}}</td>
                                                        <td>{{$asset->location}}</td>
                                                        <td>{{$asset->qty}}</td>
                                                        <td>
                                                               <button type="button" class="btn btn-info " data-bs-toggle="modal" data-bs-target="#edit_{{$asset->id}}">Edit</button>
                                                        </td>
                                                 </tr>
                                                 <div id="edit_{{$asset->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myModalLabel">Edit Asset</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                                                </div>
                                                                <form action="{{ route('asset.update', $asset->id) }}" method="Post">
                                                                  @csrf
                                                                  @method("patch")
                                                                         <div class="modal-body">
                                                                                <div class="form-group">
                                                                                       <label for="name">Name</label>
                                                                                       <input type="text" name="name" required value="{{$asset->name}}" id="name" class="form-control">
                                                                                </div>
                                                                                <div class="form-group mt-2">
                                                                                       <label for="location">Location</label>
                                                                                       <input type="text" name="location" value="{{$asset->location}}" id="location" class="form-control">
                                                                                </div>
                                                                                <div class="form-group mt-2">
                                                                                       <label for="qty">Qty</label>
                                                                                       <input type="number" name="qty" value="{{$asset->qty}}" id="qty" class="form-control">
                                                                                </div>
                                                                         </div>
                                                                         <div class="modal-footer">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                                         </div>
                                                                  </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                          @endforeach
                                   </tbody>
                            </table>
                     </div>
              </div>
       </div>
</div>
<!-- Default Modals -->

<div id="new" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create New Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('asset.store') }}" method="post">
              @csrf
                     <div class="modal-body">
                            <div class="form-group">
                                   <label for="name">Name</label>
                                   <input type="text" name="name" required id="name" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                   <label for="location">Location</label>
                                   <input type="text" name="location" id="location" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                   <label for="qty">Qty</label>
                                   <input type="number" name="qty" required min="1" id="qty" class="form-control">
                            </div>
                     </div>
                     <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                     </div>
              </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

