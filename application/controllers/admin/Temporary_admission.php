<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Temporary_admission extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("live_class_model");
        $this->load->model("temporary_admission_model");
        $this->load->library('form_validation');
       
    }

    public function index()
    {
        $admin = $this->session->userdata('admin');
        $centre_id = $admin['centre_id'];

        if (!$this->rbac->hasPrivilege('temporary_admission', 'can_add') || $centre_id != 2) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'temporary_admission/index');
        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if (empty($_FILES['file']['name'])) {
            $this->form_validation->set_rules('file', 'Document', 'required');
        }

        $data['classlist'] = $this->class_model->get('', $classteacher = 'yes');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('student/temporary_admission/create', $data);
            $this->load->view('layout/footer', $data);
        } else {
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if ($ext == 'csv') {
                    $file = $_FILES['file']['tmp_name'];
                    $this->load->library('CSVReader');
                    $result = $this->csvreader->parse_file($file);
                    $class_id = $this->input->post('class_id');
                    $section_id = $this->input->post('section_id');
                    $year=$this->input->post('year');

                    foreach ($result as $row) {
                        $user_id = $this->MakeUserId(5);

                        $array = array(
                            'class_id' => $class_id,
                            'section_id' => $section_id,
                            'user_id' => $user_id,
                            'year'=>$year,
                        );
                        // $this->sendLoginSms($user_id, $row['phone']);
                        $row = array_merge($row, $array);
                        $this->temporary_admission_model->create($row);
                    }
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Temporary Students has been added.</div>');
                    redirect('admin/temporary_admission');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Please upload CSV file only.</div>');
                    $this->load->view('layout/header', $data);
                    $this->load->view('student/temporary_admission/create', $data);
                    $this->load->view('layout/footer', $data);
                }
            }
        }
    }


    public function search()
    {

        if (!$this->rbac->hasPrivilege('student', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'student/temp_student_details');
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();
        $carray = array();

        if (!empty($data["classlist"])) {
            foreach ($data["classlist"] as $ckey => $cvalue) {

                $carray[] = $cvalue["id"];
            }
        }

        $button = $this->input->post('search');
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('student/temporary_admission/search', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $year = $this->input->post('year');

            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == FALSE) {

                    } else {
                        $data['searchby'] = "filter";
                        $data['class_id'] = $this->input->post('class_id');
                        $data['section_id'] = $this->input->post('section_id');
                        $data['year'] = $this->input->post('year');


                        $data['search_text'] = $this->input->post('search_text');
                        $resultlist = $this->temporary_admission_model->searchByClassSection($class, $section,$year);
                        $data['resultlist'] = $resultlist;
                        $title = $this->classsection_model->getDetailbyClassSection($data['class_id'], $data['section_id']);
                        $data['title'] = 'Student Details for ' . $title['class'] . "(" . $title['section'] . ")";
                    }
                } else if ($search == 'search_full') {
                    $data['searchby'] = "text";

                    $data['search_text'] = trim($this->input->post('search_text'));



                    $resultlist = $this->student_model->searchFullText($search_text, $carray);
                    $data['resultlist'] = $resultlist;

                    $data['title'] = 'Search Details: ' . $data['search_text'];
                }
                //var_dump($resultlist);
            }
            $this->load->view('layout/header', $data);
            $this->load->view('student/temporary_admission/search', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    private function MakeUserId($length)
    {
        $salt = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $len = strlen($salt);
        $makepass = '';
        mt_srand(10000000 * (float)microtime());
        for ($i = 0; $i < $length; $i++) {
            $makepass .= $salt[mt_rand(0, $len - 1)];
        }
        return $makepass;
    }

    private function sendLoginSms($user_id, $phone)
    {
        $password = "test";
        $fullApi = 'http://prioritysms.a4add.com/api/sendhttp.php?authkey=341137A6fjmQ8YSgq95f588459P1&mobiles={num}&message={msg}&sender=AMCSFN&route=4&country=91&unicode=1&DLT_TE_ID={tid}';
        $tid = '1207162731815046564';
        $msg = "AMCSFNCK B.Sc Nursing Application 2024-25. Your Applicant ID: " . $user_id . " and Password: " . $password . ".\n For more details www.amcsfnck.com or https://bit.ly/3AR0uPs";;
        $msg = urlencode($msg);
        $num = $phone;
        $api     = str_replace(['{msg}', '{num}', '{tid}'], [$msg, $num, $tid], $fullApi);

        $url = $api;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $http_result = $info['http_code'];
        curl_close($ch);
    }
    function edit($id)
    {
        if (!$this->rbac->hasPrivilege('student', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Student';
        $data['id'] = $id;
        $student = $this->student_model->get($id);
        $genderList = $this->customlib->getGender();
        $data['student'] = $student;
        // var_dump( $data['student']);exit;
        $data['genderList'] = $genderList;
        $session = $this->setting_model->getCurrentSession();
        $vehroute_result = $this->vehroute_model->get();
        $data['vehroutelist'] = $vehroute_result;
        $class = $this->class_model->get();
        $setting_result = $this->setting_model->get();
        // $student_categorize = $setting_result[0]["student_categorize"];
        // $data["student_categorize"] = $student_categorize ;
        $data["student_categorize"] = 'class';
        $data['classlist'] = $class;
        $feeyear = $this->feemaster_model->getfeeyear();
        $data['feeyearlist'] = $feeyear;
        $sch = $this->student_model->getscholarship();
        $data['sch'] = $sch;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $hostelList = $this->hostel_model->get();
        $data['hostelList'] = $hostelList;
        $houses = $this->student_model->gethouselist();
        $data['houses'] = $houses;
        $data["bloodgroup"] = $this->blood_group;
        $siblings = $this->student_model->getMySiblings($student['parent_id'], $student['id']);
        $data['siblings'] = $siblings;
        $data['siblings_counts'] = count($siblings);
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');

        $this->form_validation->set_rules('guardian_is', 'Guardian', 'trim|required|xss_clean');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
        $this->form_validation->set_rules('guardian_name', 'Guardian Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('rte', 'RTE', 'trim|required|xss_clean');
        $this->form_validation->set_rules('annual_income', 'Annual income', 'trim|required|xss_clean');
        $this->form_validation->set_rules('guardian_phone', 'Guardian Phone', 'trim|required|numeric|max_length[25]|min_length[3]');
        $this->form_validation->set_rules(
            'roll_no',
            'Roll No.',
            array(
                'trim',
                array('check_exists', array($this->student_model, 'valid_student_roll'))
            )
        );

        $this->form_validation->set_rules('file', 'Image', 'callback_handle_upload');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('student/temporary_admission/edit', $data);
            $this->load->view('layout/footer', $data); 
        } else {
            $student_id = $this->input->post('student_id');
            $student = $this->student_model->get($student_id);
            $sibling_id = $this->input->post('sibling_id');
            $siblings_counts = $this->input->post('siblings_counts');
            $siblings = $this->student_model->getMySiblings($student['parent_id'], $student_id);
            $total_siblings = count($siblings);


            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $hostel_room_id = $this->input->post('hostel_room_id');
            $fees_discount = $this->input->post('fees_discount');
            $vehroute_id = $this->input->post('vehroute_id');
            if (empty($vehroute_id)) {
                $vehroute_id = 0;
            }
            if (empty($hostel_room_id)) {
                $hostel_room_id = 0;
            }
            $data = array(
                'user_id' => $user['id'],
                'admission_no' => $this->input->post('admission_no'),
                'kuhs_reg' => $this->input->post('kuhs_reg'),
                'roll_no' => $this->input->post('roll_no'),
                'class_id' => $this->input->post('class_id'),
                'section_id' => $this->input->post('section_id'),
                // 'full_name' => $this->input->post('firstname') . ' ' . $this->input->post('lastname'),
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->input->post('dob'),
                'age' => $this->input->post('age'),
                'category_id' => $this->input->post('category_id'),
                'religion' => $this->input->post('religion'),
                'cast' => $this->input->post('cast'),
                'mobileno' => $this->input->post('mobileno'),
                'email' => $this->input->post('email'),

                'year' => $this->input->post('year'),
                'admission_date' => $this->input->post('admission_date'),
                'file' => $student_img_name,
                'blood_group' => $this->input->post('blood_group'),
                'height' => $this->input->post('height'),
                'weight' => $this->input->post('weight'),
                'nationality' => $this->input->post('nationality'),
                'annual_income' => $this->input->post('annual_income'),
                'adhar_no' => $this->input->post('adhar_no'),
                'fees_discount' => $this->input->post('fees_discount'),
                'father_name' => $this->input->post('father_name'),
                'father_phone' => $this->input->post('father_phone'),
                'father_occupation' => $this->input->post('father_occupation'),
                'father_pic' => $father_img_name,
                'mother_name' => $this->input->post('mother_name'),
                'mother_phone' => $this->input->post('mother_phone'),
                'mother_occupation' => $this->input->post('mother_occupation'),
                'mother_pic' =>  $mother_img_name,
                'guardian_is' => $this->input->post('guardian_is'),
                'guardian_name' => $this->input->post('guardian_name'),
                'guardian_relation' => $this->input->post('guardian_relation'),
                'guardian_phone' => $this->input->post('guardian_phone'),
                'guardian_occupation' => $this->input->post('guardian_occupation'),
                'guardian_email' => $this->input->post('guardian_email'),
                'guardian_pic' => $guardian_img_name,
                'guardian_address' => $this->input->post('guardian_address'),
                'autofill_current_address' => $this->input->post('autofill_current_address'),
                'current_address' => $this->input->post('current_address'),
                'permanent_address' => $this->input->post('permanent_address'),

                'qualifying_exam' => $this->input->post('qualifying_exam'),
                'regno' => $this->input->post('regno'),


                'monthyear' => $this->input->post('monthyear'),
                'total_mark' => $this->input->post('total_mark'),
                'neetrank' => $this->input->post('neetrank'),
                'totmark' => $this->input->post('totmark'),
                'chem_markob' => $this->input->post('chem_markob'),
                'chem_maxmark' => $this->input->post('chem_maxmark'),
                'chem_per' => $this->input->post('chem_per'),
                'phy_markob' => $this->input->post('phy_markob'),
                'phy_maxmark' => $this->input->post('phy_maxmark'),
                'phy_per' => $this->input->post('phy_per'),
                'bio_markob' => $this->input->post('bio_markob'),
                'bio_maxmark' => $this->input->post('bio_maxmark'),
                'bio_per' => $this->input->post('bio_per'),
                'tot1' => $this->input->post('tot1'),
                'tot2' => $this->input->post('tot2'),
                'tot3' => $this->input->post('tot3'),
                'eng_markob' => $this->input->post('eng_markob'),
                'eng_maxmark' => $this->input->post('eng_maxmark'),
                'eng_per' => $this->input->post('eng_per'),
                // 'total_mark' => $this->input->post('total_mark'),
                'total_maxmark' => $this->input->post('total_maxmark'),
                'total_per' => $this->input->post('total_per'),
                'med_previous_school' => $this->input->post('med_previous_school'),
                'med_qualifying_exam' => $this->input->post('med_qualifying_exam'),
                'med_regno' => $this->input->post('med_regno'),
                'med_year' => $this->input->post('med_year'),






                'dfs' => $this->input->post('dfs'),
                'first_mbbs_scored' => $this->input->post('first_mbbs_scored'),
                'first_mbbs_max' => $this->input->post('first_mbbs_max'),
                'first_mbbs_per' => $this->input->post('first_mbbs_per'),
                'first_mbbs_year' => $this->input->post('first_mbbs_year'),


                'second_mbbs_scored' => $this->input->post('second_mbbs_scored'),
                'second_mbbs_max' => $this->input->post('second_mbbs_max'),
                'second_mbbs_per' => $this->input->post('second_mbbs_per'),
                'second_mbbs_year' => $this->input->post('second_mbbs_year'),

                'third_mbbs_scored' => $this->input->post('third_mbbs_scored'),
                'third_mbbs_max' => $this->input->post('third_mbbs_max'),
                'third_mbbs_per' => $this->input->post('third_mbbs_per'),
                'third_mbbs_year' => $this->input->post('third_mbbs_year'),

                'third_mbbs_scored2' => $this->input->post('third_mbbs_scored2'),
                'third_mbbs_max2' => $this->input->post('third_mbbs_max2'),
                'third_mbbs_per2' => $this->input->poszt('third_mbbs_per2'),
                'third_mbbs_year2' => $this->input->post('third_mbbs_year2'),

                'med_total' => $this->input->post('med_total'),
                'med_total_per' => $this->input->post('med_total_per'),
                'med_total_year' => $this->input->post('med_total_year'),
                'med_total_max' => $this->input->post('med_total_max'),

                'neet_reg' => $this->input->post('neet_reg'),
                'neet_rank' => $this->input->post('neet_rank'),
                'neet_marks' => $this->input->post('neet_marks'),
                'neet_phy_mark_obtained' => $this->input->post('neet_phy_mark_obtained'),
                'neet_chem_mark_obtained' => $this->input->post('neet_chem_mark_obtained'),
                'neet_bio_mark_biology' => $this->input->post('neet_bio_mark_biology'),
                'neet_percentile' => $this->input->post('neet_percentile'),
                'keam_roll_no' => $this->input->post('keam_roll_no'),
                'kerala_medical_rank' => $this->input->post('kerala_medical_rank'),
                'seat_type' => $this->input->post('seat_type'),


                'bank_account_no' => $this->input->post('bank_account_no'),
                'bank_name' => $this->input->post('bank_name'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'samagra_id' => $this->input->post('samagra_id'),
                'rte' => $this->input->post('rte'),
                'previous_school' => $this->input->post('previous_school'),
                'note' => $this->input->post('note'),
                'scholarship' => $this->input->post('scholarship'),



            );
            $this->student_model->add($data);
            $data_new = array(
                'student_id' => $id,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'session_id' => $session,
                'fees_discount' => $fees_discount
            );
            $insert_id = $this->student_model->add_student_session($data_new);
            if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
                $fileInfo = pathinfo($_FILES["file"]["name"]);
                $img_name = $id . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'image' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            if (isset($_FILES["father_pic"]) && !empty($_FILES['father_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["father_pic"]["name"]);
                $img_name = $id . "father" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["father_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'father_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }


            if (isset($_FILES["mother_pic"]) && !empty($_FILES['mother_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["mother_pic"]["name"]);
                $img_name = $id . "mother" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["mother_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'mother_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }


            if (isset($_FILES["guardian_pic"]) && !empty($_FILES['guardian_pic']['name'])) {
                $fileInfo = pathinfo($_FILES["guardian_pic"]["name"]);
                $img_name = $id . "guardian" . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["guardian_pic"]["tmp_name"], "./uploads/student_images/" . $img_name);
                $data_img = array('id' => $id, 'guardian_pic' => 'uploads/student_images/' . $img_name);
                $this->student_model->add($data_img);
            }

            if (isset($siblings_counts) && ($total_siblings == $siblings_counts)) {
                //if there is no change in sibling
            } else if (!isset($siblings_counts) && $sibling_id == 0 && $total_siblings > 0) {
                // add for new parent
                $parent_password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);

                $data_parent_login = array(
                    'username' => $this->parent_login_prefix . $student_id . "_1",
                    'password' => $parent_password,
                    'user_id' => "",
                    'role' => 'parent',
                );

                $update_student = array(
                    'id' => $student_id,
                    'parent_id' => 0,
                );
                $ins_id = $this->user_model->addNewParent($data_parent_login, $update_student);
            } else if ($sibling_id != 0) {
                //join to student with new parent
                $student_sibling = $this->student_model->get($sibling_id);
                $update_student = array(
                    'id' => $student_id,
                    'parent_id' => $student_sibling['parent_id'],
                );
                $student_sibling = $this->student_model->add($update_student);
            } else {

            }


            $this->session->set_flashdata('msg', '<div student="alert alert-success text-left">Student Record Updated successfully</div>');
            redirect('student/search');
        }
    }

}
