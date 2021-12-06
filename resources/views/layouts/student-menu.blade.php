

<div class="collapse navbar-collapse">
    <ul id="main-menu" class="main-menu">
        <?php
        if(basename(request()->path()) === 'dashboard'){
            $active = 'active';
        }else{
            $active = '';
        }
        ?>
        <li class="root-level {{$active}}">
            <a role="button" href="{{ url('/dashboard') }}">
                <span style="">Dashboard</span>
            </a>
        </li>

        <li class="root-level <?php  (request()->segment(1) === 'my-courses' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/my-courses/list/1') }}">
                <span style="">My Courses</span>
            </a>
        </li>


            <li class="root-level <?php  (request()->segment(1) === 'resources' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
                <a role="button" href="{{ url('/resources/list/1') }}">
                    <span style="">Resources</span>
                </a>
            </li>



        <li class="root-level <?php  (request()->segment(1) === 'help-centre' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/help-centre/list/1') }}">
                <span style="">Help Centre</span>
            </a>
        </li>
    </ul>
</div>