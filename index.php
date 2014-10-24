<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' type='text/css' href='css/font-awesome.min.css'/>
        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/nav-styles.css">
        <link rel="stylesheet" href="css/style.css"/>

    </head>

    <body>
        <?php 
session_start();
/*if( !isset( $_SESSION['stock'] ) )
{
    $_SESSION['stock']="Google";
}*/
$_SESSION['stock']="Google";
        ?>

        <ul id="gn-menu" class="gn-menu-main ">
            <li class="gn-trigger left">

                <span id="open" class="logo"> <a class=""><span> <i class="icon-th-large open" ></i></span></a></span>
                <nav class="gn-menu-wrapper">
                    <!-- menu wrapper -->
                    <div class="gn-scroller">
                        <ul class="gn-menu">
                            <li>
                                <a id='sstock' class=" option darker" style="border-top:1px solid rgb(170, 170, 170);"><i class="icon-ok icon"></i> Select Stock</a>

                                <ul class="gn-submenu">
                                    <li id="click-history"><a class="gn-icon gn-icon-cog option light" id="menu-summary"><i class="icon-calendar icon"></i> Historical Data</a></li>
                                </ul>

                            <li id="click-train"><a  class="gn-icon gn-icon-cog option darker" id="last"><i class="icon-refresh icon" ></i>Train Network</a></li>
                            <li class="mymenu" id="click-evaluate" ><a class="gn-icon gn-icon-cog option light mymenu" id="last"><i class="icon-terminal icon"></i> Evaluate Network</a></li>
                            <li class="mymenu" id='click-predictions' ><a class="gn-icon gn-icon-cog option darker mymenu" id="last"><i class="icon-bar-chart icon"></i> View Predictions</a></li>

                            </li>
                        </ul><!-- /gn-menu -->
                    </div><!-- /gn-scroller -->
                <!-- menu wrapper -->
            </nav>
        </li>

    <li id="name" class="left">Stock<span id="second">Prediction <i class="icon-edit icon-laptop  mycon"></i>  </span> </li>

    <li class="right" id="selected-stock">Selected Stock: <span id="insert-stock">Google</span> (<span id="price" ></span>)</li>

    </ul>

<div id="wrapper">
    
</div>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/menus.js"></script>
<script src="js/miscellaneous.js" type="text/javascript"></script>
<script type="application/javascript" src="js/transitions.js"></script>
<script type="text/javascript" src="js/highchart/highcharts.js"></script>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->
<script type="text/javascript" src="js/charts.js"></script>

</body>

</html>