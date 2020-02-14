<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $definition_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Entity extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'entity';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'project_id', 'definition_id', 'name', 'functionality_data', 'request_data', 'response_data', 'db_table_name', 'type', 'parent_id', 'created_at', 'updated_at'];


    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'id');
    }

    
    public function definition()
    {
        return $this->belongsTo(\App\Models\Definition::class, 'definition_id', 'id');
    }


    public function tests()
    {
        return $this->hasMany(\App\Models\Test::class, 'entity_id', 'id');
    }

}
