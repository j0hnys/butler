<?php

namespace App\Trident\Business\Logic;

use App\Trident\Business\Exceptions\TestException;
use App\Trident\Interfaces\Business\Logic\TestInterface;
use App\Trident\Business\Schemas\Logic\Definition\Typed\SchemaHierarchy;

class Test implements TestInterface
{

    /**
     * @param array $model
     * @param array $project
     * @param array $definition
     * @return void
     */
    public function generate($model, $project, $definition, $entity): void
    {
        if (SchemaHierarchy::class !== $definition['namespace']) {
            throw new \Exception("definition not recognized", 1);
        }

        $schema_hierarchy = (app()->make($definition['namespace']))->get();
        
        $functionality_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Tests'][0]);
        $functionality_schema_definition = app()->make($functionality_schema_namespace);

        $request_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Tests'][1]);
        $request_schema_definition = app()->make($request_schema_namespace);
        
        $response_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Tests'][2]);
        $response_schema_definition = app()->make($response_schema_namespace);
        
        //model data
        $functionality_data = json_decode($model['functionality_data'], true);
        $request_data = json_decode($model['request_data'], true);
        $response_data = json_decode($model['response_data'], true);

        //functionality json
        $functionality_json = [
            'model' => [
                'db_name' => $functionality_data['model']['db_name']
            ]
        ];
        $functionality_schema_definition->check($functionality_json);

        //request json
        $request_json = [];
        $request_json['type'] = 'json';
        $request_json['data'] = [];
        foreach ($request_data as $request_data_element) {
            $request_json['data'][ $request_data_element['name'] ] = [
                'property_type' => $request_data_element['property_type'],
                'value' => $request_data_element['property_type'] == 'auto_id' ? (int)$request_data_element['value'] : $request_data_element['value'],
            ];
        }
        $request_schema_definition->check($request_json);

        //response json
        $response_json = [];
        $response_json['type'] = 'json';
        $response_json['data'] = [];
        foreach ($response_data as $response_data_element) {
            $response_json['data'][ $response_data_element['name'] ] = [
                'property_type' => $response_data_element['property_type'],
                'value' => $response_data_element['property_type'] == 'auto_id' ? (int)$response_data_element['value'] : $response_data_element['value'],
            ];
        }
        $response_schema_definition->check($response_json);


        //write json files to project directory
        //make folder
        $path = $project['root_folder'].'/'.$project['relative_schemas_folder'].'/'.$entity['name'].'/Tests/Resource';
        if (!is_dir(dirname($path.'/.'))) {
            mkdir(dirname($path.'/.'), 0777, true);
        }
        file_put_contents($path.'/Functionality.json', json_encode($functionality_json, JSON_PRETTY_PRINT));
        file_put_contents($path.'/Request.json', json_encode($request_json, JSON_PRETTY_PRINT));
        file_put_contents($path.'/Response.json', json_encode($response_json, JSON_PRETTY_PRINT));
        
        $command  = 'cd '.str_replace('\\', '/', $project['root_folder']).' && ';
        $command .= 'php ';
        $command .= 'artisan trident:generate:workflow_restful_crud_tests '.$entity['name'].' ';
        $command .= '--functionality_schema_path="'.$project['relative_schemas_folder'].'/'.$entity['name'].'/Tests/Resource/'.'Functionality.json'.'" ';
        $command .= '--request_schema_path="'.$project['relative_schemas_folder'].'/'.$entity['name'].'/Tests/Resource/'.'Request.json'.'" ';
        $command .= '--response_schema_path="'.$project['relative_schemas_folder'].'/'.$entity['name'].'/Tests/Resource/'.'Response.json'.'" ';

        $butler_db_name = env('DB_DATABASE');
        $project_db_name = $project['db_connection_name'];
        
        putenv("DB_DATABASE=".$project_db_name);
        shell_exec( $command );
        putenv("DB_DATABASE=".$butler_db_name);
    }


}
