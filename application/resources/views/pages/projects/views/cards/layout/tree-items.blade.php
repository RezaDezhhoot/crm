<tr id="project_{{ $parent->project_id }}">
    <td colspan="12" class="hiddenRow">
        <div class="accordian-body border collapse rounded " id="child{{$parent->project_id}}">
            <table class="table table-bordered table-hover p-3 table-sm " >
                <thead>
                <tr>
                    @if(config('visibility.projects_col_checkboxes'))
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                    <input type="checkbox" id="listcheckbox-projects" name="listcheckbox-projects"
                                           class="listcheckbox-all filled-in chk-col-light-blue"
                                           data-actions-container-class="projects-checkbox-actions-container"
                                           data-children-checkbox-class="listcheckbox-projects">
                                    <label for="listcheckbox-projects"></label>
                                </span>
                        </th>
                    @endif
                    <th class="projects_col_id">
                        <a class="js-ajax-ux-request js-list-sorting" id="sort_project_id"
                           href="javascript:void(0)"
                           data-url="{{ urlResource('/projects?action=sort&orderby=project_id&sortorder=asc') }}">{{ cleanLang(__('lang.id')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    <th class="projects_col_project">
                        <a class="js-ajax-ux-request js-list-sorting" id="sort_project_title"
                           href="javascript:void(0)"
                           data-url="{{ urlResource('/projects?action=sort&orderby=project_title&sortorder=asc') }}">{{ cleanLang(__('lang.title')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    @if(config('visibility.projects_col_client'))
                        <th class="projects_col_client">
                            <a class="js-ajax-ux-request js-list-sorting" id="sort_project_client"
                               href="javascript:void(0)"
                               data-url="{{ urlResource('/projects?action=sort&orderby=project_client&sortorder=asc') }}">{{ cleanLang(__('lang.client')) }}<span
                                        class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                        </th>
                    @endif
                    <th class="projects_col_start_date hidden">
                        <a class="js-ajax-ux-request js-list-sorting" id="sort_project_date_start"
                           href="javascript:void(0)"
                           data-url="{{ urlResource('/projects?action=sort&orderby=project_date_start&sortorder=asc') }}">{{ cleanLang(__('lang.start_date')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    <th class="projects_col_end_date">
                        <a class="js-ajax-ux-request js-list-sorting" id="sort_project_date_due"
                           href="javascript:void(0)"
                           data-url="{{ urlResource('/projects?action=sort&orderby=project_date_due&sortorder=asc') }}">{{ cleanLang(__('lang.due_date')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    @if(config('visibility.projects_col_tags'))
                        <th class="projects_col_tags">{{ cleanLang(__('lang.tags')) }}</th>
                    @endif
                    <th class="projects_col_progress"><a class="js-ajax-ux-request js-list-sorting"
                                                         id="sort_project_progress" href="javascript:void(0)"
                                                         data-url="{{ urlResource('/projects?action=sort&orderby=project_progress&sortorder=asc') }}">{{ cleanLang(__('lang.progress')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    @if(config('visibility.projects_col_team'))
                        <th class="projects_col_team"><a
                                    href="javascript:void(0)">{{ cleanLang(__('lang.team')) }}</a></th>
                    @endif
                    <th class="projects_col_status">
                        <a class="js-ajax-ux-request js-list-sorting" id="sort_project_status"
                           href="javascript:void(0)"
                           data-url="{{ urlResource('/projects?action=sort&orderby=project_status&sortorder=asc') }}">{{ cleanLang(__('lang.status')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    @if(config('visibility.projects_col_actions'))
                        <th class="projects_col_action"><a
                                    href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    @endif
                </tr>
                </thead>
                <tbody id="projects-td-container{{$parent->project_id}}">
                    @foreach($children as $child)
                        <tr data-toggle="collapse" id="project_{{ $child->project_id }}"  class="accordion-toggle" data-target="#child{{$child->project_id}}">
                            @if(config('visibility.projects_col_checkboxes'))
                                <td class="projects_col_checkbox checkitem" id="projects_col_checkbox_{{ $child->project_id }}">
                                    <!--list checkbox-->
                                    <span class="list-checkboxes display-inline-block w-px-20">
                                    <input type="checkbox" id="listcheckbox-projects-{{ $child->project_id }}"
                                           name="ids[{{ $child->project_id }}]"
                                           class="listcheckbox listcheckbox-projects filled-in chk-col-light-blue"
                                           data-actions-container-class="projects-checkbox-actions-container">
                                    <label for="listcheckbox-projects-{{ $child->project_id }}"></label>
                                </span>
                                </td>
                            @endif
                            <td class="projects_col_id">
                                <a href="{{ _url('/projects/'.$child->project_id) }}">{{ $child->project_id }}</label></a>
                            </td>
                            <td class="projects_col_project">
                                <a href="{{ _url('/projects/'.$child->project_id) }}">{{ str_limit($child->project_title ??'---', 20) }}<a />
                                    <!--automation-->
                                    @if(auth()->user()->is_team && $child->project_automation_status == 'enabled')
                                        <span class="sl-icon-energy text-warning p-l-5" data-toggle="tooltip"
                                              title="@lang('lang.project_automation')"></span>
                                @endif
                            </td>
                            @if(config('visibility.projects_col_client'))
                                <td class="projects_col_client">
                                    <a
                                            href="/clients/{{ $child->project_clientid }}">{{ str_limit($child->client->client_company_name ??'---', 12) }}</a>
                                </td>
                            @endif
                            <td class="projects_col_start_date hidden">
                                {{ runtimeDate($child->project_date_start) }}
                            </td>
                            <td class="projects_col_end_date">{{ runtimeDate($child->project_date_due) }}</td>
                            @if(config('visibility.projects_col_tags'))
                                <td class="projects_col_tags">
                                    <!--tag-->
                                    @if(count($child->tags ?? []) > 0)
                                        @foreach($child->tags->take(1) as $tag)
                                            <span class="label label-outline-default">{{ str_limit($child->tag_title, 15) }}</span>
                                        @endforeach
                                    @else
                                        <span>---</span>
                                    @endif
                                    <!--/#tag-->

                                    <!--more tags (greater than tags->take(x) number above -->
                                    @if(count($project->tags ?? []) > 1)
                                        @php $tags = $project->tags; @endphp
                                        @include('misc.more-tags')
                                    @endif
                                    <!--more tags-->
                                </td>
                            @endif
                            <td class="projects_col_progress p-r-20">
                                <div class="progress" data-toggle="tooltip" title="{{ $child->project_progress }}%">
                                    @if($child->project_progress == 100)
                                        <div class="progress-bar bg-success w-100 h-px-10 font-11 font-weight-500" data-toggle="tooltip"
                                             title="100%" role="progressbar"></div>
                                    @else
                                        <!--dynamic inline style-->
                                        <div class="progress-bar bg-info h-px-10 font-16 font-weight-500 w-{{ round($child->project_progress) }}"
                                             role="progressbar"></div>
                                    @endif
                                </div>
                            </td>
                            @if(config('visibility.projects_col_team'))
                                <td class="projects_col_team">
                                    <!--assigned users-->
                                    @if(count($child->assigned ?? []) > 0)
                                        @foreach($child->assigned->take(2) as $user)
                                            <img src="{{ $user->avatar }}" data-toggle="tooltip" title="{{ $user->first_name }}" data-placement="top"
                                                 alt="{{ $user->first_name }}" class="img-circle avatar-xsmall">
                                        @endforeach
                                    @else
                                        <span>---</span>
                                    @endif
                                    <!--assigned users-->
                                    <!--more users-->
                                    @if(count($child->assigned ?? []) > 2)
                                        @php $more_users_title = __('lang.assigned_users'); $users = $child->assigned; @endphp
                                        @include('misc.more-users')
                                    @endif
                                    <!--more users-->
                                </td>
                            @endif
                            <td class="projects_col_status">
                                <span
                                        class="label {{ runtimeProjectStatusColors($child->project_status, 'label') }}">{{ runtimeLang($child->project_status) }}</span>
                                <!--archived-->
                                @if($child->project_active_state == 'archived' && runtimeArchivingOptions())
                                    <span class="label label-icons label-icons-default" data-toggle="tooltip" data-placement="top"
                                          title="@lang('lang.archived')"><i class="ti-archive"></i></span>
                                @endif
                            </td>
                            @if(config('visibility.projects_col_actions'))
                                <td class="projects_col_action actions_column">
                                    <!--action button-->
                                    <span class="list-table-action dropdown font-size-inherit">
                                         @if(config('visibility.action_buttons_delete'))
                                            <!--[delete]-->
                                            @if($child->permission_delete_project)
                                                <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                                                        class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                                                        data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                                                        data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                                                        data-url="{{ _url('/projects/'.$child->project_id) }}">
                                                    <i class="sl-icon-trash"></i>
                                                </button>
                                            @else
                                                <!--optionally show disabled button?-->
                                                <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                                                      data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                                                            class="sl-icon-trash"></i></span>
                                            @endif
                                        @endif
                                        <!--[edit]-->
                                        @if(config('visibility.action_buttons_edit'))
                                            @if($child->permission_edit_project)
                                                <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                                                        class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                                        data-toggle="modal" data-target="#commonModal"
                                                        data-url="{{ urlResource('/projects/'.$child->project_id.'/edit') }}"
                                                        data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_project')) }}"
                                                        data-action-url="{{ urlResource('/projects/'.$child->project_id) }}" data-action-method="PUT"
                                                        data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                                                    <i class="sl-icon-note"></i>
                                                </button>
                                            @else
                                                <!--optionally show disabled button?-->
                                                <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                                                      data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                                                            class="sl-icon-note"></i></span>
                                            @endif
                                            @if(auth()->user()->role->role_assign_projects == 'yes')
                                                <button type="button" title="{{ cleanLang(__('lang.assigned_users')) }}"
                                                        class="btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form data-toggle-action-tooltip"
                                                        data-toggle="modal" data-target="#commonModal"
                                                        data-url="{{ urlResource('/projects/'.$child->project_id.'/assigned') }}"
                                                        data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.assigned_users')) }}"
                                                        data-action-url="{{ urlResource('/projects/'.$child->project_id.'/assigned') }}"
                                                        data-action-method="PUT" data-modal-size="modal-sm" data-action-ajax-class="ajax-request"
                                                        data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                                                    <i class="sl-icon-people"></i>
                                                </button>
                                            @endif
                                        @endif
                                        <!--view-->
                                            <a href="{{ _url('/projects/'.$child->project_id) }}" title="{{ cleanLang(__('lang.view')) }}"
                                               class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                                                <i class="ti-new-window"></i>
                                            </a>
                                        </span>
                                    <!--action button-->
                                    <!--more button (team)-->
                                    @if(config('visibility.action_buttons_edit'))
                                        <span class="list-table-action dropdown font-size-inherit">
                                            <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    title="{{ cleanLang(__('lang.more')) }}"
                                                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                                                <i class="ti-more"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="listTableAction">
                                                @include('pages.projects.views.common.dropdown-menu-team')
                                            </div>
                                        </span>
                                    @endif
                                </td>
                            @endif
                            <div>
                                @include('pages.projects.views.list.table.tree-items',['children' => $child->children,'parent' => $child])
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>