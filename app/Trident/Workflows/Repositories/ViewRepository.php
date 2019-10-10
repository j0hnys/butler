<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\ViewRepositoryInterface;

class ViewRepository extends DbRepository implements ViewRepositoryInterface
{
    public function model()
    {
        return 'App\Models\View';
    }
}