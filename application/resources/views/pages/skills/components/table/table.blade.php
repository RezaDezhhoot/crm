    <div class="card count-{{ @count($items ?? []) }}" id="leads-view-wrapper">
        <div class="card-body">
            <div class="table-responsive list-table-wrapper">
                <table id="leads-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
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
                            مهارت والد
                        </th>
                        <th class="leads_col_title">
                            {{ cleanLang(__('lang.description')) }}
                            <span class="sorting-icons"></span>
                        </th>

                        <th class="leads_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    </tr>
                    </thead>
                    <tbody id="departments-td-container">
                    <!--ajax content here-->
                    @include('pages.skills.components.table.tree',['skills' => $items])
                    <!--ajax content here-->
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
