<?php
abstract class SimulatedAnnealing
{
	var $startTemperature;
	var $stopTemperature;
	var $cycles;
	var $error;
	var $temperature;
	
	function setStartTemperature($startTemperature)
	{
		$this->startTemperature=$startTemperature;
	}
	
	function setStopTemperature($stopTemperature)
	{
		$this->stopTemperature=$stopTemperature;
	}
	
	function setCycles($cycles)
	{
		$this->cycles=$cycles;
	}
	
	function iteration()
	{
		$this->setError($this->determineError() );
		$bestArray=$this->getArray();
		$this->temperature=$this->startTemperature; 
		
		/*$array=MatrixCODEC::networkToArray( $this->network );
		for($i=0;$i< count($array);$i++ )
		{
			echo $array[$i]." &nbsp";
		}echo "<br/><br/>";
		$this->randomize();
		
		$array=MatrixCODEC::networkToArray( $this->network );
		for($i=0;$i< count($array);$i++ )
		{
			echo $array[$i]." &nbsp";
		}echo "<br/><br/>";*/
		
		for($i=0;$i<$this->cycles;$i++)
		{
			$this->randomize();
			$curError = $this->determineError();
			
			if($curError<$this->error)
			{
				$bestArray=$this->getArray();
				$this->error=$curError;
			}
			$this->putArray($bestArray);
			$ratio=exp( log($this->startTemperature/$this->stopTemperature)/($this->cycles-1) );
			$this->temperature *= $ratio;
			
		}
	}
	
	abstract function determineError();
	
	abstract function getArrayCopy();
	
	abstract function getArray();
	
	abstract function putArray($array);
	
	abstract function randomize();
	
	function setError($error)
	{
		$this->error=$error;
	}
    
    function getError()
    {
        return $this->error;
    }
}
?>