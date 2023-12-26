<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [index] process for the tags
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Departments;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for tags
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }


        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //template and dom - for additional ajax loading
        $template = 'pages/departments/components/table/wrapper';
        $dom_container = '#departments-table-wrapper';
        $dom_action = 'replace';

        //load more button - change the page number and determine buttons visibility


        //render the view and save to json
        $html = view($template, compact('page', 'items'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => $dom_container,
            'action' => $dom_action,
            'value' => $html);


        //for embedded - change breadcrumb title
        $jsondata['dom_html'][] = [
            'selector' => '.active-bread-crumb',
            'action' => 'replace',
            'value' => 'DEPARTMENTS',
        ];

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXDepartmentsMenu',
        ];

        //ajax response
        return response()->json($jsondata);
    }
}
