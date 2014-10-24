<?php
class BackpropagationLayer
{
	var $backpropagation;
	var $layer;
	var $error;
	var $errorDelta;
	var $accMatrixDelta;
	var $biasRow;
	var $matrixDelta;

	function BackpropagationLayer($backpropagation,$layer)
	{
		$this->backpropagation = $backpropagation;
		$this->layer = $layer;

		$neuronCount = $layer->getNeuronCount(); 

		if ( !empty( $this->layer->next ) )
		{
			$this->accMatrixDelta=new Matrix($this->layer->getNeuronCount() + 1, $this->layer->next->getNeuronCount());
			$this->matrixDelta=new Matrix($this->layer->getNeuronCount() + 1, $this->layer->next->getNeuronCount());
			$this->biasRow=$neuronCount;
		}
	}

	function clearError()
	{
		for ($i = 0; $i < $this->layer->getNeuronCount(); $i++) {
			$this->error[$i] = 0;
		}
	}

	function calcError()
	{
		if( func_num_args()!=0 )
		{
			$args = func_get_args();
			$ideal= $args[0];

			for($i=0;$i<$this->layer->getNeuronCount();$i++)
			{
				$this->setError($i,$ideal[$i]-$this->layer->fire[$i] );
				$this->setErrorDelta($i,BoundNumbers::bound($this->calculateDelta($i)) );
				/*echo "Output = ".$this->layer->fire[$i];
				echo "<br/>Error=  ".$this->error[$i];
				echo "<br/>ErrorDelta (func) =  ".$this->errorDelta[$i];
				echo "<br/>ErrorDelta=  ".$this->getErrorDelta($i)."<br/><br/>";*/
			} 

		} 
		else
		{

			$bplnext=$this->backpropagation->getBackpropagationLayer($this->layer->next);
			for( $i=0; $i<$this->layer->next->getNeuronCount();$i++ )
			{
				for( $j=0; $j<$this->layer->getNeuronCount(); $j++ )
				{
					$this->accumulateMatrixDelta($j,$i, $bplnext->getErrorDelta($i) * $this->layer->fire[$j]);
					$this->setError($j, $this->error[$j]+$this->layer->matrix->get($j,$i)*$bplnext->getErrorDelta($i) );
					/*echo $v=$this->error[$j]+$this->layer->matrix->get($j,$i)*$bplnext->getErrorDelta($i)." &nbsp";*/
				}
				$this->accumulateThresholdDelta($i,$bplnext->getErrorDelta($i));
				//$this->accMatrixDelta->disp();
			}//echo "<br/><br/>";

			if($this->layer->isHidden())
			{
				for($i=0;$i<$this->layer->getNeuronCount();$i++ )
				{
					$this->setErrorDelta( $i,BoundNumbers::bound($this->calculateDelta($i)) );
					//echo $this->calculateDelta($i)." &nbsp";
				}//echo "<br/><br/>";
			}

		}//calceror for hidden & input

	}

	function getErrorDelta($i)
	{
		return $this->errorDelta[$i];
	}

	function calculateDelta($i)
	{
		return $this->error[$i]* $this->layer->activationFunction->derivativeFunction($this->layer->fire[$i]);
	}

	function learn($learnRate,$momentum)
	{
		if(!$this->layer->isOutput())
		{
			$m1=MatrixMath::multiply( $this->accMatrixDelta, $learnRate );
			$m2 = MatrixMath::multiply($this->matrixDelta, $momentum);
			$this->matrixDelta = MatrixMath::add($m1, $m2);
			$this->layer->matrix= MatrixMath::add( $this->layer->matrix, $this->matrixDelta );
			$this->accMatrixDelta->clear(); 
		}
	}

	function setError($index,$v)
	{
		$this->error[$index]=$v;
	}

	function setErrorDelta($index,$v)
	{
		$this->errorDelta[$index]=$v;
	}

	function accumulateMatrixDelta($r,$c,$v)
	{
		$this->accMatrixDelta->add($r, $c, $v);
	}

	function accumulateThresholdDelta($index, $v)
	{
		$this->accMatrixDelta->add($this->biasRow, $index, $v);
	}



}
?>