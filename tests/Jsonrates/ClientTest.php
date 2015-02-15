<?php

namespace Jsonrates;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $jr;
    
    protected function setUp()
    {
        $this->jr = new Client();
    }
    
    public function testRateForSameCurrenciesIsExactlyOne()
    {
        $result = $this->jr
            ->from('EUR')
            ->to('EUR')
            ->get();
        
        $this->assertSame('1.00000000', $result['rate']);
    }
}