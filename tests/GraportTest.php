<?php
/**
 * Created by PhpStorm.
 * User: fabian
 * Date: 2014-07-15
 * Time: 21:19
 */

class GraportTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Graport
     */
    protected $graport;

    public function testClassExists()
    {
        $this->assertTrue(class_exists('Graport'));
    }

    public function setUp()
    {
        $this->graport = new Graport;
    }

    public function providerQueryUrl()
    {
        return array(
            array('TestKeyword#1', 10, 0),
            array('TestKeyword#2', 10, 10),
            array('TestKeyword#3', 100, 10),
        );
    }

    /**
     * @dataProvider providerQueryUrl
     */
    public function testQueryUrl($keyword, $num, $start)
    {
        $url = $this->graport->queryUrl($keyword, $num, $start);

        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $query);

        $this->assertEquals($this->graport->dataCenter, $parsedUrl['host']);
        $this->assertEquals('/search', $parsedUrl['path']);
        $this->assertEquals($keyword, $query['q']);
        $this->assertEquals($this->graport->lang, $query['hl']);
        $this->assertEquals($this->graport->lang, $query['lr']);
        $this->assertGreaterThan(0, intval($query['num']));
        $this->assertEquals($num, intval($query['num']));
        $this->assertGreaterThanOrEqual(0, intval($query['start']));
        $this->assertEquals($start, intval($query['start']));
    }

    public function testGetGoogleResult()
    {
        $this->assertEquals(1, $this->graport->getPosition('graport.info', 'graport.info'));
    }
}
 