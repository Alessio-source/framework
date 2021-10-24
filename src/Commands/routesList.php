<?php
namespace Commands\src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

use Framework\Classes\router;

class routesList extends Command {
    // configurazione del comando
    protected function configure() {
        $this->setName('route:list')
        ->setDescription('Return list of routes.')
        ->setHelp('Return list of routes');
    }

    // funzione dove viene eseguito il comando
    public function execute(InputInterface $input, OutputInterface $output) {

        $route = new Router();

        require __DIR__ . '/../../routes/routes.php';

        $list = [];

        foreach ($route->getRoutes()['files'] as $key => $value) {
            $list[] = [
                $value['request'],
                '-',
                'view'
            ];
        }

        foreach ($route->getRoutes()['controllers'] as $key => $value) {
            $list[] = [
                $value['request'],
                $value['method'],
                'controller'
            ];
        }

        $table = new Table($output);
        $table->setStyle('box-double');
        $table
            ->setHeaders(['routes', 'method', 'type'])
            ->setRows($list)
        ;
        $table->render();
        return Command::SUCCESS;
        
    }
}