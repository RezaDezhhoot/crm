<?php

namespace App\Http\Controllers;

use App\Http\Responses\Skills\CreateResponse;
use App\Http\Responses\Skills\DestroyResponse;
use App\Http\Responses\Skills\EditResponse;
use App\Http\Responses\Skills\IndexResponse;
use App\Http\Responses\Skills\StoreResponse;
use App\Http\Responses\Skills\UpdateResponse;
use App\Repositories\SkillRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Skill extends Controller
{
    protected $userrepo;
    protected $skillrepo;

    public function __construct(
        SkillRepository $skillRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct();
        $this->skillrepo = $skillRepository;
        $this->userrepo = $userRepository;
    }

    public function index()
    {
        $items = $this->skillrepo->index(tree: true);
        $page = $this->pageSettings('skills');

        return view('pages.skills.wrapper',['items' => $items ,'page' => $page]);

    }

    public function search(Request $request)
    {
        $items = $this->skillrepo->index($request);
        $page = $this->pageSettings('skills');

        return new IndexResponse([
            'items' => $items ,'page' => $page
        ]);
    }

    public function edit(Request $request , $skill)
    {
        $skill = $this->skillrepo->find($skill);
        $payload = [
            'skill' => $skill,
            'page' => $this->pageSettings('edit'),
            'skills' => $this->skillrepo->index(null,[$skill->id])
        ];
        return new EditResponse($payload);
    }

    public function create()
    {
        return new CreateResponse([
            'skills' => $this->skillrepo->index()
        ]);
    }

    public function store(Request $request)
    {
        $messages = [];
        //validate
        $validator = Validator::make(request()->all(), [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:300'],
            'users' => ['nullable','array','max:10'],
            'users.*' => ['required','exists:users,id'],
            'parent_id' => ['nullable','exists:skills,id']
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        try {
            $this->skillrepo->store(
                $request->only(['title','description','parent_id']),
                $request->input('users') ?? []
            );
            return new StoreResponse([
                'items' => $this->skillrepo->index(\request(),null,true),
                'page' => $this->pageSettings('skills')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => app()->environment('local') ? $e->getMessage() : 'error'
            ],500);
        }
    }


    public function update(Request $request , $skill)
    {
        $messages = [];
        //validate
        $validator = Validator::make(request()->all(), [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:300'],
            'users' => ['nullable','array','max:10'],
            'users.*' => ['required','exists:users,id'],
            'parent_id' => ['nullable','exists:skills,id']
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        try {
            $this->skillrepo->update(
                $skill,
                $request->only(['title','description','parent_id']),
                $request->input('users') ?? []
            );

            $payload = [
                'items' => $this->skillrepo->index(\request(),null,true),
                'skill' => $skill,
                'page' => $this->pageSettings('skills')
            ];

            return new UpdateResponse($payload);

        } catch (\Exception $e) {
            return response()->json([
                'message' => app()->environment('local') ? $e->getMessage() : 'error'
            ],500);
        }
    }

    public function destroy($skill)
    {
        $deleted = $this->skillrepo->destroy($skill);
        if ($deleted) {
            $payload = [
                'skill' => $skill,
            ];
            return new DestroyResponse($payload);
        }
    }

    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.skills'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'skills',
            'no_results_message' => __('lang.no_results_found'),
            'submenu_projects_category_' . request('filter_category') => 'active',
            'sidepanel_id' => 'sidepanel-filter-skills',
            'dynamic_search_url' => url('skills/search'),
            'add_button_classes' => 'add-edit-skill-button',
            'load_more_button_route' => 'skills',
            'source' => 'list',
        ];


        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_department'),
            'add_modal_create_url' => route('admin.skills.create'),
            'add_modal_action_url' => route('admin.skills.save'),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //projects list page
        if ($section == 'skills') {
            $page += [
                'meta_title' => __('lang.skills'),
                'heading' => __('lang.skills'),
                'sidepanel_id' => 'sidepanel-filter-projects',
            ];
            if (request('source') == 'ext') {
                $page += [
                    'list_page_actions_size' => 'col-lg-12',
                ];
            }
            return $page;
        }

        //project page
        if ($section == 'skill') {
            //adjust
            $page['page'] = 'skill';

            //crumbs
            $page['crumbs'] = [
                __('lang.skill'),
                '#' . $data->id,
            ];

            //add
            $page += [
                'crumbs_special_class' => 'main-pages-crumbs',
                'meta_title' => __('lang.skills') . ' - ' . $data->title,
                'heading' => $data->title,
                'project_id' => request()->segment(2),
                'source_for_filter_panels' => 'ext',
                'section' => 'overview',
            ];
            //ajax loading and tabs
            return $page;
        }

        //ext page settings
        if ($section == 'ext') {
            $page += [
                'list_page_actions_size' => 'col-lg-12',

            ];
            return $page;
        }

        //create new resource
        if ($section == 'create') {
            $page += [
                'section' => 'create',
            ];
            return $page;
        }

        //edit new resource
        if ($section == 'edit') {
            $page += [
                'section' => 'edit',
            ];
            return $page;
        }

        //return
        return $page;
    }
}
