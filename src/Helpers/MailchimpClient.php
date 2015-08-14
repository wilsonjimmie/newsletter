<?php


namespace WilsonCreative\Newsletter\NewsLetter\Helpers;


use Guzzle\Http\Client;

/**
 * Class MailchimpClient
 * @package app\Wilson\NewsLetter\Helpers
 */
class MailchimpClient extends Client
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var
     */
    public $endpoint;


    public function connect($endpoint = 'https://<dc>.api.mailchimp.com/3.0/')
    {
        $this->setEndpoint($endpoint);
        $this->client = new Client($this->endpoint);
        $this->authenticate();

        return $this->client;
    }

    /**
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $keySplit = explode('-', getenv('MAILCHIMP_API_KEY'));

        $dataCenter = $keySplit[1];

        $this->endpoint = str_replace('<dc>', $dataCenter, $endpoint);
    }

    /**
     *
     */
    public function authenticate()
    {
        $this->client->setDefaultOption('auth', ['user', getenv('MAILCHIMP_API_KEY'), 'basic']);
    }
    
}