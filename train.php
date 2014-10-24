<html>
    <head>
        <link rel='stylesheet' type='text/css' href='css/font-awesome.min.css'/>
        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/nav-styles.css">
        <link rel="stylesheet" href="css/style.css"/>
    </head>

    <body>
        <?php
include 'driver.php';

$train_from=$_POST['tfrom']; 
$training_size=$_POST['tset']; 
$training_iterations=$_POST['iterations']; 
$mode=$_POST['train']; 
$acceptable_error=$_POST['error'];
        ?>

        <ul id="gn-menu" class="gn-menu-main ">
            <li class="gn-trigger left">
                <span id="open" class="logo"> <a class=""><span> <i class="icon-th-large open" ></i></span></a></span>
            </li>

            <li id="name" class="left">Stock<span id="second">Prediction <i class="icon-edit icon-laptop  mycon"></i> </span></li>

        </ul>
        <div style="clear:both;margin-top:100px;"></div>

        <?php
$stock=$_SESSION['stock'];
$filename= trim( strtolower($stock)."_quotes.csv" );
$reader=new ReadCSV($filename);
$index=0; 

while($reader->next() && $index<1)
{
    $first_date=$reader->getDate();
    $index++;
}

$filename= trim( strtolower($stock)."_quotes_reversed.csv" );
$reader=new ReadCSV($filename);
$index2=0; 

while($reader->next() && $index2<1)
{
    $last_date=$reader->getDate();
    $index2++;
}

$first_date."<br/><br/>".$last_date;
if( strtotime($train_from) <  strtotime($first_date) ||  strtotime($train_from) >  strtotime($last_date) )
{
    die( "Date given is out of stock data range" );
}

$predict=new Predict($train_from,$training_size,$training_iterations,$acceptable_error,$mode );
$predict->main("full");
        ?>
    </body>

</html>


