<?php
namespace Commands\src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class cacheClear extends Command {
    // configurazione del comando
    protected function configure() {
        $this->setName('cache:clear')
        ->setDescription('Clear the cache.')
        ->setHelp('Clear the cache');
    }

    // funzione dove viene eseguito il comando
    public function execute(InputInterface $input, OutputInterface $output) {
        $files = scandir(__DIR__ . '/../../cache', 2);

        foreach ($files as $file) {
            if(str_contains($file, '.bladec')) {
                unlink(__DIR__ . '/../../cache/' . $file);
            }
        }

        $output->writeln("The cache as been cleared");
        return Command::SUCCESS;
        
    }
}