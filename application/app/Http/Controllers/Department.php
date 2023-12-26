<?php

namespace App\Http\Controllers;

use App\Http\Requests\Departments\DepartmentRequest;
use App\Http\Responses\Departments\CreateResponse;
use App\Http\Responses\Departments\DepartmentResponse;
use App\Http\Responses\Departments\DestroyResponse;
use App\Http\Responses\Departments\EditResponse;
use App\Http\Responses\Departments\IndexResponse;
use App\Http\Responses\Departments\StoreResponse;
use App\Http\Responses\Departments\UpdateResponse;
use App\Repositories\DepartmentRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Department extends Controller
{
    protected $projectrepo;
    protected $departmentrepo;

    protected $userrepo;

    public function __construct(
        DepartmentRepository $departmentRepository ,
        ProjectRepository $projectRepository ,
        UserRepository $userRepository
    )
    {
        $this->projectrepo = $projectRepository;
        $this->departmentrepo = $departmentRepository;
        $this->userrepo = $userRepository;
    }

    public function index(Request $request)
    {
        $items = $this->departmentrepo->index(tree: true);
        $page = $this->pageSettings('departments');

        return view('pages.departments.wrapper',['items' => $items ,'page' => $page]);
    }

    public function search(Request $request)
    {
        $items = $this->departmentrepo->index($request);
        $page = $this->pageSettings('departments');

        return new IndexResponse([
            'items' => $items ,'page' => $page
        ]);
    }


    public function edit(Request $request , $department)
    {
        $department = $this->departmentrepo->find($department);
        $payload = [
            'department' => $department,
            'page' => $this->pageSettings('edit'),
            'departments' => $this->departmentrepo->index(null,[$department->id])
        ];
        return new EditResponse($payload);
    }

    public function create()
    {
        return new CreateResponse([
            'departments' => $this->departmentrepo->index()
        ]);
    }

    public function store(Request $request)
    {
        $messages = [];
        //validate
        $validator = Validator::make(request()->all(), [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:300'],
            'managers' => ['nullable','array','max:10'],
            'managers.*' => ['required','exists:users,id'],
            'parent_id' => ['nullable','exists:departments,id']
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
            $this->departmentrepo->store(
                $request->only(['title','description','parent_id']),
                $request->input('managers') ?? null
            );
            return new StoreResponse([
                'items' => $this->departmentrepo->index(\request(),null,true),
                'page' => $this->pageSettings('departments')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => app()->environment('local') ? $e->getMessage() : 'error'
            ],500);
        }
    }

    public function update(Request $request , $department)
    {
        $messages = [];
        //validate
        $validator = Validator::make(request()->all(), [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:300'],
            'managers' => ['nullable','array','max:10'],
            'managers.*' => ['required','exists:users,id'],
            'parent_id' => ['nullable',Rule::exists('departments','id')->whereNot('id',$department)]
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
            $dep = $this->departmentrepo->update(
                $department,
                $request->only(['title','description','parent_id']),
                $request->input('managers') ?? []
            );

            $payload = [
                'items' => $this->departmentrepo->index(\request(),null,true),
                'department' => $department,
                'page' => $this->pageSettings('departments')
            ];

            return new UpdateResponse($payload);

        } catch (\Exception $e) {
            return response()->json([
                'message' => app()->environment('local') ? $e->getMessage() : 'error'
            ],500);
        }
    }

    public function destroy($department)
    {
        $deleted = $this->departmentrepo->destroy($department);
        if ($deleted) {
            $payload = [
                'department' => $department,
            ];
            return new DestroyResponse($payload);
        }
    }

    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                __('lang.departments'),
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'departments',
            'no_results_message' => __('lang.no_results_found'),
            'submenu_projects_category_' . request('filter_category') => 'active',
            'sidepanel_id' => 'sidepanel-filter-departments',
            'dynamic_search_url' => url('departments/search'),
            'add_button_classes' => 'add-edit-department-button',
            'load_more_button_route' => 'departments',
            'source' => 'list',
        ];


        //default modal settings (modify for sepecif sections)
        $page += [
            'add_modal_title' => __('lang.add_department'),
            'add_modal_create_url' => route('admin.departments.create'),
            'add_modal_action_url' => route('admin.departments.save'),
            'add_modal_action_ajax_class' => '',
            'add_modal_action_ajax_loading_target' => 'commonModalBody',
            'add_modal_action_method' => 'POST',
        ];

        //projects list page
        if ($section == 'departments') {
            $page += [
                'meta_title' => __('lang.departments'),
                'heading' => __('lang.departments'),
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
        if ($section == 'department') {
            //adjust
            $page['page'] = 'department';

            //crumbs
            $page['crumbs'] = [
                __('lang.department'),
                '#' . $data->id,
            ];

            //add
            $page += [
                'crumbs_special_class' => 'main-pages-crumbs',
                'meta_title' => __('lang.departments') . ' - ' . $data->title,
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
