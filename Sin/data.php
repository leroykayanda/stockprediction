<?php

$arr=array();
$angle=0;

function sinDEG($deg)
{
    $rad=$deg * (M_PI/180);
    $result=sin($rad);  
    return ( (int) ($result * 100000.0) )/ 100000.0;
}

for($i=0;$i<100;$i++)
{
    $arr[]=array($angle,sinDEG($angle));
    $angle+=10;
}

$arr2=array("data"=>$arr);

echo json_encode($arr2);

?>