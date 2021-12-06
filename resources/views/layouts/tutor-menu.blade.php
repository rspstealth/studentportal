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

        <li class="root-level <?php  (request()->segment(1) === 'students' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/students/list/1') }}">
                <span style="">Manage Users</span>
            </a>
        </li>

        <li class="root-level <?php  (request()->segment(1) === 'marking' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/marking/list/1?q=priority_students') }}">
                <span style="">Marking</span>
            </a>
        </li>

            <li class="root-level <?php  (request()->segment(1) === 'help-centre' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
                <a role="button" href="{{ url('/help-centre/list/1') }}">
                    <span style="">Help Centre</span>
                </a>
            </li>

        <li class="root-level <?php  (request()->segment(1) === 'task-management' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/task-management/list/1') }}">
                <span style="">Task Management</span>
            </a>
        </li>




        <li class="root-level <?php  (request()->segment(1) === 'revenue' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/revenue/list/1') }}">
                <span style="">Revenue</span>
            </a>
        </li>

        <li class="root-level <?php (basename(request()->path()) === 'request-holidays' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/request-holidays/') }}">
                <span style="">Holidays</span>
            </a>
        </li>

        <li class="root-level <?php (basename(request()->path()) === 'staff-area' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/staff-area') }}">
                <span style="">Staff Area</span>
            </a>
        </li>
    </ul>
</div>