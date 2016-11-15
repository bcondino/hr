@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Salary Grades Setup</h2>     
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
                  <a href="{{ url('pwiz?page=5') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=7') }}">Continue</a>
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
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/grade'.'/'.$comp) }}" method="POST" id="form_add_grade">      
          {!! csrf_field() !!}
            <div class="form-group">
              <label for="grade_code">Grade Code</label>
              <input class="form-control" type="text" name="grade_code" id="grade_code"/>
            </div>   
            <div class="form-group">
              <label for="minimum_salary">Minimum Salary</label>
              <input type="text" name="minimum_salary" id="minimum_salary" class="form-control"/>
            </div>
            <div class="form-group">
              <label for="maximum_salary">Maximum Salary</label>
              <input type="text" name="maximum_salary" id="maximum_salary" class="form-control"/>
            </div>
            <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-add-grade">Save changes</button>
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
        <h4 class="modal-title">Edit Location</h4>
        </div>
        <div class="modal-body" style="background-color:#fff;">
          <form action="{{ url('pwiz/grade') }}" method="POST" id="form_edit_grade"> 
          {!! csrf_field() !!}
          <input type="hidden" name="_method" value="PUT" />
          <input type="hidden" name="edit_flag" value="0" />
          <input type="hidden" name="grade" value="" />
            <div class="form-group">
              <label for="edit_grade_code">Grade Code</label>
              <input class="form-control" type="text" name="edit_grade_code" id="edit_grade_code"/>
            </div>   
            <div class="form-group">
              <label for="edit_minimum_salary">Minimum Salary</label>
              <input type="text" name="edit_minimum_salary" id="edit_minimum_salary" class="form-control"/>
            </div>
            <div class="form-group">
              <label for="edit_maximum_salary">Maximum Salary</label>
              <input type="text" name="edit_maximum_salary" id="edit_maximum_salary" class="form-control"/>
            </div>
            <br />
          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success edit_submit_grade" id="edit_submit_grade">Save</button>
      </div>
        </div>        
      </div>
    </div>
    <!-- EDIT of ADD MODAL -->


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
        <form action=" {{ url('pwiz/grade') }} " id="form_grade_del" method="POST">
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
                  <h3 class="box-title">List of Salary Grades</h3>
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
                          <th>Code</th>                                               
                          <th>Range</th>
                        </thead>
                        <tbody>
                          @if(count($salary_grade) > 0)
                            @foreach($salary_grade as $grade)
                            <tr>
                              <td><input type="checkbox" class="ch_grade" name="grade[]" value="{{ $grade['grade_id'] }}" data-name="{{ $grade['grade_code'] }}"/></td>
                              <td>{{ $grade['grade_code'] }}</td>
                              <td>{{ $grade['minimum_salary'] or null }} - {{ $grade['maximum_salary'] or null }} </td>
                              <td><button class="btn btn-grade-edit" data-toggle="modal" data-target="#edit_record" data-gid="{{ $grade['grade_id'] }}" data-gcode="{{ $grade['grade_code'] }}" data-minsal="{{ $grade['minimum_salary'] or null }}" data-maxsal="{{ $grade['maximum_salary'] or null }}">Edit</button></td>
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

    $('.btn-add-grade').click(function(){     
        $('#form_add_grade').submit();
    });

    $('#edit_submit_grade').click(function(){
      $('#form_edit_grade').submit();
    });

    $('.btn-grade-edit').click(function(){
        $("input[name|=grade]").val( $(this).attr('data-gid') );
        $("#edit_grade_code").val( $(this).attr('data-gcode') );
        $("#edit_minimum_salary").val( $(this).attr('data-minsal') );
        $("#edit_maximum_salary").val( $(this).attr('data-maxsal') );
        $("input[name|=edit_flag]").val('1');
    });

    $("#btn_delete_rec").click(function(){
        $("#del_inputs").empty();
        $("#del_labels").empty();

        $(".ch_grade:checked").each(function(){
          $("#del_inputs").append('<input type="hidden" name="grade[]" value="'+ $(this).val() +'" />');
          $("#del_labels").append('<div class="form-group"><label>'+ $(this).attr('data-name') +'</label></div>');
        });
    });

    $("#delete_grade").click(function(){
        $("#form_grade_del").submit();
    });
    

  });
</script>
@endsection

