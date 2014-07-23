<?php
/** Created by griga at 20.05.2014 | 9:00.
 * 
 */

function uncamelize($camel,$splitter="_") {
    $camel=preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter.'$0', $camel));
    return strtolower($camel);
}

function underscore_case($string){
    return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
}
/**
 * Generate Float Random Number
 *
 * @param float $min Minimal value
 * @param float $max Maximal value
 * @param int $round The optional number of decimal digits to round to. default 0 means not round
 * @return float Random float value
 */
function float_rand($min, $max, $round = 0)
{
    //swap variables if needed
    if ($min > $max) {
        list($min,$max) = array($max,$min);
    }
    $randomFloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    if ($round > 0)
        $randomFloat = round($randomFloat, $round);

    return $randomFloat;
}