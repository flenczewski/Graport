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
    
    /**
     *  Language
     */
    public $lang;

    function __construct() {
        $this->dataCenter = 'www.google.pl';
        $this->lang = 'pl';
    }


    function __destruct() {
    }


    /**
     * Grab Search Engine Result Page 
     * 
     * @param string $googleUrl  - url from $this->queryUrl()
     * 
     * @return string
     */
    private function _getGoogleResult( $googleUrl ) {
      	$rC = curl_init();
    	curl_setopt($rC, CURLOPT_HEADER, 0);
    	curl_setopt($rC, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($rC, CURLOPT_VERBOSE, 1);
    	curl_setopt($rC, CURLOPT_REFERER, $this->dataCenter);
    	curl_setopt($rC, CURLOPT_URL, $googleUrl );
    	$data = curl_exec($rC);
    	curl_close($rC);

        return $data;
    }

    /**
     * Prepare URL address
     *
     * @param string $query      - keywords
     * @param int    $num        - number of results on one page (pack size)
     * @param int 	 $start		 - start position
     *
     * @return string url
     */
    public function queryUrl( $query, $num = 10, $start = 0) {
        return 'http://'. $this->dataCenter
                    .'/search?num='. $num
                    .'&hl='. $this->lang
                    .'&q='. urlencode($query)
                    .'&lr=' . $this->lang 
                    .'&start=' . $start;
    }

}
