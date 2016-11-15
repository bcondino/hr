<ul class="sidebar-menu">
        <li class="header">Progress</li>
        <li {!! $page_num == 1 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 1)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 1)
              <i class="fa fa-check text-green"></i>
            @endif
            <span>Introduction</span>
          </a>
        </li>
        <li {!! $page_num == 2 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 2)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 2)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            
            <span>General Details</span>
          </a>
        </li>
        <li {!! $page_num == 3 ? 'class="active"' : null !!}>
          <a href="#">

            @if($page_num == 3)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 3)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            
            <span>Business Structure</span>
          </a>
        </li>
        <li {!! $page_num == 4 ? 'class="active"' : null !!}>
          <a href="#">

           @if($page_num == 4)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 4)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif

            <span>Location</span>
          </a>
        </li>                
        <li {!! $page_num == 5 ? 'class="active"' : null !!} > 
          <a href="#">
            @if($page_num == 5)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 5)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Employment Type</span>
          </a>
        </li>
        <li {!! $page_num == 6 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 6)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 6)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Salary Grade</span>
          </a>
        </li>
        <li {!! $page_num == 7 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 7)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 7)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Positions</span>
          </a>
        </li>
        <li {!! $page_num == 8 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 8)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 8)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Earnings</span>
          </a>
        </li>
        <li {!! $page_num == 9 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 9)
              <i class="fa fa-circle-o text-yellow"></i>
            @elseif($page_num > 9)
              <i class="fa fa-check text-green"></i>
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Deductions</span>
          </a>
        </li>                                                       
        <li {!! $page_num == 10 ? 'class="active"' : null !!}>
          <a href="#">
            @if($page_num == 10)
              <i class="fa fa-circle-o text-yellow"></i>            
            @else
              <i class="fa fa-circle-o"></i>
            @endif
            <span>Done!</span>
          </a>
        </li>       
      </ul>