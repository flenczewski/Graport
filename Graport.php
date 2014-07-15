<?php

/**
 *
 * 
 * @author  Fabian Lenczewski <fabian.lenczewski@gmail.com>
 * @since   2014-07-10
 */

class Graport
{
    /**
     *  Google DC
     */
    public $dataCenter;
    
    function __construct() {
        $this->dataCenter = 'www.google.pl';
    }


    function __destruct() {
    }

    /**
     * Prepare URL address
     *
     * @param string $query      - keywords
     * @param string $lang       - language
     * @param int    $num        - number of results on one page (pack size)
     * @param int 	 $start		 - start position
     *
     * @return string url
     */
    function queryUrl( $query, $lang = 'pl', $num = 10, $start = 0) {
        return 'http://'. $this->dataCenter .'/search?num='. $num .'&hl='. $lang .'&q='. urlencode($query) .'&lr=' . $lang . '&start=' . $start;
    }

}
