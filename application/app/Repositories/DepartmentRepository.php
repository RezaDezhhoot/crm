<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentRepository
{
    public function index(Request $request = null , $ignore = null , $tree = false)
    {
        $items = Department::query()
            ->latest()
            ->when($tree , function ($q){
                return $q->whereNull('parent_id')->with(['child','parent']);
            })->when($ignore,function ($q) use ($ignore){
                return $q->whereNotIn('id',$ignore);
            })->withCount('projects')
            ->when($request && $request->filled('search'),function ($q) use ($request){
                return $q->where('title','like','%'.$request->get('search').'%');
            })->get();

        return $items;
    }

    public function store($data , $managers = null)
    {
        try {
            DB::beginTransaction();
            $dep = Department::query()->create($data);
            if ($managers && sizeof($managers) > 0) {
                $dep->managers()->attach($managers);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }

        return $dep;
    }

    public function update($id , $data , $managers = null)
    {
        try {
            DB::beginTransaction();
            $dep = Department::query()->findOrFail($id);
            $dep->update($data);
            if ($managers && is_array($managers)) {
                $dep->managers()->sync($managers);
            }
            DB::commit();
            return $dep;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }
    }

    public function destroy($id)
    {
        return Department::destroy($id);
    }

    public function find($id)
    {
        $dep = Department::query()->with('managers')->findOrFail($id);
        return $dep;
    }
}