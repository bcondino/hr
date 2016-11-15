@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Positions Setup</h2>     
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
                  <a href="{{ url('pwiz?page=6') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=8') }}">Continue</a>
                </div>                
              </div>
            </div>
          </div>         
    </section>

    <!-- ADD MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="add_record">
      <div class="modal-dialog moda l-md">        
        <div class="modal-content">
        <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Add Position</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
         <form action="{{ url('pwiz/position'.'/'.$comp) }}" method="POST" id="form_add_post">      
         {!! csrf_field() !!}
          <div class="form-group">
            <label for="position_code">Position Code</label>
            <input class="form-control" type="text" name="position_code" id="position_code"/>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control" type="text" name="description" id="description"/>
          </div>     
        <div class="form-group">
            <label for="business_unit">Business Unit</label>
            {{ Form::select('business_unit_id', [null => '']  + \App\BusinessUnit::where('active_flag', '1')->lists('business_unit_name', 'business_unit_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'business_unit')) }}
          </div>    
          <div class="form-group">
            <label for="salary_grade">Salary Grade</label>
            {{ Form::select('grade_id', [null => '']  + \App\SalaryGrade::where('active_flag', '1')->lists('grade_code', 'grade_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'salary_grade')) }}
          </div>
          <div class="form-group">
            <label for="classification">Classification</label>
            {{ Form::select('class_id',[null => '']  + \App\Classification::where('active_flag', '1')->lists('class_name', 'class_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'classification')) }}  
          </div>
          <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-add-post">Save changes</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- END of ADD MODAL -->

    <!-- EDIT MODAL -->
    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="edit_record">
      <div class="modal-dialog moda l-md">        
        <div class="modal-content">
        <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <h4 class="modal-title">Edit Position</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
       <form action="{{ url('pwiz/position') }}" method="POST" id="form_edit_post"> 
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="PUT" />
          <input type="hidden" name="edit_flag" value="0" />
          <input type="hidden" name="position_id" value="" />
          <div class="form-group">
            <label for="edit_position_code">Position Code</label>
            <input class="form-control" type="text" name="edit_position_code" id="edit_position_code"/>
          </div>
          <div class="form-group">
            <label for="edit_position_desc">Description</label>
            <input class="form-control" type="text" name="edit_position_desc" id="edit_position_desc"/>
          </div>
          <div class="form-group">
            <label for="edit_business_unit">Business Unit</label>
            {{ Form::select('business_unit_id', [null => '']  + \App\BusinessUnit::where('active_flag', '1')->lists('business_unit_name', 'business_unit_id') -> toArray() , null , array('class'=>'form-control', 'id'=>'edit_business_unit')) }}
          </div>
          <div class="form-group">
            <label for="edit_salary_grade">Salary Grade</label>
            {{ Form::select('grade_id',  [null => ''] + \App\SalaryGrade::where('active_flag', '1')->lists('grade_code', 'grade_id') -> toArray() , null, array('class'=>'form-control', 'id'=>'edit_salary_grade')) }}
          </div>
          <div class="form-group">
            <label for="edit_classification">Classification</label>
            {{ Form::select('class_id',[null => ''] + \App\Classification::where('active_flag', '1')->lists('class_name', 'class_id') -> toArray() , null, array('class'=>'form-control', 'id'=>'edit_classification')) }}    
          </div>
          <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success edit_submit_post" id="edit_submit_post">Save changes</button>
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
          <form action=" {{ url('pwiz/position') }} " id="form_post_del" method="POST">
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
        <button type="button" class="btn btn-success" id="delete_grade">Delete</button>
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
                  <h3 class="box-title">List of Positions</h3>
                </div>
                <div class="box-body">
                  <div id="upper panel">
                      <div id="edit_panel" class="btn-group">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add_record">
              <i class="fa fa-plus"></i> Add
            </button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete_record" id ="btn_delete_rec"><i class="fa fa-minus"></i> Delete</button>                        
                      </div>
                      <div id="search_panel"></div>
                  </div>
                  <div>
                    <br/>
                      <table class="table table-condensed table-bordered table-striped dataTable">
                        <thead>
                          <th width="40px;"></th>
                          <th>Position</th>                       
                          <th>Description</th>
                          <th>Business Unit</th>
                          <th>Salary Grade</th>
                          <th>Class</th>
                        </thead>
                        <tbody>
                          @if(count($pos) > 0)
                            @foreach($pos as $post)
                            <tr>
                              <td><input type="checkbox" class="ch_post" name="pos[]" value="{{ $post['position_id'] }}" data-pcode="{{ $post['position_code'] }}"/></td>
                              <td>{{ $post['position_code'] }}</td>
                              <td>{{ $post['description'] or null }}</td>
                              <td>{{ $post['business_unit_name'] or null }}</td>
                              <td>{{ $post['grade_code'] or null }}</td>
                              <td>{{ $post['class_name'] or null }}</td>
                              <td><button class="btn btn-post-edit" id="btn-post-edit" data-toggle="modal" data-target="#edit_record"  data-pid="{{ $post['position_id'] }}" data-pcode="{{ $post['position_code'] }}" data-pdesc = "{{ $post['description'] }}" data-bu ="{{ $post['business_unit_name'] or null }}" data-class="{{ $post['class_name'] or null }}" data-grade="{{ $post['grade_code'] or null }}">Edit</button></td>
                            </tr>
                            @endforeach
                          @else
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>No data found!</td>
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

 $('.btn-post-edit').click(function(){
        $("input[name|=position_id]").val( $(this).attr('data-pid') );
        $("#edit_position_code").val( $(this).attr('data-pcode') );
        $("#edit_position_desc").val( $(this).attr('data-pdesc') );
        $("#edit_business_unit option:contains(" + $(this).attr('data-bu') +")").attr("selected", true);
        $("#edit_salary_grade option:contains(" + $(this).attr('data-grade') +")").attr("selected", true);
        $("#edit_classification option:contains(" + $(this).attr('data-class') +")").attr("selected", true);
        $("input[name|=edit_flag]").val('1');
    });
  
  $('.btn-add-post').click(function(){     
        $('#form_add_post').submit();
    });

  $('#edit_submit_post').click(function(){
      $('#form_edit_post').submit();
    });

  $("#btn_delete_rec").click(function(){
        $("#del_inputs").empty();
        $("#del_labels").empty();

        $(".ch_post:checked").each(function(){
          $("#del_inputs").append('<input type="hidden" name="pos[]" value="'+ $(this).val() +'" />');
          $("#del_labels").append('<div class="form-group"><label>'+ $(this).attr('data-pcode') +'</label></div>');
        });
    });

  $("#delete_grade").click(function(){
        $("#form_post_del").submit();
    });

  });
</script>
@endsection