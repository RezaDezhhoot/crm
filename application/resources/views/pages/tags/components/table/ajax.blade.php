@foreach($items as $item)
<!--each row-->
<tr id="tag_{{ $item->tag_id }}">
    <td class="tags_col_date">
        {{ runtimeDate($item->tag_created) }}
    </td>
    <td class="tags_col_title">{{ $item->tag_title }}</td>
    <td class="tags_col_creator">
        <img src="{{ getUsersAvatar($item->avatar_directory, $item->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        {{ $item->first_name ?? runtimeUnkownUser() }}
    </td>
    <td class="tags_col_resourcetype">
        {{ runtimeLang($item->tagresource_type) }}
    </td>
    <td class="tags_col_amount">
        @if($item->tagresource_id == 0)
        ---
        @else
        {{ $item->tagresource_id }}
        @endif
    </td>
    <td class="tags_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/tags/'.$item->tag_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_tag')) }}" data-action-url="{{ urlResource('/tags/'.$item->tag_id) }}"
                data-action-method="PUT" data-action-ajax-class="js-ajax-ux-request"
                data-action-ajax-loading-target="tags-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_tag')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url('/') }}/tags/{{ $item->tag_id }}">
                <i class="sl-icon-trash"></i>
            </button>
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->