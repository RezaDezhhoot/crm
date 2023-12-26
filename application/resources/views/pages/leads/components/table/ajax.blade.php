@foreach($leads as $lead)
<!--each row-->
<tr id="lead_{{ $lead->lead_id }}">

    <td class="leads_col_title" id="leads_col_title_{{ $lead->title }}">
        <a class="show-modal-button reset-card-modal-form js-ajax-ux-request" data-toggle="modal"
            href="javascript:void(0)" data-target="#cardModal" data-url="{{ urlResource('/leads/'.$lead->id) }}"
            data-loading-target="main-top-nav-bar" id="table_lead_title_{{ $lead->title }}">
            {{ str_limit($lead->title, 20) }}</a>
    </td>


    <td class="leads_col_stage" id="leads_col_stage_{{ $lead->lead_id }}">
        <span class="label {{ bootstrapColors($lead->leadstatus->leadstatus_color ?? '', 'label') }}">
            <!--notes: alternatve lang for lead status will need to be added manally by end user in lang files-->
            {{ runtimeLang($lead->leadstatus->leadstatus_title ?? '') }}</span>

            <!--archived-->
        @if($lead->lead_active_state == 'archived' && runtimeArchivingOptions())
        <span class="label label-icons label-icons-default" data-toggle="tooltip" data-placement="top"
            title="@lang('lang.archived')"><i class="ti-archive"></i></span>
        @endif
    </td>
    <td class="leads_col_value" id="leads_col_value_{{ $lead->lead_id }}">
        {{ runtimeMoneyFormat($lead->lead_value) }}
    </td>
    <td class="leads_col_action actions_column" id="leads_col_action_{{ $lead->lead_id }}">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            @if(config('visibility.action_buttons_delete'))
            <!--[delete]-->
            @if($lead->permission_delete_lead)
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/') }}/leads/{{ $lead->lead_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            @else
            <!--optionally show disabled button?-->
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i
                    class="sl-icon-trash"></i></span>
            @endif
            @endif
            <!--send email-->
            <button type="button" title="@lang('lang.send_email')"
                class="data-toggle-action-tooltip btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('/appwebmail/compose?view=modal&webmail_template_type=leads&resource_type=lead&resource_id='.$lead->lead_id) }}"
                data-loading-target="commonModalBody" data-modal-title="@lang('lang.send_email')"
                data-action-url="{{ url('/appwebmail/send') }}" data-action-method="POST" data-modal-size="modal-xl"
                data-action-ajax-loading-target="leads-td-container">
                <i class="ti-email display-inline-block m-t-3"></i>
            </button>
            <!--view-->
            <button type="button" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm show-modal-button reset-card-modal-form js-ajax-ux-request"
                data-toggle="modal" data-target="#cardModal" data-url="{{ urlResource('/leads/'.$lead->lead_id) }}"
                data-loading-target="main-top-nav-bar">
                <i class="ti-new-window"></i>
            </button>
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
                <!--change category-->
                @if($lead->permission_edit_lead)
                <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                    href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                    data-modal-title="{{ cleanLang(__('lang.change_category')) }}"
                    data-url="{{ url('/leads/change-category') }}"
                    data-action-url="{{ urlResource('/leads/change-category?id='.$lead->lead_id) }}"
                    data-loading-target="actionsModalBody" data-action-method="POST">
                    {{ cleanLang(__('lang.change_category')) }}</a>
                <!--change status-->
                <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                    href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                    data-modal-title="{{ cleanLang(__('lang.change_status')) }}"
                    data-url="{{ urlResource('/leads/'.$lead->lead_id.'/change-status') }}"
                    data-action-url="{{ urlResource('/leads/'.$lead->lead_id.'/change-status') }}"
                    data-loading-target="actionsModalBody" data-action-method="POST">
                    {{ cleanLang(__('lang.change_status')) }}</a>

                <!--archive-->
                @if($lead->lead_active_state == 'active' && runtimeArchivingOptions())
                <a class="dropdown-item confirm-action-info"
                    data-confirm-title="{{ cleanLang(__('lang.archive_lead')) }}"
                    data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
                    data-url="{{ urlResource('/leads/'.$lead->lead_id.'/archive') }}">
                    {{ cleanLang(__('lang.archive')) }}
                </a>
                @endif

                <!--activate-->
                @if($lead->lead_active_state == 'archived' && runtimeArchivingOptions())
                <a class="dropdown-item confirm-action-info"
                    data-confirm-title="{{ cleanLang(__('lang.restore_lead')) }}"
                    data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="PUT"
                    data-url="{{ urlResource('/leads/'.$lead->lead_id.'/activate') }}">
                    {{ cleanLang(__('lang.restore')) }}
                </a>
                @endif


                @else
                <span class="small">--- no options avaiable</span>
                @endif
            </div>
        </span>
        @endif
        <!--more button-->
    </td>
</tr>
@endforeach
<!--each row-->