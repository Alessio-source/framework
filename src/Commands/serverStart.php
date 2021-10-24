<?php
namespace Commands\src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class serverStart extends Command {
    // configurazione del comando
    protected function configure() {
        $this->setName('serve')
        ->setDescription('Start an a localhost server.')
        ->setHelp('Start an a localhost server');
    }

    // funzione dove viene eseguito il comando
    public function execute(InputInterface $input, OutputInterface $output) {
        exec('php -S localhost:8000');
        return Command::SUCCESS;
        
    }
}