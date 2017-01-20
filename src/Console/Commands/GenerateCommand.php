<?php

namespace BackendBaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use BackendBaker\Utils;

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
        $model = str_singular(studly_case($table));

        $this->info("Start to generate {$name} page from table {$table} ...");

        $this->info("Making {$model} model from table {$table} ...");

        Utils::makeModel($model, $table);

        $this->info('Finished!');
    }
}
