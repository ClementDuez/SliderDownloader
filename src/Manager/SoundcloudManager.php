<?php

namespace App\Manager;

use App\Document\Song;
use Doctrine\ODM\MongoDB\DocumentManager;
use Facebook\WebDriver\WebDriverKeys;
use Panthere\Client;
use Symfony\Component\Console\Output\OutputInterface;

class SoundcloudManager
{
    const SOUNDCLOUD_URL_LIKES = 'https://api-v2.soundcloud.com/users/53587230/likes?offset=1520846671130215&limit=24&client_id=4jkoEFmZEDaqjwJ9Eih4ATNhcH3vMVfp&app_version=1523637157&app_locale=fr';

    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * SoundcloudManager constructor.
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function listAllSongs($user, OutputInterface $output = null)
    {
        return $this->listAllSongsNew($user, $output);
    }

    private function listAllSongsNew($user, OutputInterface $output = null)
    {
        $clientGuzzle = new \GuzzleHttp\Client();
        $clientSelenium = Client::createSeleniumClient('http://hub:4444/wd/hub');
        $crawler = $clientSelenium->request('GET', sprintf('https://soundcloud.com/%s', $user));
        $soundcloudUserId  = explode(':', $crawler->filter("meta[property='twitter:app:url:googleplay']")->attr('content'));
        $soundcloudUserId = $soundcloudUserId[count($soundcloudUserId) - 1];

        $url = sprintf('https://api-v2.soundcloud.com/users/%s/track_likes?client_id=z7K0MTDkeSUpV4yFhzyDEhLw6esDOh4f&limit=100&offset=0&linked_partitioning=1&app_version=1525260260&app_locale=fr', $soundcloudUserId);
        $songs = [];
        $continue = true;
        do {
            $resultGuzzle = $clientGuzzle->get($url);
            $result = json_decode($resultGuzzle->getBody()->getContents());
            $query = parse_url($result->next_href);
            $offset = [];
            if (!isset($query['query'])) {
                $continue = false;
            } else {
                parse_str($query['query'], $offset);
                $url = sprintf('https://api-v2.soundcloud.com/users/%s/track_likes?client_id=z7K0MTDkeSUpV4yFhzyDEhLw6esDOh4f&limit=100&offset=%s&linked_partitioning=1&app_version=1525260260&app_locale=fr', $soundcloudUserId, $offset['offset']);
            }

            foreach ($result->collection as $soundcloudSong) {
                $song = new Song();
                $songs[] = $song
                    ->setSoundCloudName($soundcloudSong->track->title)
                    ->setArtist($soundcloudSong->track->user->first_name)
                    ->setDuration($soundcloudSong->track->full_duration)
                    ->setThumbnail($soundcloudSong->track->artwork_url)
                    ->setSoundCloudLink($soundcloudSong->track->permalink_url)
//                    ->setCreatedAt($re)
                ;
                $this->documentManager->persist($song);
            }

            $this->documentManager->flush();
        } while($continue);
        $now = new \DateTime();

        file_put_contents(sprintf('/var/www/html/songs-%s.json', $now->format('dmy_his')), json_encode($songs));

        return $songs;
    }

    private function listAllSongsOld($user, OutputInterface $output = null)
    {
        $client = Client::createSeleniumClient('http://hub:4444/wd/hub');
        $crawler = $client->request('GET', sprintf('https://soundcloud.com/%s/likes', $user));
        $webdriver = $client->getWebDriver();
        $keyboard = $webdriver->getKeyboard();
        $titres = [];
        $globalLastTitle = null;
        $death = 200;
        $i = 0;

        do {
            $output->writeln($i);

            if ($i%10 === 0) {
                $client->takeScreenshot(sprintf('/var/www/html/sliderCrawler/screen/lol-%s.png', $i));
            }
            $keyboard->pressKey(WebDriverKeys::PAGE_DOWN);
            $client->wait(10,500);
            $keyboard->pressKey(WebDriverKeys::PAGE_DOWN);
            $lastTitle = $crawler->filter('.soundTitle__title')->last()->getText();
            $i++;

            if ($globalLastTitle !== $lastTitle) {
                $globalLastTitle = $lastTitle;
            } else {
                $output->writeln(sprintf('death %s', $death));
                $death--;
            }
        } while($death !== 0);

//        for ($i=0; $i < 300; $i++) {
//            $output->writeln($i);
//            $client->takeScreenshot(sprintf('/media/dudu/3B1C91340DD1647C3/Project/sliderCrawler/sliderCrawler/screen/lol-%s.png', $i));
//            $keyboard->pressKey(WebDriverKeys::PAGE_DOWN);
//            $client->wait(10,300);
//        }

        $crawler->filter('.soundTitle__title')->each(function ($el) use($output, &$titres) {
            $titre = $el->text();
            $output->writeln($titre);

            if (!isset($titres[$titre])) {
                $titres[] = $titre;
            }
        });

        file_put_contents('/var/www/html/sliderCrawler/songs.json', json_encode($titres));

        return $titres;
    }
}
