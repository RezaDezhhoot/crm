<div>
    <div class="card-comments" id="post-card-comment-form">
        <div class="x-heading"><i class="mdi mdi-message-text"></i>گزارشات اعضا</div>
        <div class="x-content">
            <div class="post-comment" id="manager-report-form">
                <!--placeholder textbox-->
                <div class="x-message-field x-message-field-placeholder m-b-10" id="card-coment-placeholder-input-container"
                     data-show-element-container="card-comment-tinmyce-container">
        <textarea class="form-control form-control-sm w-100" rows="1"
                  id="card-coment-placeholder-input">{{ cleanLang(__('lang.post_a_report')) }}...</textarea>

                </div>
                <!--rich text editor-->
                <div class="x-message-field hidden" id="card-comment-tinmyce-container">
                    <!--tinymce editor-->
                    <textarea class="form-control form-control-sm w-99" rows="2" id="card-comment-tinmyce"
                              name="report_text" ></textarea>
                    <!--close button-->

                    <div class="x-button m-0 p-b-10 text-right ">
                        <div class="col-6 m-0">
                            <label for="example-month-input" class="col-12 m-0 col-form-label text-left">دوره گزارش</label>
                            <select  class="select2-basic form-control form-control-sm" id="type"
                                     name="type">
                                <option value="{{ \App\Enums\TaskPeriodEnum::DAILY->value }}">روزانه</option>
                                <option value="{{ \App\Enums\TaskPeriodEnum::HOURLY->value }}">ساعتی</option>
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-default btn-sm" id="card-comment-close-button">
                                {{ cleanLang(__('lang.close')) }}
                            </button>
                            <!--submit button-->
                            <button type="button" class="btn btn-danger btn-sm x-submit-button" id="card-comment-post-button"
                                    data-url="{{ urlResource('/tasks/'.$task->task_id.'/reports') }}" data-type="form" data-ajax-type="post"
                                    data-form-id="manager-report-form" data-loading-target="card-coment-placeholder-input-container">
                                {{ cleanLang(__('lang.post')) }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!--comments-->
            <div id="card-comments-container">
                <!--dynamic content here-->
            </div>
        </div>
    </div>



</div>
<div id="card-comments-container">
    @foreach($reports as $report)
        <div class="display-flex border mb-2 rounded flex-row comment-row" id="card_comment_{{ $report->id }}">
            <div class="p-2 comment-avatar">
                <img src="{{ getUsersAvatar($report->avatar_directory, $report->avatar_filename) }}" class="img-circle"
                     alt="{{ $report->user->first_name ?? runtimeUnkownUser() }}" width="40">
            </div>
            <div class="comment-text w-100 js-hover-actions">
                <div class="row">
                    <div class="col-sm-6 x-name">
                        <strong>
                            {{ $report->user->first_name ?? runtimeUnkownUser() }}
                        </strong>
                    </div>
                    <div class="col-sm-6 x-meta text-right">
                        <!--meta-->
                        <span class="x-date"><small>{{ runtimeDateAgo($report->created_at) }}</small></span>
                        <!--actions: delete-->

                        <span class="comment-actions"> |
                            <a href="javascript:void(0)" class="js-delete-ux-confirm confirm-action-danger text-danger">
                                <small>{{ $report->type->value }}</small>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="p-t-4">{!! clean($report->text) !!}</div>
            </div>
        </div>
    @endforeach
</div>