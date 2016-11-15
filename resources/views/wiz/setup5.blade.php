@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Employment Setup</h2>     
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
                  <a href="{{ url('pwiz?page=4') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=6') }}">Continue</a>
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
        <h4 class="modal-title">Add Employment type</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
        <form action="{{ url('pwiz/employment'.'/'.$comp ) }}" id="form-add-empt" method="POST">          
        {!! csrf_field() !!}
          <div class="form-group">
            <label for="status_name">Status</label>
            <input class="form-control" type="text" name="status_name" id="status_name"/>
          </div>
          <div class="form-group">
            <label for="min_hrs">Minimum Hours</label>
            <input class="form-control" type="text" name="min_hrs" id="min_hrs" />
          </div>          
          <div class="form-group">
            <label for="max_hrs">Maximum Hours</label>
            <input class="form-control" type="text" name="max_hrs" id="max_hrs" />
          </div>          
          <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-add-empt">Save</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- END of ADD MODAL -->

    <!-- EDIT MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="edit_record">
      <div class="modal-dialog modal-md">        
        <div class="modal-content">
        <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Edit Employment Type</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/employment') }}" method="POST" id="form_edit_empt"> 
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="edit_flag" value="0" />
            <input class="form-control" type="text" name="empt" id="empt" value="" />   
            <div class="form-group">
              <label for="edit_status_name">Status</label>
              <input class="form-control" type="text" name="edit_status_name" id="edit_status_name"/>
            </div>
            <div class="form-group">
              <label for="edit_min_hrs">Minimum Hours</label>
              <input class="form-control" type="text" name="edit_min_hrs" id="edit_min_hrs" />
            </div>          
            <div class="form-group">
              <label for="edit_max_hrs">Maximum Hours</label>
              <input class="form-control" type="text" name="edit_max_hrs" id="edit_max_hrs" />
            </div>          
            </form>
          <br />
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success edit_submit_empt" id="edit_submit_empt">Save changes</button>
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
        <h4 class="modal-title">Are you sure that you want to delete this/these ?</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
                <form action=" {{ url('pwiz/employment') }} " id="form_empt_del" method="POST">
          <input type="hidden" name="_method" value="PUT" />
          {!! csrf_field() !!}          
            <div id="del_inputs" name="del_inputs">            
            </div>
            <div id="del_labels" name="del_labels">            
            </div>        
          </form>                
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="delete_empt">Delete</button>
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
                  <i class="fa fa-list"></i>
                  <h3 class="box-title">List of Employment types</h3>
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
                      <table class="table table-condensed table-bordered table-striped dataTable">
                      <thead>
                        <th width="40px;"></th>
                        <th>Status</th>
                        <th>Minimum Hours</th>
                        <th>Maximum Hours</th>
                        <th>Edit</th>
                      </thead>
                      <tbody>
                      @if(count($employment) > 0)
                        @foreach($employment as $empt)
                        <tr>
                          <td><input type="checkbox" class="ch_empt" name="empt[]" value="{{ $empt['type_id'] }}"" data-name="{{ $empt['type_name'] }}"/></td>
                          <td>{{ $empt['type_name'] }}</td>
                          <td>{{ $empt['min_hrs'] or null }}</td>
                          <td>{{ $empt['max_hrs'] or null }}</td>
                          <td><button class="btn btn-default btn-edit-empt" data-toggle="modal" data-target="#edit_record" data-etid="{{ $empt['type_id'] }}" data-etname="{{ $empt['type_name'] or null  }}" data-minhr ="{{$empt['min_hrs']  or null }}" data-maxhr ="{{$empt['max_hrs']  or null }}">Edit</button></td>
                        </tr>
                        @endforeach
                      @else
                      <tr>
                          <td></td>
                          <td></td>
                          <td>No data found!</td>
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

    $('.btn-add-empt').click(function(){     
        $('#form-add-empt').submit();
    });

    $('.btn-edit-empt').click(function(){
        $("input[name|=empt]").val( $(this).attr('data-etid') );
        $("#edit_status_name").val( $(this).attr('data-etname') );
        $("#edit_min_hrs").val( $(this).attr('data-minhr') );
        $("#edit_max_hrs").val( $(this).attr('data-maxhr') );
        $("input[name|=edit_flag]").val('1');
    });

    $('#edit_submit_empt').click(function(){
      $('#form_edit_empt').submit();
    });


    $("#btn_delete_rec").click(function(){
        $("#del_inputs").empty();
        $("#del_labels").empty();

        $(".ch_empt:checked").each(function(){
          $("#del_inputs").append('<input type="hidden" name="empt[]" value="'+ $(this).val() +'" />');
          $("#del_labels").append('<div class="form-group"><label>'+ $(this).attr('data-name') +'</label></div>');
        });
    });

    $("#delete_empt").click(function(){
        $("#form_empt_del").submit();
    });


  });
</script>
@endsection