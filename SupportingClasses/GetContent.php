<?php
class GetContent
{
    function getSelectStock()
    {
        echo '<div id="select-wrapper">
        <div class="small-3 columns x">
            <div class="title">Select Stock <i class="icon-ok titleicons specialicon"></i> </div>

            <ul id="stocks-list">
                <li><i style="display:block;" class="icon-ok-circle"></i> <span>Google</span></li>
                <li><i class="icon-ok-circle"></i><span>Apple</span></li>
                <li><i class="icon-ok-circle"></i><span>Facebook</span></li>
                <li><i class="icon-ok-circle"></i><span>Microsoft</span></li>
                <li><i class="icon-ok-circle"></i><span>Cisco</span></li>
            </ul>

        </div>
        <div class="small-9 columns y">
            <div id="y-inner">
                <div class="title">real time prices <i class="icon-exchange titleicons"></i></div>

                <div id="rt-chart"></div>
            </div>
        </div>
    </div>';

        //echo "stock data page";
    }

    function getHistoryPage()
    {
        echo '<table id="historical-table">';        

        $stock=$_SESSION['stock'];

        echo '<caption>Historical Data for '.$stock.'</caption>';
        echo '<tr id="theader"><td>date</td> <td>open</td> <td>high</td> <td>low</td> <td>adj close</td> </tr>';

        $filename= trim( strtolower($stock)."_quotes.csv" );

        $reader=new ReadCSV($filename);

        $index=0;
        while( $reader->next() && $index<100)
        {
            echo '<tr><td>'.$reader->getDate().'</td><td>'.$reader->get("open").'</td><td>'.$reader->get("high").'</td><td>'.$reader->get("low").'</td><td>'.$reader->get("adj close").'</td></tr>';
            $index++;
        }

        echo '</table> ';
    }


    function getYAxis()
    {
        $arr=array();
        $stock=$_SESSION['stock'];
        date_default_timezone_set("Africa/Nairobi");
        $t=time()*1000;

        $filename= trim( strtolower($stock)."_quotes_reversed.csv" );    

        $reader=new ReadCSV($filename);
        $index=-19;

        while($reader->next() && $index<=0)
        {
            $arr[]=array( "x"=>($t+1000*$index), "y" => floatval( $reader->get("close") ) );
            $index++;
        }


        echo json_encode($arr);
    }

    function getStockPrice()
    {
        $stock=$_SESSION['stock'];

        if(trim($stock)=="Google")
        {
            $symbol="GOOGL";
        }

        if(trim($stock)=="Apple")
        {
            $symbol="AAPL";
        }

        if(trim($stock)=="Facebook")
        {
            $symbol="FB";
        }

        if(trim($stock)=="Microsoft")
        {
            $symbol="MSFT";
        }

        if(trim($stock)=="Cisco")
        {
            $symbol="CSCO";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://query.yahooapis.com/v1/public/yql?q=select%20AskRealtime%20from%20yahoo.finance.quotes%20where%20symbol%3D%22'.$symbol.'%22%0A%09%09&format=json&env=http%3A%2F%2Fdatatables.org%2Falltables.env'
            //,CURLOPT_CONNECTTIMEOUT => 0
        ));

        $result=curl_exec($curl);

        if( !curl_errno($curl) )
        {

            $phpObj =  json_decode($result); 

            if( is_object($phpObj) && is_object($phpObj->query) )
            {
                $price=$phpObj->query->results->quote->AskRealtime;
                $lastPrice=$price;
                echo $price;
            }

        }

