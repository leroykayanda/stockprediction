<?php

class FeedforwardNetwork
{
	var $inputLayer;
	var $outputLayer;
	var $layers;
	
	function FeedforwardNetwork()
	{
		
	}
	
	function addLayer($layer)
	{
		if(!empty($this->outputLayer))
		{
			$layer->setPrevious($this->outputLayer);
			$this->outputLayer->setNext($layer);
		}
		
		if(count($this->layers)==0)
		{
			$this->inputLayer=$this->outputLayer=$layer; 
		}else
		{
			$this->outputLayer=$layer; 
		}
		
		$this->layers[]=$layer; 
		
	}
	
	function computeOutputs($input)
	{
		try
		{
		if(count($input)!=$this->inputLayer->getNeuronCount())
		{
			throw new Exception("Input to Feedforward Network doesn't match number of input neurons");
		}
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
		
		$layers=$this->layers;
		foreach($layers as $layer)
		{
			if( $layer->isInput() )
			{
				$layer->computeOutputs($input);
			}else if( $layer->isHidden() )
			{
				$layer->computeOutputs();
			}
		}
		
		return $this->outputLayer->getFire();
	}
	
	function reset()
	{
		$layers=$this->layers;
		foreach($layers as $layer)
		{
			if( $layer->isInput() ||  $layer->isHidden())
			{
				$layer->reset();
			}
		}
	}
	
	function getLayers()
	{
		return $this->layers;
	}
	
	function calculateError($input,$ideal)
	{
		$errorCalculation = new ErrorCalculation();
		
		for ($i = 0; $i < count($ideal); $i++)
		{
			$this->computeOutputs($input[$i]); $out=$this->outputLayer->getFire(); 
			//echo $out[0]." ";
			$errorCalculation->updateError($this->outputLayer->getFire(),$ideal[$i]);
		}
		return ($errorCalculation->calculateRMS());
	}
	
}

?>