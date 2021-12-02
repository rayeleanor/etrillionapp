<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : Ramom school management system
 * @version : 4.0
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Modules.php
 * @copyright : Reserved RamomCoder Team
 */

class Modules extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!get_permission('modules', 'is_view')) {
            access_denied();
        }
        $this->data['systemmodules'] = $this->app_lib->getTable('modules', "module_type='system'");
        $this->data['studentmodules'] = $this->app_lib->getTable('modules', "module_type='student'");
        $this->data['parentmodules'] = $this->app_lib->getTable('modules', "module_type='parent'");
        $this->data['sub_page'] = 'modules/index';
        $this->data['main_menu'] = 'settings';
        $this->data['title'] = translate('modules');
        $this->load->view('layout/index', $this->data);
    }

    public function status()
    {
        if (!get_permission('modules', 'is_edit')) {
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
        $this->db->update('modules', $arrayData);
        $return = array('msg' => translate('information_has_been_updated_successfully'), 'status' => true);
        echo json_encode($return);
    }
}
