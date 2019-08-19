<?php

namespace App\Trident\Workflows\Logic;

use App\Models\View as ViewModel;
use App\Trident\Workflows\Exceptions\ViewException;
use App\Trident\Interfaces\Workflows\Repositories\ViewRepositoryInterface as ViewRepository;
use App\Trident\Interfaces\Workflows\Logic\ViewInterface;
use App\Trident\Interfaces\Business\Logic\ViewInterface as ViewBusiness;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructIndexView;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructStoreView;
use App\Trident\Workflows\Schemas\Logic\View\Typed\StructUpdateView;
use App\Trident\Workflows\Schemas\Logic\View\Resources\ViewResource;
use App\Trident\Workflows\Schemas\Logic\View\Resources\ViewResourceCollection;

class View implements ViewInterface
{
    
    /**
     * @var \App
     */
    protected $app;

    /**
     * @var ViewBusiness
     */
    protected $view_business;
    
    /**
     * @var ViewRepository
     */
    protected $view_repository;

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct(ViewBusiness $viewBusiness, ViewRepository $viewRepository)
    {
        $this->view_business = $viewBusiness;
        $this->view_repository = $viewRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param  StructIndexView $structIndexView
     * @return ViewResourceCollection
     */
    public function index(StructIndexView $structIndexView): ViewResourceCollection
    {
        $data = $structIndexView->getFilledValues();
        
        $views = $this->view_repository->get();
        return new ViewResourceCollection($views);
        
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
     * @param  StructStoreView  $structStoreView
     * @return ViewResource
     */
    public function store(StructStoreView  $structStoreView): ViewResource
    {        
        $data = $structStoreView->getFilledValues();
        $new_view = $this->view_repository->create($data);

        return new ViewResource($new_view);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ViewResource
     */
    public function show($id): ViewResource
    {
        $view = $this->view_repository->findOrFail($id);
        return new ViewResource($view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return ViewModel
     */
    public function edit($id): ViewModel
    {
        return $this->view_repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StructUpdateView  $structUpdateView
     * @return ViewResource
     */
    public function update(StructUpdateView  $structUpdateView): ViewResource
    {   
        $id = $structUpdateView['id'];
        $data = $structUpdateView->getFilledValues();
        $view = $this->view_repository->findOrFail($id);

        try {
            $view->update($data);
        } catch (\Exception $e) {
            throw new ViewException('updateFailed');
        }

        return new ViewResource($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Boolean
     */
    public function destroy($id)
    {
        $deleted_count = $this->view_repository->destroy($id);
        return ($deleted_count > 0);
    }

    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function generate($request, $id)
    {
        $model = $this->view_repository->with(['project','definition','entity'])->find($id);
        
        $this->view_business->generate(
            $model->getAttributes(),
            $model->getRelations()['project']->getAttributes(),
            $model->getRelations()['definition']->getAttributes(),
            $model->getRelations()['entity']->getAttributes(),
        );

        return $model;
    }


}
