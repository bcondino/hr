@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Earnings Setup</h2>     
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
                  <a href="{{ url('pwiz?page=7') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=9') }}">Continue</a>
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
        <h4 class="modal-title">Add Earnings</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/earning'.'/'.$comp) }}" method="POST" id="form_add_earn">
          {!! csrf_field() !!}  
            <div class="form-group">
              <label for="earning_name">Name</label>
              <input class="form-control" type="text" name="earning_name" id="earning_name"/>
            </div>   
            <div class="form-group">
              <label for="earning_type">Earning Type</label>
                {{ Form::select('earning_type_id', [null => '']  + \App\EarningType::lists('earning_type_name', 'earning_type_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'earning_type')) }}
            </div>
              <!--<div class="form-group">
              <label for="tax_flag">Taxable ?</label>
              <input type="hidden" name="tax_flag" id="tax_flag" value="Y" />
                <div class="btn-group">              
                <button class="btn btn-primary active">Yes</button>
                <button class="btn btn-primary">No</button>              
                </div>
              </div>-->
            <br/>
         </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success btn-add-earn" id="btn-add-earn">Save</button>
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
        <h4 class="modal-title">Add Earnings</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/earning') }}" method="POST" id="form_edit_earn"> 
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="PUT" />
          <input type="hidden" name="edit_flag" value="0" />
          <input type="hidden" name="earning_id" value="" />
            <div class="form-group">
              <label for="edit_earning_name">Name</label>
              <input class="form-control" type="text" name="edit_earning_name" id="edit_earning_name"/>
            </div>   
            <div class="form-group">
              <label for="edit_earning_type">Earning Type</label>
                {{ Form::select('earning_type_id', [null => '']  + \App\EarningType::lists('earning_type_name', 'earning_type_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'edit_earning_type')) }}
            </div>
            <br/>
         </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success btn-edit" id="btn-edit">Save Changes</button>
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
          <form action=" {{ url('pwiz/earning') }} " id="form_earn_del" method="POST">
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
        <button type="button" class="btn btn-success" id="delete_earn">Delete</button>
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
                  <i class="fa fa-dollar"></i>
                  <h3 class="box-title">List of Earnings</h3>
                </div>
                <div class="box-body">
                  <div id="upper panel">
                      <div id="edit_panel" class="btn-group">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_record">
              <i class="fa fa-plus"></i> Add
            </button>
                        <button class="btn btn-danger" id="btn_delete_rec" data-toggle="modal" data-target="#delete_record"><i class="fa fa-minus"></i> Delete</button>                        
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
                        <!--<th>Taxable</th>-->
                      </thead>
                      <tbody>
                         @if(count($earning) > 0)
                            @foreach($earning as $earn)
                            <tr>
                              <td><input type="checkbox" class="ch_earn" name="earn[]" value="{{ $earn['earning_id'] }}" data-name="{{ $earn['earning_name'] }}"/></td>
                              <td>{{ $earn['earning_name'] }}</td>
                              <td>{{ $earn['earning_type_name'] or null }}</td>
                             <!-- @if($earn['is_taxable'])
                              <td>Yes</td>
                              @else
                              <td>No</td>  
                              @endif-->
                              <td><button class="btn btn-earn-edit" id="btn-earn-edit" data-toggle="modal" data-target="#edit_record" data-id="{{$earn['earning_id']}}" data-name="{{$earn['earning_name']}}" data-type="{{$earn['earning_type_name']}}" data-tax="{{$earn['is_taxable']}}">Edit</button></td>
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
  
  $('.btn-add-earn').click(function(){     
        //console.log('clicked');
        $('#form_add_earn').submit();
    });

  $('.btn-earn-edit').click(function(){
        $("input[name|=earning_id]").val( $(this).attr('data-id') );
        $("#edit_earning_name").val( $(this).attr('data-name') );
        $("#edit_earning_type option:contains(" + $(this).attr('data-type') +")").attr("selected", true);
        $("input[name|=edit_flag]").val('1');
    });
  $('#btn-edit').click(function(){
       $('#form_edit_earn').submit();
  });

   $("#btn_delete_rec").click(function(){
        $("#del_inputs").empty();
        $("#del_labels").empty();

        $(".ch_earn:checked").each(function(){
          $("#del_inputs").append('<input type="hidden" name="earn[]" value="'+ $(this).val() +'" />');
          $("#del_labels").append('<div class="form-group"><label>'+ $(this).attr('data-name') +'</label></div>');
        });
    });

  $('#delete_earn').click(function(){
       $('#form_earn_del').submit();
  });

  });
</script>
@endsection