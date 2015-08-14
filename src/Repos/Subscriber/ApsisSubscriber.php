<?php

namespace WilsonCreative\Newsletter\Repos\Subscriber;

use Guzzle\Http\Client;
use WilsonCreative\Newsletter\Contracts\SubscriberRepositoryInterface;

/**
 * Class ApsisSubscriber
 * @package App\Wilson\NewsLetter
 */
class ApsisSubscriber implements SubscriberRepositoryInterface
{

    /**
     * @var string
     */
    public $createSubscriberUri = 'http://se.api.anpdm.com/v1/subscribers/mailinglist/{MailingListId}/create';

    /**
     * @var string
     */
    public $updateSubscriberUri = 'http://se.api.anpdm.com/v1/subscribers/mailinglist/{MailingListId}/create?updateIfExists={UpdateIfExists}';

    /**
     * @var string
     */
    public $deleteSubscriberUri = 'http://se.api.anpdm.com/v1/subscribers/email';

    /**
     * @var string
     */
    public $subscriberIdUri = 'http://se.api.anpdm.com/subscribers/v2/email';

    /**
     * @var string
     */
    public $subscriberByIdUri = 'http://se.api.anpdm.com/v1/subscribers/id/';


    /**
     * @return mixed
     */
    public function all($list_id, $page = 1)
    {
        $client = new Client();

        $request = $client->post($this->getAllSubscribersUri, null, ['AllDemographics' => false]);
        $response = $request->send();

        return $response->Result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function find(array $data)
    {
        $client = new Client();

        $request = $client->post($this->subscriberIdUri, null, $data['email']);
        $response = $request->send();

        $result = json_decode($response);
        $subscriberId = $result->Result;

        $request = $client->post($this->subscriberByIdUri . $subscriberId);
        $response = $request->send();

        return $response->Result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $client = new Client();

        $this->createSubscriberUri = str_replace('{MailingListId}', $data['mailinglist_id'], $this->createSubscriberUri);
        $this->createSubscriberUri = str_replace('{UpdateIfExists}', $data['email'], $this->createSubscriberUri);

        $request = $client->post($this->createSubscriberUri, null, $data);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        $client = new Client();

        $this->updateSubscriberUri = str_replace('{MailingListId}', $data['mailinglist_id'], $this->updateSubscriberUri);
        $this->updateSubscriberUri = str_replace('{UpdateIfExists}', $data['email'], $this->updateSubscriberUri);

        $request = $client->post($this->updateSubscriberUri, null, $data);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param $email
     * @return mixed
     */
    public function delete(array $data)
    {
        $client = new Client();

        $request = $client->delete($this->deleteSubscriberUri, null, $data['email']);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param $response
     * @return mixed
     */
    public function checkResponse($response)
    {
        $res = json_decode($response);

        return (isset($res->Message) && $res->Message == "OK");
    }

}