<?php

/**
 * Check your website position in Google SERP
 * 
 * @author  Fabian Lenczewski <fabian.lenczewski@gmail.com>
 * @since   2014-07-10
 */

class Graport
{
    /**
     *  Google DC
     */
    public $dataCenter = 'www.google.pl';
    
    /**
     *  Language
     */
    public $lang = 'pl';

    /**
     *  SERP packsize on one page
     */
    public $packSize = 10;

    /**
     *  SERP pages
     */
    public $pages = 10;

    /**
     * @var string
     */
    private $_positionPattern = '/<h3 class="r"><a href="([^"]+)"/';

    function __construct() {
    }

    function __destruct() {
    }

    /**
     * Get URL position in SERP
     *
     * @param $url
     * @param $keyword
     *
     * @return int|null
     */
    public function getPosition($url, $keyword)
    {
        $startPosition = 0;

        for($pack = 0; $pack < $this->pages; $pack++) {

            // prepare SERP URL
            $queryUrl = $this->queryUrl($keyword, $this->packSize, $startPosition);

            // getting data
            $data = $this->_getGoogleResult( $queryUrl );

            preg_match_all($this->_positionPattern, $data, $matches);
            $matches = array_pop($matches);

            foreach($matches as $key => $value) {

                $serpRowUrl = parse_url($value);
                parse_str($serpRowUrl['query'], $serpRowUrlParams);
                $rowUrl = parse_url($serpRowUrlParams['q']);

                if($rowUrl['host'] == $url) {
                    $result = $startPosition + $key + 1;
                    break;
                }
            }

            if(isset($result)) {
                break;
            } else {
                $startPosition = $this->packSize * $pack;
            }
        }

        return isset($result) ? $result : null;
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
