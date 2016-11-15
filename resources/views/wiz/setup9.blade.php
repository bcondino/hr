@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Deductions Setup</h2>     
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
                  <a href="{{ url('pwiz?page=8') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=10') }}">Continue</a>
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
        <h4 class="modal-title">Add Deductions</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/deduction'.'/'.$comp) }}" method="POST" id="form_add_ded">
          {!! csrf_field() !!}  
          <div class="form-group">
            <label for="deduction_name">Name</label>
            <input class="form-control" type="text" name="deduction_name" id="deduction_name"/>
          </div>   
          <div class="form-group">
            <label for="deduction_type">Types</label>
             {{ Form::select('deduction_type_id', [null => '']  + \App\DeductionType::lists('deduction_type_name', 'deduction_type_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'deduction_type')) }}
          </div>
          <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn_add" id="btn_add">Save changes</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- END of ADD MODAL -->


    <!-- edit MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="edit_record">
      <div class="modal-dialog modal-md">        
        <div class="modal-content">
        <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Edit Deductions</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
         <form action="{{ url('pwiz/deduction') }}" method="POST" id="form_edit_ded"> 
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="PUT" />
          <input type="hidden" name="edit_flag" value="0" />
          <input type="hidden" name="deduction_id" value="" />
          <div class="form-group">
            <label for="edit_deduction_name">Name</label>
            <input class="form-control" type="text" name="edit_deduction_name" id="edit_deduction_name"/>
          </div>   
          <div class="form-group">
            <label for="edit_deduction_type">Types</label>
             {{ Form::select('deduction_type_id', [null => '']  + \App\DeductionType::lists('deduction_type_name', 'deduction_type_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'edit_deduction_type')) }}
          </div>
          <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn_edit" id="btn_edit">Save changes</button>
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
           <form action=" {{ url('pwiz/deduction') }} " id="form_ded_del" method="POST">
          <input type="hidden" name="_method" value="PUT" />
          {!! csrf_field() !!}          
          <div id="del_inputs" name="del_inputs">            
          </div>
          <div id="del_labels" name="del_labels">              
          </div>        
          </form>                    
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="btn_del">Delete</button>
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
                  <i class="fa fa-money"></i>
                  <h3 class="box-title">List of Deduction(s)</h3>
                </div>
                <div class="box-body">
                  <div id="upper panel">
                      <div id="edit_panel" class="btn-group">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_record">
              <i class="fa fa-plus"></i> Add
            </button>
                        <button class="btn btn-danger" id="delete_ded" data-toggle="modal" data-target="#delete_record"><i class="fa fa-minus"></i> Delete</button>                        
                      </div>
                      <div id="search_panel"></div>
                  </div>
                  <div>
                    <br/>
                      <table class="table table-condensed table-bordered table-striped dataTable">
                      <thead>
                        <th width="40px;"></th>
                        <th>Name</th>
                        <th>Type</th>
                      </thead>
                      <tbody>
                           @if(count($deduction) > 0)
                            @foreach($deduction as $ded)
                            <tr>
                              <td><input type="checkbox" class="ch_ded" name="ded[]" value="{{ $ded['deduction_id'] }}" data-name="{{$ded['deduction_name']}}""/></td>
                              <td>{{ $ded['deduction_name'] }}</td>
                              <td>{{ $ded['deduction_type_name'] or null }}</td>
                              <td><button class="btn btn-ded-edit" id="btn-ded-edit" data-toggle="modal" data-target="#edit_record" data-id="{{$ded['deduction_id']}}" data-name="{{$ded['deduction_name']}}" data-type="{{$ded['deduction_type_name']}}" data-tax="{{$ded['is_mandatory']}}">Edit</button></td>
                            </tr>
                            @endforeach
                          @else
                          <tr>
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
  
  $('.btn_add').click(function(){     
        $('#form_add_ded').submit();
    });

  $('.btn-ded-edit').click(function(){
        $("input[name|=deduction_id]").val( $(this).attr('data-id') );
        $("#edit_deduction_name").val( $(this).attr('data-name') );
        $("#edit_deduction_type option:contains(" + $(this).attr('data-type') +")").attr("selected", true);
        $("input[name|=edit_flag]").val('1');
    });
  
  $('#btn_edit').click(function(){
       $('#form_edit_ded').submit();
  });

   $("#delete_ded").click(function(){
        $("#del_inputs").empty();
        $("#del_labels").empty();

        $(".ch_ded:checked").each(function(){
          $("#del_inputs").append('<input type="hidden" name="ded[]" value="'+ $(this).val() +'" />');
          $("#del_labels").append('<div class="form-group"><label>'+ $(this).attr('data-name') +'</label></div>');
        });
    });

    $('#btn_del').click(function(){
         $('#form_ded_del').submit();
    });

  });
</script>
@endsection