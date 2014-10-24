<?php
set_time_limit(0);

session_start();

function loader1($class_name) {
    $filename='matrix/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

function loader2($class_name) {
    $filename='hopfield/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

function loader3($class_name) {
    $filename='FeedForward/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

function loader4($class_name) {
    $filename='Sin/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

function loader5($class_name) {
    $filename='Prediction/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

function loader6($class_name) {
    $filename='SupportingClasses/'.$class_name . '.php';
    if(!file_exists($filename))
    {
        return false;
    }
    include $filename;
}

spl_autoload_register('loader1');
spl_autoload_register('loader2');
spl_autoload_register('loader3');
spl_autoload_register('loader4');
spl_autoload_register('loader5');
spl_autoload_register('loader6');

if( isset($_GET['call']) )
{
    $func=$_GET['call'];
}
else
{
    $func="";
}

if($func=="getSelectStock")
{
    (new GetContent())->getSelectStock();
}

if($func=="getStockName")
{
    $_SESSION['stock']=$_GET['stock'];
}

if($func=="getYAxis")
{
    (new GetContent())->getYAxis();
}

if($func=="getStockPrice")
{
    (new GetContent())->getStockPrice();
}

if($func=="getHistoryPage")
{
    (new GetContent())->getHistoryPage();
}

if($func=="getTrainPage")
{
    (new GetContent())->getTrainPage();
}

if($func=="getEvaluatePage")
{
    (new GetContent())->getEvaluatePage();
}

if($func=="getPredictPage")
{
    (new GetContent())->getPredictPage();
}

if($func=="getPredictData")
{
    (new GetContent())->getPredictData();
}

?>