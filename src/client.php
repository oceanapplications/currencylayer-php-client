<?php

namespace currencylayer;

/**
 * PHP client for the currencylayer API
 * 
 * @version 1.3.1
 * @link https://currencylayer.com/
 */
class client
{
	
    /**
     * API base URL
     */
    const ENDPOINT = 'http://apilayer.net/api';
    
    /**
     * API endpoint parameters
     */
    private $source = null;
    private $currencies = null;
    private $from = null;
    private $to = null;
    private $amount = null;
    private $date = null;
    private $start_date = null;
    private $end_date = null;
    private $access_key = null;
    
    /**
     * Constructor
     * 
     * @param string $access_key
     */
    public function __construct($access_key = null)
    {
        $this->access_key = $access_key;
    }
        
    /**
     * Request the API's "live" endpoint
     * 
     * @return array
     */
    public function live()
    {
        return $this->request('/live', array(
            'currencies' => $this->currencies,
            'source' => $this->source
        ));
    }
    
    /**
     * Request the API's "convert" endpoint
     * 
     * @return array
     */
    public function convert()
    {
        return $this->request('/convert', array(
            'from' => $this->from,
            'to' => $this->to,
            'amount' => $this->amount,
            'date' => $this->date
        ));
    }
    
    /**
     * Request the API's "historical" endpoint
     * 
     * @return array
     */
    public function historical()
    {
        $this->request('/historical', array(
            'date' => $this->date,
            'currencies' => $this->currencies,
            'source' => $this->source
        ));
    }
    
    /**
     * Request the API's "timeframe" endpoint
     * 
     * @return array
     */
    public function timeframe()
    {
        return $this->request('/timeframe', array(
            'currencies' => $this->currencies,
            'source' => $this->source,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ));
    }

    /**
     * Request the API's "change" endpoint
     * 
     * @return array
     */
    public function change()
    {
        return $this->request('/change', array(
            'currencies' => $this->currencies,
            'source' => $this->source,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ));
    }

    /**
     * Execute the API request
     * 
     * @param string $endpoint
     * @param array $params
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function request($endpoint, $params)
    {
        		
		$params['access_key'] = $this->access_key;
        $url = self::ENDPOINT . $endpoint . '?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $rsp = json_decode($json, true);
	
        if (array_key_exists('error', $rsp)) {
            throw new \InvalidArgumentException($rsp['error']);
        }
        
        return $rsp;
    }
    
}

?>
