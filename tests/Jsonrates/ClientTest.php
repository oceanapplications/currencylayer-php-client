<?php

namespace Jsonrates;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $jr;
    
    protected function setUp()
    {
        $this->jr = new Client('jr-demo-54beb0044ee6a01f303c798d89e');
    }
    
    public function testRateForSameCurrenciesIsExactlyOne()
    {
        $result = $this->jr
            ->from('EUR')
            ->to('EUR')
            ->get();
        
        $this->assertSame('1.00000000', $result['rate']);
    }
    
    public function testValidFromToRateHasEightDecimalPlaces()
    {
        $result = $this->jr
            ->from('XBT')
            ->to('GBP')
            ->get();
        
        $this->assertSame(8, strlen(substr($result['rate'], strpos($result['rate'], '.') + 1)));
    }
    
    public function testAllCurrenciesForABaseIsALargeList()
    {
        $result = $this->jr
            ->base('JPY')
            ->get();
        
        $this->assertGreaterThan(150, $result['rates']);
    }
    
    public function testUnknownCurrencyForGetDeliversAnError()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        $result = $this->jr
            ->from('USD')
            ->to('EURR')
            ->get();
    }
    
    public function testConvertingOneXBTToUSD()
    {
        $result = $this->jr
            ->from('XBT')
            ->to('USD')
            ->amount(1)
            ->convert();
        
        $this->assertGreaterThan(100, $result['amount']);
        $this->assertContains('.', $result['amount']);
    }
    
    public function testConvertingInverseIsSameAsContraryNotInverse()
    {
        $resultInverse = $this->jr
            ->from('JOD')
            ->to('MAD')
            ->amount(6.75)
            ->inverse('yes')
            ->convert();
        $resultNotInverse = $this->jr
            ->from('MAD')
            ->to('JOD')
            ->amount(6.75)
            ->inverse('no')
            ->convert();
        
        $this->assertSame(substr($resultInverse['amount'], 0, 8), substr($resultNotInverse['amount'], 0, 8));
    }
    
    public function testHistoricalRateForSpecificCurrenciesIsAlwaysTheSame()
    {
        $result = $this->jr
            ->from('JPY')
            ->to('SAR')
            ->date('2015-01-01')
            ->historical();
        
        $this->assertSame('0.03132084', $result['rates']['2015-01-01']['rate']);
        $this->assertSame('2015-01-01T23:50:02+01:00', $result['rates']['2015-01-01']['utctime']);
    }
    
    public function testHistoricalRatesForFourDaysGetsFourResultObjects()
    {
        $result = $this->jr
            ->from('JPY')
            ->to('SAR')
            ->dateStart('2015-01-01')
            ->dateEnd('2015-01-04')
            ->historical();
        
        $this->assertCount(4, $result['rates']);
        $this->assertSame('0.03115948', $result['rates']['2015-01-02']['rate']);
        $this->assertSame('2015-01-03T23:50:02+01:00', $result['rates']['2015-01-03']['utctime']);
        $this->assertNotNull($result['rates']['2015-01-04']);
    }
    
    public function testHistoricalRatesWithPeriodForFiveMonthsGetsFiveResultObjects()
    {
        $result = $this->jr
            ->from('GBP')
            ->to('EUR')
            ->dateStart('2014-10-10')
            ->dateEnd('2015-02-10')
            ->period('month')
            ->historical();
        
        $this->assertCount(5, $result['rates']);
        $this->assertNotNull($result['rates']['2014-10-10']);
        $this->assertNotNull($result['rates']['2014-11-10']);
        $this->assertNotNull($result['rates']['2014-12-10']);
        $this->assertNotNull($result['rates']['2015-01-10']);
        $this->assertNotNull($result['rates']['2015-02-10']);
    }
    
    public function testRateForSameLocalesIsExactlyOne()
    {
        $result = $this->jr
            ->from('de_DE')
            ->to('de_DE')
            ->locale();
        
        $this->assertSame('1.00000000', $result['rate']);
    }
    
    public function testRateForTwoValidLocalesHasEightDecimalPlaces()
    {
        $result = $this->jr
            ->from('de_DE')
            ->to('en_US')
            ->locale();
        
        $this->assertSame(8, strlen(substr($result['rate'], strpos($result['rate'], '.') + 1)));
    }

	public function testCurrencyList()
	{
		// TODO write test for Client::currencies method
	}
}