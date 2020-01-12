<?php

namespace App\Trident\Workflows\Logic;

use App\Models\Entity as EntityModel;
use App\Trident\Workflows\Exceptions\EntityException;
use App\Trident\Interfaces\Workflows\Repositories\EntityRepositoryInterface as EntityRepository;
use App\Trident\Interfaces\Workflows\Logic\EntityInterface;
use App\Trident\Interfaces\Business\Logic\EntityInterface as EntityBusiness;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructIndexEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructStoreEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructUpdateEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Resources\EntityResource;
use App\Trident\Workflows\Schemas\Logic\Entity\Resources\EntityResourceCollection;
use App\Trident\Workflows\Schemas\Logic\Entity\Resources\EntityupdateResourceResource;
use App\Trident\Workflows\Schemas\Logic\Entity\Resources\EntitygetParentsResourceCollection;

class Entity implements EntityInterface
{
    
    /**
     * @var \App
     */
    protected $app;

    /**
     * @var EntityBusiness
     */
    protected $entity_business;
    
    /**
     * @var EntityRepository
     */
    protected $entity_repository;

    /**
     * @var string
     * @return void
     */
    public function __construct(EntityBusiness $entityBusiness, EntityRepository $entityRepository)
    {
        $this->entity_business = $entityBusiness;
        $this->entity_repository = $entityRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param  StructIndexEntity $structIndexEntity
     * @return EntityResourceCollection
     */
    public function index(StructIndexEntity $structIndexEntity): EntityResourceCollection
    {
        $data = $structIndexEntity->getFilledValues();
        
        $entitys = $this->entity_repository->get();
        return new EntityResourceCollection($entitys);
        
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
     * @param  StructStoreEntity  $structStoreEntity
     * @return EntityResource
     */
    public function store(StructStoreEntity  $structStoreEntity): EntityResource
    {        
        $data = $structStoreEntity->getFilledValues();
        $new_entity = $this->entity_repository->create($data);

        return new EntityResource($new_entity);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EntityResource
     */
    public function show($id): EntityResource
    {
        $entity = $this->entity_repository->findOrFail($id);
        return new EntityResource($entity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return EntityModel
     */
    public function edit($id): EntityModel
    {
        return $this->entity_repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StructUpdateEntity  $structUpdateEntity
     * @return EntityResource
     */
    public function update(StructUpdateEntity  $structUpdateEntity): EntityResource
    {   
        $id = $structUpdateEntity['id'];
        $data = $structUpdateEntity->getFilledValues();
        $entity = $this->entity_repository->findOrFail($id);

        try {
            $entity->update($data);
        } catch (\Exception $e) {
            throw new EntityException('updateFailed');
        }

        return new EntityResource($entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Boolean
     */
    public function destroy($id)
    {
        $deleted_count = $this->entity_repository->destroy($id);
        return ($deleted_count > 0);
    }

    /**
     * @var array
     * @return array
     */
    public function generate($request_data, $id)
    {
        $model = $this->entity_repository->with(['project','definition'])->find($id);

        $this->entity_business->generate(
            $model->getAttributes(),
            $model->getRelations()['project']->getAttributes(),
            $model->getRelations()['definition']->getAttributes(),
        );

        return true;
    }



    /**
     * @var array
     * @return array
     */
    public function updateResource($request_struct, $id)
    {   
        $model = $this->entity_repository->with(['project','definition'])->find($id);

        $this->entity_business->updateResource(
            $model->getAttributes(),
            $model->getRelations()['project']->getAttributes(),
            $model->getRelations()['definition']->getAttributes(),
        );

        return new EntityupdateResourceResource( $model );
    }



    /**
     * @var array
     * @return array
     */
    public function getParents($request_struct, $id)
    {   
        $data = $request_struct->getFilledValues();
        $model = [];

        if ($id) {
            $model = $this->entity_repository->get()->where('parent_id', $id);
        } else {
            $model = $this->entity_repository->get()->where('parent_id', 0);
        }

        return new EntitygetParentsResourceCollection( $model );
    }


}
