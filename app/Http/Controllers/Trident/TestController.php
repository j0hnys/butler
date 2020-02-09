<?php

namespace App\Http\Controllers\Trident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trident\Interfaces\Workflows\Logic\TestInterface as TestWorkflow;
use App\Trident\Interfaces\Workflows\Repositories\TestRepositoryInterface as TestRepository;
use App\Trident\Workflows\Validations\TestStoreRequest;
use App\Trident\Workflows\Validations\TestUpdateRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructIndexTest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructStoreTest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructUpdateTest;
use App\Trident\Workflows\Validations\TestGenerateRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructGenerateTest;
use App\Trident\Workflows\Validations\TestGetParentsRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructGetParentsTest;
use App\Trident\Workflows\Validations\TestRefreshRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructRefreshTest;
use App\Trident\Workflows\Validations\TestGenerateFeatureRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructGenerateFeatureTest;
use App\Trident\Workflows\Validations\TestRefreshFeatureRequest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructRefreshFeatureTest;

class TestController extends Controller
{
    
    /**
     * @var TestWorkflow
     */
    protected $test_workflow;
    
    /**
     * @var TestRepository
     */
    protected $test_repository;

    public function __construct(TestWorkflow $test_workflow, TestRepository $test_repository)
    {
        $this->test_workflow = $test_workflow;
        $this->test_repository = $test_repository;
    }


    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD START
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @return TestRepository
     */
    public function index(Request $request)
    {
        $this->authorize('list',$this->test_repository);
        $structIndexTest = new StructIndexTest( $request->all() );
        $testResourceCollection = $this->test_workflow->index($structIndexTest);
        return response()->json( $testResourceCollection );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $this->authorize('create',$this->test_repository);
        return view('test_create');  //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TestStoreRequest $request)
    {
        $this->authorize('create',$this->test_repository);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['entity_id'] = (int)$request_all['entity_id'];
        $request_all['parent_id'] = (int)$request_all['parent_id'];
        $structStoreTest = new StructStoreTest( $request_all );
        $testResource = $this->test_workflow->store($structStoreTest);
        return response()->json( $testResource );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $this->authorize('view', [$this->test_repository, $id]);
        return response()->json( $this->test_workflow->show($id) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('update', [$this->test_repository, $id]);
        $test = $this->test_workflow->edit($id);
        return view('test_edit', compact('test'));    //ayto DEN tha to exw sto restful_crud code generation
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TestUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TestUpdateRequest $request, $id)
    {   
        $this->authorize('update', [$this->test_repository, $id]);
        $request_all = $request->all();
        $request_all['project_id'] = (int)$request_all['project_id'];
        $request_all['definition_id'] = (int)$request_all['definition_id'];
        $request_all['entity_id'] = (int)$request_all['entity_id'];
        $request_all['parent_id'] = (int)$request_all['parent_id'];
        $structUpdateTest = new StructUpdateTest($request_all);        
        $testResource = $this->test_workflow->update($structUpdateTest);
        return response()->json( $testResource );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', [$this->test_repository, $id]);
        return response()->json( $this->test_workflow->destroy($id) );
    }

    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // RESTFUL CRUD END
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


    /**
     * *enter description here.*
     *
     * @param  TestgenerateRequest
     * @return \Illuminate\Http\Response
     */
    public function generate(TestGenerateRequest $request, $id)
    {   
        $this->authorize('generate', [$this->test_repository,$id]);
        $structgenerateTest = new StructGenerateTest($request->all());    
        $testgenerateResource = $this->test_workflow->generate( $structgenerateTest ,$id);
        return response()->json( $testgenerateResource );
    }


    /**
     * @param  TestgetParentsRequest
     * @return \Illuminate\Http\Response
     */
    public function getParents(TestGetParentsRequest $request, $id = 0)
    {   
        $this->authorize('getParents', [$this->test_repository,$id]);
        $request_all = $request->all();
        $request_all['id'] = (int)$request_all['id'];
        $structgetParentsTest = new StructGetParentsTest($request_all);    
        $testgetParentsResource = $this->test_workflow->getParents( $structgetParentsTest, $id);
        return response()->json( $testgetParentsResource );
    }


    /**
     * @param  TestrefreshRequest
     * @return \Illuminate\Http\Response
     */
    public function refresh(TestRefreshRequest $request, $id)
    {   
        $this->authorize('refresh', [$this->test_repository,$id]);
        $structrefreshTest = new StructRefreshTest($request->all());    
        $testrefreshResource = $this->test_workflow->refresh( $structrefreshTest ,$id);
        return response()->json( $testrefreshResource );
    }


    /**
     * @param  TestgenerateFeatureRequest
     * @return \Illuminate\Http\Response
     */
    public function generateFeature(TestGenerateFeatureRequest $request, $id)
    {   
        $this->authorize('generateFeature', [$this->test_repository,$id]);
        $structgenerateFeatureTest = new StructGenerateFeatureTest($request->all());    
        $testgenerateFeatureResource = $this->test_workflow->generateFeature( $structgenerateFeatureTest ,$id);
        return response()->json( $testgenerateFeatureResource );
    }


    /**
     * @param  TestrefreshFeatureRequest
     * @return \Illuminate\Http\Response
     */
    public function refreshFeature(TestRefreshFeatureRequest $request, $id)
    {   
        $this->authorize('refreshFeature', [$this->test_repository,$id]);
        $structrefreshFeatureTest = new StructRefreshFeatureTest($request->all());    
        $testrefreshFeatureResource = $this->test_workflow->refreshFeature( $structrefreshFeatureTest ,$id);
        return response()->json( $testrefreshFeatureResource );
    }



}
