<?php

namespace App\Trident\Business\Logic;

use App\Trident\Interfaces\Business\Logic\DefinitionInterface;
use App\Trident\Business\Schemas\Logic\Definition\Typed\SchemaHierarchy;
use App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Response;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\IntegerType;

class Definition implements DefinitionInterface
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
     * gets schema definitions
     *
     * @param string $table_name
     * @param [type] $db_connection
     * @return void
     */
    public function get($table_name, $db_connection)
    {
        $db_name = $db_connection->getDatabaseName();
        $columns = $this->getPropertiesFromTable(
            $table_name,
            $db_connection
        );

        $schema_hierarchy = (new SchemaHierarchy())->get();
        $request_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resource'][1]);
        $request_schema_definition = app()->make($request_schema_namespace);
        $request_schema = $request_schema_definition->getFilledValues();

        $response_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resource'][2]);
        $response_schema_definition = app()->make($response_schema_namespace);
        $response_schema = $response_schema_definition->getFilledValues();

        $presentation_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Presentation'][0]);
        $presentation_schema_definition = app()->make($presentation_schema_namespace);
        $presentation_schema = $presentation_schema_definition->getFilledValues();


        //request schema
        $request_table_data = [];
        foreach ($columns as $column) {
            $tmp_type = $request_schema['data']['{{entity_property}}']['type'];
            if ($column->getType() instanceof IntegerType) {
                $tmp_type = 'T::integer()';
            } else if ($column->getType() instanceof TextType) {
                $tmp_type = 'T::string()';
            } else if ($column->getType() instanceof StringType) {
                $tmp_type = 'T::string()';
            }

            $tmp_type = 'T::nullable('.$tmp_type.')';

            $request_table_data []= [
                'name' => $column->getName(),
                'type' => $tmp_type,
                'validation' => json_encode($request_schema['data']['{{entity_property}}']['validation']),
                'fillable' => $request_schema['data']['{{entity_property}}']['fillable'],
            ];
        }

        //response schema
        $response_table_data = [];
        foreach ($columns as $column) {
            $tmp_type = $response_schema['data']['{{entity_property}}']['resource'];

            $response_table_data []= [
                'name' => $column->getName(),
                'resource' => $tmp_type,
            ];
        }


        //presentation schema
        $presentation_table_data = [
            "ajax" => [
                "get" => [
                    "GET" => "T::string()"
                ],
                "create" => [
                    "POST" => "T::string()"
                ],
                "update" => [
                    "POST" => "T::string()"
                ],
                "delete" => [
                    "DELETE" => "T::string()"
                ]
            ],
            "presentation" => [
                "type" => "form",
                "schema" => []
            ],
        ];
        foreach ($columns as $column) {
            $tmp_type = 'string';
            $validation_rules = [
                "required" =>true,
                "type" =>"string",
                "trigger" =>"blur"
            ];
            $attributes = [
                "type" => [
                    "string" => true
                ],
                "default_value" => "''",
                "element_type" => false
            ];
            if ($column->getType() instanceof IntegerType) {
                $tmp_type = 'integer';
                $validation_rules = [
                    "required" =>true,
                    "type" =>"number",
                    "trigger" =>"blur"
                ];
                $attributes = [
                    "type" => [
                        "number" => true
                    ],
                    "default_value" => "''",
                    "element_type" => false
                ];
            } else if ($column->getType() instanceof TextType) {
                $tmp_type = 'string';
            } else if ($column->getType() instanceof StringType) {
                $tmp_type = 'string';
            }

            $presentation_table_data['presentation']['schema'] []= [
                'column_name' => $column->getName(),
                "column_type" => $tmp_type,
                "type" => "fillable",
                'validation_rules' => json_encode($validation_rules),
                'attributes' => json_encode($attributes),
            ];
        }

        // dd([
        //     '$schema_hierarchy' => $schema_hierarchy,
        //     '$request_schema' => $request_schema,
        //     '$request_table_data' => $request_table_data,
        //     '$response_schema' => $response_schema,
        //     '$response_table_data' => $response_table_data,
        //     '$presentation_schema' => $presentation_schema,
        //     '$presentation_table_data' => $presentation_table_data,
        //     '$db_name' => $db_name,
        //     '$columns' => $columns,
        // ]);
        
        return (object)[
            'request_table_data' => $request_table_data,
            'response_table_data' => $response_table_data,
            'presentation_table_data' => $presentation_table_data,
        ];
    }

    private function getPropertiesFromTable(string $table_name, $connection): array
    {
        $schema = $connection->getDoctrineSchemaManager($table_name);
        $databasePlatform = $schema->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');

        $properties = [];

        $platformName = $databasePlatform->getName();
        $customTypes = app()['config']->get("ide-helper.custom_db_types.{$platformName}", array());
        foreach ($customTypes as $yourTypeName => $doctrineTypeName) {
            $databasePlatform->registerDoctrineTypeMapping($yourTypeName, $doctrineTypeName);
        }

        $database = $connection->getDatabaseName();

        $columns = $schema->listTableColumns($table_name, $database);

        return $columns;
    }



    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function getByEntityId(Array $data): array
    {
        //
        // TO DO
        //

        return $data;
    }



    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function getWithProject(Array $data): array
    {
        //
        // TO DO
        //

        return $data;
    }


}
