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

        if (!is_dir($data['root_folder'])) {
            mkdir(str_replace('\\', '/', $data['root_folder']), 0777);
            $command .= 'cd '.str_replace('\\', '/', $data['root_folder']).' && ';
            $command .= 'git clone https://github.com/j0hnys/trident-vista-project.git . && ';
            $command .= 'git remote rm origin';
        } else {
            throw new \Exception("project already made", 1);
        }
        
        shell_exec( $command );

        //change .env.example with projects root folder name
        $env_example_contents = \file_get_contents($data['root_folder'].'/.env.example');
        $env_example_contents = \str_replace('trident-vista-project', \pathinfo($data['root_folder'])['basename'], $env_example_contents);
        $env_example_contents = \str_replace('laravel', $data['db_connection_name'], $env_example_contents);
        \file_put_contents($data['root_folder'].'/.env.example', $env_example_contents);
        \file_put_contents($data['root_folder'].'/.env', $env_example_contents);

        //change webpack.mix.js with projects root folder name
        $webpack_mix_contents = \file_get_contents($data['root_folder'].'/webpack.mix.js');
        $webpack_mix_contents = \str_replace('trident-vista-project', \pathinfo($data['root_folder'])['basename'], $webpack_mix_contents);
        \file_put_contents($data['root_folder'].'/webpack.mix.js', $webpack_mix_contents);

    }


}
