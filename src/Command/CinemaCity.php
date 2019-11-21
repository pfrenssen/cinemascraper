<?php

declare(strict_types = 1);

namespace CinemaScraper\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command that scrapes the CinemaCity website.
 */
class CinemaCity extends Command
{

    protected static $defaultName = 'cinemacity';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
          ->setDescription('Scrapes the CinemaCity website.')
          ->addArgument('cinema', InputArgument::REQUIRED, 'Either "Paradise Center" or "Mall of Sofia".')
          ->addOption('api-key', NULL, InputOption::VALUE_REQUIRED, 'The OMDB API key.')
          ->addOption('date', NULL, InputOption::VALUE_REQUIRED, 'The date for which to retrieve movie screenings.', date('Y-m-d'));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        switch ($input->getArgument('cinema')) {
            case 'Paradise Center':
                $input->setArgument('cinema', '1266');
                break;
            case 'Mall of Sofia':
                $input->setArgument('cinema', '1261');
                break;
            default:
                throw new \InvalidArgumentException('Invalid cinema.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->validate($input);

        $cinema = $input->getArgument('cinema');
        $date = $input->getOption('date');
        $api_key = $input->getOption('api-key');

        $guzzle_client = new Client();
        $response = $guzzle_client->request('GET', 'https://www1.cinemacity.bg/bg/data-api-service/v1/quickbook/10106/film-events/in-cinema/' . $cinema . '/at-date/' . $date, [
            'query' => [
                'lang' => 'en_GB',
            ]
        ]);
        if ($response->getStatusCode() != 200) {
            throw new \RuntimeException('Invalid response code ' . $response->getStatusCode());
        }

        $data = json_decode($response->getBody()->getContents());

        $table = new Table($output);
        $table->setHeaders(['Movie', 'Runtime', 'Released', 'Rating', 'Age', 'Language', 'Screenings']);

        foreach ($data->body->films as $film) {
            $omdb_response = $guzzle_client->request('GET', 'http://www.omdbapi.com/', [
                'query' => [
                    'apikey' => $api_key,
                    't' => $film->name,
                    'y' => $film->releaseYear,
                ],
            ]);
            $omdb_data = json_decode($omdb_response->getBody()->getContents());

            if (!empty($omdb_data->Error)) continue;

            $film_id = $film->id;
            $screenings = array_filter($data->body->events, function ($event) use ($film_id) {
                return $event->filmId === $film_id;
            });

            $screening_times = array_map(function ($screening) {
                return date('H:i', strtotime($screening->eventDateTime));
            }, $screenings);

            $table->addRow([
                strlen($film->name) > 30 ? substr($film->name, 0, 30) . '...' : $film->name,
                date('G:i', mktime(0, $film->length)),
                $omdb_data->Released,
                $omdb_data->imdbRating,
                $omdb_data->Rated,
                $omdb_data->Language,
                implode(', ', $screening_times),
            ]);
        }
        $table->render();
    }

    /**
     * Validates the user input.
     *
     * @param InputInterface $input
     *   The command input.
     *
     * @throws \InvalidArgumentException
     *   Thrown when user input is invalid.
     */
    protected function validate(InputInterface $input): void
    {
        $date = $input->getOption('date');

        $date_object = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$date_object || $date_object->format('Y-m-d') !== $date) {
            throw new \InvalidArgumentException('Date is invalid.');
        }
    }

}
