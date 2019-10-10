<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\EntityRepositoryInterface;

class EntityRepository extends DbRepository implements EntityRepositoryInterface
{    
    public function model()
    {
        return 'App\Models\Entity';
    }
}