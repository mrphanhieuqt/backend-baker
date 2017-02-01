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
        // $tableDetails = \DB::connection()->getDoctrineSchemaManager()->listTableDetails($table);
        // dd($tableDetails);

        $model = str_singular(studly_case($table));

        $this->info("Start to generate {$name} page from table {$table} ...");

        $this->info("Coping resources ...");
        $this->copyResources();

        $this->info("Making {$model} model from table {$table} ...");
        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($table);
        $this->makeModel($model, $table, $columns);

        $controllerName = studly_case($name).'Controller';
        $this->info("Making {$controllerName} ...");
        $this->makeController($name, $model);

        $this->info("Making views ...");
        $this->makeView($name, $columns);

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
        $copyFlg = !file_exists($verFile);
        if(!$copyFlg) {
            $copyFlg = $this->confirm('Resources already exist. Do you want to overwrite them ?');
        }
        if($copyFlg) {
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
    private function makeView($page, $columns) {
        if(!file_exists(resource_path("views/admin"))) {
            mkdir(resource_path("views/admin"));
        }

        $viewPath = resource_path("views/admin/$page");
        if(!file_exists($viewPath)) {
            mkdir($viewPath);
        }

        $layoutPath = resource_path("views/admin/layouts");
        if(!file_exists($layoutPath)) {
            mkdir($layoutPath);
        }

        $partialPath = resource_path("views/admin/layouts/partials");
        if(!file_exists($partialPath)) {
            mkdir($partialPath);
        }

        $pageStudly = studly_case($page);
        $controllerName = $pageStudly.'Controller';

        // Layout
        $createFlg = !file_exists($layoutPath.'/admin.blade.php');
        if(!$createFlg) {
            $createFlg = $this->confirm("Layouts already exist. Do you want to overwrite them ?");
        }
        if($createFlg) {
            $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/layouts/admin.tpl");
            file_put_contents($layoutPath.'/admin.blade.php', $tplContent);
            $this->info('-> ' . $layoutPath.'/admin.blade.php');
        }

        // Partial
        if(!file_exists($partialPath.'/_left_sidebar.blade.php')) {
            $tplContent = file_get_contents(dirname(__FILE__) . "/../../../templates/layouts/_left_sidebar.tpl");
            file_put_contents($partialPath . '/_left_sidebar.blade.php', $tplContent);
            $this->info('-> ' . $partialPath . '/_left_sidebar.blade.php');
        }

        // Menu
        $tplContent = file_get_contents(dirname(__FILE__) . "/../../../templates/layouts/_left_sidebar.tpl");
        $tplContentLines = explode(PHP_EOL, $tplContent);
        $lines = count($tplContentLines);
        for ($i = $lines; $i > $lines - 5; $i--) {
            $tplContentLines[$i] = $tplContentLines[$i-1];
        }
        $tplContentMenu = file_get_contents(dirname(__FILE__) . "/../../../templates/layouts/_left_sidebar_menu.tpl");
        $tplContentMenu = str_replace("{{page}}", $page, $tplContentMenu);
        $tplContentMenu = str_replace("{{Page}}", $pageStudly, $tplContentMenu);
        $tplContentLines[$lines-5] = $tplContentMenu;
        $tplContent = implode(PHP_EOL, $tplContentLines);
        file_put_contents($partialPath . '/_left_sidebar.blade.php', $tplContent);

        // Index
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/index.tpl");
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);
        $skips = ['id', 'created_at', 'updated_at', 'password', 'remember_token'];
        $data = '<tr>' . PHP_EOL;
        $data .= '                    <th><input type="checkbox" class="minimal" name="select_all" value="on"></th>' . PHP_EOL;
        foreach ($columns as $column) {
            if(!in_array($column, $skips)) {
                $thName = str_replace('_', ' ', ucfirst($column));
                $data .= "                    <th>$thName</th>".PHP_EOL;
            }
        }
        $data .= "                    <th></th>".PHP_EOL;
        $data .= '                <tr>'.PHP_EOL;
        $data .= '                @if(!empty($data))'.PHP_EOL;
        $data .= '                  @foreach($data as $item)'.PHP_EOL;
        $data .= '                    <tr>'.PHP_EOL;
        $data .= '                        <td><input type="checkbox"  class="minimal select_item" name="id[]" value="{{$item->id}}"></td>'.PHP_EOL;
        foreach ($columns as $column) {
            if(!in_array($column, $skips)) {
                $data .= '                        <td>{{$item->' . $column . '}}</td>' . PHP_EOL;
            }
        }
        $data .= '                        <td class="text-right">'.PHP_EOL;
        $data .= '                          <a class="btn btn-info" href="{{action(\'Admin\\'.$controllerName.'@edit\', [\'id\'=>$item->id])}}">{{ trans(\'admin::messages.edit\') }}</a>'.PHP_EOL;
        $data .= '                          <a class="btn btn-danger btn-delete" href="{{action(\'Admin\\'.$controllerName.'@delete\', [\'id\'=>$item->id])}}">{{ trans(\'admin::messages.delete\') }}</a>'.PHP_EOL;
        $data .= '                        </td>' . PHP_EOL;
        $data .= '                    <tr/>'.PHP_EOL;
        $data .= '                  @endforeach' . PHP_EOL;
        $data .= '                @endif';
        $tplContent = str_replace("{{data}}", $data, $tplContent);
        file_put_contents($viewPath.'/index.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/index.blade.php');

        // Form
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/_form.tpl");
        $data = '';
        $skips = ['created_at', 'updated_at', 'remember_token'];
        foreach ($columns as $column) {
            if(!in_array($column, $skips)) {
                if($column == 'id') {
                    $data .= '    @if($isEdit)'.PHP_EOL;
                    $data .= '        <input type="hidden" name="'.$column.'" value="{{ $data->'.$column.' }}">'.PHP_EOL;
                    $data .= '    @endif'.PHP_EOL;
                } else {
                    $thName = str_replace('_', ' ', ucfirst($column));
                    $type = 'text';
                    if($column == 'password') {
                        $type = 'password';
                    }

                    $data .= '    <div class="form-group">'.PHP_EOL;
                    $data .= '        <label for="'.$column.'">'.$thName.'</label>'.PHP_EOL;
                    $data .= '        <input type="'.$type.'" class="form-control" name="'.$column.'" value="{{ old(\''.$column.'\', $data->'.$column.') }}">'.PHP_EOL;
                    $data .= '    </div>'.PHP_EOL;
                }
            }
        }
        $tplContent = str_replace("{{page}}", $page, $tplContent);
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);
        $tplContent = str_replace("{{data}}", $data, $tplContent);
        file_put_contents($viewPath.'/_form.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/_form.blade.php');

        // Add
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/add.tpl");
        $tplContent = str_replace("{{page}}", $page, $tplContent);
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);
        file_put_contents($viewPath.'/add.blade.php', $tplContent);
        $this->info('-> ' . $viewPath.'/add.blade.php');

        // Edit
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/views/edit.tpl");
        $tplContent = str_replace("{{page}}", $page, $tplContent);
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);
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

        if(!file_exists(app_path('Http/Controllers/Admin'))) {
            mkdir(app_path('Http/Controllers/Admin'));
        }

        $controllerPath = app_path('Http/Controllers/Admin').'/'.$pageStudly.'Controller.php';
        $createFlg = !file_exists($controllerPath);
        if(!$createFlg) {
            $createFlg = $this->confirm($pageStudly."Controller already exists. Do you want to overwrite it ?");
        }
        if($createFlg) {
            file_put_contents($controllerPath, $tplContent);
            $this->info('-> ' . $controllerPath);
            $this->info('');
        }
    }

    /**
     * @param $model
     * @param $table
     * @return mixed
     */
    private function makeModel($model, $table, $columns) {
        $tplContent = file_get_contents(dirname(__FILE__)."/../../../templates/models/model.tpl");
        $tplContent = str_replace("{{Model}}", $model, $tplContent);
        $tplContent = str_replace("{{table}}", $table, $tplContent);

        $fillable = "[]";
        if(!empty($columns)) {
            $brl = PHP_EOL;
            $fillable = "[$brl        '". implode("',$brl        '", $columns) ."'$brl    ]";
        }

        $tplContent = str_replace("{{fillable}}", $fillable, $tplContent);

        $modelPath = app_path().'/'.$model.'.php';
        $createFlg = !file_exists($modelPath);
        if(!$createFlg) {
            $createFlg = $this->confirm("$model model already exists. Do you want to overwrite it ?");
        }
        if($createFlg) {
            file_put_contents($modelPath, $tplContent);
            $this->info('-> ' . $modelPath);
            $this->info('');
        }
    }
}