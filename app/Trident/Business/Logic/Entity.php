<?php

namespace App\Trident\Business\Logic;

use App\Trident\Business\Exceptions\EntityException;
use App\Trident\Interfaces\Business\Logic\EntityInterface;


class Entity implements EntityInterface
{

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  array  $data
     * @return void
     */
    public function index(array $data): void
    {
        //
        // TO DO
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  array  $data
     * @return void
     */
    public function create(array $data): void
    {   
        //
        // TO DO
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return void
     */
    public function store(array $data): void
    {
        //
        // TO DO
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $data
     * @return void
     */
    public function show(array $data): void
    {
        //
        // TO DO
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  array  $data
     * @return void
     */
    public function edit(array $data): void
    {
        //
        // TO DO
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $data
     * @return void
     */
    public function update(array $data): void
    {   
        //
        // TO DO
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  array  $data
     * @return void
     */
    public function destroy(array $data): void
    {
        //
        // TO DO
        //
    }


    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function generate(Array $data): array
    {
        //
        // TO DO
        //

        return $data;
    }


}
