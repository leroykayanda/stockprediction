<?php
class ActivationTANH
{
    function ActivationTANH()
    {

    }

    function activationFunction($x)
    {
        return ( exp(2*$x) - 1 ) / ( exp(2*$x) + 1 ) ;
    }

    function derivativeFunction ($x)
    {
        return 1-( pow( $this->activationFunction($x),2 ) );
    }
}
?>