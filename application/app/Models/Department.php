<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Department extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function projects()
    {
        return $this->belongsToMany(Project::class,'department_project','department_id','project_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_department','department_id','user_id');
    }

    public function managers()
    {
        return $this->belongsToMany(User::class,'departments_managers','department_id','user_id');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function child()
    {
        return $this->children()->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }
}
