<?php

namespace OceanApplications\currencylayer;

/**
 * PHP client for the currencylayer API.
 *
 * @version 1.3.1
 *
 * @link https://currencylayer.com/
 */
class client
{
    /**
     * API base URL.
     */
    const ENDPOINT = 'http://apilayer.net/api';

    /**
     * API endpoint parameters.
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
     * Constructor.
     *
     * @param string $access_key
     */
    public function __construct($access_key = null)
    {
        $this->access_key = $access_key;
    }

    /**
     * @param $source
     *
     * @return $this
     */
    public function source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param $currencies
     *
     * @return $this
     */
    public function currencies($currencies)
    {
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * @param $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param $to
     *
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function amount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param $date
     *
     * @return $this
     */
    public function date($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param $start_date
     *
     * @return $this
     */
    public function start_date($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * @param $end_date
     *
     * @return $this
     */
    public function end_date($end_date)
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * Request the API's "live" endpoint.
     *
     * @return array
     */
    public function live()
    {
        return $this->request('/live', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     * Request the API's "convert" endpoint.
     *
     * @return array
     */
    public function convert()
    {
        return $this->request('/convert', [
            'from'   => $this->from,
            'to'     => $this->to,
            'amount' => $this->amount,
            'date'   => $this->date,
        ]);
    }

    /**
     * Request the API's "historical" endpoint.
     *
     * @return array
     */
    public function historical()
    {
        $this->request('/historical', [
            'date'       => $this->date,
            'currencies' => $this->currencies,
            'source'     => $this->source,
        ]);
    }

    /**
     * Request the API's "timeframe" endpoint.
     *
     * @return array
     */
    public function timeframe()
    {
        return $this->request('/timeframe', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ]);
    }

    /**
     * Request the API's "change" endpoint.
     *
     * @return array
     */
    public function change()
    {
        return $this->request('/change', [
            'currencies' => $this->currencies,
            'source'     => $this->source,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ]);
    }

    /**
     * Execute the API request.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function request($endpoint, $params)
    {
        $params['access_key'] = $this->access_key;
        $url = self::ENDPOINT.$endpoint.'?'.http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $rsp = json_decode($json, true);

        if (array_key_exists('error', $rsp)) {
            $error = $rsp['error'];
            throw new \InvalidArgumentException($error['info'], $error['code']);
        }

        return $rsp;
    }
}
