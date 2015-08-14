<?php

namespace WilsonCreative\Newsletter\Repos\Mailinglist;


use WilsonCreative\Newsletter\Helpers\MailchimpClient;
use WilsonCreative\Newsletter\Contracts\MailinglistRepositoryInterface;
use Guzzle\Http\Client;


/**
 * Class MailchimpMailinglist
 * @package app\Wilson\NewsLetter\Repos\Mailinglist
 */
class MailchimpMailinglist implements MailinglistRepositoryInterface
{

    /**
     * @var string
     */
    protected $endpoint;
    /**
     * @var MailchimpClient
     */
    protected $client;


    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $endpoint = getenv('MAILCHIMP_ENDPOINT');
        $apiKey = getenv('MAILCHIMP_API_KEY');
        $keySplit = explode('-', $apiKey);
        $dataCenter = $keySplit[1];

        $this->client = new $client(str_replace('<dc>', $dataCenter, $endpoint));
        $this->client->setDefaultOption('auth', ['user', $apiKey, 'basic']);
    }

    /**
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function all($page = 1)
    {
        $count = 10;
        $offset = ($page -1) * $count;

        $response = $this->client->get('lists/?count=' . $count . '&offset=' . $offset)->send();

        $array = (array)json_decode($response->getBody());

        $lists = [];
        foreach ($array['lists'] as $list) {


            $cpgn = [
                'id' => $list->id,
                'name' => $list->name,
                'created_at' => $list->date_created
            ];
            array_push($lists, $cpgn);
        }

        return $lists;
    }

    /**
     * @param $id
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function find($id)
    {
        $response = $this->client->get('lists/' . $id)->send();

        $array = (array)json_decode($response->getBody());

        $list = [
            'id' => $array['id'],
            'name' => $array['name'],
            'permission_reminder' => $array['permission_reminder'],
            'subscribe_url' => $array['subscribe_url_short'],
            'created_at' => $array['date_created'],
        ];

        return $list;
    }

    /**
     * @param array $data
     * @return \Guzzle\Http\Message\EntityEnclosingRequestInterface|\Guzzle\Http\Message\RequestInterface
     */
    public function create(array $data)
    {
        return false;
    }

    /**
     * @param array $data
     * @return \Guzzle\Http\Message\EntityEnclosingRequestInterface|\Guzzle\Http\Message\RequestInterface
     */
    public function update(array $data)
    {
        return false;
    }

    /**
     * @param $id
     * @return \Guzzle\Http\Message\EntityEnclosingRequestInterface|\Guzzle\Http\Message\RequestInterface
     */
    public function delete($id)
    {
        $response = $this->client->delete('lists/' . $id)->send();

        $array = (array)json_decode($response->getBody());

        return (is_array($array)) ? ['message' => 'Successfully deleted!'] : ['message' => 'Error: Something went wrong!'];
    }
}