@extends('shared._public')

@section('title', 'Business Structure')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> <b>{{ ucwords($company->company_name) }}</b> </h1>
		</div>
	</div>
</div>

<!-- list company setup -->
<div class="uk-container uk-container-center">
	<div class="categories">
		<div class="uk-grid">
			<div class="uk-width-1-4">
				<ul class="uk-nav uk-nav-side">
					<li><a href="{{ url('companies/details/'.$company->company_id) }}">Company Details</a></li>
					<li class="uk-active"><a href="{{ url('companies/business_structure/'.$company->company_id) }}">Business Structure</a></li>
					<li><a href="{{ url('companies/locations/'.$company->company_id) }}">Location</a></li>
					<li><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>
			</div> <!-- list company setup-->
			<!-- location -->
			<div class="uk-width" style="width:75%;">
				<div id="status" >
					<div class="uk-alert uk-alert-success" id="succ_message" style = "display:none"></div>
				</div>
					Right-click on the business unit to create a sub-unit under.
				<div id="treeDemo"  class="ztree" >
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(function () {
	$('#treeDemo').jstree({
		"core" : {
		    "themes" : {
		      "icons" : false
		    },
		    "check_callback" : true,
		    'data' : {
		        "url" : "{{ url('treeview/treeviewcompany'.'/'.$company->company_id) }}",
		        "data" : function (node) {
		          return { "id" : node.id };
		        }
	      	}
		},
	    "file" : {
	      "icon" : "glyphicon glyphicon-file",
	      "valid_children" : []
	    },
		"types" : {
			 "#" : {
			  "max_depth" : 7
			}
		},
		"contextmenu":{
		    "items": function($node) {
		        var tree = $("#treeDemo").jstree(true);
				var $treeSelected = tree.get_selected();
				if($('#'+$treeSelected).attr('level') == 1){
					return {
						"Add": {
							"separator_before": false,
							"separator_after": false,
							"label": "Add",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
									$node = tree.create_node($node);
									tree.edit($node,'Add Business Unit',function(data){
										var $company_id = $('#'+data.id).parent().parent().attr('parent_id');
										var $level = $('#'+data.id).parent().parent().attr('level');
										$.ajax({
											type        : 'POST',
											url         : '{{ url("treeview") }}',
											data        : { parent_id: data.parent, text:data.text, level: $level, company_id: $company_id, _token: "{{ csrf_token() }}" },
											success     : function (data){
												$('#treeDemo').jstree(true).refresh();
												$('#succ_message').html('New business unit has been added successfully.');
												$("#succ_message").show();
											}
										});
									});
							}
						}
					};
				}else if($('#'+$treeSelected).attr('level') >= 2 && $('#'+$treeSelected).attr('level') <= 6){
					return {
						"Add": {
							"separator_before": false,
							"separator_after": false,
							"label": "Add",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
									$node = tree.create_node($node);
									tree.edit($node,'Add Business Unit',function(data){
										var $company_id = $('#'+data.id).parent().parent().attr('parent_id');
										var $level = $('#'+data.id).parent().parent().attr('level');
										$.ajax({
											type        : 'POST',
											url         : '{{ url("treeview") }}',
											data        : { parent_id: data.parent, text:data.text, level: $level, company_id: $company_id, _token: "{{ csrf_token() }}" },
											success     : function (data){
												$('#treeDemo').jstree(true).refresh();
												$('#succ_message').html('New business unit has been added successfully.');
												$("#succ_message").show();
											}
										});
									});
							}
						},
						"Edit": {
							"separator_before": false,
							"separator_after": false,
							"label": "Edit",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
								console.log(obj);
									tree.edit($node, null,function(data){
										var $company_id = $('#'+data.id).parent().parent().attr('parent_id');
										var $level = $('#'+data.id).parent().parent().attr('level');
										$.ajax({
											type        : 'POST',
											url         : '{{ url("treeview") }}'+'/'+data.id,
											data        : { id: data.id, parent_id: data.parent, text:data.text, level: $level, company_id: $company_id, _token: "{{ csrf_token() }}", _method: "PUT" },
											success     : function (data){
												$('#treeDemo').jstree(true).refresh();
												$('#succ_message').html('Business unit has been updated successfully.');
												$("#succ_message").show();
											}
										});
									});


							}
						},
						"Delete": {
							"separator_before": false,
							"separator_after": false,
							"label": "Delete",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
									tree.delete_node($node);
									var $level = $node.li_attr.level;
									console.log($level);
									$.ajax({
										type        : 'POST',
										url         : '{{ url("treeview") }}'+'/'+$node.id,
										data        : { id: $node.id, parent_id: $node.parent, level: $level, _token: "{{ csrf_token() }}", _method: "DELETE" },
										success     : function (data){
											$('#treeDemo').jstree(true).refresh();
											$('#succ_message').html('Selected business unit has been deleted successfully.');
											$("#succ_message").show();
										}
									});
							}
						}
					};
				}else{
					return {
						"Edit": {
							"separator_before": false,
							"separator_after": false,
							"label": "Edit",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
									tree.edit($node,'New',function(data){
										var $company_id = $('#'+data.id).parent().parent().attr('parent_id');
										var $level = $('#'+data.id).parent().parent().attr('level');
										$.ajax({
											type        : 'POST',
											url         : '{{ url("treeview") }}'+'/'+data.id,
											data        : { id: data.id, parent_id: data.parent, text:data.text, level: $level, company_id: $company_id, _token: "{{ csrf_token() }}", _method: "PUT" },
											success     : function (data){
												$('#treeDemo').jstree(true).refresh();
												$('#succ_message').html('Business unit has been updated successfully.');
											$("#succ_message").show();
											}
										});
									});
							}
						},
						"Delete": {
							"separator_before": false,
							"separator_after": false,
							"label": "Delete",
							"action": function (obj) {
								// var r = confirm("Are you sure you want to continue ?");
								// if (r == true)
									tree.delete_node($node);
										var $level = $node.li_attr.level;
										console.log($level);
										$.ajax({
											type        : 'POST',
											url         : '{{ url("treeview") }}'+'/'+$node.id,
											data        : { id: $node.id, parent_id: $node.parent, level: $level, _token: "{{ csrf_token() }}", _method: "DELETE" },
											success     : function (data){
												$('#treeDemo').jstree(true).refresh();
												$('#succ_message').html('Selected Business unit has been deleted successfully.');
											$("#succ_message").show();
											}
										});
							}
						}
					};
				}
		    }
		},
		"plugins" : [
		    "contextmenu", "dnd", "search",
		    "state", "types", "wholerow"
		]
	});



});

</script>
@endsection
