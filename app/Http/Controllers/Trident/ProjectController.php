<?php

namespace App\Http\Controllers\Trident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Container\Container as App;
// use Workflow;
use App\Trident\Interfaces\Workflows\Logic\ProjectInterface as ProjectWorkflow;
use App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface as ProjectRepository;
// use App\Trident\Workflows\Exceptions\ProjectException;
// use App\Trident\Workflows\Events\Triggers\ProjectTrigger;
use App\Trident\Workflows\Validations\ProjectgetWithDefinitionsRequest;
use App\Trident\Workflows\Validations\ProjectgetWithDefinitionsEntitiesRequest;
use App\Trident\Workflows\Validations\ProjectStoreRequest;
use App\Trident\Workflows\Validations\ProjectUpdateRequest;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructIndexProject;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructStoreProject;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructUpdateProject;

class ProjectController extends Controller
{
    
    /**
     * @var ProjectWorkflow
     */
    protected $project_workflow;
    
    /**
     * @var ProjectRepository
     */
    protected $project_repository;

    public function __construct(ProjectWorkflow $projectWorkflow, ProjectRepository $project_repository)
    {
        $this->project_workflow = $projectWorkflow;
        $this->project_repository = $project_repository;
    }


    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD START
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return ProjectRepository
     */
    public function index(Request $request)
    {
        $this->authorize('list',$this->project_repository);
        $structIndexProject = new StructIndexProject( $request->all() );
        $projectResourceCollection = $this->project_workflow->index($structIndexProject);
        return response()->json( $projectResourceCollection );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $this->authorize('create',$this->project_repository);
        return view('project_create');  //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectStoreRequest $request)
    {
        $this->authorize('create',$this->project_repository);
        $structStoreProject = new StructStoreProject( $request->all() );
        $projectResource = $this->project_workflow->store($structStoreProject);
        return response()->json( $projectResource );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', [$this->project_repository, $id]);
        return response()->json( $this->project_workflow->show($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('update', [$this->project_repository, $id]);
        $project = $this->project_workflow->edit($id);
        return view('project_edit', compact('project'));    //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectUpdateRequest $request, $id)
    {   
        $this->authorize('update', [$this->project_repository, $id]);
        $structUpdateProject = new StructUpdateProject($request->all());        
        $projectResource = $this->project_workflow->update($structUpdateProject);
        return response()->json( $projectResource );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->project_repository, $id]);
        return response()->json( $this->project_workflow->destroy($id) );
    }

    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD END
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=



    

    /**
     * *enter description here.*
     *
     * @param  ProjectgetWithDefinitionsRequest
     * @return \Illuminate\Http\Response
     */
    public function getWithDefinitions(ProjectgetWithDefinitionsRequest $request)
    {
        $this->authorize('getWithDefinitions', [$this->project_repository]);
        return response()->json( $this->project_workflow->getWithDefinitions($request) );
    }




    /**
     * *enter description here.*
     *
     * @param  ProjectgetWithDefinitionsEntitiesRequest
     * @return \Illuminate\Http\Response
     */
    public function getWithDefinitionsEntities(ProjectgetWithDefinitionsEntitiesRequest $request)
    {
        $this->authorize('getWithDefinitionsEntities', [$this->project_repository]);
        return response()->json( $this->project_workflow->getWithDefinitionsEntities($request) );
    }



}
