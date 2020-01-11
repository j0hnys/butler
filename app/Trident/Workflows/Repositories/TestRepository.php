<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\TestRepositoryInterface;

class TestRepository extends DbRepository implements TestRepositoryInterface
{
    public function model()
    {
        return 'App\Models\Test';
    }
}