        curl_close ($curl);

    }

    function getTrainPage()
    {
        $stock=$_SESSION['stock'];
        $filename= trim( strtolower($stock)."_quotes.csv" );
        $reader=new ReadCSV($filename);
        $index=0; $index2=0;

        while($reader->next() && $index<1)
        {
            $start_date=$reader->getDate();
            $start_date=strtotime($start_date);
            $start_date=date("F jS Y", $start_date);
            $index++;
        }

        $filename= trim( strtolower($stock)."_quotes_reversed.csv" );
        $reader=new ReadCSV($filename);

        while($reader->next() && $index2<1)
        {
            $end_date=$reader->getDate();
            $end_date=strtotime($end_date);
            $end_date=date("F jS Y", $end_date);
            $index2++;
        }

        echo '
            <div id="train-wrapper">

    <div id="train-left" class="small-5 columns">

        <div id="small-header">available stock data</div>
        <div class="date">'.$start_date.'</div>
        <div id="dots">.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/>.<br/></div>
        <div class="date">'.$end_date.'</div>

    </div>

    <div id="train-right" class="small-7 columns">
        <form class="custom" id="train_form" method="POST" action="train.php" target="_blank">
            <fieldset>
                <legend>
                    Training Parameters
                </legend> 

                <div class="small-10">
                    <div class="row">
                        <div class="small-5 columns">
                            <label for="tfrom" class="right inline">Train From:</label>
                        </div>
                        <div class="small-7 columns">
                            <input type="date" name="tfrom" required/>
                        </div>
                    </div>
                </div>

                <div class="small-10">
                    <div class="row">
                        <div class="small-5 columns">
                            <label for="tset" class="right inline">Training Set Size:</label>
                        </div>
                        <div class="small-7 columns">
                            <input type="text" name="tset" onkeyup="enterNumber(this);" onblur="enterNumber(this);" required/>
                        </div>
                    </div>
                </div>

                <div class="small-10">
                    <div class="row">
                        <div class="small-5 columns">
                            <label for="iterations" class="right inline">Training Iterations:</label>
                        </div>
                        <div class="small-7 columns">
                            <input type="text" name="iterations" onkeyup="enterNumber(this);" onblur="enterNumber(this);" required/>
                        </div>
                    </div>
                </div>

                <div class="small-10">
                    <div class="row">
                        <div class="small-5 columns">
                            <label for="error" class="right inline">Acceptable Error:</label>
                        </div>
                        <div class="small-7 columns">
                            <input type="text" name="error" onkeyup="enterNumber(this);" onblur="enterNumber(this);" required/>
                        </div>
                    </div>
                </div>

                <div class="small-10 sub">

                    <input id="submit1" class="send" type="submit" name="train" value="Train & Save">
                    <input id="submit2" class="send" type="submit" name="train" value="Just Train">

                </div>

            </fieldset>
        </form>
    </div>

    </div>
        ';
    }

    function getEvaluatePage()
    {
        $predict=new Predict();
        $predict->main();
        $predict->display();
    }

    function getPredictPage()
    { 
        echo '
    <div id="predict-wrapper">
        <div id="predict-periods">
            <span class="pbutton week" id="first-button" >next 1 week</span>
            <span class="pbutton month">next 1 month</span>
            <span class="pbutton year">next 1 year</span>
        </div>

        <div id="predict-graphs">

        </div>

    </div>
        ';
    }

    function getPredictData()
    {
        $stock=$_SESSION['stock'];
        $filename= trim( strtolower($stock)."_quotes_reversed.csv" );
        $reader=new ReadCSV($filename);
        $index=0;

        while($reader->next() && $index<1)
        {
            $predict_from=$reader->getDate();
            $start_amount=$reader->get("adj close");
            $index++;
        } 

        $date = new DateTime($predict_from);
        $start_from=$date->getTimestamp()*1000;

        $period=$_GET['time'];
        $result=array();
        $input_data=array();
        $predict_input=array();

        $predict=new Predict();
        $predict->main();
        $samples=$predict->actual->getSamples();

        for( $i=( count($samples) - Predict::$INPUT_SIZE ); $i < count($samples); $i++)
        {
            $input_data[]=$samples[$i]->getPercent();
            $input_data[]= floatval ( $predict->actual->getPrimeRate( $samples[$i]->getDate() ) );
        } 

        for( $i=(Predict::$INPUT_SIZE*2); $i < (Predict::$INPUT_SIZE*2)+$period; $i++ )
        { 
            $predict_input=array();

            for( $j=($i-Predict::$INPUT_SIZE*2); $j<$i; $j++  )
            {
                $predict_input[]=$input_data[$j];

            }

            $output=$predict->network->computeOutputs($predict_input);
            $result[]=$output[0];
            $input_data[]=$output[0];

        } 
        
        $result[0]=$result[0]+$start_amount;
        
        for( $i=1; $i<count($result); $i++ )
        {
            $result[$i]=$result[$i]+$result[$i-1];
        }
        
        $final_result=array( $start_from, $result );
        
        echo json_encode($final_result);

    }

}
?>