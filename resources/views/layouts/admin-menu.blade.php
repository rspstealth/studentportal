

<div class="collapse navbar-collapse">
    <ul id="main-menu" class="main-menu">
        <!-- DASHBOARD -->
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
                <span style="">Manage Students</span>
            </a>
        </li>

        <li class="root-level <?php  (request()->segment(1) === 'staff-holidays' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/staff-holidays/list/1') }}">
                <span style="">Staff Holidays</span>
            </a>
        </li>

        <li class="root-level <?php (basename(request()->path()) === 'create-users' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/create-users') }}">
                <span style="">Create Students</span>
            </a>
        </li>
        <li class="root-level <?php  (request()->segment(1) === 'manage-users' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/manage-users') }}/list/1?t=tutors">
                <span style="">Manage Users</span>
            </a>
        </li>

        <li class="root-level <?php  (request()->segment(1) === 'task-management' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/task-management/list/1') }}">
                <span style="">Task Management</span>
            </a>
        </li>
        <li class="root-level <?php  (request()->segment(1) === 'resources' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/resources/list/1') }}">
                <span style="">Resources</span>
            </a>
        </li>
        <li class="root-level <?php  (request()->segment(1) === 'materials' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/materials/list/1') }}">
                <span style="">Materials</span>
            </a>
        </li>

        <li class="root-level <?php  (request()->segment(1) === 'courses' ? (request()->segment(2) === 'list' ? print 'active' : print ''): print ''); ?>">
            <a role="button" href="{{ url('/courses/list/1') }}">
                <span style="">Courses</span>
            </a>
        </li>
        <li class="root-level <?php (basename(request()->path()) === 'stats' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/stats') }}">
                <span style="">Stats</span>
            </a>
        </li>
        <li class="root-level <?php (basename(request()->path()) === 'health-and-well-being' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/health-and-well-being') }}">
                <span style="">Health & Well Being</span>
            </a>
        </li>
        <li class="root-level <?php (basename(request()->path()) === 'staff-area' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/staff-area') }}">
                <span style="">Staff Area</span>
            </a>
        </li>
        <li class="root-level <?php (basename(request()->path()) === 'help-centre' ? print 'active' : '');?>">
            <a role="button" href="{{ url('/help-centre/list/1') }}">
                <span style="">Help Centre</span>
            </a>
        </li>


        <li class="has-sub root-level">
            <a id="communication" class="menu_toggler" href="#">
                <span style="">Communication</span>
                <i class="fa fa-chevron-circle-up dropdown-b down-arrow"></i>
            </a>
            <ul class="sub-menu" id="communication_ul" style="<?php (request()->segment(1) === 'communication' ? print 'display:block' : print '')?>">
                <li class="<?php (request()->segment(1) === 'communication' ? (request()->segment(2) === 'automatic-emails' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/communication/automatic-emails/list/1') }}">
                        <span>  Automatic Emails</span>
                    </a>
                </li>

                <li class="<?php (request()->segment(1) === 'communication' ? (request()->segment(2) === 'automatic-sms' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/communication/automatic-sms/list/1') }}">
                        <span>  Automatic SMS</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="has-sub root-level">
            <a id="settings" class="menu_toggler" href="#">
                <span style="">Settings</span>
                <i class="fa fa-chevron-circle-up dropdown-b down-arrow"></i>
            </a>
            <ul class="sub-menu" id="settings_ul" style="<?php (request()->segment(1) === 'settings' ? print 'display:block' : print '')?>">
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'system-settings' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/system-settings/') }}">
                        <span>  System</span>
                    </a>
                </li>
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'dashboard-settings' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/system-settings/') }}">
                        <span>  Dashboard</span>
                    </a>
                </li>
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'points' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/points/') }}">
                        <span>  Points</span>
                    </a>
                </li>
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'permissions' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/permissions/') }}">
                        <span>  Permissions</span>
                    </a>
                </li>
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'task-settings' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/task-settings/') }}">
                        <span>  Task Settings</span>
                    </a>
                </li>
                <li class="<?php (request()->segment(1) === 'settings' ? (request()->segment(2) === 'donation-request-settings' ? print 'active' : print ''): print '');?>">
                    <a href="{{ url('/settings/donation-request-settings/') }}">
                        <span>  Donation Request</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
        $("#helper_menu").toggleClass("active");
        $("#main-content").toggleClass("expanded");
    });

    //changed menu toggle code, please make sure main.blade and app.blade has same menu code to perform
    $('.has-sub a').click(function (e) {
        if(e.currentTarget.className == "menu_toggler"){
            e.preventDefault();
            $('#' + e.currentTarget.id + ' .down-arrow').toggleClass('rotate');
            $('#' + e.currentTarget.id + '_ul').toggle( "fast", function() {
            });
        }
    });
</script>