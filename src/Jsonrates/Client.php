<?php

namespace Jsonrates;

/**
 * PHP client for jsonrates.com
 * 
 * @version 1.2.1
 * @author Jamil Soufan (@jamsouf)
 * @link http://jsonrates.com/
 */
class Client
{
    /**
     * Endpoint of the API
     */
    const ENDPOINT = 'http://jsonrates.com/{endpoint}/';
    
    /**
     * API endpoint parameters
     */
    private $base = null;
    private $from = null;
    private $to = null;
    private $amount = null;
    private $inverse = null;
    private $date = null;
    private $dateStart = null;
    private $dateEnd = null;
    private $period = null;
    private $apiKey = null;
    
    /**
     * Constructor
     * @param string $apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Magic setter for the endpoint parameters
     * 
     * @param string $method
     * @param array $args
     * @throws BadMethodCallException
     * @return this
     */
    public function __call($method, $args)
    {
        if (property_exists(get_class($this), $method) !== false)
        {
            $this->resetDependentAttributes($method);
            $this->$method = $args[0];
        
            return $this;
        }
        
        throw new \BadMethodCallException('Call to undefined method '.$method.'()');
    }
    
    /**
     * Request the API endpoint get
     * 
     * @return array
     */
    public function get()
    {
        return $this->request('get', array(
            'base' => $this->base,
            'from' => $this->from,
            'to' => $this->to)
        );
    }
    
    /**
     * Request the API endpoint convert
     * 
     * @return array
     */
    public function convert()
    {
        return $this->request('convert', array(
            'base' => $this->base,
            'from' => $this->from,
            'to' => $this->to,
            'amount' => $this->amount,
            'inverse' => $this->inverse)
        );
    }
    
    /**
     * Request the API endpoint historical
     * 
     * @return array
     */
    public function historical()
    {
        return $this->request('historical', array(
            'base' => $this->base,
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->date,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'period' => $this->period)
        );
    }
    
    /**
     * Request the API endpoint locale
     * 
     * @return array
     */
    public function locale()
    {
        return $this->request('locale', array(
            'base' => $this->base,
            'from' => $this->from,
            'to' => $this->to)
        );
    }
    
    /**
     * Execute the API request
     * 
     * @param string $endpoint
     * @param array $params
     * @throws InvalidArgumentException
     * @return string
     */
    private function request($endpoint, $params)
    {
        $params['apiKey'] = $this->apiKey;
        $url = str_replace('{endpoint}', $endpoint, self::ENDPOINT).'?' . http_build_query($params);
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
    
    /**
     * Reset attributes if other attributes are set
     * 
     * @param string $attribute
     */
    private function resetDependentAttributes($attribute)
    {
        switch ($attribute) {
            case 'base':
                $this->from = null;
                $this->to = null;
                break;
            case 'from':
            case 'to':
                $this->base = null;
                break;
            case 'date':
                $this->dateStart = null;
                $this->dateEnd = null;
                $this->period = null;
                break;
            case 'dateStart':
            case 'dateEnd':
                $this->date = null;
                break;
        }
    }
}