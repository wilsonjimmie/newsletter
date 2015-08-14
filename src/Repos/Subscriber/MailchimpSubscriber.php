<?php

namespace WilsonCreative\Newsletter\Repos\Subscriber;

use WilsonCreative\Newsletter\Contracts\SubscriberRepositoryInterface;
use WilsonCreative\Newsletter\Helpers\MailchimpClient;
use Guzzle\Http\Client;


/**
 * Class MailchimpSubscriber
 * @package app\Wilson\NewsLetter\Repos\Subscriber
 */
class MailchimpSubscriber implements SubscriberRepositoryInterface
{

    /**
     * @var MailchimpClient
     */
    protected $client;

    /**
     * @param MailchimpClient $client
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
     * @param $list_id
     * @return Array
     */
    public function all($list_id, $page = 1)
    {
        $count = 10;
        $offset = ($page -1) * $count;

        $response = $this->client->get('lists/' . $list_id . '/members/?count=' . $count . '&offset=' . $offset)->send();
        $array = (array)json_decode($response->getBody());

        $subscribers = [];
        foreach ($array['members'] as $subscriber) {
            $sub = [
                'id' => $subscriber->id,
                'email' => $subscriber->email_address,
                'language' => $subscriber->language,
                'status' => $subscriber->status,
                'opted_in' => $subscriber->timestamp_opt,
                'last_changed' => $subscriber->last_changed
            ];
            array_push($subscribers, $sub);
        }

        return $subscribers;
    }

    /**
     * @param array $data
     *
     * $data has to contain following keys: email, list_id
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function find(array $data)
    {
        $id = md5($data['email']);

        $response = $this->client->get('lists/' . $data['list_id'] . '/members/' . $id)->send();

        $array = (array)json_decode($response->getBody());

        $subscribers = [
            'id' => $array['id'],
            'email' => $array['email_address'],
            'language' => $array['language'],
            'status' => $array['status'],
            'opted_in' => $array['timestamp_opt'],
            'last_changed' => $array['last_changed']
        ];

        return $subscribers;
    }

    /**
     * @param array $data
     *
     * $data has to contain following keys: email, list_id
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $data)
    {
        $list_id = $data['list_id'];
        unset($data['list_id']);

        $object = [
            'email_address' => $data['email'],
            'status' => 'subscribed'
        ];

        $jsonObject = json_encode($object);

        $response = $this->client->post('lists/' . $list_id . '/members/', null, $jsonObject)->send();
        $array = (array)json_decode($response->getBody());

        return $array;
    }

    /**
     * @param array $data
     *
     * $data has to contain following keys: email, list_id, status
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function update(array $data)
    {
        /*$id = md5($data['email']);
        $list_id = $data['list_id'];
        unset($data['list_id']);

        $object = [
            'status' => $data['status']
        ];

        $jsonObject = json_encode($object);

        return $this->client->post('lists/' . $list_id . '/members/' . $id, null, $jsonObject)->send();
        */

        // Currently not allowed to change a subscribtion email or status

        return false;
    }

    /**
     * @param array $data
     *
     * $data has to contain following keys: email, list_id
     *
     * @return boolean
     */
    public function delete(array $data)
    {
        $id = md5($data['email']);
        $list_id = $data['list_id'];

        $response = $this->client->delete('lists/' . $list_id . '/members/' . $id)->send();
        $array = (array)json_decode($response->getBody());

        return (is_array($array)) ? ['message' => 'Successfully unsubscribed!'] : ['message' => 'Error: Something went wrong!'];
    }
}