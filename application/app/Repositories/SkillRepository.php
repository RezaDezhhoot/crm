<?php

namespace App\Repositories;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillRepository
{
    public function index(Request $request = null , $ignore = null , $tree = false) {
        return $this->searchMysql($request , $ignore , $tree);
    }

    private function searchMysql(Request $request = null , $ignore = null , $tree = false)
    {
        $items = Skill::query()
            ->latest()
            ->when($tree,function ($q) {
                return $q->with(['parent','child'])->whereNull('parent_id');
            })->when($ignore,function ($q) use ($ignore) {
                return $q->whereNotIN('id',$ignore);
            })->when($request && $request->filled('search'),function ($q) use ($request) {
                return $q->where('title','like','%'.$request->input('search').'%');
            })->get();

        return $items;
    }

    public function store($data , $users = [])
    {
        try {
            DB::beginTransaction();
            $skill = Skill::query()->create($data);
            if (sizeof($users) > 0) {
                $skill->users()->attach($users);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }
    }

    public function update($id , $data , $users = [])
    {
        try {
            DB::beginTransaction();
            $skill = Skill::query()->findOrFail($id);
            $skill->update($data);
            $skill->users()->attach($users);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw $e;
        }
    }

    public function destroy($id)
    {
        return Skill::destroy($id);
    }

    public function find($id , $with = [])
    {
        return Skill::query()->when(sizeof($with) > 0 , function ($q) use ($with) {
            return $q->with($with);
        })->findOrFail($id);
    }
}