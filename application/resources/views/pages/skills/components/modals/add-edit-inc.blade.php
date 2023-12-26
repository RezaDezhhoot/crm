<div class="row">
    <div class="col-lg-12">


        <!--title-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.title')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder=""
                    value="{{ $skill->title ?? '' }}">
            </div>
        </div>
        <!-- description -->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label ">{{ cleanLang(__('lang.description')) }}</label>
            <div class="col-sm-12 col-lg-9">
                <textarea class="form-control form-control-sm" id="description" name="description">{{ $skill->description ?? '' }}</textarea>
            </div>
        </div>

        <div class="client-selector-container" id="client-existing-container">
            <div class="form-group row">
                <label
                        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">متخصصین</label>
                <div class="col-sm-12 col-lg-9">
                    <!--select2 basic search-->
                    <select name="users" id="users" multiple="multiple"
                            class="form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                            data-ajax--url="{{ url('/') }}/feed/contacts">
                        @if(isset($page['section']) && $page['section'] == 'edit' && $skill->managers)
                            @foreach($skill->managers as $manager)
                                <option selected value="{{$manager->id}}">
                                    {{ $manager->first_name.' '.$manager->last_name }}
                                </option>
                            @endforeach
                        @endif
                        <!--select2 basic search-->
                    </select>
                </div>
            </div>
        </div>
        <!--assigned [projects  ]-->

            <!--manager-->
            <div class="client-selector-container" id="client-existing-container">
                <div class="form-group row">
                    <label
                            class="col-sm-12 col-lg-3 text-left control-label col-form-label required">واحد والد</label>
                    <div class="col-sm-12 col-lg-9">
                        <!--select2 basic search-->
                        <select name="parent_id" id="parent_id" data-allow-clear="true"
                                class="form-control form-control-sm select2-basic">
                            <option value="">انتخاب</option>
                            @foreach($skills as $item)
                                <option {{ (isset($skill) && $skill->parent_id == $item->id) ? 'selected' : '' }} value="{{$item->id}}">
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>