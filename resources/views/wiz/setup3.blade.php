@extends('wiz._layout')

@section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Business Structure</h2>   
        <div class="pad margin no-print">
            <div class="callout callout-warning">
              <div class="row">
                <div class="col-md-6">
                <h4><i class="fa fa-warning"></i> Note: </h4>              
                Please click Continue after organizing the structure below.
                </div>                
                <br />
                <div class="col-md-6 text-right">
                  <a href="{{ url('pwiz?page=2') }}" class="btn btn-danger">Back</a>
                  <a class="btn btn-success" href="{{ url('pwiz?page=4') }}">Continue</a>
                </div>                
              </div>
            </div>
          </div>        
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <!-- Your Page Content Here -->
          <div class="box box-primary">
            <div class="box-header with-border">
                
            </div>
            <div class="box-body">
                <ul class="treeview">
                  <li>
                    <a href="#">Trial123</a>
                    <ul class="treeview menu-open">
                          <li>trial122</li>
                          <li>trial124</li>
                          <li>trial1266</li>
                    </ul>
                  </li>                  
                </ul>
            </div>        
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection