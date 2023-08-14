<?php

namespace App\Services\News;


use App\Collections\News;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

abstract class Base
{
    const CACHE_MINUTES_TO_LIVE = 5;

    private Client $client;

    function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function RSSToCollection(string $content, int $limit)
    {
        $xml = simplexml_load_string($content);

        $collection = new News();

        foreach ($xml->channel->item as $item) {
            if ($limit == 0) {
                break;
            }
            $collection->push(new \App\Models\Virtual\News($item[0]));

            $limit--;
        }

        return $collection;
    }

    public function getNews(): News
    {
        $content = $this->cachedRequest($this->getURL());

        return $this->RSSToCollection($content, $this->getLimit());
    }

    private function cachedRequest(string $url)
    {
        $key = 'news_' . $url;
        $secondsToLive = self::CACHE_MINUTES_TO_LIVE * Carbon::SECONDS_PER_MINUTE;

        return Cache::remember($key, $secondsToLive, function () use ($url) {
            return $this->request($url);
        });
    }

    private function request(string $url)
    {
        $response = $this->client->get($url);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            return $response->getBody()->getContents();
        } else {
            return null;
        }
    }

    abstract protected function getURL(): string;

    abstract protected function getLimit(): int;
}
