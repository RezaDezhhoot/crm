<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSupervisor extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */
    protected $guarded = ['id'];
}
