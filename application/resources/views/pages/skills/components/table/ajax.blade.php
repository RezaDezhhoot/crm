@foreach($items as $item)
    <!--each row-->
    <tr id="item_{{ $item->id }}">

        <td class="leads_col_title">
            {{ $loop->iteration }}
        </td>
        <td class="leads_col_title" id="leads_col_title_{{ $item->title }}">
            <a class="show-modal-button reset-card-modal-form js-ajax-ux-request">
                {{ str_limit($item->title, 20) }}</a>
        </td>
        <td class="leads_col_title">
            {{ $item->parent->title ?? '-' }}
        </td>
        <td class="leads_col_title">
            {{ str_limit($item->description, 20) }}
        </td>



        <td class="leads_col_action actions_column">
         <span class="list-table-action dropdown font-size-inherit">
                 <!--[delete]-->
                     <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                             class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                             data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                             data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                             data-url="{{ route('admin.skills.delete',$item->id) }}">
                <i class="sl-icon-trash"></i>
            </button>

             <!--[edit]-->
                     <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                             class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                             data-toggle="modal" data-target="#commonModal"
                             data-url="{{ route('admin.skills.edit',$item->id) }}"
                             data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_skill')) }}"
                             data-action-url="{{ route('admin.skills.update',$item->id)  }}" data-action-method="PUT"
                             data-action-ajax-class="" data-action-ajax-loading-target="projects-td-container">
                <i class="sl-icon-note"></i>
            </button>

        </span>
        </td>
    </tr>
@endforeach
<!--each row-->
