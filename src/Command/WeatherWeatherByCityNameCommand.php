<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:weather-by-city-name',
    description: 'Add a short description for your command',
)]
class WeatherWeatherByCityNameCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('city', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');
        if ($country) {
            $io->note(sprintf('You passed an argument: %s', $country));
        }
        if ($city) {
            $io->note(sprintf('You passed an argument: %s', $city));
        }
        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        $weather = $this->weatherUtil->getWeatherForCountryAndCity($country,$city);
        $headers = ["ID", "Date", "Temperature", "Probability of Precipitation", "Clouds"];
        $headers = implode(',', $headers);

        $output->writeln($headers);
        foreach ($weather as $singleWeather) {
            $row = $singleWeather->toArray();
            $row = implode(',', $row);
            $output->writeln($row);
        }

        return Command::SUCCESS;
    }

}
