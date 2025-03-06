<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\S3Service;

#[AsCommand(
    name: 'app:buckets-list',
    description: 'Buckets list',
)]
class BucketsListCommand extends Command
{
    public function __construct(
        protected S3Service $s3Service
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = $this->s3Service->getClient();

        $buckets = $client->listBuckets();

        dump($buckets);

        return Command::SUCCESS;
    }
}
