<?php
class MatrixCODEC
{
	static function arrayToNetwork($array,$network)
	{
		$index=0;
		
		$layers=$network->layers;
		foreach($layers as $layer)
		{
			if( !$layer->isOutput() )
			{
				$index=$layer->matrix->fromPackedArray($array,$index);
			}
		}
		
	}
	
	static function networkToArray($network)
	{
		$result;
		$layers=$network->layers;
		foreach($layers as $layer)
		{
			if( !$layer->isOutput() )
			{
				$matrix=$layer->matrix->toPackedArray();
				for($i=0;$i< count($matrix);$i++ )
				{
					$result[]=$matrix[$i];
				}
			}
		}
		
		return $result;
		
	}
	
}
?>