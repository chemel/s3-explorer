<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\S3Service;

#[AsCommand(
    name: 'app:bucket-list-objects',
    description: 'Bucket list objects',
)]
class BucketListObjectsCommand extends Command
{
    public function __construct(
        protected S3Service $s3Service
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('bucket', InputArgument::REQUIRED, 'Bucket name')
            ->addOption('dump', InputOption::VALUE_OPTIONAL, null, 'Dump result')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bucket = $input->getArgument('bucket');

        $client = $this->s3Service->getClient();

        $result = $client->listObjects([
            'Bucket' => $bucket
        ]);

        if ($input->getOption('dump')) {
            dump($result);
            return Command::SUCCESS;
        }

        if (!isset($result['Contents'])) {
            return Command::FAILURE;
        }

        foreach ($result['Contents'] as $item) {
            $output->writeln($item['Key']);
        }

        return Command::SUCCESS;
    }
}
