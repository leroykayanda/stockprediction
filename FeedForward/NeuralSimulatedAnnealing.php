<?php
class NeuralSimulatedAnnealing extends SimulatedAnnealing
{
	var $network;
	var $input;
	var $ideal;
	
	function NeuralSimulatedAnnealing($network,$input,$ideal,$startTemp,$stopTemp,$cycles)
	{
		$this->network=$network;
		$this->input=$input;
		$this->ideal=$ideal;
		$this->temperature=$startTemp;
		$this->setStartTemperature($startTemp);
		$this->setStopTemperature($stopTemp);
		$this->setCycles($cycles);
		//echo $this->cycles;
	}
	
	function determineError()
	{
		return $this->network->calculateError($this->input,$this->ideal);
	}
	
	function getArrayCopy()
	{
		
	}
	
	function getArray()
	{
		return MatrixCODEC::networkToArray($this->network);
	}
	
	function randomize()
	{
		$array=MatrixCODEC::networkToArray( $this->network );
		
		for($i=0;$i< count($array);$i++ )
		{
			$add=0.5-mt_rand(0,1.0*9)/10;
			$add/=$this->startTemperature;
			$add*=$this->temperature;
			$array[$i]=$array[$i]+ $add;
		}
		MatrixCODEC::arrayToNetwork($array, $this->network);
	}
	
	function putArray($array)
	{
		MatrixCODEC::arrayToNetwork($array, $this->network);
	}
	
}
?>