@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Location Setup</h2>     
        <div class="pad margin no-print">
            <div class="callout callout-warning">
              <div class="row">
                <div class="col-md-6">
                <h4><i class="fa fa-warning"></i> Note: </h4>              
                Feel free to interact with the objects below.<br>
                Click continue if you wish to proceed to the next step.
                </div>                
                <br />
                <div class="col-md-6 text-right">
                  <a href="{{ url('pwiz?page=3') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=5') }}">Continue</a>
                </div>                
              </div>
            </div>
          </div>         
    </section>

    <!-- ADD MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="add_record">
      <div class="modal-dialog modal-md">        
        <div class="modal-content">
        <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Add Location</h4>
        </div>
      <p>
                <!--display message -->             
                @if(Session::has('loc_err'))
                      {{ Session::get('loc_err') }}
                @endif 
                </p>  
        <div class="modal-body" style="background-color:#fff;">
        <form action="{{ url('pwiz/location'.'/'.$comp) }}" method="POST" id="form_location" value="">          
          {!! csrf_field() !!}
          <div class="form-group">
            <label for="location_code">Code<i class="fa fa-asterisk text-red"></i></label>
            <input class="form-control" type="text" name="location_code" id="location_code" value="{{old('location_code')}}"/>
          </div>
          <div class="form-group">
            <label for="location_name">Name</label>
            <input class="form-control" type="text" name="location_name" id="location_name" value="{{old('location_name')}}"/>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control" type="text" name="address" id="address" value="{{old('address')}}"/>
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input class="form-control" type="text" name="city" id="city" class="form-control" value="{{old('city')}}"/>
          </div>          
          <br />
        </form>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="save_loc">Save</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- END of ADD MODAL -->

    <!-- EDIT MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="edit_record">
      <div class="modal-dialog modal-md">        
        <div class="modal-content">
        <div class="modal-header btn-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Edit Location</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
        
        <form action="{{ url('pwiz/location') }}" method="POST" id="form_edit_location"> 
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="PUT" />
          <input type="hidden" name="edit_flag" value="0" />
          <input type="hidden" name="loc" value="" />
          <div class="form-group">
            <label for="edit_loc_code">Code</label>
            <input class="form-control" type="text" name="edit_loc_code" id="edit_loc_code"/>
          </div>
          <div class="form-group">
            <label for="edit_loc_name">Name</label>
            <input class="form-control" type="text" name="edit_loc_name" id="edit_loc_name"/>
          </div>
          <div class="form-group">
            <label for="edit_loc_address">Address</label>
            <input type="text" name="edit_loc_address" id="edit_loc_address" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="edit_loc_city">City</label>
            <input type="text" name="edit_loc_city" id="edit_loc_city" class="form-control"/>
          </div>          
          <br />
        </form>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="edit_submit_loc">Save</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- END of EDIT MODAL -->


    <!-- DELETE MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="delete_record">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
      
      
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Are you sure that you want to delete the following locations?</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
        <form action=" {{ url('pwiz/location') }} " id="form_loc_del" method="POST">
          <input type="hidden" name="_method" value="PUT" />
          {!! csrf_field() !!}          
          <div id="del_inputs" name="del_inputs">  
          </div>
          <div id="del_labels" name="del_labels">
              <!-- 
                <div class="form-group">
                  <label>Location 1</label>           
                </div>
              -->                
          </div>        
        </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="delete_loc">Delete</button>
      </div>
      
      
        </div>
      </div>
    </div>
    <!-- END of DELETE MODAL -->

    <!-- Main content -->
    <section class="content">
    <!-- Your Page Content Here -->
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-building"></i>
                  <h3 class="box-title">List of locations</h3>
                </div>
                <div class="box-body">
                  <div id="upper panel">
                      <div id="edit_panel" class="btn-group">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_record">
              <i class="fa fa-plus"></i> Add
            </button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_record" id="btn_delete_rec"><i class="fa fa-minus"></i> Delete</button>                        
                      </div>
                      <div id="search_panel"></div>
                  </div>
                  <div>
                    <br/>
                      <table class="table table-condensed table-striped">
                        <thead>
                          <th></th>
                          <th>Code</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Edit</th>
                        </thead>
                        <tbody>
                        @if(count($location) > 0 )
                          @foreach($location as $loc)
                          <tr>
                            <td><input type="checkbox" class="location" name="location[]" value="{{ $loc['id'] }}" data-name="{{ $loc['code'] }}" /></td>
                            <td>{{ $loc['code'] }}</td>
                            <td>{{ $loc['name'] or null }}</td>
                            <td>{{ $loc['address'] or null }}</td>
                            <td>{{ $loc['city'] or null }}</td>
                            <td><button class="btn btn-location-edit" data-toggle="modal" data-target="#edit_record" data-lid="{{ $loc['id'] }}" data-lcode="{{ $loc['code'] }}" data-lname="{{ $loc['name'] or null }}" data-laddress="{{ $loc['address'] or null }}" data-city="{{ $loc['city'] or null }}">Edit</button></td>
                          </tr>
                          @endforeach
                        @else
                        <tr>
                          <td></td>
                          <td></td>
                          <td>No Records found!</td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        @endif
                        </tbody>      
                      </table>
                  </div>
                </div>
          </div>
        </div>
      </div>


    </section>
    <!-- /.content -->
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){

    var del_inputs = $("#del_inputs");
    var del_labels = $("#del_labels");

    $('#save_loc').click(function(){    
      
      $('#form_location').submit();

    });

    $("#btn_delete_rec").click(function(){
        del_inputs.empty();
        del_labels.empty();

        $(".location:checked").each(function(){

          del_inputs.append('<input type="hidden" name="location[]" value="'+ $(this).val() +'" />');
          del_labels.append('<div class="form-group"><label>'+ $(this).attr('data-name') +'</label></div>');

        });
    });

    $("#delete_loc").click(function(){
        $("#form_loc_del").submit();
    });

    $("#edit_submit_loc").click(function(){
        $('#form_edit_location').submit();
    });

    $(".btn-location-edit").click(function(){
        $("input[name|=loc]").val( $(this).attr('data-lid') );
        $("#edit_loc_name").val( $(this).attr('data-lname') );
        $("#edit_loc_code").val( $(this).attr('data-lcode') );
        $("#edit_loc_city").val( $(this).attr('data-city') );
        $("#edit_loc_address").val( $(this).attr('data-laddress') );
        $("input[name|=edit_flag]").val('1');

    });

    @if (count($errors) > 0)
        $('#add_record').modal('show');
    @endif

  });
</script>
@endsection