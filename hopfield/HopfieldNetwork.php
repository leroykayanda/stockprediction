<?php
class HopfieldNetwork
{
	var $weightMatrix;

	function HopfieldNetwork($size)
	{
		/*$arr=array(
			array(0,1,-1,-1),
			array(1,0,-1,-1),
			array(-1,-1,0,1),
			array(-1,-1,1,0)
		);*/

		$this->weightMatrix=new Matrix($size,$size);
	}

	function getMatrix() {   
		return $this->weightMatrix;
	}

	function getSize() {   
		return $this->weightMatrix->getRows();
	}

	function present($pattern)
	{
		$inputMatrix =Matrix::createRowMatrix(BiPolarUtil::bipolar2double($pattern)); 
		for($col=0;$col<count($pattern);$col++)
		{
			$columnMatrix = $this->weightMatrix->getCol($col);
			$columnMatrix = MatrixMath::transpose($columnMatrix);
			$dotProduct = MatrixMath::dotProduct($inputMatrix, $columnMatrix);

			if ($dotProduct > 0) {
				$output[$col] = true;
			} else {
				$output[$col] = -1;
			}
		}
		return $output;
	}

	function train($pattern)
	{
		try
		{
			if(count($pattern)!=$this->getSize())
			{
				$nn=$this->getSize();
				$tp=count($pattern);
				throw new Exception("Neural network($nn) not the same size as training patttern($tp)");
			}
		}catch (Exception $e) {
			echo $e->getMessage(). "<br/>"; die();
		}
		
		$m2 = Matrix::createRowMatrix(BiPolarUtil::bipolar2double($pattern));
		$m1 = MatrixMath::transpose($m2);
		$m3 = MatrixMath::multiply($m1, $m2);
		$identity = MatrixMath::identity($m3->getRows());
		$m4 = MatrixMath::subtract($m3, $identity);
		$this->weightMatrix = MatrixMath::add($this->weightMatrix, $m4);
	}


}
?>