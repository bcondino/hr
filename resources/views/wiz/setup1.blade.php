@extends('wiz._layout')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Welcome to NuvemHR        
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="box">
      <div class="box-header with-border">
          <h2 class="page-header">NuvemHR Setup Wizard</h2>
      </div>
      <div class="box-body">
          Thank you for using NuvemHR version 1.0.1.
          After a few steps, you can now use 
          To proceed with the installation process, click 'Continue'
      </div>
      <div class="box-footer text-right">
        <div class="btn-group">            
            <a href="{{ url('pwiz?page=2') }}" class="btn btn-lg btn-success">Continue</a>
        </div>
        
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
@endsection