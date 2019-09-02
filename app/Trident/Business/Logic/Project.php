<?php

namespace App\Trident\Business\Logic;

use App\Trident\Business\Exceptions\ProjectException;
use App\Trident\Interfaces\Business\Logic\ProjectInterface;


class Project implements ProjectInterface
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
     * *description goes here*.
     *
     * @var array
     * @return void
     */
    public function make(Array $data): void
    {
        $command = '';

        if (!is_dir($data['root_folder']) || true) {
            mkdir(str_replace('\\', '/', $data['root_folder']), 0777);
            $command .= 'cd '.str_replace('\\', '/', $data['root_folder']).' && ';
            $command .= 'git clone https://github.com/j0hnys/trident-vista-project.git .';
        } else {
            throw new \Exception("project already made", 1);
        }
        
        shell_exec( $command );
    }


}
