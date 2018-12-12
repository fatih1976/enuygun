<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\EnUygunCore\ExchangeRateUpdaterFacade;




class PariteUpdaterCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:parite-updater';

    protected function configure()
    {
        $this
            ->setDescription('Kayitli pariteleri gunceller.')
            ->setHelp('APIlere baglanarak en dusuk paritedeki bilgilerle veritabanini gunceller')
        ;
    }

    private $updater;


    public function __construct(ExchangeRateUpdaterFacade $updater)
    {
        $this->updater = $updater;

        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->updater->updateExchangeRate();
        $output->writeln([
            'FX Updater',
            '============',
            '',
        ]);
        $output->writeln($message);



        $output->writeln('All Done!');

    }
}