<?php
class Backpropagation implements Train
{
	var $error;
	var $learnRate;
	var $momentum;
	var $network;
	var $input;
	var $ideal;
	var $layerMap;

	function Backpropagation($network,$input,$ideal,$learnRate,$momentum)
	{
		$this->network=$network;
		$this->input=$input;
		$this->ideal=$ideal;
		$this->learnRate=$learnRate;
		$this->momentum=$momentum;

		$layers=$this->network->getLayers();
		foreach($layers as $layer)
		{
			$bpl = new BackpropagationLayer($this,$layer);
			$this->layerMap[spl_object_hash($layer)]=$bpl;
		}
	}

	function getError()
	{
		return $this->error;
	}
	function iteration()
	{
		for ($j = 0; $j <count($this->input); $j++)
		{
			$this->network->computeOutputs($this->input[$j]);
			$this->calcError($this->ideal[$j]);
		}

		$this->learn();

		$this->error = $this->network->calculateError($this->input, $this->ideal); 
	}

	function calcError($ideal)
	{
		try
		{
			if( $this->network->outputLayer->getNeuronCount() != count($ideal) )
			{
				throw new Exception("Problem with calcErrorFunction func in BP class: No. of Output neurons doesnt match size of ideal output array given");
			}
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}

		$layers=$this->network->getLayers();
		foreach($layers as $layer)
		{
			$obj=$this->getBackpropagationLayer($layer)->clearError(); 
		}

		for ($i = count( $this->network->getLayers() ) - 1; $i >= 0; $i--)
		{
			$layer = $this->network->layers[$i]; 
			if($layer->isOutput() )
			{
				$this->getBackpropagationLayer($layer)->calcError($ideal);
			}else
			{
				$this->getBackpropagationLayer($layer)->calcError();
			}
		}

	}

	function getBackpropagationLayer($layer)
	{
		$bpl=$this->layerMap[spl_object_hash($layer)];

		try
		{
			if( empty($bpl) )
			{
				throw new Exception("Backpropagation layer doesnt exist");
			}
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}

		return $bpl;
	}

	function learn()
	{
		$layers=$this->network->getLayers();
		foreach($layers as $layer)
		{
			$this->getBackpropagationLayer($layer)->learn($this->learnRate,$this->momentum);
		}
	}

	}
?>