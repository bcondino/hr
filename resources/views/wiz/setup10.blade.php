@extends('wiz._layout')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <h2 class="page-header">Well done!</h2>     
        <!-- <div class="pad margin no-print">
            <div class="callout callout-warning">
              <div class="row">
                <div class="col-md-6">
                <h4><i class="fa fa-warning"></i> Note: </h4>              
                 Feel free to interact with the objects below.<br>
                Click continue if you wish to proceed to the next step.
                </div>                
                <br />
                <div class="col-md-6 text-right">
                  <a class="btn btn-success" href="setup9.html">Continue</a>
                </div>                
              </div>
            </div>
          </div>   -->   
          <br>
          <br>    
    </section>  

   <!-- Main content -->
    <section class="content">
    <!-- Your Page Content Here -->
      <div class="row">
        <div class="col-lg-12">
          
          <div class="alert alert-success">
          <h4>
            <i class="icon fa fa-check"></i>
            Congratulations
          </h4>
            <div class="text-center">
              You have successfully configured your HR system. Click Home to proceed.
            </div>
            <div class="text-center">
              <a href="{{url('home')}} "class="btn btn-primary active">Home</a>
            </div>
          </div>

        </div>
      </div>


    </section>
    <!-- /.content -->
  </div>
@endsection