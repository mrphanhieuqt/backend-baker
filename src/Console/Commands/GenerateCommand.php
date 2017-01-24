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

        $this->info("Coping resources ...");
        $this->copyResources();

        $this->info("Making {$model} model from table {$table} ...");
        $this->makeModel($model, $table);

        $controllerName = studly_case($name).'Controller';
        $this->info("Making {$controllerName} ...");
        $this->makeController($name, $model);

        $this->info("Making views ...");
        $this->makeView($name);

        $this->info("Making routes ...");
        $this->makeRoute($name);

        $this->info("Finished!");
        $this->info("------------------------------------------------");
    }

    private function copyResources() {
        $src = dirname(__FILE__).'/../../../resources/adminlte/';
        $dst = public_path('/themes/admin/');
        if(!file_exists(public_path('/themes'))) {
            mkdir(public_path('/themes'));
        }
        if(!file_exists($dst)) {
            mkdir($dst);
        }

        $verFile = $dst . '.ver';
        if(!file_exists($verFile)) {
            $this->recurseCopy($src.'bootstrap', $dst.'bootstrap');
            $this->recurseCopy($src.'dist', $dst.'dist');
            $this->recurseCopy($src.'plugins', $dst.'plugins');
            file_put_contents($verFile, time());
        }
        $this->info('');
    }

    /**
     * @param $src
     * @param $dst
     * @param null $command
     */
     private function recurseCopy($src, $dst) {
        if(!file_exists($dst)) {
            mkdir($dst);
        }
        $files = scandir($src);
        foreach ($files as $file) {
            if(($file != ".") && ($file != "..")) {
                $s = $src . '/' . $file;
                $d = $dst . '/' . $file;
                if(is_dir($s)) {
                    $this->recurseCopy($s, $d);
                } else {
                    if(copy($s, $d)) {
                        $this->info('-> ' . $d);
                    }
                }
            }
        }
    }

    /**
     * @param $page
     */
    private function makeRoute($page) {
        $routePath = base_path('routes');
        $adminRoutePath = $routePath.'/admin.php';
        if(!file_exists($adminRoutePath)) {
            $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/routes/admin.tpl");
            file_put_contents($adminRoutePath, $tplContent);
        }

        $tplContent = file_get_contents($adminRoutePath);
        if(strpos($tplContent, "// Routes for $page".PHP_EOL) === false) {
            $tplContentLines = explode(PHP_EOL, $tplContent);
            $numOfLines = count($tplContentLines);

            $tplPageRoute = file_get_contents(dirname(__FILE__)."/../../../templates/routes/_page.tpl");
            $tplPageRoute = str_replace("{{page}}", $page, $tplPageRoute);
            $tplPageRoute = str_replace("{{Page}}", studly_case($page), $tplPageRoute);
            $tplContentLines[$numOfLines] = $tplContentLines[$numOfLines-1];
            $tplContentLines[$numOfLines-1] = $tplContentLines[$numOfLines-2];
            $tplContentLines[$numOfLines-2] = $tplPageRoute;
            $tplContent = implode(PHP_EOL, $tplContentLines);

            file_put_contents($adminRoutePath, $tplContent);
            $this->info('-> ' . $adminRoutePath);
        }

        $tplContent = file_get_contents($routePath.'/web.php');
        $tplInclude = "include_once('admin.php');" . PHP_EOL;
        if(strpos($tplContent, $tplInclude) === false) {
            $tplContent .= PHP_EOL . $tplInclude;
            file_put_contents($routePath.'/web.php', $tplContent);
            $this->info('-> ' . $routePath.'/web.php');
        }

        $this->info('');
    }

    /**
     * @param $page
     */
    private function makeView($page) {
        $viewPath = resource_path("views/$page");
        if(!file_exists($viewPath)) {
            mkdir($viewPath);
        }

        $layoutPath = resource_path("views/layouts");
        if(!file_exists($layoutPath)) {
            mkdir($layoutPath);
        }

        // Layout
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/layouts/admin.tpl");
        file_put_contents($layoutPath.'/admin.blade.php', $tplContent);
        $this->info('-> ' . $layoutPath.'/admin.blade.php');

        // Index
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/index.tpl");
        file_put_contents($viewPath.'/index.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/index.blade.php');

        // Form
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/_form.tpl");
        file_put_contents($viewPath.'/_form.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/_form.blade.php');

        // Add
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/add.tpl");
        file_put_contents($viewPath.'/add.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/add.blade.php');

        // Edit
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/edit.tpl");
        file_put_contents($viewPath.'/edit.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/edit.blade.php');

        $this->info('');
    }

    /**
     * @param $page
     * @param $model
     */
    private function makeController($page, $model) {
        $pageStudly = studly_case($page);

        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/controllers/controller.tpl");
        $tplContent = str_replace("{{Model}}", $model, $tplContent);
        $tplContent = str_replace("{{page}}", $page, $tplContent);
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);

        $controllerPath = app_path('Http/Controllers').'/'.$pageStudly.'Controller.php';
        file_put_contents($controllerPath, $tplContent);
        $this->info('-> ' . $controllerPath);
        $this->info('');
    }

    /**
     * @param $model
     * @param $table
     */
    private function makeModel($model, $table) {
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/models/model.tpl");
        $tplContent = str_replace("{{Model}}", $model, $tplContent);
        $tplContent = str_replace("{{table}}", $table, $tplContent);

        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($table);
        $fillable = "[]";
        if(!empty($columns)) {
            $brl = PHP_EOL;
            $fillable = "[$brl        '". implode("',$brl        '", $columns) ."'$brl    ]";
        }

        $tplContent = str_replace("{{fillable}}", $fillable, $tplContent);

        $modelPath = app_path().'/'.$model.'.php';
        file_put_contents($modelPath, $tplContent);
        $this->info('-> ' . $modelPath);
        $this->info('');
    }
}