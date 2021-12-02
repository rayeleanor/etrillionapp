<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : Ramom school management system
 * @version : 4.0
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Control_student_form.php
 * @copyright : Reserved RamomCoder Team
 */

class Control_student_form extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!get_permission('control_student_form', 'is_view')) {
            access_denied();
        }
        $this->data['controlstudentform'] = $this->app_lib->getTable('control_student_form', "show_on_form='1'");
        $this->data['sub_page'] = 'control_student_form/index';
        $this->data['main_menu'] = 'settings';
        $this->data['title'] = translate('control_student_form');
        $this->load->view('layout/index', $this->data);
    }

    public function status()
    {
        if (!get_permission('control_student_form', 'is_edit')) {
            ajax_access_denied();
        }
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 'true') {
            $arrayData['status'] = 1;
        } else {
            $arrayData['status'] = 0;
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', $id);
        $this->db->update('control_student_form', $arrayData);
        $return = array('msg' => translate('information_has_been_updated_successfully'), 'status' => true);
        echo json_encode($return);
    }
}
