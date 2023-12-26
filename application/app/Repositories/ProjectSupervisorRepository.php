<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for project supervisors
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\ProjectSupervisor;
use Illuminate\Http\Request;
use Log;

class ProjectSupervisorRepository {

    /**
     * The supervisor repository instance.
     */
    protected $supervisor;

    /**
     * Inject dependecies
     */
    public function __construct(ProjectSupervisor $supervisor) {
        $this->supervisor = $supervisor;
    }

    /**
     * Bulk delete supervisor users for a particular project
     * @param int $project_id the id of the project
     * @return null
     */
    public function delete($project_id = '') {

        //validations
        if (!is_numeric($project_id)) {
            Log::error("validation error - invalid params", ['process' => '[ProjectSupervisorRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        $query = $this->supervisor->newQuery();
        $query->where('project_id', '=', $project_id);
        $query->delete();
    }

    /**
     * supervisor new users to a project
     * @param int $project_id the id of the project
     * @return bool
     */
    public function add($project_id = '') {
        //add only to the specified user
        if (is_numeric(request('supervisor')) && is_numeric($project_id)) {
            $supervisor = new $this->supervisor;
            $supervisor->project_id = $project_id;
            $supervisor->user_id = request('supervisor');
            $supervisor->save();
            return;
        }
    }

}