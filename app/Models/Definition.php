<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property string $namespace
 * @property string $created_at
 * @property string $updated_at
 */
class Definition extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'definition';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'namespace', 'created_at', 'updated_at'];


    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

}
