<?php
$d = array();
foreach(array_count_values($arr) as $v=>$c){
    if($c > 1){
        $d[] = $v;
    }
}
$t = array_count_values($arr);
$mc = $t[max($d)];
if(max($d) === $mc){
    return max($d);
}else{
    return -1;
}