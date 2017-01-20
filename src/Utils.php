<?php
namespace BackendBaker;

class Utils {
    /**
     * @param $model
     * @param $table
     */
    public static function makeModel($model, $table) {
        $tplContent = file_get_contents(dirname(__FILE__)."/../templates/models/model.tpl");
        $tplContent = str_replace("{{model}}", $model, $tplContent);
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
}