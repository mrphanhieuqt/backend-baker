<?php

namespace BackendBaker\Console\Commands;

use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generate {name} {--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate page by database.';

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
     */
    public function handle()
    {
        $name = $this->argument('name');
        $table = $this->option('table');
        if(!$table) {
            $table = $name;
        }
        $this->info("Generating {$name} page from table {$table} ...");


        $this->info('Finished!');
    }
}
