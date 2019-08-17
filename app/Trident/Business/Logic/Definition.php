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
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function get__(): array
    {
        
        // $response = new SchemaHierarchy();
        // $response = new Form();
        $response = new Response();
        $response->check([
            "type" => 'json',
            "tmp" => 'a string',
            "tmp1" => 'EntityName',
            "data" => [
                "id" => [
                    'resource' => true,
                ]
            ],
        ]);

        dump([
            // '$tmp' => $tmp,
            // '$tmp1' => $tmp1,
            '$response' => $response,
        ]);

        return [];
    }


    public function get($table_name, $db_connection)
    {
        $db_name = $db_connection->getDatabaseName();
        $columns = $this->getPropertiesFromTable(
            $table_name,
            $db_connection
        );

        $schema_hierarchy = (new SchemaHierarchy())->get();
        $request_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resources'][1]);
        $request_schema_definition = app()->make($request_schema_namespace);
        $request_schema = $request_schema_definition->getFilledValues();

        $response_schema_namespace = str_replace('@', '', $schema_hierarchy['hierarchy']['trident-vista']['{{entity_name}}']['Resources'][2]);
        $response_schema_definition = app()->make($response_schema_namespace);
        $response_schema = $response_schema_definition->getFilledValues();

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

        // dd([
        //     '$schema_hierarchy' => $schema_hierarchy,
        //     '$request_schema' => $request_schema,
        //     '$request_table_data' => $request_table_data,
        //     '$response_schema' => $response_schema,
        //     '$response_table_data' => $response_table_data,
        //     '$db_name' => $db_name,
        //     '$columns' => $columns,
        // ]);
        
        return (object)[
            'request_table_data' => $request_table_data,
            'response_table_data' => $response_table_data,
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


}
