<?php
class Predict
{
    var $actual;
    var $network;
    var $input;
    var $ideal;
    var $learn_from;
    var $training_size=100;
    var $training_iterations;
    var $mode;
    static $INPUT_SIZE=10;
    static $OUTPUT_SIZE=1;
    static $NEURONS_HIDDEN_1=20;

    function Predict()
    {
        if( func_num_args()!=0 )
        {
            $args = func_get_args();

            $this->learn_from=$args[0];
            $this->training_size=$args[1];
            $this->training_iterations=$args[2];
            $this->acceptable_error=$args[3]/100;
            $this->mode=$args[4];
        }

    }

    function main()
    {
        if( func_num_args()!=0 )
        {
            $args = func_get_args();
            $mode= $args[0];
            if( strcasecmp($mode,"full")==0 )
            {
                $this->run(true);
            }
        }
        else
        {
            $this->run(false);
        }
    }

    function run($full)
    {
        $this->actual=new ActualStockData(Predict::$INPUT_SIZE,Predict::$OUTPUT_SIZE);

        $stock=$_SESSION['stock'];
        $filename= trim( strtolower($stock)."_quotes.csv" );

        $this->actual->load($filename,"rates.csv");

        if($full)
        { 
            $this->createNetwork();  
            $this->generateTrainingSets(); 
            $this->trainNetworkBackprop(); 

            if($this->mode=="Train & Save")
            {
                $this->saveNeuralNetwork();
                echo "<br/><br/><span style='font-family:lato;margin-left:140px;'>Saved</style>";
            }

        }
        else
        {
            $this->loadNeuralNetwork();
        }

        //$this->display();
    }

    function saveNeuralNetwork()
    {
        $stock=$_SESSION['stock'];
        $filename= trim( strtolower($stock).".txt" );

        SerializeObject::save( $filename,$this->network );
    }

    function loadNeuralNetwork()
    {
        $stock=$_SESSION['stock'];
        $filename= trim( strtolower($stock).".txt" );
        $this->network = SerializeObject::load($filename);
    }

    function createNetwork()
    {
        $this->network = new FeedforwardNetwork();
        $this->network->addlayer( new FeedforwardLayer( Predict::$INPUT_SIZE*2 ) );
        $this->network->addlayer( new FeedforwardLayer( Predict::$NEURONS_HIDDEN_1 ) );
        $this->network->addlayer( new FeedforwardLayer( Predict::$OUTPUT_SIZE ) );

        $this->network->reset();  
    }

    function generateTrainingSets()
    {
        $samples=$this->actual->getSamples();
        $flag=false;
        $trained=0;

        for($i=0;$i<count( $samples );$i++)
        {

            if( strtotime($samples[$i]->getDate()) >= strtotime( $this->learn_from ) )
            {
                if( count($samples) < (($i+$this->training_size)-1)+ Predict::$INPUT_SIZE+Predict::$OUTPUT_SIZE && !$flag )
                    /*if( count($samples) - ($i) < $this->training_size && !$flag)*/
                {
                    echo "Training data is not enough.<br/>Reduce either training size or learn from date.";
                    break;
                }
                else
                {
                    $flag=true;

                    if( $trained < $this->training_size )
                    {
                        $this->actual->getInputData( $i, $this->input[$trained] );
                        $this->actual->getOutputData( $i, $this->ideal[$trained] );

                        $trained++;
                    }
                    else
                    {
                        $this->learnFrom=$samples[$i]->getDate();
                        break;
                    }
                }

            }
        }//for
    }//end of generateTrainingSets

    function trainNetworkBackprop()
    {
        $train= new Backpropagation($this->network,$this->input,$this->ideal,0.00001, 0.1);
        $lastError=1000000;
        $epoch=1;
        $lastAnneal=0;

        echo '<table id="training-table">';        

        echo '<tr id="theader"> <td>iteration</td> <td> error </td> </tr>';

        do
        {
            $train->iteration();
            $error=$train->getError();
            echo "<tr> <td>".$epoch." (Backpropagation) </td> <td>".$error."</td></tr>";

            if( $lastAnneal>50 && ( $error > $lastError || abs($error-$lastError) <0.0001 ) )
            {
                $this->trainNetworkAnneal();
                $lastAnneal=0;
            }

            $lastError = $train->getError();
            $epoch++;
            $lastAnneal++;

        }while( $train->getError() > $this->acceptable_error && $epoch< $this->training_iterations );

        echo '</table>';
    }

    function trainNetworkAnneal()
    {
        $train = new NeuralSimulatedAnnealing( $this->network, $this->input, $this->ideal,10, 2, 100);
        $epoch=1;

        for($i=1;$i<6;$i++)
        {
            $train->iteration();
            $error=$train->getError();
            echo "<tr class='sim'> <td>".$epoch." (<b>Simulated Annealing</b>) </td> <td><b>".$error."</b></td></tr>";
            $epoch++;
        }

    }

    function display()
    {
        $index=0;

        echo '<table id="evaluate-table">';
        $stock=$_SESSION['stock'];

        echo '<caption>Evaluating network to predict '.$stock.' stock</caption>';
        echo "<tr id='theader'> <td> Date </td> <td> Stock Price </td> <td> Actual % Change </td> <td> Predicted % Change </td> <td> Error </td> </tr>";

        $samples=$this->actual->getSamples();
        for($i=0;$i<count($samples);$i++)
        {
            if( strtotime($samples[$i]->getDate()) >= strtotime( $this->learn_from ) )
            {
                $index++;
            }

            if($index > $this->training_size )
            {
                echo "<tr>";
                
                $present=array();
                $predict=array();
                $actualOutput=array();

                echo "<td>".$samples[$i]->getDate()."</td>";
                echo "<td>".$samples[$i]->getAmount()."</td>";

                $this->actual->getInputData( ( $i - Predict::$INPUT_SIZE ) ,$present);
                $this->actual->getOutputData( ( $i - Predict::$INPUT_SIZE ) ,$actualOutput);

                echo "<td>".$actualOutput[0]."</td>";

                $predict = $this->network->computeOutputs($present);
                echo "<td>".$predict[0] ."</td>";

                $error = new ErrorCalculation();
                $error->updateError($predict, $actualOutput);
                echo "<td>".$error->calculateRMS()."</td>";

                echo "</tr>";
            }

        }
        echo '</table> ';

    }

}
?>