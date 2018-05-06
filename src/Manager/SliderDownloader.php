<?php

namespace App\Manager;

use App\Document\Song;
use GuzzleHttp\Client;

class SliderDownloader
{
    public function download(Song $song)
    {
        $client = new Client();
        $url = sprintf('http://slider.kz/vk_auth.php?q=%s', urlencode($song->getSoundCloudName()));
        $responseGuzzle = $client->get($url);
        $response = $responseGuzzle->getBody()->getContents();
        $a = '';
    }

    public function getBitrate()
    {

    }
}
