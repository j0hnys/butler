<?php

namespace App\Trident\Workflows\Logic;

use App\Models\Definition as DefinitionModel;
use App\Trident\Workflows\Exceptions\DefinitionException;
use App\Trident\Interfaces\Workflows\Repositories\DefinitionRepositoryInterface as DefinitionRepository;
use App\Trident\Interfaces\Workflows\Logic\DefinitionInterface;
use App\Trident\Interfaces\Business\Logic\DefinitionInterface as DefinitionBusiness;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructIndexDefinition;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructStoreDefinition;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructUpdateDefinition;
use App\Trident\Workflows\Schemas\Logic\Definition\Resources\DefinitionResource;
use App\Trident\Workflows\Schemas\Logic\Definition\Resources\DefinitionResourceCollection;
use App\Trident\Workflows\Schemas\Logic\Definition\Resources\GetDefaultDefinitionValuesResource;
use App\Trident\Workflows\Schemas\Logic\Definition\Resources\DefinitionGetDatabaseTablesResource;
use App\Trident\Workflows\Schemas\Logic\Definition\Resources\GetDefaultDefinitionValuesResourceCollection;

class Definition implements DefinitionInterface
{
    
    /**
     * @var \App
     */
    protected $app;

    /**
     * @var DefinitionBusiness
     */
    protected $definition_business;
    
    /**
     * @var DefinitionRepository
     */
    protected $definition_repository;

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct(DefinitionBusiness $definitionBusiness, DefinitionRepository $definitionRepository)
    {
        $this->definition_business = $definitionBusiness;
        $this->definition_repository = $definitionRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param  StructIndexDefinition $structIndexDefinition
     * @return DefinitionResourceCollection
     */
    public function index(StructIndexDefinition $structIndexDefinition): DefinitionResourceCollection
    {
        $data = $structIndexDefinition->getFilledValues();
        
        $definitions = $this->definition_repository->get();
        return new DefinitionResourceCollection($definitions);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //
        // TO DO
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StructStoreDefinition  $structStoreDefinition
     * @return DefinitionResource
     */
    public function store(StructStoreDefinition  $structStoreDefinition): DefinitionResource
    {        
        $data = $structStoreDefinition->getFilledValues();
        $new_definition = $this->definition_repository->create($data);

        return new DefinitionResource($new_definition);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return DefinitionResource
     */
    public function show($id): DefinitionResource
    {
        $definition = $this->definition_repository->findOrFail($id);
        return new DefinitionResource($definition);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return DefinitionModel
     */
    public function edit($id): DefinitionModel
    {
        return $this->definition_repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StructUpdateDefinition  $structUpdateDefinition
     * @return DefinitionResource
     */
    public function update(StructUpdateDefinition  $structUpdateDefinition): DefinitionResource
    {   
        $id = $structUpdateDefinition['id'];
        $data = $structUpdateDefinition->getFilledValues();
        $definition = $this->definition_repository->findOrFail($id);

        try {
            $definition->update($data);
        } catch (\Exception $e) {
            throw new DefinitionException('updateFailed');
        }

        return new DefinitionResource($definition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Boolean
     */
    public function destroy($id)
    {
        $deleted_count = $this->definition_repository->destroy($id);
        return ($deleted_count > 0);
    }

    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function get($request_data, $id)
    {
        $result = $this->definition_business->get($request_data['db_table_name'], \DB::connection('mysql_butler_trident_vista'));

        return new GetDefaultDefinitionValuesResource($result);
    }


    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function getDatabaseTables($request_data, $id)
    {
        $table_names = \DB::connection('mysql_butler_trident_vista')->getDoctrineSchemaManager()->listTableNames();

        $structured_for_ui = [];
        foreach ($table_names as $table_name) {
            $structured_for_ui []= [
                'label' => $table_name,
                'value' => $table_name,
            ];
        }

        return new DefinitionGetDatabaseTablesResource((object)[
            'table_names' => $structured_for_ui
        ]);
    }


}
