<?php

namespace App\Trident\Interfaces\Workflows\Repositories;

interface TestRepositoryInterface
{
    public function all();
    
    public function save();

    public function get(array $columns = ['*']);

    public function show($id);

    public function paginate(int $perPage, array $columns);
    
    public function create(array $data);

    public function update(array $data, $id);

    public function delete();

    public function destroy($ids);

    public function find($id, array $columns = ['*']);

    public function findBy($attribute, $value, array $columns);

    public function findOrFail($id, array $columns = ['*']);

    public function with(array $relations);

    public function where(string $column_name, $relations);
}
