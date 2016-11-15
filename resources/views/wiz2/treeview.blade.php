<div id="status" >
	<div class="uk-alert uk-alert-success" id="succ_message" style = "display:none"></div>
</div>
Right-click on the business unit to create a sub-unit under.
<div id="treeDemo"  class="ztree" >
</div>

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
		        "url" : "{{ url('treeview/treeviewcompany'.'/'.$comp) }}",
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
