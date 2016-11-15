@extends('wiz._layout')

@section('content')
<div class="content-wrapper">
<form action="{{ url('pwiz/company') }}" method="POST" id="form_comp">
  {!! csrf_field() !!}
  <input type="hidden" name="user" id="user" value="{{ $user_id }}" />
  <input type="hidden" name="comp" id="company" value="{{ $company['id'] or null }}">
    <input type="hidden" name="_method" value="PUT" />
  <section class="content-header">      
      <h2 class="page-header">General Details</h2>        
      <div class="pad margin no-print">
        <div class="callout callout-warning">
          <div class="row">
            <div class="col-md-6">
            <h4><i class="fa fa-warning"></i> Note: </h4>              
            Please click Save & Continue after filling in the forms below.
            </div>                
            <br />
            <div class="col-md-6 text-right">
              <a class="btn btn-success" href="#" id="submit_put">Save & Continue</a>
            </div>                
          </div>
        </div>
      </div>        
  </section>

  <!-- Main content -->      
  <section class="content">
  <!-- Your Page Content Here -->
    <!-- content / left elements -->
      <div class="row">          
        <div class="col-md-6">
          <div class="box box-primary">
                <div class="box-header with-border">
                <!-- <div class="box-header with-border col-md-12 text-left"> -->
                  <div class="" style="padding-left:0;">
                    <i class="fa fa-black-tie"></i>
                    <h2 class="box-title">Company Details</h2>
                  </div>
                 <!--  <div class="col-xs-6 text-right" style="padding-right:0;">
                    <button class="btn btn-success">Save</button>
                  </div> -->
                </div>
                <div class="box-body">
                      <div class="form-group">
                          <label for="company_name">Company Name <i class="fa fa-asterisk text-red"></i></label>                    
                        <input class="form-control" type="text" name="company_name" id="company_name" value="{{ $company['name'] or null }}"  maxlength="250"/>
                        @if ($errors->has('company_name'))<p style="color:red;">{!!$errors->first('company_name')!!}</p>@endif
                      </div>
                      <div class="form-group">
                        <label for="address"> Address</label>
                        <input class="form-control" type="text" name="address" id="address" value="{{ $company['address'] or null }}" maxlength="250"/>
                      </div>
                      <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ $company['city'] or null}}" maxlength="250"/>
                      </div>
                      <div class="form-group">
                        <label for="region">Region</label>
                        <input type="text" class="form-control" name="region" id="region" value="{{ $company['region'] or null }}" maxlength="50"/>            
                      </div>
                      <div class="form-group">
                        <label for="zip_code">Zip Code</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ $company['zip_code'] or null }}" maxlength="10"/>
                        @if ($errors->has('zip_code'))<p style="color:red;">{!!$errors->first('zip_code')!!}</p>@endif
                      </div>
                </div>
          </div>
        </div>  
        <div class="col-md-6">
          <div class="box box-primary">
              <div class="box-header with-border">
                <div class="col-xs-6" style="padding-left:0;">
                  <i class="fa fa-bank"></i>
                  <h2 class="box-title">Government Registration</h2>
                </div>                    
                <div class="col-xs-6 text-right" style="padding-right:0;">
                  <!-- <button class="btn btn-success">Save</button> -->
                </div>
              </div>
              <div class="box-body">
                    <div class="form-group">
                        <label for="bus_reg_num">Business Registration #</label>                    
                      <input class="form-control" type="text" name="bus_reg_num" id="bus_reg_num" value="{{ $company['bir_reg_num'] or null }}"  maxlength="16"/>   
                       @if ($errors->has('bir_reg_no'))<p style="color:red;">{!!$errors->first('bir_reg_no')!!}</p>@endif               
                    </div>
                    <div class="form-group">
                      <label for="tin_num">TIN #</label>
                      <input class="form-control" type="text" name="tin_num" id="tin_num" value="{{ $company['tin_num'] or null }}" />
                      @if ($errors->has('tin_no'))<p style="color:red;">{!!$errors->first('tin_no')!!}</p>@endif               
                    </div>
                    <div class="form-group">
                      <label for="sss_num">SSS #</label>
                      <input type="text" class="form-control" name="sss_num" id="sss_num" value="{{ $company['sss_num'] or null }}" />
                      @if ($errors->has('sss_no'))<p style="color:red;">{!!$errors->first('sss_no')!!}</p>@endif 
                    </div>
                    <div class="form-group">
                      <label for="hdmf_num">HDMF #</label>
                      <input type="text" class="form-control" name="hdmf_num" id="hdmf_num" value="{{ $company['hdmf_num'] or null }}" />
                      @if ($errors->has('hdmf_no'))<p style="color:red;">{!!$errors->first('hdmf_no')!!}</p>@endif             
                    </div>
                    <div class="form-group">
                      <label for="phil_health_num">PhilHealth #</label>
                      <input type="text" name="phil_health_num" id="phil_health_num" class="form-control" value="{{ $company['phil_health_num'] or null }}" />
                      @if ($errors->has('philhealth'))<p style="color:red;">{!!$errors->first('philhealth')!!}</p>@endif   
                    </div>
                    <div class="form-group">
                      <label for="bir_rdo_num">BIR RDO #</label>
                      <input type="text" class="form-control" name="bir_rdo_num" id="bir_rdo_num" value="{{ $company['bir_rdo_num'] or null }}" />
                      @if ($errors->has('bir_rdo_no'))<p style="color:red;">{!!$errors->first('bir_rdo_no')!!}</p>@endif 
                    </div>
          </div>
        </div>
      </div>
      </div>
      <!-- cont / right elements -->
  </section>
  <!-- /.content -->
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){

    $('#submit_put').click(function(){     
        $('#form_comp').submit();
    });

    $('#bus_reg_num').keyup(function () {
      var reglength = $(this).val().length; // get character length

      switch (reglength) {
          case 3:
              var cctVal = $(this).val();
              var cctNewVal = cctVal + '-';
              $(this).val(cctNewVal);
              break;
          case 7:
              var cctVal = $(this).val();
              var cctNewVal = cctVal + '-';
              $(this).val(cctNewVal);
              break;
          case 11:
              var cctVal = $(this).val();
              var cctNewVal = cctVal + '-';
              $(this).val(cctNewVal);
              break;
          case 15:
              var cctVal = $(this).val();
              var cctNewVal = cctVal + '-';
              $(this).val(cctNewVal);
              break;
          default:
              break;
    }
});

  });
</script>
@endsection