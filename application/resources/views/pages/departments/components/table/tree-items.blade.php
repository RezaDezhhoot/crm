<tr id="item_{{ $parent->id }}">
    <td colspan="12" class="hiddenRow">
        <div class="accordian-body collapse" id="child{{$parent->id}}">
            <div class="panel-heading">
                {{ $parent->title }}
            </div>
            <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                <tr>
                    <th class="leads_col_title">
                        #
                    </th>
                    @if(config('visibility.leads_col_checkboxes'))
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-leads" name="listcheckbox-leads"
                                       class="listcheckbox-all filled-in chk-col-light-blue"
                                       data-actions-container-class="leads-checkbox-actions-container"
                                       data-children-checkbox-class="listcheckbox-leads">
                                <label for="listcheckbox-leads"></label>
                            </span>
                        </th>
                    @endif
                    <th class="leads_col_title">
                        {{ cleanLang(__('lang.title')) }}
                        <span class="sorting-icons"><i class="ti-arrows-vertical"></i></span>
                    </th>
                    <th class="leads_col_title">
                        واحد والد
                    </th>
                    <th class="leads_col_title">
                        {{ cleanLang(__('lang.description')) }}
                        <span class="sorting-icons"></span>
                    </th>

                    <th class="leads_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                </tr>
                </thead>
                <tbody>

                @foreach($children as $child)
                    <tr data-toggle="collapse" id="item_{{ $child->id }}"  class="accordion-toggle" data-target="#child{{$child->id}}">
                        <td class="leads_col_title">
                            {{ $loop->iteration }}
                        </td>
                        <td class="leads_col_title" id="leads_col_title_{{ $child->title }}">
                            <a class="show-modal-button reset-card-modal-form js-ajax-ux-request">
                                {{ $child->title }}</a>
                        </td>
                        <td class="leads_col_title">
                            {{ $child->parent->title ?? '-' }}
                        </td>
                        <td class="leads_col_title">
                            {{ str_limit($child->description, 20) }}
                        </td>

                        <td class="leads_col_action actions_column">
                         <span class="list-table-action dropdown font-size-inherit">
                                 <!--[delete]-->
                                     <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                                             class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                                             data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                                             data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                                             data-url="{{ route('admin.departments.delete',$child->id) }}">
                                <i class="sl-icon-trash"></i>
                            </button>

                             <!--[edit]-->
                                     <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                                             class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                             data-toggle="modal" data-target="#commonModal"
                                             data-url="{{ route('admin.departments.edit',$child->id) }}"
                                             data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_department')) }}"
                                             data-action-url="{{ route('admin.departments.update',$child->id)  }}" data-action-method="PUT"
                                             data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                                <i class="sl-icon-note"></i>
                            </button>

                        </span>
                        </td>
                        <div>
                            @if($child->children && $child->children->count() > 0)
                                @include('pages.departments.components.table.tree-items',['children' => $child->children,'parent' => $child])
                            @endif
                        </div>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>