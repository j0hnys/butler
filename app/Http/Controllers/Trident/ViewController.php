<?php

namespace App\Http\Controllers\Trident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trident\Interfaces\Workflows\Logic\ViewInterface as ViewWorkflow;
use App\Trident\Interfaces\Workflows\Repositories\ViewRepositoryInterface as ViewRepository;
use App\Trident\Workflows\Validations\ViewgenerateRequest;
use App\Trident\Workflows\Validations\ViewStoreRequest;
use App\Trident\Workflows\Validations\ViewUpdateRequest;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructIndexView;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructStoreView;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructUpdateView;

class ViewController extends Controller
{
    
    /**
     * @var ViewWorkflow
     */
    protected $view_workflow;
    
    /**
     * @var ViewRepository
     */
    protected $view_repository;

    public function __construct(ViewWorkflow $viewWorkflow, ViewRepository $view_repository)
    {
        $this->view_workflow = $viewWorkflow;
        $this->view_repository = $view_repository;
    }


    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD START
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return ViewRepository
     */
    public function index(Request $request)
    {
        $this->authorize('list',$this->view_repository);
        $structIndexView = new StructIndexView( $request->all() );
        $viewResourceCollection = $this->view_workflow->index($structIndexView);
        return response()->json( $viewResourceCollection );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $this->authorize('create',$this->view_repository);
        return view('view_create');  //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ViewStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ViewStoreRequest $request)
    {
        $this->authorize('create',$this->view_repository);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['entity_id'] = (int)$request_all['entity_id'];
        $structStoreView = new StructStoreView( $request_all );
        $viewResource = $this->view_workflow->store($structStoreView);
        return response()->json( $viewResource );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', [$this->view_repository, $id]);
        return response()->json( $this->view_workflow->show($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('update', [$this->view_repository, $id]);
        $view = $this->view_workflow->edit($id);
        return view('view_edit', compact('view'));    //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ViewUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ViewUpdateRequest $request, $id)
    {   
        $this->authorize('update', [$this->view_repository, $id]);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['entity_id'] = (int)$request_all['entity_id'];
        $structUpdateView = new StructUpdateView($request_all);        
        $viewResource = $this->view_workflow->update($structUpdateView);
        return response()->json( $viewResource );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->view_repository, $id]);
        return response()->json( $this->view_workflow->destroy($id) );
    }

    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD END
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=



    

    /**
     * @param  ViewgenerateRequest
     * @return \Illuminate\Http\Response
     */
    public function generate(ViewgenerateRequest $request,$id)
    {
        $this->authorize('generate', [$this->view_repository,$id]);
        $request_all = $request->all();
        return response()->json( $this->view_workflow->generate($request_all, $id) );
    }




}
