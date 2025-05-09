<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentfee extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('smsgateway');
        $this->load->library('mailsmsconf');
		
    }

    function index() {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/index');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeSearch', $data);
        $this->load->view('layout/footer', $data);
    }

    function pdf() {
        $this->load->helper('pdf_helper');
    }

    function search() {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Student Search';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $button = $this->input->post('search');
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $search = $this->input->post('search');
            $search_text = $this->input->post('search_text');
            if (isset($search)) {
                if ($search == 'search_filter') {
                    $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
                    if ($this->form_validation->run() == FALSE) {
                        
                    } else {
                        $resultlist = $this->student_model->searchByClassSection($class, $section);
                        $data['resultlist'] = $resultlist;
                    }
                } else if ($search == 'search_full') {
                    $resultlist = $this->student_model->searchFullText($search_text);
                    $data['resultlist'] = $resultlist;
                }
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/studentfeeSearch', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    function feesearch() {
        if (!$this->rbac->hasPrivilege('search_due_fees', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/feesearch');
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $feesessiongroup = $this->feesessiongroup_model->getFeesByGroup();

        $data['feesessiongrouplist'] = $feesessiongroup;
        $this->form_validation->set_rules('feegroup_id', 'Fee Group', 'trim|required|xss_clean');

        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentSearchFee', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data['student_due_fee'] = array();
            $feegroup_id = $this->input->post('feegroup_id');
            $feegroup = explode("-", $feegroup_id);
            $feegroup_id = $feegroup[0];
            $fee_groups_feetype_id = $feegroup[1];
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_due_fee = $this->studentfee_model->getDueStudentFees($feegroup_id, $fee_groups_feetype_id, $class_id, $section_id);
            if (!empty($student_due_fee)) {
                foreach ($student_due_fee as $student_due_fee_key => $student_due_fee_value) {
                    $amt_due = $student_due_fee_value['amount'];
                    $student_due_fee[$student_due_fee_key]['amount_discount'] = 0;
                    $student_due_fee[$student_due_fee_key]['amount_fine'] = 0;
                    $a = json_decode($student_due_fee_value['amount_detail']);
                    if (!empty($a)) {
                        $amount = 0;
                        $amount_discount = 0;
                        $amount_fine = 0;

                        foreach ($a as $a_key => $a_value) {
                            $amount = $amount + $a_value->amount;
                            $amount_discount = $amount_discount + $a_value->amount_discount;
                            $amount_fine = $amount_fine + $a_value->amount_fine;
                        }
                        if ($amt_due <= $amount) {
                            unset($student_due_fee[$student_due_fee_key]);
                        } else {

                            $student_due_fee[$student_due_fee_key]['amount_detail'] = $amount;
                            $student_due_fee[$student_due_fee_key]['amount_discount'] = $amount_discount;
                            $student_due_fee[$student_due_fee_key]['amount_fine'] = $amount_fine;
                        }
                    }
                }
            }


            $data['student_due_fee'] = $student_due_fee;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentSearchFee', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function reportbyname() {
        if (!$this->rbac->hasPrivilege('fees_statement', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/reportbyname');
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByName', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);
            } else {
                $data['student_due_fee'] = array();
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                $student = $this->student_model->get($student_id);
                $data['student'] = $student;
                $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['id']);
                $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
                $data['student_discount_fee'] = $student_discount_fee;
                $data['student_due_fee'] = $student_due_fee;
                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;
                $data['student_id'] = $student_id;
                $category = $this->category_model->get();
                $data['categorylist'] = $category;
                $this->load->view('layout/header', $data);
                $this->load->view('studentfee/reportByName', $data);
                $this->load->view('layout/footer', $data);
            }
        }
    }

    function reportbyclass() {
        $data['title'] = 'student fees';
        $data['title'] = 'student fees';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $student_fees_array = array();
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $student_result = $this->student_model->searchByClassSection($class_id, $section_id);
            $data['student_due_fee'] = array();
            if (!empty($student_result)) {
                foreach ($student_result as $key => $student) {
                    $student_array = array();
                    $student_array['student_detail'] = $student;
                    $student_session_id = $student['student_session_id'];
                    $student_id = $student['id'];
                    $student_due_fee = $this->studentfee_model->getDueFeeBystudentSection($class_id, $section_id, $student_session_id);
                    $student_array['fee_detail'] = $student_due_fee;
                    $student_fees_array[$student['id']] = $student_array;
                }
            }
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $data['student_fees_array'] = $student_fees_array;
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/reportByClass', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'studentfee List';
        $studentfee = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentfeeShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function deleteFee() {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_delete')) {
            access_denied();
        }
        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice = $this->input->post('sub_invoice');
		$studentname=$this->input->post('studentname');
		$type=$this->input->post('type');
	
		$currentdate=date('Y-m-d');
        if (!empty($invoice_id)) {
			
			
			$array=array(
			'studentname'=>$studentname,
			'type'=>$type,
			'invoice'=>$sub_invoice,
			'date'=>date('Y-m-d')
			);
			
			
            $this->studentfee_model->remove($invoice_id, $sub_invoice,$array);
        }
		
	
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }
	
	
	function refund_fee()
	{
	
	
	  $refund_amount =$this->input->post('refund_amount');
	  $student_fees_master_id =$this->input->post('student_fees_master_id');
	  $fee_groups_feetype_id =$this->input->post('fee_groups_feetype_id');
	  $date =$this->input->post('date');
	  $payment_mode=$this->input->post('payment_mode');
	  $amount=array(
	  'date'=>$date,
	  'amount'=>$refund_amount,
	  'payment_mode'=>$payment_mode
	  );
	  
	  $data=array(
	  'student_fees_master_id'=>$student_fees_master_id,
	  'fee_groups_feetype_id'=> $fee_groups_feetype_id,
	  //'amount_detail'=>array(),
	  'refund_detail'=>json_encode($amount)
	  
	  );
	  	
	  	$this->studentfee_model->refund_fee($data);
		
		 $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
		
	}
	
	
	
	
	
	
	

    function deleteStudentDiscount() {

        $discount_id = $this->input->post('discount_id');
        if (!empty($discount_id)) {
            $data = array('id' => $discount_id, 'status' => 'assigned', 'payment_id' => "");
            $this->feediscount_model->updateStudentDiscount($data);
        }
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function addfee($id) {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Student Detail';
        $student = $this->student_model->get($id);
        $data['student'] = $student;
		
		$billdetail=$this->studentfeemaster_model->get_billdetail($id);
         $fees_excess=$this->studentfeemaster_model->get_fee_excess($id);
		$fees_advance=$this->studentfeemaster_model->get_fee_advance($id); 
        $student_due_fee = $this->studentfeemaster_model->getStudentFees($student['id']);
		$fee_excess=$this->studentfeemaster_model->getFeeexcess($id);
		$data['fee_excess']=$fee_excess;
		$fee_advance=$this->studentfeemaster_model->getFeeadvance($id);
		$data['fee_advance']=$fee_advance;
		
        $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
		
		$data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $class_section = $this->student_model->getClassSection($student["class_id"]);
        $data["class_section"] = $class_section;
         $session = $this->setting_model->getCurrentSession();
        
        $studentlistbysection = $this->student_model->getStudentClassSection($student["class_id"],$session);
		
		if(!empty($billdetail)){
		 foreach($billdetail as $key=>$val)
		  {
			$arr[$key]=$val;
			  }}
		if(!empty($fees_excess)){	  
		foreach($fees_excess as $key=>$res)
	     {
		   $arr[$key]=$res;
				  
			}}
			if(!empty($fees_advance)){	  
		 foreach($fees_advance as $key=>$ar)
		 {
			$arr[$key]=$ar; 
			 }}
			   
		 $data['billdetail']=$arr;
		 
		
		
        $data["studentlistbysection"] = $studentlistbysection;
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/studentAddfee', $data);
        $this->load->view('layout/footer', $data);
    }

    function deleteTransportFee() {
        $id = $this->input->post('feeid');
        $this->studenttransportfee_model->remove($id);
        $array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
    }

    function delete($id) {
        $data['title'] = 'studentfee List';
        $this->studentfee_model->remove($id);
        redirect('studentfee/index');
    }

    function create() {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Add studentfee';
        $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">Employee added to successfully</div>');
            redirect('studentfee/index');
        }
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('collect_fees', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit studentfees';
        $data['id'] = $id;
        $studentfee = $this->studentfee_model->get($id);
        $data['studentfee'] = $studentfee;
        $this->form_validation->set_rules('category', 'category', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('studentfee/studentfeeEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'category' => $this->input->post('category'),
            );
            $this->studentfee_model->add($data);
            $this->session->set_flashdata('msg', '<div studentfee="alert alert-success text-center">Employee updated successfully</div>');
            redirect('studentfee/index');
        }
    }

    function addstudentfee() {

        $this->form_validation->set_rules('student_fees_master_id', 'Fee Master', 'required|trim|xss_clean');
        $this->form_validation->set_rules('fee_groups_feetype_id', 'Student', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean|callback_check_deposit');
        $this->form_validation->set_rules('amount_discount', 'Discount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount_fine', 'Fine', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount' => form_error('amount'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'amount_discount' => form_error('amount_discount'),
                'amount_fine' => form_error('amount_fine'),
                'payment_mode' => form_error('payment_mode'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
			//$invoice=$this->input->post('ad_invo');
			$admin=$this->session->userdata('admin');
            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName();
            $student_fees_discount_id = $this->input->post('student_fees_discount_id');
			$type=$this->input->post('feename');
			$stud_name=$this->input->post('stud_name');
			$group=$this->input->post('group');
			$invoice=$this->studentfeemaster_model->inv_no();
			
			
            $json_array = array(
                'amount' => $this->input->post('amount'),
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $this->input->post('amount_discount'),
                'amount_fine' => $this->input->post('amount_fine'),
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
				
            );
            $data = array(
			   'centre_id'=>$admin['centre_id'],
                'student_fees_master_id' => $this->input->post('student_fees_master_id'),
                'fee_groups_feetype_id' => $this->input->post('fee_groups_feetype_id'),
                'amount_detail' => $json_array,
				
				'created_at' => date('Y-m-d')
            );
			
			
            $send_to = $this->input->post('guardian_phone');
            $email = $this->input->post('guardian_email');
            $inserted_id = $this->studentfeemaster_model->fee_deposit($data, $send_to, $student_fees_discount_id,$invoice);
			
			$income_amount= $this->input->post('amount')+$this->input->post('amount_fine');
			
			$amount=array(
		    'invoice_no'=> $invoice, 
			'person_name'=>$stud_name,
			'amount' => $income_amount,
			'centre_id'=>$admin['centre_id'],
			'note'=>$group.': '.$type,
			'name'=>$type,
			'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
			);
			$this->income_model->add($amount);
			
			
           /* $sender_details = array('invoice' => $inserted_id, 'contact_no' => $send_to, 'email' => $email);
            $this->mailsmsconf->mailsms('fee_submission', $sender_details);*/

            $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
        }
    }

 function addstudentfee2() {

        $this->form_validation->set_rules('fee_groups_feetype_id[]', ' Fees Head', 'required|trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|xss_clean');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim|xss_clean');
		
        if ($this->form_validation->run() == false) {
            $data = array(
                'amount2' => form_error('amount'),
                
                'tfeetype' => form_error('fee_groups_feetype_id[]'),
               
                'payment_mode' => form_error('payment_mode'),
			
            );
            $array = array('status' => 'fail', 'error' => $data);
            
			echo json_encode($array);
			
        } 
		
		
		else {
			$admin=$this->session->userdata('admin');
			$amount=$this->input->post('amount');
			$bamount=$this->input->post('balance');
			$fee_groups_feetype_id=$this->input->post('fee_groups_feetype_id');
			$c=count($fee_groups_feetype_id);
			$cal_amount=$this->input->post('cal_amount');
			$student_fees_master_id=$this->input->post('student_fees_master_id');
			$dis_fee_type_id = $this->input->post('dis_fee_type_id');
			$amount_discount=$this->input->post('amount_discount');
			//$invoice=$this->input->post('invo');
			$invoice=$this->studentfeemaster_model->inv_no();
		    $fixed_fine=$this->input->post('amount_fine');
			$stud_name=$this->input->post('stud_name');
		    $t_amount=$amount;
			
			
			
		    if($cal_amount != $amount && $dis_fee_type_id ==0 )
			{
			for($i=0;$i<$c;$i++)
			{ 
			  if($t_amount !=0)
			   {
				if($t_amount < (int)$bamount[$i])
				{
				
				 $final_amount = $t_amount ;
				 $t_amount=0;
				
				}
				 else if($t_amount == (int)$bamount[$i])
				 {
				  $final_amount=$bamount[$i];	
				   $t_amount=0;	
					 
				 }
				else
				{
				 $final_amount=$bamount[$i];
				 $t_amount=$t_amount-(int)$bamount[$i];
				
				}
			  
            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName();
            $student_fees_discount_id = $this->input->post('student_fees_discount_id');           
			if(!empty($dis_fee_type_id))
			{ 
			if($fee_groups_feetype_id[$i] == $dis_fee_type_id)
			{
				$income_amount=($final_amount-$amount_discount)+$fixed_fine[$i];
				 $json_array = array(
                'amount' => $final_amount-$amount_discount,
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $amount_discount,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
            );
				
				
				}
				else
				{
				$income_amount=$final_amount+$fixed_fine[$i];	  
					
			 $json_array = array(
			
                'amount' => $final_amount,
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => 0,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' =>$this->input->post('payment_mode')
            );
					
					
				}
				
				}
			
			else
			{
				$income_amount=$income_amount+$fixed_fine[$i];
				
				$json_array = array(
                'amount' => $income_amount,
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $amount_discount,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
            );
				
				
			}
			
			
            $data = array(
			   'centre_id'=>$admin['centre_id'],
                'student_fees_master_id' =>$student_fees_master_id[$i],
                'fee_groups_feetype_id' =>$fee_groups_feetype_id[$i],
                'amount_detail' => $json_array,
				'created_at' => date('Y-m-d')
            );
			
			  
            $send_to = $this->input->post('guardian_phone');
            $email = $this->input->post('guardian_email');
            $inserted_id = $this->studentfeemaster_model->total_fee_deposit($data, $send_to, $student_fees_discount_id,$invoice);
			$incomename=$this->studentfeemaster_model->getfeetypefeegroup($fee_groups_feetype_id[$i]);
			
			
			$amount=array(
		    'invoice_no'=> $invoice, 
			'person_name'=>$stud_name,
			'amount' => $income_amount,
			'centre_id'=>$admin['centre_id'],
			'note'=>$incomename['name'].': '.$incomename['type'],
			'name'=>$incomename['type'],
			'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
			);
			$this->income_model->add($amount);
             
			  
        
            $sender_details = array('invoice' => $inserted_id, 'contact_no' => $send_to, 'email' => $email);
            $this->mailsmsconf->mailsms('fee_submission', $sender_details);
 } 
 
 else{
	  $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
	 
	 }
 
 
 }
 
 $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
}
      
       
	   
	   else
	   {
		   
		   
		 for($i=0;$i<$c;$i++)
			{ 
			  
            $collected_by = " Collected By: " . $this->customlib->getAdminSessionUserName();
            $student_fees_discount_id = $this->input->post('student_fees_discount_id');           
			if(!empty($dis_fee_type_id))
			{ 
			if($fee_groups_feetype_id[$i] == $dis_fee_type_id)
			{
				$income_amount=($bamount[$i]-$amount_discount)+$fixed_fine[$i];
				
				 $json_array = array(
                'amount' => $bamount[$i]-$amount_discount,
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $amount_discount,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
            );
				
				
				}
				else
				{
					  
				$income_amount=	$bamount[$i]+$fixed_fine[$i];
			 $json_array = array(
			
                'amount' => $bamount[$i],
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => 0,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' =>$this->input->post('payment_mode')
            );
					
					
				}
				
				}
			
			else
			{
				$income_amount=	$bamount[$i]+$fixed_fine[$i];
				$json_array = array(
                'amount' => $bamount[$i],
                'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
                'amount_discount' => $amount_discount,
                'amount_fine' => $fixed_fine[$i],
                'description' => $this->input->post('description') . $collected_by,
                'payment_mode' => $this->input->post('payment_mode')
            );
				
				
			}
			
			
            $data = array(
			     'centre_id'=>$admin['centre_id'],
                'student_fees_master_id' =>$student_fees_master_id[$i],
                'fee_groups_feetype_id' =>$fee_groups_feetype_id[$i],
                'amount_detail' => $json_array,
				'created_at' => date('Y-m-d') 
            );

            $send_to = $this->input->post('guardian_phone');
            $email = $this->input->post('guardian_email');
            $inserted_id = $this->studentfeemaster_model->total_fee_deposit($data, $send_to, $student_fees_discount_id,$invoice);
             $incomename=$this->studentfeemaster_model->getfeetypefeegroup($fee_groups_feetype_id[$i]);
			 
			 $amount=array(
		    'invoice_no'=> $invoice, 
			'person_name'=>$stud_name,
			'amount' => $income_amount,
			'centre_id'=>$admin['centre_id'],
			'note'=>$incomename['name'].': '.$incomename['type'],
			'name'=>$incomename['type'],
			'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date'))),
			);
			$this->income_model->add($amount);
             
			 
			  
        
            $sender_details = array('invoice' => $inserted_id, 'contact_no' => $send_to, 'email' => $email);
            $this->mailsmsconf->mailsms('fee_submission', $sender_details);
 } 
 
 
	  $array = array('status' => 'success', 'error' => '');
            echo json_encode($array);
	 
	
 
 }  
	   
	   
	       
       
		
    }}



    function printFeesByName() {
        $data = array('payment' => "0");

        $record = $this->input->post('data');
        $invoice_id = $this->input->post('main_invoice');
        $sub_invoice_id = $this->input->post('sub_invoice');
        $student_session_id = $this->input->post('student_session_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $student = $this->studentsession_model->searchStudentsBySession($student_session_id);

        $fee_record = $this->studentfeemaster_model->printFeeByInvoice($invoice_id, $sub_invoice_id);
        $data['student'] = $student;
        $data['sub_invoice_id'] = $sub_invoice_id;
        $data['feeList'] = $fee_record;
        $this->load->view('print/printFeesByName', $data);
    }
	
	
	function printBillwise() {
     

       
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $data['billno']=$this->input->post('billno');
		 $data['billamount']=$this->input->post('billamount');
		  $data['billdate']=$this->input->post('billdate');
		   $data['studname']=$this->input->post('studname');
		  $data['type']=$this->input->post('type');
		  $data['mode']=$this->input->post('mode');
		  $data['course']=$this->input->post('course');
		  $data['admin_no']=$this->input->post('admin_no');

        $this->load->view('print/printBillwise', $data);
    }
	
	
	
	
	
	

    function printFeesByGroup() {
        $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
        $fee_master_id = $this->input->post('fee_master_id');
        $fee_session_group_id = $this->input->post('fee_session_group_id');
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $data['feeList'] = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);

        $this->load->view('print/printFeesByGroup', $data);
    }

    function printFeesByGroupArray() {
        $setting_result = $this->setting_model->get();
        $data['settinglist'] = $setting_result;
        $record = $this->input->post('data');
        $record_array = json_decode($record);
        $fees_array = array();
		
	     
		
		 //$student_due_fee = $this->studentfeemaster_model->getStudentFees($student['id']);
		
       /* $student_discount_fee = $this->feediscount_model->getStudentFeesDiscount($student['student_session_id']);
		
		$data['student_discount_fee'] = $student_discount_fee;
        $data['student_due_fee'] = $student_due_fee;
        $category = $this->category_model->get();
        $data['categorylist'] = $category;
        $class_section = $this->student_model->getClassSection($student["class_id"]);
        $data["class_section"] = $class_section;
        $session = $this->setting_model->getCurrentSession();
        
        $studentlistbysection = $this->student_model->getStudentClassSection($student["class_id"],$session);*/
		
		
		
		
        foreach ($record_array as $key => $value) {
            $fee_groups_feetype_id = $value->fee_groups_feetype_id;
            $fee_master_id = $value->fee_master_id;
            $fee_session_group_id = $value->fee_session_group_id;
			
            $feeList = $this->studentfeemaster_model->getDueFeeByFeeSessionGroupFeetype($fee_session_group_id, $fee_master_id, $fee_groups_feetype_id);
            $fees_array[] = $feeList;
			
				
        }
       
        $data['feearray'] = $fees_array;
		
        $this->load->view('print/printFeesByGroupArray', $data);
    }

    function searchpayment() {
        if (!$this->rbac->hasPrivilege('search_fees_payment', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Fees Collection');
        $this->session->set_userdata('sub_menu', 'studentfee/searchpayment');
        $data['title'] = 'Edit studentfees';


        $this->form_validation->set_rules('paymentid', 'Payment ID', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $paymentid = $this->input->post('paymentid');
            $invoice = explode("/", $paymentid);

            if (array_key_exists(0, $invoice) && array_key_exists(1, $invoice)) {
                $invoice_id = $invoice[0];
                $sub_invoice_id = $invoice[1];
				
				
                $feeList = $this->studentfeemaster_model->getFeeByInvoice($invoice_id, $sub_invoice_id);
                $data['feeList'] = $feeList;
                $data['sub_invoice_id'] = $paymentid;
            } else {
                $data['feeList'] = array();
            }
        }
        $this->load->view('layout/header', $data);
        $this->load->view('studentfee/searchpayment', $data);
        $this->load->view('layout/footer', $data);
    }

    function addfeegroup() {
        $this->form_validation->set_rules('fee_session_groups', 'Fee Group', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_session_groups' => form_error('fee_session_groups'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $student_session_id = $this->input->post('student_session_id');
            $fee_session_groups = $this->input->post('fee_session_groups');
            $student_sesssion_array = isset($student_session_id) ? $student_session_id : array();
            $student_ids = $this->input->post('student_ids');
            $delete_student = array_diff($student_ids, $student_sesssion_array);

            $preserve_record = array();
            if (!empty($student_sesssion_array)) {
				$admin=$this->session->userdata('admin');
                foreach ($student_sesssion_array as $key => $value) {

                    $insert_array = array(
					    'centre_id'=>$admin['centre_id'],
                        'student_session_id' => $value,
                        'fee_session_group_id' => $fee_session_groups,
						'student_id'=>$this->input->post('student_id_'.$value)
                    );
                    $inserted_id = $this->studentfeemaster_model->add($insert_array);

                    $preserve_record[] = $inserted_id;
                }
            }
			
			
            if (!empty($delete_student)) {
                $this->studentfeemaster_model->delete($fee_session_groups, $delete_student);
            }
            
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
            echo json_encode($array);
        }
    }
	
	
	 /*function addmessfeegroup() {
        $this->form_validation->set_rules('mess_fee_session_id', 'Fee Group', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'mess_fee_session_id' => form_error('mess_fee_session_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $student_session_id = $this->input->post('student_session_id');
            $mess_fee_session_id = $this->input->post('mess_fee_session_id');
            $student_sesssion_array = isset($student_session_id) ? $student_session_id : array();
            $student_ids = $this->input->post('student_ids');
            $delete_student = array_diff($student_ids, $student_sesssion_array);

            $preserve_record = array();
            if (!empty($student_sesssion_array)) {
				
                foreach ($student_sesssion_array as $key => $value) {

                    $insert_array = array(
					    
                        'student_session_id' => $value,
                        'mess_fee_session_id' => $mess_fee_session_id,
						'student_id'=>$this->input->post('student_id_'.$value)
                    );
                    $inserted_id = $this->studentfeemaster_model->addmess($insert_array);

                    $preserve_record[] = $inserted_id;
                }
            }
			
			
			
            if (!empty($delete_student)) {
                $this->studentfeemaster_model->deletemeemaster($mess_fee_session_id, $delete_student);
            }
           
			 
            $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');
            echo json_encode($array);
        }
    }
	*/
	
	
	
	

    function geBalanceFee() {
        $this->form_validation->set_rules('fee_groups_feetype_id', 'fee_groups_feetype_id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_fees_master_id', 'student_fees_master_id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id', 'student_session_id', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                'student_fees_master_id' => form_error('student_fees_master_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array();
			$fine=$this->input->post('fine');
            $student_session_id = $this->input->post('student_session_id');
            $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
            $student_fees_master_id = $this->input->post('student_fees_master_id');
            $remain_amount = $this->getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id);
            $discount_not_applied = $this->getNotAppliedDiscount($student_session_id);
            $remain_amount = json_decode($remain_amount)->balance;
            $array = array('status' => 'success', 'error' => '', 'balance' => $remain_amount, 'discount_not_applied' => $discount_not_applied,'fine'=>$fine);
            echo json_encode($array);
        }
    }




 function geBalanceFee2() {
        //$this->form_validation->set_rules('fee_groups_feetype_id', 'fee_groups_feetype_id', 'required|trim|xss_clean');
        //$this->form_validation->set_rules('student_fees_master_id', 'student_fees_master_id', 'required|trim|xss_clean');
        $this->form_validation->set_rules('student_session_id', 'student_session_id', 'required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            $data = array(
                //'fee_groups_feetype_id' => form_error('fee_groups_feetype_id'),
                //'student_fees_master_id' => form_error('student_fees_master_id'),
            );
            $array = array('status' => 'fail', 'error' => $data);
            echo json_encode($array);
        } else {
            $data = array();
			
            $student_session_id = $this->input->post('student_session_id');
            $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
            $student_fees_master_id = $this->input->post('student_fees_master_id');
			$student_id=$this->input->post('student_id');
			
			
			
			$c=count($fee_groups_feetype_id);
			
			$ar=array();
			
			for($i=0;$i<$c;$i++)
			{
				
			$remain_amount = $this->getStuFeetypeBalance($fee_groups_feetype_id[$i], $student_fees_master_id[$i]);
			
			
			   $remain_amount = json_decode($remain_amount)->balance;
			$ar[]=$remain_amount;
			
			}
			
            $discount_not_applied = $this->getNotAppliedDiscount($student_session_id);
            //$remain_amount = json_decode($remain_amount)->balance;
			
			$t_fee_type=$this->getNotAppliedfeetype($student_id);
			
            $array = array('status' => 'success', 'error' => '', 'discount_not_applied' => $discount_not_applied,'balance' =>$ar,'t_fee_type'=>$t_fee_type);
            echo json_encode($array);
        }
    }







    function getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id) {
        $data = array();
        $data['fee_groups_feetype_id'] = $fee_groups_feetype_id;
        $data['student_fees_master_id'] = $student_fees_master_id;

		
        $result = $this->studentfeemaster_model->studentDeposit($data);
		
		
        $amount_balance = 0;
        $amount = 0;
        $amount_fine = 0;
        $amount_discount = 0;
        $due_amt = $result->amount;
        if ($result->is_system) {
            $due_amt = $result->student_fees_master_amount;
        }
        $amount_detail = json_decode($result->amount_detail);

        if (is_object($amount_detail)) {

            foreach ($amount_detail as $amount_detail_key => $amount_detail_value) {
                $amount = $amount + $amount_detail_value->amount;
                $amount_discount = $amount_discount + $amount_detail_value->amount_discount;
                $amount_fine = $amount_fine + $amount_detail_value->amount_fine;
            }
        }

       
		  $amount_balance = $due_amt - ($amount + $amount_discount);
        $array = array('status' => 'success', 'error' => '', 'balance' => $amount_balance);
        return json_encode($array);
    }
	
	
	

    function check_deposit($amount) {
        if ($this->input->post('amount') != "" && $this->input->post('amount_discount') != "") {
            if ($this->input->post('amount') < 0) {
                $this->form_validation->set_message('check_deposit', 'Deposit amount can not be less than zero');
                return FALSE;
            } else {
                $student_fees_master_id = $this->input->post('student_fees_master_id');
                $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
                $deposit_amount = $this->input->post('amount') + $this->input->post('amount_discount');
                $remain_amount = $this->getStuFeetypeBalance($fee_groups_feetype_id, $student_fees_master_id);
                $remain_amount = json_decode($remain_amount)->balance;
                if ($remain_amount < $deposit_amount) {
                    $this->form_validation->set_message('check_deposit', 'Deposit amount can not be grater than remaining');
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
            return TRUE;
        }
        return TRUE;
    }

    function getNotAppliedDiscount($student_session_id) {
        return $this->feediscount_model->getDiscountNotApplied($student_session_id);
    }
	
	
	function getNotAppliedfeetype($student_id)
	{
	return $this->studentfee_model->getNotAppliedfeetype($student_id);	
		
	}
	
	
	
	
	function deleteFee_ex()
	{
		$id=$this->input->post('id');
		if(!empty($id))
		{
			$this->studentfee_model->delete_fee_ex($id);
			
			}
		$array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
		}
	
	 function deleteFee_ad()
	{
		$id=$this->input->post('id');
		if(!empty($id))
		{
			$this->studentfee_model->delete_fee_ad($id);
			
			}
		$array = array('status' => 'success', 'result' => 'success');
        echo json_encode($array);
		}
	
	
	
	
	
	function fee_advance()
	{
		
		$id=$this->input->post('student_id');
		//$invoice=$this->input->post('ad_invo');
		$invoice=$this->studentfeemaster_model->inv_no();
		$stud_name=$this->input->post('stud_name');
		$json_array=array(
		'amount'=>$this->input->post('ad_amount'),
		'date'=>date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('ad_date'))),
		'payment_mode'=>$this->input->post('payment_mode_fee'),
		'description'=>$this->input->post('ad_note'),
		'invo'=>$invoice
		);
		
		$data=array(
		
		'student_id'=>$this->input->post('student_id'),
		'type'=>'Fees Received in Advance',
		'amount_detail'=>json_encode(array($invoice=>$json_array))
		
		);
	   
	   $this->studentfeemaster_model->collect_fee_advance($data);
	   $admin=$this->session->userdata('admin');
	   
	    $amount=array(
		    'invoice_no'=> $invoice, 
			'person_name'=>$stud_name,
			'amount' => $this->input->post('ad_amount'),
			'centre_id'=>$admin['centre_id'],
			'note'=>'Fees Received in Advance',
			'name'=>'Fees Received in Advance',
			'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('ad_date'))),
			);
			$this->income_model->add($amount);
	   
	
		 $array = array('status' => 'success', 'error' => '');
         echo json_encode($array);
		
		
		}
	
	
	
	
	function fee_excess()
	{
		
		$id=$this->input->post('student_id');
		//$invoice=$this->input->post('ex_invo');
		$invoice=$this->studentfeemaster_model->inv_no();
		$stud_name=$this->input->post('stud_name');
		$json_array=array(
		'amount'=>$this->input->post('ex_amount'),
		'date'=>date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('ex_date'))),
		'payment_mode'=>$this->input->post('payment_mode_fee'),
		'description'=>$this->input->post('ex_note'),
		'invo'=>$invoice
		);
		
		$data=array(
		
		'student_id'=>$this->input->post('student_id'),
		'type'=>'Fees Received in Excess',
		'amount_detail'=>json_encode(array($invoice=>$json_array))
		
		);
	   
	   $this->studentfeemaster_model->collect_fee_excess($data);
	   
	     $admin=$this->session->userdata('admin');
	     $amount=array(
		    'invoice_no'=> $invoice, 
			'person_name'=>$stud_name,
			'amount' => $this->input->post('ex_amount'),
			'centre_id'=>$admin['centre_id'],
			'note'=>'Fees Received in Excess',
			'name'=>'Fees Received in Excess',
			'date' => date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('ex_date'))),
			);
			$this->income_model->add($amount);
	   
	   
	   
	
		 $array = array('status' => 'success', 'error' => '');
         echo json_encode($array);
		
		
		}
	
	
	
	
	
	
	
		
		
		
		
	
	

}

?>