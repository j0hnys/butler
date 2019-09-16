<?php

namespace App\Trident\Business\Logic;

use App\Trident\Interfaces\Business\Logic\ViewInterface;

class View implements ViewInterface
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
     * @return void
     */
    public function generate($model, $project, $definition, $entity): void
    {        
        $schema_hierarchy = (app()->make($definition['namespace']))->get();
        $presentation_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Presentation'][0]);
        $presentation_schema_definition = app()->make($presentation_schema_namespace);
        
        //model data
        $presentation_data = json_decode($model['presentation_data'], true);

        //request json
        $presentation_json = [];
        $presentation_json['ajax'] = $presentation_data['ajax'];
        $presentation_json['presentation'] = $presentation_data['presentation'];
        foreach ($presentation_json['presentation']['schema'] as &$presentation_data_element) {
            $presentation_data_element['validation_rules'] = json_decode($presentation_data_element['validation_rules'], true);
            $presentation_data_element['attributes'] = json_decode($presentation_data_element['attributes'], true);
        }
        $presentation_schema_definition->check($presentation_json);

        //write json files to project directory
        //make folder
        $path = $project['root_folder'].'/'.$project['relative_schemas_folder'].'/'.$model['name'].'/Presentation';
        if (!is_dir(dirname($path.'/.'))) {
            mkdir(dirname($path.'/.'), 0777, true);
        }
        file_put_contents($path.'/Form.json', json_encode($presentation_json, JSON_PRETTY_PRINT));
        

        $command  = 'cd '.str_replace('\\', '/', $project['root_folder']).' && ';
        $command .= 'php ';
        $command .= 'artisan vista:generate:crud '.$model['name'].' ';
        $command .= '--schema_path="/'.$project['relative_schemas_folder'].'/'.$model['name'].'/Presentation/'.'Form.json'.'" ';
        $command .= '--resources_relative_path_name="'.$model['vista_resource_folder_name'].'" ';

        shell_exec( $command );
    }





}
