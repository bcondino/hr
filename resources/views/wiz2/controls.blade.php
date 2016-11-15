

<div align="right">
    <div>
        <div>
            <?php
$prev = $step - 1;
$next = $step + 1;
?>
            @if($step == 8)
                <div class="button-container" align="left" style="margin-left:20px;">
                    <a href="{{ url('wiz2?step='.$prev) }}" class="uk-button">Back</a>
                    <a href="{{ url('home') }}" class="uk-button btn-add">Proceeed to Home</a>
                </div>
            @elseif($step == 0)
                <div class="button-container" align="left" style="margin-left:20px;">
                    <a href="{{ url('wiz2?step=1') }}" class="uk-button btn-add" > <span class="uk-icon uk-icon-check"></span> Proceed </a>
                    <a href="{{ url('auth/logout') }}" class="uk-button btn-cancel" id="btn-cancel" >Cancel</a>
                </div>
            @elseif($step == 1)
                <a href="{{ url('wiz2?step='.$prev) }}" class="uk-button btn" id="btn-prev" > <span class="uk-icon uk-icon-chevron-circle-left"> </span> &nbsp; </a>
                <button class="uk-button" type="submit"> <span class="uk-icon uk-icon-chevron-circle-right"></span> &nbsp;</button>
                <a href="{{ url('home') }}" class="uk-button btn-finish" id="btn-finish" >Save and Finish Later</a>
                <a href="{{ url('auth/logout') }}" class="uk-button btn-cancel" id="btn-cancel" >Cancel</a>
            @elseif($step == 2)
                <a href="{{ url('wiz2?step='.$prev) }}" class="uk-button" id="btn-prev" > <span class="uk-icon uk-icon-chevron-circle-left"> </span> &nbsp; </a>
                <a href="{{ url('wiz2?step='.$next) }}" class="uk-button" id="btn-comp-sub"> <span class="uk-icon uk-icon-chevron-circle-right"> </span> &nbsp; </a>
                <a href="{{ url('home') }}" class="uk-button btn-finish" id="btn-finish" >Save and Finish Later</a>
                <a href="{{ url('auth/logout') }}" class="uk-button btn-cancel" id="btn-cancel" >Cancel</a>
            @else
                <a href="{{ url('wiz2?step='.$prev) }}" class="uk-button" id="btn-prev"> <span class="uk-icon uk-icon-chevron-circle-left"> </span> &nbsp; </a>
                <a href="{{ url('wiz2?step='.$next) }}" class="uk-button" id="btn-comp-sub"> <span class="uk-icon uk-icon-chevron-circle-right"> </span> &nbsp; </a>
                <a href="{{ url('home') }}" class="uk-button btn-finish" id="btn-finish" >Save and Finish Later</a>
                <a href="{{ url('auth/logout') }}" class="uk-button btn-cancel" id="btn-cancel" >Cancel</a>
            @endif
        </div>
    </div>
</div>