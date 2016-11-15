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
            Please fill in with valid company details.
            <br/>
            <!--display message -->             
            @if(Session::has('display'))
                  {{ Session::get('display') }}
            @endif      
            </div>       
            <br />
            <div class="col-md-6 text-right">
              <a href="#" class="btn btn-success"  id="submit_put">Save</a>
              <a href="{{ url('pwiz?page=3') }}" class="btn btn-success">Continue</a>
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
                        <input class="form-control" type="text" name="company_name" id="company_name" value="{{ (($errors->has('company_name')) or ($company['name'] == null)) ? old('name') : $company['name'] }}"  maxlength="250"/>
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
                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ (($errors->has('zip_code')) or ($company['zip_code'] == null)) ? old('zip_code') : $company['zip_code'] }}" maxlength="10"/>
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
                      <input class="form-control" type="text" name="bus_reg_num" id="bus_reg_num" value="{{ $company['bir_reg_no'] or null }}"  maxlength="15" placeholder="000-000-000-000" />   
                       @if ($errors->has('bus_reg_num'))<p style="color:red;">{!!$errors->first('bus_reg_num')!!}</p>@endif               
                    </div>
                    <div class="form-group">
                      <label for="tin_num">TIN #</label>
                      <input class="form-control" type="text" name="tin_num" id="tin_num" value="{{ $company['tin_num'] or null }}" maxlength="16" placeholder="000-000-000-0000"/>
                      @if ($errors->has('tin_num'))<p style="color:red;">{!!$errors->first('tin_num')!!}</p>@endif               
                    </div>
                    <div class="form-group">
                      <label for="sss_num">SSS #</label>
                      <input type="text" class="form-control" name="sss_num" id="sss_num" value="{{ $company['sss_num'] or null }}" placeholder="000-00-0000"/>
                      @if ($errors->has('sss_num'))<p style="color:red;">{!!$errors->first('sss_num')!!}</p>@endif 
                    </div>
                    <div class="form-group">
                      <label for="hdmf_num">HDMF #</label>
                      <input type="text" class="form-control" name="hdmf_num" id="hdmf_num" value="{{ $company['hdmf_num'] or null }}" placeholder="0000-0000-0000"/>
                      @if ($errors->has('hdmf_num'))<p style="color:red;">{!!$errors->first('hdmf_num')!!}</p>@endif             
                    </div>
                    <div class="form-group">
                      <label for="phil_health_num">PhilHealth #</label>
                      <input type="text" name="phil_health_num" id="phil_health_num" class="form-control" value="{{ $company['phil_health_num'] or null }}" placeholder="0000-0000-0000"/>
                      @if ($errors->has('phil_health_num'))<p style="color:red;">{!!$errors->first('phil_health_num')!!}</p>@endif   
                    </div>
                    <div class="form-group">
                      <label for="bir_rdo_num">BIR RDO #</label>
                      <input type="text" class="form-control" name="bir_rdo_num" id="bir_rdo_num" value="{{ $company['bir_rdo_num'] or null }}" maxlength="3" />
                      @if ($errors->has('bir_rdo_num'))<p style="color:red;">{!!$errors->first('bir_rdo_num')!!}</p>@endif 
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
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){

    $('#submit_put').click(function(){     
        $('#form_comp').submit();
    });

$.mask.definitions['h'] = "[A-Za-z0-9]";
  $.mask.definitions['v'] = "[VN]";
  $("#bus_reg_num").mask("?hhh-hhh-hhh-hhh");
  $("#tin_num").mask("?999-999-999-999v");
  $("#sss_num").mask("?999-99-9999");
  $("#hdmf_num").mask("?9999-9999-9999");
  $("#phil_health_num").mask("?9999-9999-9999");

  });

  
</script>
@endsection 