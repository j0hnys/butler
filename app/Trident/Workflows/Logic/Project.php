<?php

namespace App\Trident\Workflows\Logic;

use App\Models\Project as ProjectModel;
use App\Trident\Workflows\Exceptions\ProjectException;
use App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface as ProjectRepository;
use App\Trident\Interfaces\Workflows\Logic\ProjectInterface;
use App\Trident\Interfaces\Business\Logic\ProjectInterface as ProjectBusiness;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructIndexProject;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructStoreProject;
use App\Trident\Workflows\Schemas\Logic\Project\Typed\StructUpdateProject;
use App\Trident\Workflows\Schemas\Logic\Project\Resources\ProjectResource;
use App\Trident\Workflows\Schemas\Logic\Project\Resources\ProjectResourceCollection;

class Project implements ProjectInterface
{
    
    /**
     * @var \App
     */
    protected $app;

    /**
     * @var ProjectBusiness
     */
    protected $project_business;
    
    /**
     * @var ProjectRepository
     */
    protected $project_repository;

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct(ProjectBusiness $projectBusiness, ProjectRepository $projectRepository)
    {
        $this->project_business = $projectBusiness;
        $this->project_repository = $projectRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param  StructIndexProject $structIndexProject
     * @return ProjectResourceCollection
     */
    public function index(StructIndexProject $structIndexProject): ProjectResourceCollection
    {
        $data = $structIndexProject->getFilledValues();
        
        $projects = $this->project_repository->get();
        return new ProjectResourceCollection($projects);
        
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
     * @param  StructStoreProject  $structStoreProject
     * @return ProjectResource
     */
    public function store(StructStoreProject  $structStoreProject): ProjectResource
    {        
        $data = $structStoreProject->getFilledValues();
        $new_project = $this->project_repository->create($data);

        return new ProjectResource($new_project);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProjectResource
     */
    public function show($id): ProjectResource
    {
        $project = $this->project_repository->findOrFail($id);
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return ProjectModel
     */
    public function edit($id): ProjectModel
    {
        return $this->project_repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StructUpdateProject  $structUpdateProject
     * @return ProjectResource
     */
    public function update(StructUpdateProject  $structUpdateProject): ProjectResource
    {   
        $id = $structUpdateProject['id'];
        $data = $structUpdateProject->getFilledValues();
        $project = $this->project_repository->findOrFail($id);

        try {
            $project->update($data);
        } catch (\Exception $e) {
            throw new ProjectException('updateFailed');
        }

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Boolean
     */
    public function destroy($id)
    {
        $deleted_count = $this->project_repository->destroy($id);
        return ($deleted_count > 0);
    }
}
