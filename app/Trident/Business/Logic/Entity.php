<?php

namespace App\Trident\Business\Logic;

use App\Trident\Business\Exceptions\EntityException;
use App\Trident\Interfaces\Business\Logic\EntityInterface;
use App\Trident\Business\Schemas\Logic\Definition\Typed\SchemaHierarchy;


class Entity implements EntityInterface
{

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct()
    {
       //
    }


    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function generate($model, $project, $definition): void
    {

        $schema_hierarchy = (new SchemaHierarchy())->get();
        $functionality_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resource'][0]);
        $functionality_schema_definition = app()->make($functionality_schema_namespace);
        
        $request_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resource'][1]);
        $request_schema_definition = app()->make($request_schema_namespace);
        
        $response_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resource'][2]);
        $response_schema_definition = app()->make($response_schema_namespace);
        
        //model data
        $request_data = json_decode($model['request_data'], true);
        $response_data = json_decode($model['response_data'], true);


        //functionality json
        $functionality_json = [
            'model' => [
                'db_name' => $model['db_table_name'],
            ]
        ];
        $functionality_schema_definition->check($functionality_json);

        //request json
        $request_json = [];
        $request_json['type'] = 'json';
        $request_json['data'] = [];
        foreach ($request_data as $request_data_element) {
            $request_json['data'][ $request_data_element['name'] ] = [
                'type' => $request_data_element['type'],
                'validation' => json_decode($request_data_element['validation'], true),
                'fillable' => $request_data_element['fillable'] === 'true' ? true : false,
            ];
        }
        $request_schema_definition->check($request_json);

        //response json
        $response_json = [];
        $response_json['type'] = 'json';
        $response_json['data'] = [];
        foreach ($response_data as $response_data_element) {
            $response_json['data'][ $response_data_element['name'] ] = [
                'resource' => $response_data_element['resource'] === 'true' ? true : false,
            ];
        }
        $response_schema_definition->check($response_json);


        //write json files to project directory
        //make folder
        $path = $project['root_folder'].'/'.$project['relative_schemas_folder'].'/'.$model['name'].'/Resource';
        if (!is_dir(dirname($path.'/.'))) {
            mkdir(dirname($path.'/.'), 0777, true);
        }
        file_put_contents($path.'/Functionality.json', json_encode($functionality_json, JSON_PRETTY_PRINT));
        file_put_contents($path.'/Request.json', json_encode($request_json, JSON_PRETTY_PRINT));
        file_put_contents($path.'/Response.json', json_encode($response_json, JSON_PRETTY_PRINT));
        
        $command  = 'cd '.str_replace('\\', '/', $project['root_folder']).' && ';
        $command .= 'php ';
        $command .= 'artisan trident:generate:workflow_restful_crud '.$model['name'].' ';
        $command .= '--functionality_schema_path="'.$project['relative_schemas_folder'].'/'.$model['name'].'/Resource/'.'Functionality.json'.'" ';
        $command .= '--resource_schema_path="'.$project['relative_schemas_folder'].'/'.$model['name'].'/Resource/'.'Response.json'.'" ';
        $command .= '--validation_schema_path="'.$project['relative_schemas_folder'].'/'.$model['name'].'/Resource/'.'Request.json'.'" ';

        shell_exec( $command );
    }

    function execInBackground($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &"); 
        }
    }


}
