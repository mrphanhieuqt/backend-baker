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
            $brl = "\r\n";
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

        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/views/index.tpl");
        file_put_contents($viewPath.'/index.blade.php', $tplContent);
    }
}