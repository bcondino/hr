@extends('shared._wiz')

@section('title', 'Nuvem HR Setup')

@section('content')

<!-- start: modal for delete button -->
<div id="cancel" class="uk-modal">
                <div class="uk-modal-dialog">
                        <button class="uk-modal-close uk-close"></button>
                        <form action="{{ url('wiz2/cancel'.'/'.$comp) }}" role="form" action="" method="POST" id="form-del-loc">
                        {!! csrf_field() !!}
                                <div class="uk-modal-header"><span class="uk-icon-trash"></span>Cancel Setup</div>
                                <div class="uk-margin uk-modal-content">
                                        Are you sure you want to cancel? All the saved data will be deleted. If not, please click NO.
                                </div>
                                <div id="div-del-inp" name="div-del-inp">
                                </div>
                                <div class="uk-modal-footer uk-text-right form-buttons">
                                        <button id="btn-cancel-ok" class="uk-button btn-delete js-modal-confirm"  type="submit"><span class="uk-icon uk-icon-trash"></span>Yes</button>
                                        <button class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> No</button>
                                </div>
                        </form>
                </div>
        </div> <!-- end: modal for delete button -->

<!-- list company setup -->
<div class="uk-container uk-container-center">
	<div class="categories">
		<div class="uk-grid">
			<div class="uk-width-1-4">
				@include('wiz2._nav')
			</div> <!-- list company setup-->
			
			<!-- company details -->
			<div class="uk-width" style="width:75%;">
				@if($step == 0)
					<div>
						@include($tg)
						@include('wiz2.controls')
					</div>
				@endif

				@if($step == 1)
					@include('wiz2.details')
				@endif

				@if($step == 2)
					<div>
						@include($tg)
						<br/><br/><br/>
						<div class="text-center">
							@include('wiz2.controls')
						</div>					
					</div>
				@endif

				@if($step > 2 && $step < 8)
					<div>
						@include($tg)
					</div>
				@endif

				@if($step == 8)
					<div>
						@include($tg)
						<div class="text-center">
							@include('wiz2.controls')
						</div>	
					</div>
				@endif
		    </div> <!-- company details -->
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script>

	$(document).ready(function(){
		$('#btn-comp-sub').click(function(){
			$("form#form-company").submit();
		});

	  $.mask.definitions['h'] = "[A-Za-z0-9]";
	  $.mask.definitions['v'] = "[VN]";
	  $("#bus_reg_num").mask("?hhh-hhh-hhh-hhh");
	  $("#tin_num").mask("?999-999-999-9999"); // 20161007 debugged by Melvin Militante
	  $("#sss_num").mask("?999-99-9999");
	  $("#hdmf_num").mask("?9999-9999-9999");
	  $("#phil_health_num").mask("?9999-9999-9999");

   $('#save_loc').click(function(){          
      $('#form_location').submit();
    });

	});
</script>

@endsection