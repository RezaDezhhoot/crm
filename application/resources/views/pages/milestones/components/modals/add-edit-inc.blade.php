<div class="form-group row">
    <label class="col-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.milestone_name')) }}*</label>
    <div class="col-12">
        <input type="text" class="form-control  form-control-sm" autocomplete="off" id="milestone_title"
            name="milestone_title" value="{{ $milestone->milestone_title ?? '' }}">
        <input type="hidden" name="milestone_projectid" value="{{ request('project_id') }}">
    </div>

    <div class="col-12">
        <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">مرحله والد</label>
        <div class="col-12">
            @if(isset($page['section']) && $page['section'] == 'edit')
                @php $selected[] = $milestone->parent_id; @endphp
            @endif
            <select name="parent_id" id="parent_id" class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                    data-allow-clear="true"  data-ajax--url="{{ url('/') }}/feed/milestones">
                <!--array of assigned-->

                <!--/#array of assigned-->
                <!--users list-->
                @foreach($milestones as $item)
                    <option></option>
                    <option value="{{ $item->milestone_id }}"
                            {{ runtimePreselectedInArray($item->milestone_id ?? '', $selected ?? []) }}
                    >
                        {{ $item->milestone_title }}
                    </option>
                @endforeach
                <!--/#users list-->
            </select>
        </div>
    </div>
</div>