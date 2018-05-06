<?php

namespace App\Command;

use App\Manager\SliderDownloader;
use App\Manager\SoundcloudManager;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverKeys;
use Panthere\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloaderCommand extends ContainerAwareCommand
{
    /** @var SoundcloudManager */
    private  $soundcloudManager;

    /** @var SliderDownloader */
    private $sliderDownloader;

    /**
     * DownloaderCommand constructor.
     * @param SoundcloudManager $soundcloudManager
     */
    public function __construct(string $name = null, SoundcloudManager $soundcloudManager, SliderDownloader $sliderDownloader)
    {
        parent::__construct($name);
        $this->soundcloudManager = $soundcloudManager;
        $this->sliderDownloader = $sliderDownloader;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:download')

            // the short description shown while running "php bin/console list"
            ->setDescription('Download things.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $songs = $this->soundcloudManager->listAllSongs('kaiziak', $output);

        foreach ($songs as $song) {
            $this->sliderDownloader->download($song);
        }
    }
}
