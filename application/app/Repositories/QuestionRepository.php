<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionRepository
{
    public function index(Request $request)
    {

    }

    private function searchMySql(Request $request = null)
    {
        $items = Question::query()
            ->latest()
            ->when($request && $request->filled('search') , function ($q) use ($request) {
                return $q->where('title','like','%'.$request->input('search').'%');
            })->get();

        return $items;
    }

    public function store($data)
    {
        try {
            $question = Question::query()->create($data);
            return $question;
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }

    public function update($id , $data)
    {
        try {
            return Question::query()->where('id',$id)
                ->update($data);
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }

    public function destroy($id)
    {
        return Question::destroy($id);
    }

    public function find($id)
    {
        return Question::query()->findOrFail($id);
    }
}