<?php

class FeedforwardLayer
{
	var $fire;
	var $matrix;
	var $next;//feedforward layer
	var $previous;//feedforward layer
	var $activationFunction; 
	
	function FeedforwardLayer($num)
	{
		//$this->activationFunction=new ActivationSigmoid();
        $this->activationFunction=new ActivationTANH();
		for($i=0;$i<$num;$i++)
		{
			$this->fire[]=0;
		}
	}
	
	function getNeuronCount()
	{
		return count($this->fire);
	}
	
	function setNext($inp)
	{
		$this->next=$inp; 
		$this->matrix=new Matrix( $this->getNeuronCount()+1,$this->next->getNeuronCount() );
	}
	
	function setPrevious($inp)
	{
		$this->previous=$inp;
		
	}
	
	function getFire()
	{
		return $this->fire;
	}
	
	function computeOutputs()
	{
		if( func_num_args()!=0 )
		{
			$args = func_get_args();
			$pattern = $args[0];
			for ($i = 0; $i < $this->getNeuronCount(); $i++)
			{
				$this->setFire($i,$pattern[$i]);
			}
		} //$this->matrix->disp(); echo "<br/>";
		
		$inputMatrix = $this->createInputMatrix($this->fire);
		
		for ($i = 0; $i < $this->next->getNeuronCount(); $i++)
		{
			$col=$this->matrix->getCol($i);
			$sum=MatrixMath::dotProduct($inputMatrix,$col);
			$this->next->setFire($i, $this->activationFunction->activationFunction($sum) );
			//echo $sum."<br/>";
		}
		
	}
	
	function isHidden()
	{
		return  ( (!empty($this->next)) && (!empty($this->previous)) );
	}
	
	function isInput()
	{
		return ( empty($this->previous) );
	}
	
	function isOutput()
	{
		return ( empty( $this->next ) );
	}
	
	function setFire($index,$value)
	{
		$this->fire[$index]=$value;
	}
	
	function createInputMatrix($pattern)
	{
		for($i=0;$i<count($pattern);$i++ )
		{
			$newmatrix[]=$pattern[$i];
		}
		$newmatrix[]=1;
		return Matrix::createRowMatrix($newmatrix);
	}
	
	function reset()
	{
		$this->matrix->random(-1,1);
		
		/*if($this->isInput())
		{
			$this->matrix=new Matrix(
				array(
					array(0,1,1),
					array(1,1,0),
					array(0,1,-1)
				)
			); 
		}
		
		if($this->isHidden())
		{
			$this->matrix=new Matrix(
				array(
					array(0),
					array(1),
					array(-1),
					array(0)
				)
			); 
		}*/
	}
	
}
?>