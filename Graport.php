<?php

/**
 *
 * 
 * @author  Fabian Lenczewski <fabian.lenczewski@gmail.com>
 * @since   2014-07-10
 */

class Graport
{
    function __construct()
    {

    }


    function __destruct()
    {

    }

    /**
     * Prepare URL address
     *
     * @param string $query      - keywords
     * @param string $lang       - language
     * @param int    $num        - number of results on one page
     * @param int 	 $start		 - start position
     * @param string $dataCenter - google DC
     *
     * @return string url
     */
    function queryUrl( $query, $lang = 'pl', $num = 10, $start = 0, $dataCenter = 'www.google.pl')
    {
        return 'http://'. $dataCenter .'/search?num='. $num .'&hl='. $lang .'&q='. urlencode($query) .'&lr=' . $lang . '&start=' . $start;
    }

}
