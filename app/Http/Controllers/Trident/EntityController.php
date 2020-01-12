<?php

namespace App\Http\Controllers\Trident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trident\Interfaces\Workflows\Logic\EntityInterface as EntityWorkflow;
use App\Trident\Interfaces\Workflows\Repositories\EntityRepositoryInterface as EntityRepository;
use App\Trident\Workflows\Validations\EntitygenerateRequest;
use App\Trident\Workflows\Validations\EntityStoreRequest;
use App\Trident\Workflows\Validations\EntityUpdateRequest;
use App\Trident\Workflows\Validations\EntityUpdateResourceRequest;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructUpdateResourceEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructIndexEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructStoreEntity;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructUpdateEntity;
use App\Trident\Workflows\Validations\EntityGetParentsRequest;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructGetParentsEntity;
use App\Trident\Workflows\Validations\EntityGenerateFeatureRequest;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructGenerateFeatureEntity;
use App\Trident\Workflows\Validations\EntityRefreshFeatureRequest;
use App\Trident\Workflows\Schemas\Logic\Entity\Typed\StructRefreshFeatureEntity;

        
class EntityController extends Controller
{
    
    /**
     * @var EntityWorkflow
     */
    protected $entity_workflow;
    
    /**
     * @var EntityRepository
     */
    protected $entity_repository;

    public function __construct(EntityWorkflow $entityWorkflow, EntityRepository $entity_repository)
    {
        $this->entity_workflow = $entityWorkflow;
        $this->entity_repository = $entity_repository;
    }


    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD START
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return EntityRepository
     */
    public function index(Request $request)
    {
        $this->authorize('list',$this->entity_repository);
        $structIndexEntity = new StructIndexEntity( $request->all() );
        $entityResourceCollection = $this->entity_workflow->index($structIndexEntity);
        return response()->json( $entityResourceCollection );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $this->authorize('create',$this->entity_repository);
        return view('entity_create');  //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EntityStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EntityStoreRequest $request)
    {
        $this->authorize('create',$this->entity_repository);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['parent_id'] = (int)$request_all['parent_id'];
        $structStoreEntity = new StructStoreEntity( $request_all );
        $entityResource = $this->entity_workflow->store($structStoreEntity);
        return response()->json( $entityResource );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', [$this->entity_repository, $id]);
        return response()->json( $this->entity_workflow->show($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('update', [$this->entity_repository, $id]);
        $entity = $this->entity_workflow->edit($id);
        return view('entity_edit', compact('entity'));    //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EntityUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EntityUpdateRequest $request, $id)
    {   
        $this->authorize('update', [$this->entity_repository, $id]);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['parent_id'] = (int)$request_all['parent_id'];
        $structUpdateEntity = new StructUpdateEntity($request_all);        
        $entityResource = $this->entity_workflow->update($structUpdateEntity);
        return response()->json( $entityResource );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->entity_repository, $id]);
        return response()->json( $this->entity_workflow->destroy($id) );
    }

    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD END
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    

    /**
     * @param  EntitygenerateRequest
     * @return \Illuminate\Http\Response
     */
    public function generate(EntitygenerateRequest $request,$id)
    {
        $this->authorize('generate', [$this->entity_repository,$id]);
        $request_all = $request->all();
        return response()->json( $this->entity_workflow->generate($request_all, $id) );
    }


    /**
     * @param  EntityupdateResourceRequest
     * @return \Illuminate\Http\Response
     */
    public function updateResource(EntityUpdateResourceRequest $request,$id)
    {   
        $this->authorize('updateResource', [$this->entity_repository,$id]);
        $structupdateResourceEntity = new StructUpdateResourceEntity($request->all());    
        $entityupdateResourceResource = $this->entity_workflow->updateResource( $structupdateResourceEntity ,$id);
        return response()->json( $entityupdateResourceResource );
    }


    /**
     * *enter description here.*
     *
     * @param  EntitygetParentsRequest
     * @return \Illuminate\Http\Response
     */
    public function getParents(EntityGetParentsRequest $request, $id = 0)
    {   
        $this->authorize('getParents', [$this->entity_repository,$id]);
        $request_all = $request->all();
        $request_all['id'] = (int)$request_all['id'];
        $structgetParentsEntity = new StructGetParentsEntity($request_all);    
        $entitygetParentsResource = $this->entity_workflow->getParents( $structgetParentsEntity ,$id);
        return response()->json( $entitygetParentsResource );
    }


    /**
     * @param  EntitygenerateFeatureRequest
     * @return \Illuminate\Http\Response
     */
    public function generateFeature(EntityGenerateFeatureRequest $request, $id)
    {   
        $this->authorize('generateFeature', [$this->entity_repository,$id]);
        $request_all = $request->all();
        $request_all['id'] = (int)$id;
        $structgenerateFeatureEntity = new StructGenerateFeatureEntity($request_all);    
        $entitygenerateFeatureResource = $this->entity_workflow->generateFeature( $structgenerateFeatureEntity ,$id);
        return response()->json( $entitygenerateFeatureResource );
    }


    /**
     * @param  EntityrefreshFeatureRequest
     * @return \Illuminate\Http\Response
     */
    public function refreshFeature(EntityRefreshFeatureRequest $request, $id)
    {   
        $this->authorize('refreshFeature', [$this->entity_repository,$id]);
        $request_all = $request->all();
        $request_all['id'] = (int)$id;
        $structrefreshFeatureEntity = new StructRefreshFeatureEntity($request_all);    
        $entityrefreshFeatureResource = $this->entity_workflow->refreshFeature( $structrefreshFeatureEntity ,$id);
        return response()->json( $entityrefreshFeatureResource );
    }



}
