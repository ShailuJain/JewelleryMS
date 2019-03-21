<?php
require_once '../core/constants.php';

/**
 * THis function is basically a utility function which is used to convert associativeArray
 * into the query format used for insertion and updating. (in prepared statement format)
 * @param $associativeArray - array to be converted
 * @param $constant - to specify the format.
 * @return string - return the columns and values in insert or update query format
 */
function getString($associativeArray, $constant){
    $numKeys = count($associativeArray);
    $keys = array_keys($associativeArray);
    if($constant==INSERT_QUERY_FORMAT){
        $string="(";
        $string1="(";
        for($i=0; $i < $numKeys; ++$i)
        {
            $string.="$keys[$i],";
            $string1.="?,";
        }
        $string[strlen($string)-1]=")";
        $string1[strlen($string1)-1]=")";
        $string.=" VALUES ".$string1;
    }
    else if($constant==UPDATE_QUERY_FORMAT){
        $string="";
        for($i=0; $i < $numKeys; ++$i) {
            $string.="$keys[$i] = ?";
            if($i!=$numKeys-1)
                $string.=",";
        }
    }
    return $string;
}