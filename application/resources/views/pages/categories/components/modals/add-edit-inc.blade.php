<div class="row">
    <div class="col-lg-12">
        <!--title-->
        <div class="form-group row">
            <label class="col-12 text-left control-label col-form-label required">{{ $page['form_label_category_name'] ?? '' }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="category_name" name="category_name"
                       value="{{ $category->category_name ?? '' }}">
                <input type="hidden" name="category_type" value="{{ request('category_type') }}">
            </div>
        </div>


        <div class="client-selector-container" id="supervisor-existing-container">
            <div class="form-group row">
                <label
                        class="col-12 control-label col-form-label required">{{ cleanLang(__('lang.supervisor')) }}</label>
                <div class="col-12">
                    <!--select2 basic search-->
                    <select name="supervisor" id="supervisor"
                            class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                            data-ajax--url="{{ url('/') }}/feed/contacts">

                        @if(isset($page['section']) && $page['section'] == 'edit' && isset($category->supervisors))
                            @foreach($category->supervisors as $user)
                                <option selected value="{{$user->id}}">{{ $user->first_name.' '.$user->last_name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <!--select2 basic search-->
                    </select>
                </div>
            </div>
        </div>


        <!--migrate to another category-->
        @if(isset($page['section']) && $page['section'] == 'edit')
            <div class="form-group row">
                <label class="col-12 text-left control-label col-form-label required">{{ $page['form_label_move_items'] ?? '' }} ({{ cleanLang(__('lang.optional')) }})</label>
                <div class="col-12">
                    <select class="select2-basic form-control form-control-sm" id="migrate"
                            name="migrate">
                        <option>&nbsp;</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

    </div>
</div>