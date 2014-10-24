<?php 
class XORclass
{
	var $XOR_INPUT=array(
		array(0,0),
		array(1,0),
		array(0,1),
		array(1,1)
	);
	var $XOR_IDEAL=array(
		array(0),
		array(1),
		array(1),
		array(0)
	);
	
	function main()
	{
		$net=new FeedforwardNetwork();
		$net->addLayer(new FeedforwardLayer(2)); 
		$net->addLayer(new FeedforwardLayer(3)); 
		$net->addLayer(new FeedforwardLayer(1));
		$net->reset(); 
			
		//$train = new Backpropagation($net,$this->XOR_INPUT,$this->XOR_IDEAL,0.7, 0.9);
		
		$train=new NeuralSimulatedAnnealing($net,$this->XOR_INPUT,$this->XOR_IDEAL,10,2,100);
		$epoch = 1;
		
		//$train->iteration(); 
		
		
		do
		{
			$train->iteration();
			echo "Iteration : $epoch &nbsp Error : ".$train->error."<br/>";
			$epoch++;
			
		}while($epoch<100 && $train->error>0.01 );
		//while($epoch<5000 && $train->error>0.01 );
		
		echo "<br/><br/>NEURAL NETWORK RESULTS<br/><br/>";
		for($i=0;$i< count($this->XOR_IDEAL);$i++ )
		{
			$actual=$net->computeOutputs($this->XOR_INPUT[$i] );
			echo $this->XOR_INPUT[$i][0]." &nbsp". $this->XOR_INPUT[$i][1]." = ".$actual[0]."<br/><br/>";
		}
		
		
		
	}
}
?>