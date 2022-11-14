<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
use App\Entity\City;
use App\Repository\CityRepository;

#[AsCommand(
    name: 'weather:weather-by-id',
    description: 'Add a short description for your command',
)]
class WeatherWeatherByIdCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
    public function __construct( WeatherUtil $weatherUtil, CityRepository $cityRepository)
    {
        $this->weatherUtil = $weatherUtil;
        $this->cityRepository = $cityRepository;
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');

        if ($id) {
            $io->note(sprintf('You passed an argument: %s', $id));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        settype($id, "integer");
        $city = $this->cityRepository->getCity($id);
        $output->writeln($this->weatherUtil->getWeatherForId($city[0]));

        return Command::SUCCESS;
    }
}
