<?php
//get logged in user role
$user_role_id = Auth::user()->role_id;
//1 => student,
if($user_role_id == 1){
    ?>
    @include('layouts.student-menu')
    <?php
}
//2 => parent,
if($user_role_id == 2){
    ?>
    @include('layouts.admin-menu')
    <?php
}
//3 => teacher,
if($user_role_id == 3){
    ?>
    @include('layouts.tutor-menu')
    <?php
}
?>
