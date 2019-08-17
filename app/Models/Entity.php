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
    protected $fillable = ['user_id', 'project_id', 'definition_id', 'name', 'created_at', 'updated_at'];

}