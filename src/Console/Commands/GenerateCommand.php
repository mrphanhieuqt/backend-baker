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
    protected $signature = 'admin:generate {name} {--table=} {--all}';

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

        if(!empty($name)) {
            $table = $this->option('table');
            if($name == 'all') {
                if($table) {
                    return $this->syntaxError();
                }
                // TODO
            } else {
                if(!$table) {
                    $table = $name;
                }
                $this->genereateOnePage($name, $table);
            }
        }
    }

    private function syntaxError() {
        $this->info("Syntax error!");
    }

    /**
     * @param $name
     * @param $table
     */
    private function genereateOnePage($name, $table) {
        $model = str_singular(studly_case($table));

        $this->info("Start to generate {$name} page from table {$table} ...");

        $this->info("Making {$model} model from table {$table} ...");
        Utils::makeModel($model, $table);

        $controllerName = studly_case($name).'Controller';
        $this->info("Making {$controllerName} ...");
        Utils::makeController($name, $model);



        $this->info("Finished!");
        $this->info("------------------------------------------------");
    }
}