<?php

namespace App\Console\Commands;

use App\Crawler\StayReader;
use Illuminate\Console\Command;

class StayReaderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reader:download {--id=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $book_id = $this->option('id');

        $reader = new StayReader();
        if ($book_id == 'ALL') {
            $this->output->writeln('start download all novels...');
            $reader->downloadDotAllBooks();
        } else {
            $this->output->writeln('start download a novel...');
            $reader->downloadDotBookById(intval($book_id));
        }
        $this->output->writeln('done.');
    }
}
