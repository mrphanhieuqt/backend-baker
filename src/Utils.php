<?php
namespace BackendBaker;

class Utils {
    /**
     * @param $model
     * @param $table
     */
    public static function makeModel($model, $table) {
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/models/model.tpl");
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
    }

    /**
     * @param $page
     * @param $model
     */
    public static function makeController($page, $model) {
        $pageStudly = studly_case($page);

        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/controllers/controller.tpl");
        $tplContent = str_replace("{{Model}}", $model, $tplContent);
        $tplContent = str_replace("{{page}}", $page, $tplContent);
        $tplContent = str_replace("{{Page}}", $pageStudly, $tplContent);

        $modelPath = app_path('Http/Controllers').'/'.$pageStudly.'Controller.php';
        file_put_contents($modelPath, $tplContent);
    }

    /**
     * @param $page
     */
    public static function makeView($page) {
        $viewPath = resource_path("views/$page");
        if(!file_exists($viewPath)) {
            mkdir($viewPath);
        }
        if(!file_exists($viewPath.'/layouts')) {
            mkdir($viewPath.'/layouts');
        }

        // Layout
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/layouts/admin.tpl");
        file_put_contents($viewPath.'/layouts/admin.blade.php', $tplContent);

        // Index
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/views/index.tpl");
        file_put_contents($viewPath.'/index.blade.php', $tplContent);

        // Form
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/views/_form.tpl");
        file_put_contents($viewPath.'/_form.blade.php', $tplContent);

        // Add
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/views/add.tpl");
        file_put_contents($viewPath.'/add.blade.php', $tplContent);

        // Edit
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/views/edit.tpl");
        file_put_contents($viewPath.'/edit.blade.php', $tplContent);
    }

    /**
     * @param $page
     */
    public static function makeRoute($page) {
        $routePath = base_path('routes');
        $adminRoutePath = $routePath.'/admin.php';
        if(!file_exists($adminRoutePath)) {
            $tplContent = file_get_contents(dirname(__FILE__)."/../templates/routes/admin.tpl");
            file_put_contents($adminRoutePath, $tplContent);
        }

        $tplContent = file_get_contents($adminRoutePath);
        if(strpos($tplContent, "// Routes for $page".PHP_EOL) === false) {
            $tplContentLines = explode(PHP_EOL, $tplContent);
            $numOfLines = count($tplContentLines);

            $tplPageRoute = file_get_contents(dirname(__FILE__)."/../templates/routes/_page.tpl");
            $tplPageRoute = str_replace("{{page}}", $page, $tplPageRoute);
            $tplContentLines[$numOfLines] = $tplContentLines[$numOfLines-1];
            $tplContentLines[$numOfLines-1] = $tplContentLines[$numOfLines-2];
            $tplContentLines[$numOfLines-2] = $tplPageRoute;
            $tplContent = implode(PHP_EOL, $tplContentLines);

            file_put_contents($adminRoutePath, $tplContent);
        }
    }
}