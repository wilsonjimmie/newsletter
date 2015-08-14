<?php


namespace WilsonCreative\Newsletter\Repos\Newsletter;

use WilsonCreative\Newsletter\Contracts\NewsletterRepositoryInterface;
use WilsonCreative\Newsletter\Helpers\MailchimpClient;
use Guzzle\Http\Client;

/**
 * Class MailchimpNewsletter
 * @package app\Wilson\NewsLetter\Repos\Newsletter
 */
class MailchimpNewsletter implements NewsletterRepositoryInterface
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
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function all($page = 1)
    {
        $count = 10;
        $offset = ($page -1) * $count;

        $response = $this->client->get('campaigns/?count=' . $count . '&offset=' . $offset)->send();

        $array = (array)json_decode($response->getBody());

        //dd($array);

        $campaigns = [];
        foreach ($array['campaigns'] as $campaign) {

            (isset($campaign->settings->subject_line)) ? $subject = $campaign->settings->subject_line : $subject = '';

            $cpgn = [
                'id' => $campaign->id,
                'title' => $campaign->settings->title,
                'subject' => $subject,
                'type' => $campaign->type,
                'created_at' => $campaign->create_time,
                'sent_at' => $campaign->send_time
            ];
            array_push($campaigns, $cpgn);
        }

        return $campaigns;
    }

    /**
     * @param $id
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function find($id)
    {
        $response = $this->client->get('campaigns/' . $id)->send();

        $array = (array)json_decode($response->getBody());

        //dd($array);
        (isset($array['settings']->subject_line)) ? $subject = $array['settings']->subject_line : $subject = '';

        $newsletter = [
            'id' => $array['id'],
            'title' => $array['settings']->title,
            'subject' => $subject,
            'access_url' => $array['archive_url'],
            'type' => $array['status'],
            'created_at' => $array['create_time'],
            'sent_at' => $array['send_time']
        ];

        return $newsletter;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        return false;
    }

    /**
     * @param array $data
     * @return bool
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
        $response = $this->client->delete('campaigns/' . $id)->send();

        $array = (array)json_decode($response->getBody());

        return (is_array($array)) ? ['message' => 'Successfully deleted!'] : ['message' => 'Error: Something went wrong!'];
    }
}