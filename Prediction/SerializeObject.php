<?php
class SerializeObject
{
    static function save($filename,$object)
    {
        $network_string=serialize($object);

        $myfile = fopen($filename, "w");
        fwrite($myfile, $network_string);
        fclose($myfile);
    }
    
    static function load($filename)
    {
        $myfile=fopen($filename,"r");
        $network_string=fread($myfile,filesize($filename));
        fclose($myfile);
        
        return unserialize($network_string);
    }
}
?>