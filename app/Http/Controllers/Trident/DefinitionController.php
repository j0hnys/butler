<?php

namespace App\Http\Controllers\Trident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Container\Container as App;
// use Workflow;
use App\Trident\Interfaces\Workflows\Logic\DefinitionInterface as DefinitionWorkflow;
use App\Trident\Interfaces\Workflows\Repositories\DefinitionRepositoryInterface as DefinitionRepository;
// use App\Trident\Workflows\Exceptions\DefinitionException;
// use App\Trident\Workflows\Events\Triggers\DefinitionTrigger;
use App\Trident\Workflows\Validations\DefinitiongetRequest;
use App\Trident\Workflows\Validations\DefinitionStoreRequest;
use App\Trident\Workflows\Validations\DefinitionUpdateRequest;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructIndexDefinition;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructStoreDefinition;
use App\Trident\Workflows\Schemas\Logic\Definition\Typed\StructUpdateDefinition;

class DefinitionController extends Controller
{
    
    /**
     * @var DefinitionWorkflow
     */
    protected $definition_workflow;
    
    /**
     * @var DefinitionRepository
     */
    protected $definition_repository;

    public function __construct(DefinitionWorkflow $definitionWorkflow, DefinitionRepository $definition_repository)
    {
        $this->definition_workflow = $definitionWorkflow;
        $this->definition_repository = $definition_repository;
    }


    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD START
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return DefinitionRepository
     */
    public function index(Request $request)
    {
        $this->authorize('list',$this->definition_repository);
        $request_all = $request->all();
        $structIndexDefinition = new StructIndexDefinition( $request_all );
        $definitionResourceCollection = $this->definition_workflow->index($structIndexDefinition);
        return response()->json( $definitionResourceCollection );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $this->authorize('create',$this->definition_repository);
        return view('definition_create');  //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DefinitionStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DefinitionStoreRequest $request)
    {
        $this->authorize('create',$this->definition_repository);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $structStoreDefinition = new StructStoreDefinition( $request_all );
        $definitionResource = $this->definition_workflow->store($structStoreDefinition);
        return response()->json( $definitionResource );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', [$this->definition_repository, $id]);
        return response()->json( $this->definition_workflow->show($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('update', [$this->definition_repository, $id]);
        $definition = $this->definition_workflow->edit($id);
        return view('definition_edit', compact('definition'));    //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DefinitionUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DefinitionUpdateRequest $request, $id)
    {   
        $this->authorize('update', [$this->definition_repository, $id]);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $structUpdateDefinition = new StructUpdateDefinition($request_all);        
        $definitionResource = $this->definition_workflow->update($structUpdateDefinition);
        return response()->json( $definitionResource );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->definition_repository, $id]);
        return response()->json( $this->definition_workflow->destroy($id) );
    }

    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD END
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


    

    /**
     * *enter description here.*
     *
     * @param  DefinitiongetRequest
     * @return \Illuminate\Http\Response
     */
    public function get(DefinitiongetRequest $request,$id)
    {
        // dd('csdcdsc');
        // $this->authorize('get', [$this->definition_repository,$id]);
        return response()->json( $this->definition_workflow->get([''],$id) );
    }



}
