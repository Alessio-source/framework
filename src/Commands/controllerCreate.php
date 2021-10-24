<?php
namespace Commands\src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class controllerCreate extends Command {
    // configurazione del comando
    protected function configure() {
        $this->setName('controller:create')
        ->setDescription('Create a controller.')
        ->setHelp('Create a controller')
        ->addArgument('controller-name', InputArgument::REQUIRED, 'The name of the controller.');
    }

    // funzione dove viene eseguito il comando
    public function execute(InputInterface $input, OutputInterface $output) {
        $dir = __DIR__ . '/../../controllers/';
        $filename = $input->getArgument('controller-name') . '.php';

        if(file_exists($dir . $filename)) {
            $output->writeln("The contoller '" . $input->getArgument('controller-name') . "' already exist!");
            return Command::SUCCESS;
        } else {
            $file = fopen($dir . $filename, "w");

            $code = '<?php

    class ' . $input->getArgument('controller-name') . ' extends controller {
        public function index() {

        }

        public function create() {

        }

        public function update() {

        }

        public function delete() {

        }
    }';

            fwrite($file, $code);
            fclose($file);

            $output->writeln("The contoller '" . $input->getArgument('controller-name') . "' was created");
            return Command::SUCCESS;
        }
        
    }
}