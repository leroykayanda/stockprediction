<?php
class SinWave
{
    var $actual;
    var $network;
    var $input;
    var $ideal;

    static $ACTUAL_SIZE=500;
    static $INPUT_SIZE = 5;
    static $OUTPUT_SIZE = 1;
    static $NEURONS_HIDDEN_1=7;
    static $TRAINING_SIZE=250;
    static $USE_BACKPROP=true;
    
    function main()
    {
        $wave = new SinWave();
        $wave->run();
    }

    function run()
    {
        $this->generateActual();
        $this->createNetwork();
        $this->generateTrainingSets();
        
        if( SinWave::$USE_BACKPROP )
        {
            $this->trainNetworkBackprop();
        }else
        {
            $this->trainNetworkAnneal();
        }
        $this->display();
    }
    
    function display()
    {
        $input;
        $output;
        $str="";
        
        //for($i=0;$i<6;$i++)
        for($i=0;$i<SinWave::$ACTUAL_SIZE - SinWave::$INPUT_SIZE;$i++)
        {
            $str="";
            $this->actual->getInputData($i,$input);
            $this->actual->getOutputData($i,$output);
            
            $str=$str.$i.":Actual="; 
            
            for($j=0;$j<SinWave::$OUTPUT_SIZE;$j++)
            {
                $str.=$output[$j];
            }
            
            $predict= $this->network->computeOutputs($input);
            
            $str.=" Predicted=";
            
            for($k=0;$k<SinWave::$OUTPUT_SIZE;$k++)
            {
                $str.=$predict[$k];
            }
            
            $str.=" Error=";
            
            $error = new ErrorCalculation();
            $error->updateError($predict, $output);
            
            $str.=$error->calculateRMS()."<br/>";
            
            echo $str;
            
        }//end of for
    }// end of display function
    
    function trainNetworkAnneal()
    {
        $train = new NeuralSimulatedAnnealing($this->network, $this->input, $this->ideal, 10, 2, 100);

		$epoch = 1;

		do {
			$train->iteration();
			echo "Iteration #". $epoch." Error:".$train->error."<br/>";
            $epoch++;
		} while (($train->error > 0.01) && $epoch<5000);
        echo "Iteration #". $epoch." Error:".$train->error."<br/>";
    }
    
    function generateTrainingSets()
    {
        for ($i = 0; $i < SinWave::$TRAINING_SIZE; $i++) {
			$this->actual->getInputData($i, $this->input[$i]);
			$this->actual->getOutputData($i, $this->ideal[$i]);
		} 
    }
    
    function createNetwork()
    {
        $this->network= new FeedforwardNetwork();
        $this->network->addLayer( new FeedforwardLayer( SinWave::$INPUT_SIZE ) );
        $this->network->addLayer( new FeedforwardLayer(SinWave::$NEURONS_HIDDEN_1) );
        $this->network->addLayer( new FeedforwardLayer( SinWave::$OUTPUT_SIZE ) );
        $this->network->reset(); 
    }

    function generateActual()
    { 
        $this->actual=new ActualData(SinWave::$ACTUAL_SIZE,SinWave::$INPUT_SIZE,SinWave::$OUTPUT_SIZE);
    }

    function trainNetworkBackprop()
    {
        $train = new Backpropagation($this->network, $this->input,$this->ideal, 0.001, 0.1);

        $epoch = 1;

        do {
            $train->iteration();
            echo "Iteration #". $epoch." Error:".$train->getError()."<br/>";
            $epoch++;
        } while ( ( $train->getError() > 0.01) && $epoch<5000 );
        echo "Iteration #". $epoch." Error:".$train->getError()."<br/>";
    }

}
?>