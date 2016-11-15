<ul style="pointer-events: none; cursor:default" class="uk-nav uk-nav-side">
	@if($step == '0')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Welcome</a>
		</li>
	@elseif($step > '0')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Welcome</a>
		</li>
	@else
		<li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>Welcome</a> </li>
	@endif

	@if($step == '1')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Company Details</a>
		</li>
	@elseif($step > '1')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Company Details</a>
		</li>
	@else
		<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Company Details</a> </li>
	@endif

	@if($step == '2')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Business Structure</a>
		</li>
	@elseif($step > '2')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Business Structure</a>
		</li>
	@else
		<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Business Structure</a> </li>
	@endif

	@if($step == '3')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Location</a>
		</li>
	@elseif($step > '3')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Location</a>
		</li>
	@else
		<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location</a> </li>
	@endif

	@if($step == '4')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Employee Type</a>
		</li>
	@elseif($step > '4')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Employee Type</a>
		</li>
	@else
		<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee Type</a> </li>
	@endif

	@if($step == '5')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Salary Grade</a>
		</li>
	@elseif($step > '5')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Salary Grade</a>
		</li>
	@else
	<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salary Grade</a> </li>
	@endif

	@if($step == '6')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Classification</a>
		</li>
	@elseif($step > '6')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Classification</a>
		</li>
	@else
	<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Classification</a> </li>
	@endif

	@if($step == '7')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Position</a>
		</li>
	@elseif($step > '7')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Position</a>
		</li>
	@else
	<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Position</a> </li>
	@endif

	@if($step == '8')
		<li class="uk-active">
			<a href=""><i class="uk-icon-hand-o-right uk-text-primary"></i> Your Done!</a>
		</li>
	@elseif($step > '8')
		<li>
			<a href=""><i class="uk-icon-check-square-o uk-text-primary"></i> Your Done!</a>
		</li>
	@else
		<li> <a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your Done!</a> </li>	
	@endif
 </ul>
