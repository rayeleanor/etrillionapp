<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package : Ramom school management system
 * @version : 4.0
 * @developed by : RamomCoder
 * @support : ramomcoder@yahoo.com
 * @author url : http://codecanyon.net/user/RamomCoder
 * @filename : Multi_class_student.php
 * @copyright : Reserved RamomCoder Team
 */

class Multi_class_student extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('multi_class_student_model');
    }

    public function index()
    {
        // check access permission
        if (!get_permission('multi_class_student', 'is_view')) {
            access_denied();
        }
 
        $branchID = $this->application_model->get_branch_id();
        if (isset($_POST['search'])) {
            $classID = $this->input->post('class_id');
            $sectionID = $this->input->post('section_id');
            $this->data['students'] = $this->online_admission_model->getOnlineAdmission($classID, $branchID);
        }
        
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('multi_class_student');
        $this->data['main_menu'] = 'admission';
        $this->data['branchlist'] = $this->app_lib->get_table('branch');
        $this->data['classlist'] = $this->app_lib->getTable('class');
        $this->data['sub_page'] = 'multi_class_student/index';
        $this->data['headerelements'] = array(
            'js' => array(
                'js/student.js',
                'js/app.fn.js',
            ),
        );

        $this->form_validation->set_rules('branch_id', translate('branch'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', translate('section'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', translate('class'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {

        } else {
            $this->data['classlist']       = $this->app_lib->getTable('class');
            $this->data['student_due_fee'] = array();
            $classID                   = $this->input->post('class_id');
            // $sectionID                 = $this->input->post('section_id');
            $branchID                  = $this->input->post('branch_id');
            $this->data['classes']     = $this->multi_class_student_model->allClassSections($classID);

            $this->data['students'] = $this->application_model->getStudentListByMultiClassSection($classID, '', $branchID, false, true);
        }
        // echo "<pre>";
        // echo $classID;
        // echo "<br>";
        // print_r($this->data['classes']);exit;
        $this->load->view('layout/index', $this->data);
        // $this->load->view('multi_class_student/index', $this->data);
    }

    public function save()
    {

        $student_id       = '';
        $message          = "";
        $duplicate_record = 0;
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('student_id', translate('student_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('row_count[]', 'row_count[]', 'trim|required|xss_clean');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $total_rows = $this->input->post('row_count[]');
            if (!empty($total_rows)) {

                foreach ($total_rows as $key_rowcount => $row_count) {

                    $this->form_validation->set_rules('class_id_' . $row_count, translate('class'), 'trim|required|xss_clean');

                    $this->form_validation->set_rules('section_id_' . $row_count, translate('section'), 'trim|required|xss_clean');
                }
            }
        }

        if ($this->form_validation->run() == false) {

            $msg = array(
                'student_id'  => form_error('student_id'),
                'row_count[]' => form_error('row_count[]'),
            );

            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                if (!empty($total_rows)) {

                    $total_rows = $this->input->post('row_count[]');
                    foreach ($total_rows as $key_rowcount => $row_count) {

                        $msg['class_id_' . $row_count]   = form_error('class_id_' . $row_count);
                        $msg['section_id_' . $row_count] = form_error('section_id_' . $row_count);
                    }
                }
            }
            if (!empty($msg)) {
                $message = translate('something_went_wrong');
            }

            $array = array('status' => '0', 'error' => $msg, 'message' => $message);
        } else {

            $rowcount            = $this->input->post('row_count[]');
            $class_section_array = array();
            $duplicate_array     = array();
            foreach ($rowcount as $key_rowcount => $value_rowcount) {

                $array = array(
                    'class_id'   => $this->input->post('class_id_' . $value_rowcount),
                    'session_id' => get_session_id(),
                    'student_id' => $this->input->post('student_id'),
                    'section_id' => $this->input->post('section_id_' . $value_rowcount),
                    'branch_id' => $this->input->post('branch_id'),
                );

                $class_section_array[] = $array;
                $duplicate_array[]     = $this->input->post('class_id_' . $value_rowcount) . "-" . $this->input->post('section_id_' . $value_rowcount);
            }

            foreach (array_count_values($duplicate_array) as $val => $c) {

                if ($c > 1) {
                    $duplicate_record = 1;
                    break;
                }
            }
            if ($duplicate_record) {

                $array = array('status' => 0, 'error' => '', 'message' => translate('duplicate_entry'));
            } else {
                $this->multi_class_student_model->add($class_section_array, $this->input->post('student_id'));

                $array = array('status' => 1, 'error' => '', 'message' => translate('success_message'));
            }
        }
        echo json_encode($array);
    }

}
