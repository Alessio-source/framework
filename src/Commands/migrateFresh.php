<?php
namespace Commands\src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Framework\Classes\config;
use Framework\Classes\database;
use Framework\Classes\migrations;

class migrateFresh extends Command {
    // configurazione del comando
    protected function configure() {
        $this->setName('migrate:fresh')
        ->setDescription('refresh all the tables.')
        ->setHelp('refresh all the tables.');
    }

    // funzione dove viene eseguito il comando
    public function execute(InputInterface $input, OutputInterface $output) {
        require __DIR__ . '/../classes/migration.php';

        $mgs = new migrations;

        $files = scandir(__DIR__ . '/../../migrations', 2);

        foreach ($files as $value) {
            if(str_contains($value, 'migration')) {
                require __DIR__ . "/../../migrations/$value";
                $value = explode('.', $value);
                $class = $value[0];
                $migration = new $class;
                $migration->migrate();
                $mgs->addMigration($migration->deleteSQL());
                $mgs->addMigration($migration->createSQL());
                $output->writeln("recreated $class");
            }
        }

        $mgs->exec();

        $output->writeln("Migrate fresh success");
        return Command::SUCCESS;
        
    }
}