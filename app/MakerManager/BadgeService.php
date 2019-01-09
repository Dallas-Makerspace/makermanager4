<?php
namespace MakerManager;

use App\Badge;
use GuzzleHttp\Client;

class BadgeService
{
    protected $badge;

    public function __construct(Badge $badge)
    {
        $this->badge = $badge;
    }

    public function activate()
    {
        try {
            $this->request('add', $this->badge->number);
        } catch(\Exception $e) {

        }

        return true;
    }

    public function suspend()
    {
        $this->request('remove', $this->badge->number);
    }

    public function deactivate()
    {
        $this->request('remove', $this->badge->number);
    }

    /**
     * Send the request, returning the results.
     *
     * @param string $action
     * @param string $badge
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request(string $action, string $badge)
    {
        if( ! in_array($action, ['add', 'remove'])) {
            throw new \Exception("Action must be add or remove");
        }

        $url = config('services.doorcontrol.url');
        $key = config('services.doorcontrol.key');

        $client = new Client([
            'base_uri' => $url,
            'timeout' => 30,
            'verify' => false
        ]);

        return $client->request('GET', '/accessControlApi', [
            'query' => [
                'apiKey' => $key,
                'action' => $action,
                'badge' => $badge
            ]
        ]);
    }

}