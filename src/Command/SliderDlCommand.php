<?php

namespace App\Command;

use Panthere\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SliderDlCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('app:sliderdl')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $songs = json_decode(file_get_contents('/media/dudu/3B1C91340DD1647C3/Project/sliderCrawler/sliderCrawler/songs.json.old', true));
        $client = Client::createChromeClient();

        foreach ($songs as $song) {
            $a = urlencode($song);
            $url = sprintf('http://slider.kz/vk_auth.php?q=%s', urlencode($song));

            $response =
            $k = '';
        }
    }

    private function getBitrate($entry)
    {
        $client = Client::createChromeClient();
        $crawler= $client->request('GET', sprintf('http://slider.kz/vk_auth.php?q=%s', urlencode($entry)));
        json_decode($crawler->getText());
    }
}
