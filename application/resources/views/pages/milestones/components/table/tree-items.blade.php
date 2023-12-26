<tr id="milestone_{{ $parent->milestone_id }}">
    <td colspan="12" class="hiddenRow">
        <div class="accordian-body border collapse rounded " id="child{{$parent->milestone_id}}">
            <table class="table table-bordered table-hover p-3 table-sm " >
                <thead>
                <tr>
                    <th class="milestones_col_name"><a class="js-ajax-ux-request js-list-sorting"
                                                       id="sort_milestone_title" href="javascript:void(0)"
                                                       data-url="{{ urlResource('/milestones?action=sort&orderby=milestone_title&sortorder=asc') }}">{{ cleanLang(__('lang.name')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                    </th>
                    <th class="milestones_col_tasks w-20"><a class="js-ajax-ux-request js-list-sorting"
                                                             id="sort_total_tasks" href="javascript:void(0)"
                                                             data-url="{{ urlResource('/milestones?action=sort&orderby=total_tasks&sortorder=asc') }}">{{ cleanLang(__('lang.all_tasks')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                    <th class="milestones_col_tasks_pending w-20"><a class="js-ajax-ux-request js-list-sorting"
                                                                     id="sort_pending_tasks" href="javascript:void(0)"
                                                                     data-url="{{ urlResource('/milestones?action=sort&orderby=pending_tasks&sortorder=asc') }}">{{ cleanLang(__('lang.pending_tasks')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                    <th class="milestones_col_tasks_completed w-20"><a class="js-ajax-ux-request js-list-sorting"
                                                                       id="sort_completed_tasks" href="javascript:void(0)"
                                                                       data-url="{{ urlResource('/milestones?action=sort&orderby=completed_tasks&sortorder=asc') }}">{{ cleanLang(__('lang.completed_tasks')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                    @if(config('visibility.milestone_actions'))
                        <th class="milestones_col_action w-5"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    @endif
                </tr>
                </thead>
                <tbody id="milestones-td-container{{$parent->milestone_id}}">
                @foreach($children as $child)
                    <tr data-toggle="collapse" id="milestone_{{ $child->milestone_id }}"  class="accordion-toggle" data-target="#child{{$child->milestone_id}}">

                        <td class="milestones_col_name">
                            @if(config('visibility.milestone_actions'))
                                <span class="mdi mdi-drag-vertical cursor-pointer"></span>
                            @endif
                            <a class="js-dynamic-url js-ajax-ux-request" data-loading-target="embed-content-container"
                               data-dynamic-url="{{ url('/projects') }}/{{ $child->milestone_projectid }}/tasks?source=ext&taskresource_type=project&taskresource_id={{ $child->milestone_projectid }}&filter_task_milestoneid={{ $child->milestone_id }}"
                               data-url="{{ url('/tasks') }}?source=ext&taskresource_type=project&taskresource_id={{ $child->milestone_projectid }}&filter_task_milestoneid={{ $child->milestone_id }}"
                               href="#projects_ajaxtab">{{ runtimeLang($child->milestone_title, 'task_milestone').'@'.$child->milestone_id }}</a>

                            @if($child->milestone_type == 'uncategorised')
                                <span class="sl-icon-star text-warning p-l-5" data-toggle="tooltip" title="{{ cleanLang(__('lang.default_category')) }}"></span>
                            @endif
                            <!--sorting data-->
                            @if(config('visibility.milestone_actions'))
                                <input type="hidden" name="sort-milestones[{{ $child->milestone_id }}]"
                                       value="{{ $child->milestone_id }}">
                            @endif
                        </td>
                        <td class="milestones_col_tasks">
                            {{ $child->milestone_count_tasks_all_child }}
                        </td>
                        <td class="milestones_col_tasks_pending">
                            {{ $child->milestone_count_tasks_pending_child }}
                        </td>
                        <td class="milestones_col_tasks_completed">
                            {{ $child->milestone_count_tasks_completed_child }}
                        </td>

                        @if(config('visibility.milestone_actions'))
                            <td class="milestones_col_action actions_column">
                                <!--action button-->
                                <span class="list-table-action dropdown font-size-inherit">
                            @if($child->milestone_type == 'categorised')
                                                        <!---delete milestone with confirm checkbox-->
                                                        <span id="milestone_form_{{ $child->milestone_id }}">
                                <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                                        class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                                        id="foobar" data-confirm-title="{{ cleanLang(__('lang.delete_milestone')) }}"
                                        data-confirm-text="
                                            <input type='checkbox' id='confirm_action_{{ $child->milestone_id }}'
                                                   class='filled-in chk-col-light-blue confirm_action_checkbox'
                                                   data-field-id='delete_milestone_tasks_{{ $child->milestone_id }}'>
                                            <label for='confirm_action_{{ $child->milestone_id }}'>{{ cleanLang(__('lang.delete_all_tasks')) }}</label>" data-ajax-type="DELETE" data-type="form"
                                        data-form-id="milestone_form_{{ $child->milestone_id }}"
                                        data-url="{{ url('/') }}/milestones/{{ $child->milestone_id }}?project_id={{ $child->milestone_projectid }}">
                                    <i class="sl-icon-trash"></i>
                                </button>
                                <input type="hidden" class="confirm_hidden_fields" name="delete_milestone_tasks"
                                       id="delete_milestone_tasks_{{ $child->milestone_id }}">
                            </span>
                                                        <!---/#delete milestone with confirm checkbox-->
                                                        <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                                                                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                                                data-toggle="modal" data-target="#commonModal"
                                                                data-url="{{ urlResource('/milestones/'.$child->milestone_id.'/edit') }}"
                                                                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_milestone')) }}"
                                                                data-action-url="{{ urlResource('/milestones/'.$child->milestone_id.'?ref=list') }}"
                                                                data-action-method="PUT" data-action-ajax-class=""
                                                                data-action-ajax-loading-target="milestones-td-container">
                                <i class="sl-icon-note"></i>
                            </button>
                                                    @else
                                                        <!--optionally show disabled button?-->
                                                        <span class="btn btn-outline-default btn-circle btn-sm disabled {{ runtimePlaceholdeActionsButtons() }}"
                                                              data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-trash"></i></span>
                                                        <span class="btn btn-outline-default btn-circle btn-sm disabled {{ runtimePlaceholdeActionsButtons() }}"
                                                              data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-note"></i></span>
                                                    @endif
                        </span>
                                <!--action button-->
                            </td>
                        @endif

                        <div>
                            @include('pages.milestones.components.table.tree-items',['children' => $child->children,'parent' => $child])
                        </div>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>