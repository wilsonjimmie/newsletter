<?php

namespace WilsonCreative\Newsletter\Repos\Newsletter;

use WilsonCreative\Newsletter\Contracts\NewsletterRepositoryInterface;
use Guzzle\Http\Client;

/**
 * Class ApsisNewsLetter
 * @package App\Wilson
 */
class ApsisNewsLetter implements NewsletterRepositoryInterface
{

    /**
     * @var string
     */
    public $apiEndpoint = ' http://se.api.anpdm.com/v1/newsletters/';



    /**
     * @return mixed
     */
    public function all()
    {
        $client = new Client();

        $request = $client->post($this->apiEndpoint . 'all');
        $response = $request->send();

        return $response->Result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $client = new Client();

        $request = $client->get($this->apiEndpoint . $id);
        $response = $request->send();

        return $response->Result;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $client = new Client();

        $request = $client->post($this->apiEndpoint, null, $data);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $client = new Client();

        $id = $data['id'];
        unset($data['id']);

        $request = $client->post($this->apiEndpoint . $id, null, $data);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $client = new Client();

        $request = $client->delete($this->apiEndpoint . $id);
        $response = $request->send();

        return $this->checkResponse($response);
    }

    /**
     * @param $response
     * @return bool
     */
    public function checkResponse($response)
    {
        $res = json_decode($response);

        return (isset($res->Message) && $res->Message == "OK");
    }
}
