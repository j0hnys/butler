<?php

namespace App\Trident\Workflows\Logic;

use App\Models\Test as TestModel;
use App\Trident\Workflows\Exceptions\TestException;
use App\Trident\Interfaces\Workflows\Repositories\TestRepositoryInterface as TestRepository;
use App\Trident\Interfaces\Workflows\Logic\TestInterface;
use App\Trident\Interfaces\Business\Logic\TestInterface as TestBusiness;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructIndexTest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructStoreTest;
use App\Trident\Workflows\Schemas\Logic\Test\Typed\StructUpdateTest;
use App\Trident\Workflows\Schemas\Logic\Test\Resources\TestResource;
use App\Trident\Workflows\Schemas\Logic\Test\Resources\TestResourceCollection;
use App\Trident\Workflows\Schemas\Logic\Test\Resources\TestgenerateResource;
use App\Trident\Workflows\Schemas\Logic\Test\Resources\TestgetParentsResourceCollection;

class Test implements TestInterface
{
    
    /**
     * @var \App
     */
    protected $app;

    /**
     * @var TestBusiness
     */
    protected $test_business;
    
    /**
     * @var TestRepository
     */
    protected $test_repository;

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct(TestBusiness $test_business, TestRepository $test_repository)
    {
        $this->test_business = $test_business;
        $this->test_repository = $test_repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param  StructIndexTest $structIndexTest
     * @return TestResourceCollection
     */
    public function index(StructIndexTest $structIndexTest): TestResourceCollection
    {
        $data = $structIndexTest->getFilledValues();
        
        $tests = $this->test_repository->get();
        return new TestResourceCollection($tests);
        
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
     * @param  StructStoreTest  $structStoreTest
     * @return TestResource
     */
    public function store(StructStoreTest  $structStoreTest): TestResource
    {        
        $data = $structStoreTest->getFilledValues();
        $new_test = $this->test_repository->create($data);

        return new TestResource($new_test);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TestResource
     */
    public function show($id): TestResource
    {
        $test = $this->test_repository->findOrFail($id);
        return new TestResource($test);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return TestModel
     */
    public function edit($id): TestModel
    {
        return $this->test_repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StructUpdateTest  $structUpdateTest
     * @return TestResource
     */
    public function update(StructUpdateTest  $structUpdateTest): TestResource
    {   
        $id = $structUpdateTest['id'];
        $data = $structUpdateTest->getFilledValues();
        $test = $this->test_repository->findOrFail($id);

        try {
            $test->update($data);
        } catch (\Exception $e) {
            throw new TestException('updateFailed');
        }

        return new TestResource($test);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Boolean
     */
    public function destroy($id)
    {
        $deleted_count = $this->test_repository->destroy($id);
        return ($deleted_count > 0);
    }

    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function generate($request_struct, $id)
    {   
        $model = $this->test_repository->with(['project','definition','entity'])->find($id);
        
        $this->test_business->generate(
            $model->getAttributes(),
            $model->getRelations()['project']->getAttributes(),
            $model->getRelations()['definition']->getAttributes(),
            $model->getRelations()['entity']->getAttributes(),
        );

        return new TestgenerateResource( $model );
    }



    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function getParents($request_struct, $id)
    {   
        $data = $request_struct->getFilledValues();
        $model = [];
        
        if ($id) {
            $model = $this->test_repository->get()->where('parent_id', $id);
        } else {
            $model = $this->test_repository->get()->where('parent_id', 0);
        }

        return new TestgetParentsResourceCollection( $model );
    }


}
