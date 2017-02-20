<?php
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'date', 'common_helper']);
        //$this->load->library('email');
        $this->load->library('my_phpmailer');
        $this->load->library(['form_validation']);
        $this->load->model(['manage/admin_model', 'user/user_model', 'manage/loan_application_model', 'manage/bank_model', 'manage/analyst_model']);
        $this->sms_url = 'http://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=SpdxEeX9K6D';
        if (!$this->user_authentication->try_session_login()) {
            redirect('home');
        }
    }

    public function index() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        if ($data["utype_id"] == 1 || $data["utype_id"] == 2 || $data["utype_id"] == 3) {
            if ($data["utype_id"] == 1) {
                $id['usr.uid'] = $this->session->userdata('sesuserId');
                $other["tables"] = "TBL_MSME";
                $users_details = $this->admin_model->getUserDetails($id, $other);
                $this->db->where('tbl_loan_application.msme_id', $this->session->userdata('sesuserId'));
                $sel = 'tbl_loan_application.application_id,tbl_loan_application.status,tbl_loan_application.msme_id,tbl_loan_application.channel_partner_id,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility';
            } else if ($data["utype_id"] == 2) {
                $id['usr.uid'] = $this->session->userdata('sesuserId');
                $other["tables"] = "TBL_CHANNEL_PARTNER";
                $users_details = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                $msme['ms.channel_partner_id'] = $users_details[0]->uid;
                $msme_list = $this->admin_model->getMSMEArray($msme);
                //print_r($msme_list);exit;
                if (!empty($msme_list)) {
                    $wh = "(tbl_loan_application.channel_partner_id=" . $this->session->userdata('sesuserId') . " or tbl_loan_application.msme_id in(" . $msme_list . "))";
                    $this->db->where($wh);
                } else {
                    $this->db->where('tbl_loan_application.channel_partner_id', $this->session->userdata('sesuserId'));
                }

                $sel = 'tbl_loan_application.application_id,tbl_loan_application.status,tbl_loan_application.msme_id,tbl_loan_application.channel_partner_id,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility';
            } else {
                $sel = 'tbl_loan_application.application_id,tbl_loan_application.status,tbl_upload_documents.application_id,tbl_loan_application.msme_id,tbl_loan_application.channel_partner_id,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility';
                $this->db->join('tbl_upload_documents', 'tbl_upload_documents.application_id=tbl_loan_application.application_id', 'INNER');
            }
            $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
            $this->db->where_not_in("tbl_loan_application.status", '3');
            $this->db->order_by('tbl_loan_application.application_id', 'DESC');
            $data['loan_list'] = $this->admin_model->getRecords('tbl_loan_application', '', $sel);
             
                    
            $this->template->load('manage/main', 'manage/dashboard', $data);
        } else if ($data["utype_id"] == 4) {
            redirect("manage/dashboard/loan_application_list");
        } else {
            redirect("manage/dashboard/bank_list");
        }
    }

    public function statusList() {
        //print_r($_POST);
        $id["uid"] = $this->session->userdata('sesuserId');
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        if ($data["utype_id"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
        }
        $sel = 'tbl_loan_application.application_id,tbl_loan_application.status,tbl_loan_application.channel_partner_id,tbl_loan_application.created_dtm';
        $this->db->where('tbl_loan_application.application_id', $this->input->post('application_id'));
        $data['loan_lists'] = $this->admin_model->getRecords('tbl_loan_application', '', $sel);
        //print_r($data['loan_lists']);exit;
        $bank = 'tbl_loan_application.application_id,tbl_bank_master.bank_id,tbl_bank_application.bank_id,tbl_bank_application.application_id,tbl_bank_application.status,tbl_bank_master.bank_name';
        $this->db->join('tbl_bank_master', 'tbl_bank_master.bank_id=tbl_bank_application.bank_id', 'left');
        $this->db->join('tbl_loan_application', 'tbl_loan_application.application_id=tbl_bank_application.application_id', 'left');
        $this->db->where('tbl_loan_application.application_id', $this->input->post('application_id'));
        if ($data["utype_id"] == 4) {
            $this->db->where('tbl_bank_application.bank_id', $data["bank_details"][0]->bank_id);
        }
        $data["bank_list"] = $this->admin_model->getRecords('tbl_bank_application', '', $bank);
        //print_r($datas["bank_list"]);exit;
        //print_r($data["bank_list"]);exit;

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));
    }

    public function mis_report() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $data["state"] = $this->user_model->fetch_state();
        $other["tables"] = "TBL_BANK_MASTER";
        $data["bank_details"] = $this->admin_model->getbank($other);
        $this->template->load('manage/main', 'manage/mis_report', $data);
    }

    public function show_mis_report() {

        //echo "<pre>";print_r($_POST);exit;
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $data["state"] = $this->user_model->fetch_state();
        $other["tables"] = "TBL_BANK_MASTER";
        $data["bank_details"] = $this->admin_model->getbank($other);
        //-------------------------Loan List-----------------------
        $this->db->distinct();
        $sel = 'tbl_enterprise_profile.contact_numbers,tbl_loan_application.application_id,tbl_enterprise_background.industry_segment,tbl_loan_requirement.Amount,tbl_enterprise_background.date_of_establishment,tbl_loan_application.status,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility,tbl_msme.enterprise_name,tbl_channel_partner.advisor_name';
        $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
        $this->db->join('tbl_enterprise_background', 'tbl_enterprise_background.application_id=tbl_loan_application.application_id', 'left');
        $this->db->join('tbl_enterprise_profile', 'tbl_enterprise_profile.application_id=tbl_loan_application.application_id', 'left');

        if ($this->input->post('organization') != '') {
            $organization = $this->input->post('organization');
            foreach ($organization as $val) {
                $this->db->like("tbl_enterprise_profile.legal_entity", $val);
            }
            $data['organization'] = $this->input->post('organization');
        }
        if ($this->input->post('state') != '') {
            $this->db->where_in("tbl_enterprise_profile.state", $this->input->post('state'));
            $data['states'] = $this->input->post('state');
        }
        if ($this->input->post('city') != '') {
            $this->db->where_in("tbl_enterprise_profile.city", $this->input->post('city'));
            $data['city'] = $this->input->post('city');
        }
        if ($this->input->post('loan_product') != '') {
            $loan_product = implode(",", $this->input->post('loan_product'));
            $loan_products = explode(",", $loan_product);
            $this->db->where_in("tbl_loan_requirement.type_of_facility", $loan_products);
            $data['loan_product'] = $loan_products;
        }
        if ($this->input->post('status') != '') {
            $status = implode(",", $this->input->post('status'));
            $statuss = explode(",", $status);
            $this->db->where_in("tbl_loan_application.status", $statuss);
            $data['status'] = $statuss;
        }
        if ($this->input->post('bank_status') != '') {
            $bank_status = implode(",", $this->input->post('bank_status'));
            $bank_statuss = explode(",", $bank_status);
            $this->db->where_in("tbl_bank_application.status", $bank_statuss);
            $this->db->join('tbl_bank_application', 'tbl_bank_application.application_id=tbl_loan_application.application_id', 'left');
            $data['bank_status'] = $bank_statuss;
        }
        if ($this->input->post('bank_name') != '') {
            $bank_name = implode(",", $this->input->post('bank_name'));
            $bank_names = explode(",", $bank_name);
            $this->db->where_in("tbl_bank_application.bank_id", $bank_names);
            //$this->db->join('tbl_bank_application', 'tbl_bank_application.application_id=tbl_loan_application.application_id','left');
            $data['bank_name'] = $bank_names;
        }
        if ($this->input->post('industry') != '') {
            $industry = implode(",", $this->input->post('industry'));
            $industrys = explode(",", $industry);
            $this->db->where_in("tbl_enterprise_background.industry_segment", $industrys);
            $data['industry'] = $industrys;
        }
        if ($this->input->post('from_year') != '' && $this->input->post('to_year') != '') {
            if ($this->input->post('to_year') > $this->input->post('from_year')) {
                $whs = "tbl_loan_application.created_dtm BETWEEN '" . date('Y-m-d', strtotime($this->input->post('from_year'))) . "' AND  '" . date('Y-m-d', strtotime($this->input->post('to_year'))) . "'";
                $this->db->where($whs);
                $data['to_year'] = $this->input->post('to_year');
                $data['from_year'] = $this->input->post('from_year');
            }
        }
        if ($this->input->post('min_amount') != '' && $this->input->post('max_amount') != '') {
            if ($this->input->post('min_amount') > 0 && $this->input->post('max_amount') > 0) {
                $wh = "AND ";
                $wh = "tbl_loan_requirement.Amount BETWEEN '" . str_replace(",", "", $this->input->post('min_amount')) . "' AND  '" . str_replace(",", "", $this->input->post('max_amount')) . "'";
                $this->db->where($wh);
                $data['min_amount'] = $this->input->post('min_amount');
                $data['max_amount'] = $this->input->post('max_amount');
            }
        }
        if ($this->input->post('min_amount') > 0 && $this->input->post('max_amount') == '') {
            $wh = "tbl_loan_requirement.Amount <= '" . str_replace(",", "", $this->input->post('min_amount')) . "'";
            $this->db->where($wh);
            $data['min_amount'] = $this->input->post('min_amount');
        }
        if ($this->input->post('max_amount') > 0 && $this->input->post('min_amount') == '') {
            $wh = "tbl_loan_requirement.Amount <= '" . str_replace(",", "", $this->input->post('max_amount')) . "'";
            $this->db->where($wh);
            $data['max_amount'] = $this->input->post('max_amount');
        }
        $this->db->join('tbl_msme', 'tbl_msme.uid=tbl_loan_application.msme_id', 'left');
        $this->db->join('tbl_channel_partner', 'tbl_channel_partner.uid=tbl_loan_application.channel_partner_id', 'left');
        $this->db->where_not_in("tbl_loan_application.status", '3');
        $data['loan_list'] = $this->admin_model->getRecords('tbl_loan_application', '', $sel);

        //-------------------------End Loan List--------------------------------------------

        //-------------------Excel Generation---------------------------------------------------
        if (!empty($data['loan_list']) && $this->input->post('download_btn') == 1) {
            $this->load->library('excel');

            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('MIS Report');
            $mcell = ['A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1'];
            foreach ($mcell as $ncell) {
                $this->excel->getActiveSheet()->getStyle($ncell)->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle($ncell)->getFont()->setBold(true);
            }

            $headings = ['Reference ID',
                'MSME',
                'Channel Partner',
                'Date Applied',
                'Type of Facility',
                'Mobile No',
                'Status'];

            $cell = 'A';
            foreach ($headings as $heading) {
                $this->excel->getActiveSheet()->setCellValue(($cell++) . '1', $heading);
            }
            $row_num = 1;
                  
                    
            foreach ($data['loan_list'] as $row) {
                $GMT = new DateTimeZone("GMT");
                $date_post = new DateTime($row['created_dtm'], $GMT);
                if ($row['status'] == 0) {
                    $status = "Incomplete";
                } else if ($row['status'] == 1) {
                    $status = "Forwarded To Analyst";
                } else {
                    $status = "Forwarded To Bank";
                }
                if ($row['type_of_facility'] == 1) {
                    $facility = "Personal Loan";
                } else if ($row['type_of_facility'] == 2) {
                    $facility = "Housing Loan";
                } else if ($row['type_of_facility'] == 3) {
                    $facility = "Loan against Property";
                } else if ($row['type_of_facility'] == 4) {
                    $facility = "Vehicle Loan";
                } else if ($row['type_of_facility'] == 5) {
                    $facility = "Education Loan";
                } else if ($row['type_of_facility'] == 6) {
                    $facility = "Gold Loan";
                } else if ($row['type_of_facility'] == 7) {
                    $facility = "Business Loan";
                } else if ($row['type_of_facility'] == 8) {
                    $facility = "Others";
                } else {
                    $facility = "";
                }
                ++$row_num;
                $cella = 'A';
                $cellb = 'B';
                $cellc = 'C';
                $celld = 'D';
                $celle = 'E';
                $cellf = 'F';
                $cellg = 'G';
                $this->excel->getActiveSheet()->setCellValue(($cella++) . $row_num, "#" . $row['application_id']);
                $this->excel->getActiveSheet()->setCellValue(($cellb++) . $row_num, $row['enterprise_name']);
                $this->excel->getActiveSheet()->setCellValue(($cellc++) . $row_num, $row['advisor_name']);
                $this->excel->getActiveSheet()->setCellValue(($celld++) . $row_num, $date_post->format('d-m-Y H:i:s'));
                $this->excel->getActiveSheet()->setCellValue(($celle++) . $row_num, $facility);
                $this->excel->getActiveSheet()->setCellValue(($cellf++) . $row_num, $row['contact_numbers']);
                $this->excel->getActiveSheet()->setCellValue(($cellf++) . $row_num, $status);
            }
            $mydate = getdate(date("U"));
            $temp = date("m-d-Y-H-i-s");
            $filename = 'mis_report' . $temp . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
        //-------------------End Excel Generation-----------------------------------------------

        $this->template->load('manage/main', 'manage/mis_report', $data);
    }

    public function inbox() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $id['uid'] = $this->session->userdata('sesuserId');
        if ($data["utype_id"] == 1) {
            $other["tables"] = "TBL_MSME";
            $users_details = $this->admin_model->getUserDetails($id, $other);
            $this->db->where('tbl_loan_application.msme_id', $this->session->userdata('sesuserId'));
            //$wh="(tbl_message_inbox.post_from=".$users_details[0]->id." or tbl_loan_application.channel_partner_id in(".$users_details[0]->channel_partner_id."))";
            $wh = "(tbl_message_inbox.utype_id=3 or tbl_message_inbox.utype_id =4)";
            $this->db->where($wh);
        } else if ($data["utype_id"] == 2) {
            $msme['ms.channel_partner_id'] = $this->session->userdata('sesuserId');
            $msme_list = $this->admin_model->getMSMEArray($msme);
            //print_r($msme_list);exit;
            if (!empty($msme_list)) {
                $wh = "(tbl_loan_application.channel_partner_id=" . $this->session->userdata('sesuserId') . " or tbl_loan_application.msme_id in(" . $msme_list . "))";
                $this->db->where($wh);
            } else {
                $this->db->where('tbl_loan_application.channel_partner_id', $this->session->userdata('sesuserId'));
            }
            $wh = "(tbl_message_inbox.utype_id=3 or tbl_message_inbox.utype_id =4)";
            $this->db->where($wh);
        } else if ($data["utype_id"] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $users_details = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $wh = "(tbl_message_inbox.utype_id=1 or tbl_message_inbox.utype_id =2)";
            $this->db->where('tbl_message_inbox.post_to', $this->session->userdata('sesuserId'));
        } else {
            $other["tables"] = "TBL_BANK_MASTER";
            $users_details = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $wh = "(tbl_message_inbox.utype_id=1 or tbl_message_inbox.utype_id =2)";
            $this->db->where($wh);
            $this->db->where('tbl_message_inbox.post_to', $this->session->userdata('sesuserId'));
        }
        $sel = 'tbl_message_inbox.application_id,tbl_message_inbox.is_read,tbl_message_inbox.post_to,tbl_loan_application.msme_id,tbl_loan_application.channel_partner_id,tbl_message_inbox.id,tbl_message_inbox.message_id,tbl_message.msg_id,tbl_message_inbox.utype_id,tbl_message_inbox.message,tbl_message_inbox.massage_sent_time,tbl_message_inbox.post_from';
        $this->db->join('tbl_message', 'tbl_message.msg_id=tbl_message_inbox.message_id', 'INNER');
        $this->db->join('tbl_loan_application', 'tbl_loan_application.application_id=tbl_message_inbox.application_id', 'LEFT');
        if ($data["utype_id"] == 4) {
            $this->db->join('tbl_analyst_documents', 'tbl_analyst_documents.application_id=tbl_loan_application.application_id', 'INNER');
        }
        $this->db->order_by('tbl_message_inbox.massage_sent_time', 'DESC');
        $this->db->group_by('tbl_message.msg_id');
        $data['inbox_list'] = $this->admin_model->getRecords('tbl_message_inbox', '', $sel);
        //print_r($data['inbox_list']);exit;
        $this->template->load('manage/main_loan', 'manage/inbox', $data);
    }

    public function sent_query($app_id = NULL) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $id['uid'] = $this->session->userdata('sesuserId');
        $wh["msg_id"] = base64_decode($app_id);
        if ($wh["msg_id"] != '') {
            $table = 'tbl_message_inbox';
            $wheremsg['message_id'] = $wh["msg_id"];
            if ($data["utype_id"] == 3 || $data["utype_id"] == 4) {
                $wheremsg["utype_id IN (1,2)"] = null;
            } else {
                $wheremsg["utype_id IN (3,4)"] = null;
            }
            $msgoptions['is_read'] = 1;
            $this->admin_model->updateUserDetails($table, $msgoptions, $wheremsg);
            if ($data["utype_id"] == 1) {
                $wh["utype_id IN (1,3,4)"] = null;
            }
            $data['sent_list'] = $this->loan_application_model->getMessage('tbl_message_inbox', $wh);
        }
        //print_r($data['sent_list']);exit;

        if ($data['utype_id'] == 1) {
            $other["tables"] = "TBL_MSME";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            $data['username'] = $userdet["user_details"][0]->enterprise_name;
            unset($other["tables"]);
            $option["post_from"] = $userdet["user_details"][0]->uid;
            $data["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 2) {
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $data['username'] = $userdet["user_details"][0]->advisor_name;
            $option["post_from"] = $userdet["user_details"][0]->uid;
            $data["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $data['username'] = $userdet["user_details"][0]->analyst_name;
            $option["post_from"] = $userdet["user_details"][0]->uid;
            $data["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $data['username'] = $userdet["user_details"][0]->bank_name;
            //print_r($userdet["user_details"]); //exit;
            $option["post_from"] = $userdet["user_details"][0]->uid;
            $data["post_from"] = $userdet["user_details"][0]->uid;
        }
        $other['post_to'] = '';
        $data['sent_own_list'] = $this->loan_application_model->getMessage('tbl_message_inbox', $option, $other);
        if ($app_id != "") {
            $this->template->load('manage/main_loan', 'manage/sent_query', $data);
        } else {
            $this->template->load('manage/main_loan', 'manage/user_sent_query', $data);
        }
    }

    public function compose_query() {
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');

        if ($data["utype_id"] == 4) {
            $id['uid'] = $this->session->userdata('sesuserId');
            $other["tables"] = "TBL_BANK_MASTER";
            $bank_details = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_FILTER";
            $bank_filter['bank_id'] = $bank_details[0]->bank_id;
            $bankfilter_details = $this->admin_model->getUserDetails($bank_filter, $other);
            unset($id['uid'], $other["tables"]);
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($bank_filter, $other);
            //echo "Rj";exit;
            //print_r($bankfilter_details);exit;
            $sel = 'tbl_loan_application.application_id,tbl_channel_partner.advisor_name,tbl_msme.enterprise_name,tbl_enterprise_profile.application_id,tbl_enterprise_profile.name_enterprise,tbl_loan_application.status,tbl_enterprise_background.industry_segment,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility';
            $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
            $this->db->join('tbl_msme', 'tbl_msme.uid=tbl_loan_application.msme_id', 'left');
            $this->db->join('tbl_channel_partner', 'tbl_channel_partner.uid=tbl_loan_application.channel_partner_id', 'left');
            $this->db->join('tbl_enterprise_profile', 'tbl_enterprise_profile.application_id=tbl_loan_application.application_id', 'left');
            $this->db->join('tbl_enterprise_background', 'tbl_enterprise_background.application_id=tbl_loan_application.application_id', 'inner');
            if (!empty($bankfilter_details)) {
                if (isset($bankfilter_details[0]->loan_product)) {
                    if ($bankfilter_details[0]->loan_product != 0) {
                        $this->db->where_not_in("tbl_loan_requirement.type_of_facility", $bankfilter_details[0]->loan_product);
                    }
                }

                if (isset($bankfilter_details[0]->industry)) {
                    if ($bankfilter_details[0]->industry != 0) {
                        $this->db->where_not_in("tbl_enterprise_background.industry_segment", $bankfilter_details[0]->industry);
                    }
                }
                if (isset($bankfilter_details[0]->from_year) && isset($bankfilter_details[0]->to_year)) {
                    if ($bankfilter_details[0]->to_year > $bankfilter_details[0]->from_year) {
                        $whs = "tbl_enterprise_background.date_of_establishment BETWEEN '" . $bankfilter_details[0]->from_year . "' AND  '" . $bankfilter_details[0]->to_year . "'";
                        $this->db->where($whs);
                    }
                }
                if (isset($bankfilter_details[0]->min_loan_amt) && isset($bankfilter_details[0]->max_loan_amt)) {
                    if ($bankfilter_details[0]->min_loan_amt > 0 && $bankfilter_details[0]->max_loan_amt > 0) {
                        $wh = "AND ";
                        $wh = "tbl_loan_requirement.Amount BETWEEN '" . $bankfilter_details[0]->min_loan_amt . "' AND  '" . $bankfilter_details[0]->max_loan_amt . "'";
                        $this->db->where($wh);
                    }
                }
                if (!empty($data["bank_application"]) && ($bankfilter_details[0]->loan_product != 0 || $bankfilter_details[0]->industry != 0 || $bankfilter_details[0]->to_year > $bankfilter_details[0]->from_year || $bankfilter_details[0]->min_loan_amt > 0 && $bankfilter_details[0]->max_loan_amt)) {
                    foreach ($data["bank_application"] as $val) {
                        $this->db->or_where("tbl_loan_application.application_id", $val->application_id);
                    }
                }
            }
        } else {
            $sel = 'tbl_loan_application.application_id,tbl_channel_partner.advisor_name,tbl_msme.enterprise_name,tbl_enterprise_profile.application_id,tbl_enterprise_profile.name_enterprise,tbl_loan_application.status,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility';
            $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
            $this->db->join('tbl_msme', 'tbl_msme.uid=tbl_loan_application.msme_id', 'left');
            $this->db->join('tbl_channel_partner', 'tbl_channel_partner.uid=tbl_loan_application.channel_partner_id', 'left');
            $this->db->join('tbl_enterprise_profile', 'tbl_enterprise_profile.application_id=tbl_loan_application.application_id', 'left');
            $this->db->join('tbl_upload_documents', 'tbl_upload_documents.application_id=tbl_loan_application.application_id', 'inner');
        }
        $data['loan_list'] = $this->admin_model->getRecords('tbl_loan_application', '', $sel);

        $this->template->load('manage/main_loan', 'manage/compose_query', $data);
    }

    public function save_compose_query() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $id["uid"] = $this->session->userdata('sesuserId');
        $data["utype_id"] = $this->session->userdata('utype_id');

        if ($_FILES['attachment']['error'] == 0) {
            $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
            $config['allowed_types'] = 'jpg|png|jpeg|JPEG|GIF|JPG|xls|xlsx|doc|docx|pdf|PDF';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;
            $config['upload_path'] = $sPath . 'message';
            $config['x_axis'] = '68';
            $config['y_axis'] = '68';
            $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['attachment']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('attachment')) {
                $error = $this->upload->display_errors();
                $this->session->set_userdata('error_message', $error);
                redirect("manage/dashboard/compose_query/");
            } else {
                $option["attachment"] = date('y-m-d-h-i-s') . $_FILES['attachment']['name'];
            }
            unset($config);
        }
        if ($data['utype_id'] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $option["post_from"] = $this->session->userdata('sesuserId');
        } else {
            $other["tables"] = "TBL_BANK_MASTER";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $option["post_from"] = $this->session->userdata('sesuserId');
        }
        //----------------Manage In Main Thread for Existing Message------------------------------
        $other['limit'] = 1;
        $message_inbox['application_id'] = $this->input->post("application_id");
        $message_inbox['post_from'] = $option["post_from"];
        $message_record = $this->loan_application_model->getMessage('tbl_message_inbox', $message_inbox, $other);
        //print_r($message_record);exit;
        if (!empty($message_record)) {
            $option["message_id"] = $message_record[0]->message_id;
            $option["post_to"] = $message_record[0]->post_to;
            $option["application_id"] = $this->input->post("application_id");
            $option["utype_id"] = $this->session->userdata('utype_id');
            $option["message"] = $this->input->post("message");
            $option["massage_sent_time"] = date('Y-m-d H:i:s');
            $sdata1 = $this->loan_application_model->addCompose_message($option);
        } else {
            //----------------Manage In Main Thread for Existing Message------------------------------
            $opt["status"] = 1;
            $add = $this->loan_application_model->add_message($opt);
            $option["message_id"] = $add;
            $option["application_id"] = $this->input->post("application_id");
            $option["utype_id"] = $this->session->userdata('utype_id');
            $option["message"] = $this->input->post("message");
            $option["massage_sent_time"] = date('Y-m-d H:i:s');
            $wh["application_id"] = $this->input->post("application_id");
            $other["tables"] = "TBL_LOAN_APPLICATION";
            $loan_list = $this->admin_model->getUserDetails($wh, $other);
            //print_r($loan_list);exit;
            unset($other);
            if (!empty($loan_list) && $loan_list[0]->channel_partner_id == 0) {
                $option["post_to"] = $loan_list[0]->msme_id;
            } else {
                $option["post_to"] = $loan_list[0]->channel_partner_id;
            }

            $sdata1 = $this->loan_application_model->addCompose_message($option);
        }
        if ($sdata1) {
            redirect("manage/dashboard/inbox");
        }
    }

    public function save_query() {
        //print_r($_POST); exit;
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $id["uid"] = $this->session->userdata('sesuserId');
        $data["utype_id"] = $this->session->userdata('utype_id');

        if ($_FILES['attachment']['error'] == 0) {
            $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
            $config['allowed_types'] = 'jpg|png|jpeg|JPEG|GIF|JPG|xls|xlsx|doc|docx|pdf|PDF';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;
            $config['upload_path'] = $sPath . 'message';
            $config['x_axis'] = '68';
            $config['y_axis'] = '68';
            $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['attachment']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('attachment')) {
                $error = $this->upload->display_errors();
                $this->session->set_userdata('error_message', $error);
                redirect("manage/dashboard/sent_query" . '/' . base64_encode($this->input->post("message_id")));
            } else {
                $option["attachment"] = date('y-m-d-h-i-s') . $_FILES['attachment']['name'];
            }
            unset($config);
        }
        $option["message_id"] = $this->input->post("message_id");
        $option["application_id"] = $this->input->post("application_id");
        $option["utype_id"] = $this->session->userdata('utype_id');
        $option["message"] = $this->input->post("message");
        $option["massage_sent_time"] = date('Y-m-d H:i:s');
        $option["post_to"] = $this->input->post("post_from");
        if ($data['utype_id'] == 1) {
            $other["tables"] = "TBL_MSME";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $option["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 2) {
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $option["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $option["post_from"] = $userdet["user_details"][0]->uid;
        } else if ($data['utype_id'] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $userdet["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_ENTERPRISE_PROFILE";
            $application_id["application_id"] = $this->input->post("application_id");
            $userdet["user_list"] = $this->admin_model->getUserDetails($application_id, $other);
            //print_r($userdet["user_details"]);
            //print_r($userdet["user_list"]); exit;
            unset($other["tables"]);
            $option["post_from"] = $userdet["user_details"][0]->uid;
        }

        if ($data['utype_id'] == 4) {
            $wh["application_id"] = $this->input->post("application_id");
            $other["tables"] = "TBL_LOAN_APPLICATION";
            $loan_list = $this->admin_model->getUserDetails($wh, $other);
            unset($other);
            if ($loan_list[0]->channel_partner_id == 0) {
                $where["uid"] = $loan_list[0]->msme_id;
                $other["tables"] = "TBL_MSME";
                $data["msme_details"] = $this->admin_model->getUserDetails($where, $other);
                $email_id = $data["msme_details"][0]->owner_email;

                //Start for SMS
                $phone_no = $data["msme_details"][0]->mob_no;

                $text = urlencode('You have received query from ' . $userdet["user_details"][0]->bank_name . '(name of bank) on your loan application #   (' . $this->input->post("application_id") . ' nos). Please  access your myloanassocham account to reply');

                $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                $response = file_get_contents($url);

                //End for SMS
            } else {
                $where["uid"] = $loan_list[0]->channel_partner_id;
                $other["tables"] = "TBL_CHANNEL_PARTNER";
                $data["channel_details"] = $this->admin_model->getUserDetails($where, $other);
                $email_id = $data["channel_details"][0]->advisor_email;

                //Start for SMS
                $phone_no = $data["channel_details"][0]->advisor_mob_no;

                $text = urlencode('You have received query from ' . $userdet["user_details"][0]->bank_name . '(name of bank) on your loan application #   (' . $this->input->post("application_id") . ' nos). Please  access your myloanassocham account to reply');
                $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                $response = file_get_contents($url);

                //End for SMS
            }
            $sdata1 = $this->loan_application_model->addCompose_message($option);
            $app_id = $this->input->post("application_id");
            //start for sending Email......
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'assocham01@gmail.com'; // SMTP username
            $mail->Password = 'om123456';
            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465; // TCP port to connect to
            $mail->FromName = 'MyLoanassocham';
            $mail->addAddress($email_id);
            //$mail->AddAddress($options["email_id"]);                 // Add a recipient
            $mail->WordWrap = 50; // Set word wrap to 50 characters
            $mail->IsHTML(true); // Set email format to HTML
            $mail->SMTPKeepAlive = true; // Set email format to HTML

            $mail->Subject = 'Reply from ' . $userdet["user_details"][0]->bank_name;
            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
				<tr>
					<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
				</tr>
				<tr>
					<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
						<p>Dear ' . $userdet["user_list"][0]->name_enterprise . ',</p>
						<p style="display:block; margin:0; padding-top:10px;">You have received query from ' . $userdet["user_details"][0]->bank_name . ' on your loan application # (' . $app_id . '). Please access your myloanassocham account to reply</p>

						<br/>Sincerely,
						<br/>MyLoanAssocham  Team
					</p>

				</td>
			</tr>
			<tr>
				<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
				<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
			</tr>
		</table>';
            //echo $mail->Body;die();

            if (!$mail->Send()) {
                // $this->session->set_flashdata('notification', 'Please check your email to find new password');
                //echo $mail->Body;die();
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                exit;
            } else {
                //echo $mail->Body;die();
                $this->session->set_userdata('error_message', 1);
                //redirect("manage/dashboard/sent_query".'/'.base64_encode($this->input->post("message_id")));
                redirect("manage/dashboard/inbox");
            }
        } else {

            $sdata1 = $this->loan_application_model->addCompose_message($option);
            if ($sdata1) {
                redirect("manage/dashboard/sent_query" . '/' . base64_encode($this->input->post("message_id")));
            }
        }
    }

    public function bank_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $sel = 'tbl_bank_master.bank_id,tbl_bank_master.bank_name,tbl_bank_master.person_name';
        $data['bank_list'] = $this->admin_model->getRecords('tbl_bank_master', '', $sel);
        //print_r($data['bank_list']);exit;
        $this->template->load('manage/main', 'manage/bank_list', $data);
    }

    public function add_bank() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');

        $this->template->load('manage/main', 'manage/add_bank', $data);
    }

    public function saveBank() {
        //echo "<pre>";print_r($_POST);echo "</pre>";exit;

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');

        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('person_name', 'Person Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
        $this->form_validation->set_rules('mob_no', 'Mobile No', 'trim|required|max_length[10]|numeric|is_unique[tbl_user.mobile_no]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tbl_user.email_id]');
        $this->form_validation->set_rules('branch', 'branch', 'trim|required');
        $this->form_validation->set_rules('landline_no', 'landline_no', 'trim|required|max_length[11]|numeric');
        $this->form_validation->set_rules('password', 'Select Password', 'trim|required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');

        $this->form_validation->set_rules('nodal_person_name', 'Nodal Person Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('nodal_designation', 'Nodal Designation', 'trim|required');
        $this->form_validation->set_rules('nodal_mob_no', 'Nodal Mobile No', 'trim|required|max_length[10]|numeric');
        $this->form_validation->set_rules('nodal_email', 'Nodal Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('nodal_branch', 'Nodal Branch', 'trim|required');

        $this->form_validation->set_rules('emp_person_name[0]', 'Second Point Person Name', 'trim|required|max_length[50]|alpha|xss_clean');
        $this->form_validation->set_rules('emp_designation[0]', 'Second Point Designation', 'trim|required||xss_clean');
        $this->form_validation->set_rules('emp_mob_no[0]', 'Second Point Mobile No', 'trim|required|max_length[10]|numeric|xss_clean');
        $this->form_validation->set_rules('emp_email[0]', 'Second Point Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('emp_branch[0]', 'Second Point Branch', 'trim|required|');

        $this->form_validation->set_rules('emp_person_name[1]', 'Third Point Person Name', 'trim|required|max_length[50]|alpha|xss_clean');
        $this->form_validation->set_rules('emp_designation[1]', 'Third Point Designation', 'trim|required||xss_clean');
        $this->form_validation->set_rules('emp_mob_no[1]', 'Third Point Mobile No', 'trim|required|max_length[10]|numeric|xss_clean');
        $this->form_validation->set_rules('emp_email[1]', 'Third Point Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('emp_branch[1]', 'Third Point Branch', 'trim|required|');

        //print_r($_REQUEST);exit;
        if ($this->form_validation->run()) {
            $option["name"] = $this->input->post("bank_name");
            $option["email_id"] = $this->input->post("email");
            $option["password"] = $this->user_model->_prep_password($this->input->post("password"));
            $option["mobile_no"] = $this->input->post("mob_no");
            $option["utype_id"] = 4;
            $option["status"] = 1;
            $option["created_dtm"] = date('Y-m-d H:i:s');

            //Start email verification code
            $code = '0123456789abcdefghijklmnopqrst';
            $code_length = 15;
            $char_length = strlen($code);
            $random_str = '';
            for ($i = 0; $i < $code_length; $i++) {
                $random_str .= $code[rand(0, $char_length - 1)];
            }
            $email_verification_code = $random_str;
            //End email verification code
            $option["email_verification_code"] = $email_verification_code;

            $sdata1 = $this->user_model->addUser($option);

            $opt["uid"] = $sdata1;
            $opt["bank_name"] = $this->input->post("bank_name");
            $opt["person_name"] = $this->input->post("person_name");
            $opt["email"] = $this->input->post("email");
            $opt["mob_no"] = $this->input->post("mob_no");
            $opt["branch"] = $this->input->post("branch");
            $opt["landline_no"] = $this->input->post("landline_no");
            $opt["designation"] = $this->input->post("designation");
            $opt["created_dtm"] = date('Y-m-d H:i:s');
            $opt["status"] = 1;
            //-----------for Nodal officer contact details-------//
            $opt["nodal_person_name"] = $this->input->post("nodal_person_name");
            $opt["nodal_email"] = $this->input->post("nodal_email");
            $opt["nodal_mob_no"] = $this->input->post("nodal_mob_no");
            $opt["nodal_branch"] = $this->input->post("nodal_branch");
            $opt["nodal_designation"] = $this->input->post("nodal_designation");
            $sdata = $this->bank_model->addBank($opt);

            $empopt["bank_id"] = $sdata;
            $person_name = $this->input->post("emp_person_name");
            $email = $this->input->post("emp_email");
            $mob_no = $this->input->post("emp_mob_no");
            $branch = $this->input->post("emp_branch");
            $designation = $this->input->post("emp_designation");

            $person_name = array_values(array_filter($person_name));
            $email = array_values(array_filter($email));
            $mob_no = array_values(array_filter($mob_no));
            $branch = array_values(array_filter($branch));
            $designation = array_values(array_filter($designation));

            $i = 0;
            $j = 2;
            foreach ($person_name as $k => $row) {
                $data1['person_name'] = $person_name[$i];
                $data1['email'] = $email[$i];
                $data1['mob_no'] = $mob_no[$i];
                $data1['branch'] = $branch[$i];
                $data1['designation'] = $designation[$i];
                $data1['bank_id'] = $sdata;
                $data1["uid"] = $sdata1;
                $data1["created_dtm"] = date('Y-m-d H:i:s');
                $data1["escalation"] = $j;
                $add = $this->db->insert(TBL_BANK_EMPLOYEE, $data1);
                $i++;
                $j++;
            }
            if ($add) {
                $where_email["u.email_id"] = $option["email_id"];
                $get_code = $this->user_model->get_verification_code($where_email);
                //print_r($get_code); exit;
                $ver_code = $get_code[0]->email_verification_code;
                $this->sendVerificatinEmail($option["email_id"], $ver_code, $this->input->post("password"));

                //echo "<script>parent.refress();parent.closeFB();</script>";
                $this->session->set_userdata('error_message', 1);
                //$this->template->load('manage/main','loan_application/enterprise_profile',$data);
                redirect("manage/dashboard/add_bank");
            } else {
                $data["error"] = "Error in Bank Add";
                $this->load->view("manage/dashboard/add_bank", $data);
            }
        } else {
            //$this->load->view("manage/dashboard/add_bank");
            $this->template->load('manage/main', 'manage/add_bank', $data);
        }
    }

    public function analyst_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $sel = 'id,analyst_name,analyst_email';
        $data['analyst_list'] = $this->admin_model->getRecords('tbl_analyst', '', $sel);

        $this->template->load('manage/main', 'manage/analyst_list', $data);
    }

    public function add_analyst() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');

        $this->template->load('manage/main', 'manage/add_analyst', $data);
    }

    public function saveAnalyst() {
        //print_r($_POST); exit;
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');

        $this->form_validation->set_rules('analyst_name', 'Analyst Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('analyst_mob_no', 'Analyst Mobile Number', 'trim|required|max_length[10]|numeric|is_unique[tbl_user.mobile_no]');
        $this->form_validation->set_rules('analyst_email', 'Analyst Email Id', 'trim|required|valid_email|is_unique[tbl_user.email_id]');
        $this->form_validation->set_rules('password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run()) {
            $option["name"] = $this->input->post("analyst_name");
            $option["email_id"] = $this->input->post("analyst_email");
            $option["password"] = $this->user_model->_prep_password($this->input->post("password"));
            $option["mobile_no"] = $this->input->post("analyst_mob_no");
            $option["utype_id"] = 3;
            $option["status"] = 0;
            $option["created_dtm"] = date('Y-m-d H:i:s');

            //Start email verification code
            $code = '0123456789abcdefghijklmnopqrst';
            $code_length = 15;
            $char_length = strlen($code);
            $random_str = '';
            for ($i = 0; $i < $code_length; $i++) {
                $random_str .= $code[rand(0, $char_length - 1)];
            }
            $email_verification_code = $random_str;
            //End email verification code
            $option["email_verification_code"] = $email_verification_code;

            $sdata1 = $this->user_model->addUser($option);

            $opt["uid"] = $sdata1;
            $opt["analyst_name"] = $this->input->post("analyst_name");
            $opt["analyst_email"] = $this->input->post("analyst_email");
            $opt["analyst_mob_no"] = $this->input->post("analyst_mob_no");

            $sdata = $this->analyst_model->addAnalyst($opt);

            if ($sdata) {
                $where_email["u.email_id"] = $option["email_id"];
                $get_code = $this->user_model->get_verification_code($where_email);
                //print_r($get_code); exit;
                $ver_code = $get_code[0]->email_verification_code;
                $this->sendVerificatinEmail($option["email_id"], $ver_code, $this->input->post("password"));
                //echo "<script>parent.refress();parent.closeFB();</script>";
                $this->session->set_userdata('error_message', 1);
                //$this->template->load('manage/main','loan_application/enterprise_profile',$data);
                redirect("manage/dashboard/add_analyst");
            } else {
                $data["error"] = "Error in Analyst add";
                //$this->load->view("analyst/manage/add_analyst",$data);
                $this->template->load('manage/main', 'manage/add_analyst', $data);
            }
        } else {
            //$this->load->view("analyst/manage/add_analyst");
            $this->template->load('manage/main', 'manage/add_analyst', $data);
        }
    }

    public function channel_partner_msme_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $id['uid'] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $sel = 'tbl_msme.id as msmeid,tbl_msme.enterprise_name,tbl_msme.owner_name,tbl_msme.constitution';
        $this->db->where('tbl_msme.channel_partner_id', $this->session->userdata('sesuserId'));
        $data['msme_list'] = $this->admin_model->getRecords('tbl_msme', '', $sel);
        $this->template->load('manage/main', 'manage/channel_partner_msme_list', $data);
    }

    public function add_msme() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main', 'manage/add_msme', $data);
    }

    public function save_msme() {

        //print_r($_POST); exit;
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $data["utype_id"] = $this->session->userdata('utype_id');

        $this->form_validation->set_rules('enterprise_name', 'Enterprise Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('constitution', ' Legal Entity', 'trim|required');
        $this->form_validation->set_rules('owner_name', 'Director Name', 'trim|required|max_length[50]|alpha');
        $this->form_validation->set_rules('owner_email', 'Owner email ID', 'trim|required|valid_email|is_unique[tbl_user.email_id]');
        $this->form_validation->set_rules('mob_no', 'Mobile No', 'trim|required|max_length[10]|numeric|is_unique[tbl_user.mobile_no]');
        $this->form_validation->set_rules('pan_firm', 'PAN of Firm', 'trim|required|max_length[10]|is_unique[tbl_msme.pan_firm]');
        $this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required|max_length[500]');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[6]');
        $this->form_validation->set_rules('latest_audited_turnover', 'Latest Audited Turnover', 'trim|required|max_length[11]');
        //$this->form_validation->set_rules('password','Select Password','trim|required');
        //$this->form_validation->set_rules('con_password','Confirm Password','trim|required|matches[password]');

        if ($this->form_validation->run()) {
            $id["uid"] = $this->session->userdata('sesuserId');
            $Details = $this->admin_model->getUsers($id);
            //$data["name"]=$Details[0]->name;
            $option["name"] = $this->input->post("owner_name");
            $option["email_id"] = $this->input->post("owner_email");
            $option["password"] = $this->user_model->_prep_password(date('Y-m-d H:i:s') . 'admin');
            $option["mobile_no"] = $this->input->post("mob_no");
            $option["utype_id"] = 1;
            $option["status"] = 2;
            $option["created_dtm"] = date('Y-m-d H:i:s');

            $sdata1 = $this->user_model->addUser($option);

            $opt["uid"] = $sdata1;
            if ($data["utype_id"] == 2) {
                $other["tables"] = "TBL_CHANNEL_PARTNER";
                $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                $opt["channel_partner_id"] = $data["user_details"][0]->uid;
            }
            $opt["enterprise_name"] = $this->input->post("enterprise_name");
            $opt["constitution"] = $this->input->post("constitution");
            //$opt["category"] = $this->input->post("category");
            $opt["owner_name"] = $this->input->post("owner_name");
            $opt["owner_email"] = $this->input->post("owner_email");
            $opt["mob_no"] = $this->input->post("mob_no");
            $opt["pan_firm"] = $this->input->post("pan_firm");
            $opt["address1"] = $this->input->post("address1");
            $opt["address2"] = $this->input->post("address2");
            $opt["state"] = $this->input->post("state");
            $opt["city"] = $this->input->post("city");
            $opt["pincode"] = $this->input->post("pincode");
            $opt["landline_no"] = $this->input->post("landline_no");
            $opt["latest_audited_turnover"] = str_replace(",", "", $this->input->post("latest_audited_turnover"));
            $opt["created_dtm"] = date('Y-m-d H:i:s');

            $sdata = $this->user_model->addMSME($opt);
            //$data["msg"] ="sdfsadfsadfsda";
            if ($sdata) {
                redirect("manage/dashboard/channel_partner_msme_list", $data);
            }
        } else {
            $data["state"] = $this->user_model->fetch_state();
            $this->template->load('manage/main', 'manage/add_msme', $data);
        }
    }

    public function delete_user($user_type = NULL, $id = NULL) {
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $data["utype_id"] = $this->session->userdata('utype_id');
        $ids["uid"] = $this->session->userdata('sesuserId');
        $Details = $this->admin_model->getUsers($ids);

        $data['user_type'] = base64_decode($user_type);
        //echo base64_decode($id);exit;
        if ($data["user_type"] == 1) {
            $other["tables"] = "TBL_MSME";
            $msme['id'] = base64_decode($id);
            $data["user_details"] = $this->admin_model->getUserDetails($msme, $other);
            $delte = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);

            $other["tables"] = "TBL_USER";
            $uid = $data["user_details"][0]->uid;
            $userdelte = $this->admin_model->delete($uid, $other);
            if ($userdelte) {
                redirect('manage/dashboard/msme_list');
            }
        } else if ($data["user_type"] == 2) {
            $channel['id'] = base64_decode($id);
            $other["tables"] = "TBL_MSME";
            $data["user_details"] = $this->admin_model->getUserDetails($channel, $other);
            $delte = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_USER";
            $uid = $data["user_details"][0]->uid;
            $userdelte = $this->admin_model->delete($uid, $other);
            if ($userdelte) {
                redirect('manage/dashboard/channel_partner_msme_list');
            }
        } else if ($data["user_type"] == 22) {
            $channel['id'] = base64_decode($id);
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $data["user_details"] = $this->admin_model->getUserDetails($channel, $other);
            $delte = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_USER";
            $uid = $data["user_details"][0]->uid;
            $userdelte = $this->admin_model->delete($uid, $other);
            if ($userdelte) {
                redirect('manage/dashboard/channel_partner_list');
            }
        } else if ($data["user_type"] == 3) {
            $analyst['id'] = base64_decode($id);
            $other["tables"] = "TBL_ANALYST";
            $data["user_details"] = $this->admin_model->getUserDetails($analyst, $other);
            $delte = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_USER";
            $uid = $data["user_details"][0]->uid;
            $userdelte = $this->admin_model->delete($uid, $other);
            if ($userdelte) {
                redirect('manage/dashboard/analyst_list');
            }
        } else if ($data["user_type"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $bank['bank_id'] = base64_decode($id);
            $data["bank_details"] = $this->admin_model->getUserDetails($bank, $other);
            $deltebank = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_EMPLOYEE";
            $options["usr.bank_id"] = $bank['bank_id'];
            $data["emp_details"] = $this->admin_model->getUserDetails($options, $other);
            $delteemp = $this->admin_model->delete(base64_decode($id), $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_USER";
            $uid = $data["bank_details"][0]->uid;
            $userdelte = $this->admin_model->delete($uid, $other);
            if ($userdelte) {
                redirect('manage/dashboard/bank_list');
            }
        } else {
            $application['application_id'] = base64_decode($id);
            $table = 'tbl_loan_application';
            $msgoptions['status'] = 3;
            $updt = $this->admin_model->updateUserDetails($table, $msgoptions, $application);
            if ($updt) {
                redirect('manage/dashboard/loan_application_list');
            }
        }
    }

    public function edit_users($user_type = NULL, $id = NULL) {
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $data["utype_id"] = $this->session->userdata('utype_id');
        $ids["uid"] = $this->session->userdata('sesuserId');
        $Details = $this->admin_model->getUsers($ids);
        $data["state"] = $this->user_model->fetch_state();

        $data['user_type'] = base64_decode($user_type);
        //echo base64_decode($id);exit;
        if ($data["user_type"] == 1) {
            $other["tables"] = "TBL_MSME";
            $msme['id'] = base64_decode($id);
            $data["user_details"] = $this->admin_model->getUserDetails($msme, $other);
            $op["c.id"] = $data["user_details"][0]->city;
            $data['msmeid'] = $msme['id'];
            $data["city"] = $this->user_model->fetch_city_name($op);
            unset($other["tables"]);
            //echo "<pre>"; print_r($data); exit;
            $this->template->load('manage/main', 'manage/edit_msme', $data);
        } else if ($data["user_type"] == 2) {
            $channel['id'] = base64_decode($id);
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $data["user_details"] = $this->admin_model->getUserDetails($channel, $other);
            $data['channel_id'] = $channel['id'];
            unset($other["tables"]);
            $this->template->load('manage/main', 'manage/edit_channel_partner', $data);
        } else if ($data["user_type"] == 3) {
            $analyst['id'] = base64_decode($id);
            $other["tables"] = "TBL_ANALYST";
            $data['analyst_id'] = $analyst['id'];
            $data["user_details"] = $this->admin_model->getUserDetails($analyst, $other);
            unset($other["tables"]);
            //print_r($data); exit;
            $this->template->load('manage/main', 'manage/edit_analyst', $data);
        } else if ($data["user_type"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $bank['bank_id'] = base64_decode($id);
            $data["bank_details"] = $this->admin_model->getUserDetails($bank, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_EMPLOYEE";
            $options["usr.bank_id"] = $bank['bank_id'];
            $data["emp_details"] = $this->admin_model->getUserDetails($options, $other);
            unset($other["tables"]);
            $this->template->load('manage/main_filter', 'manage/edit_bank', $data);
        } else {
            unset($data["state"], $data["city"]);
            $other["tables"] = "TBL_ADMIN";
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            //print_r($data); exit;
            $this->template->load('manage/main', "manage/admin_details", $data);
        }
    }

    public function Update_userdetails() {
        //print_r($_POST); exit;
        $data["utype_id"] = $this->session->userdata('utype_id');
        $id["uid"] = $this->session->userdata('sesuserId');
        $bank_uid["uid"] = $this->input->post("uid");

        $Details = $this->admin_model->getUsers($id);
        $data["name"] = $Details[0]->name;
        $data["state"] = $this->user_model->fetch_state();
        $data["city"] = $this->user_model->fetch_city_name();
        if ($this->input->post("user_type") == 1) {
            $table = "tbl_msme";
            $options["enterprise_name"] = $this->input->post("enterprise_name");
            $options["owner_name"] = $this->input->post("owner_name");
            $options["constitution"] = $this->input->post("constitution");
            //$options["category"]    =     $this->input->post("category");
            $options["pan_firm"] = $this->input->post("pan_firm");
            $options["owner_email"] = $this->input->post("owner_email");
            $options["address1"] = $this->input->post("address1");
            $options["address2"] = $this->input->post("address2");
            $options["state"] = $this->input->post("state");
            $options["city"] = $this->input->post("city");
            $options["pincode"] = $this->input->post("pincode");
            $options["mob_no"] = $this->input->post("mob_no");
            $options["landline_no"] = $this->input->post("landline_no");
            $where['id'] = $this->input->post("id");
            $options["latest_audited_turnover"] = str_replace(",", "", $this->input->post("latest_audited_turnover"));
            $this->admin_model->updateUserDetails($table, $options, $where);
            unset($options, $table, $where);
            if ($data["utype_id"] == 2) {
                redirect("manage/dashboard/channel_partner_msme_list");
            } else {
                redirect("manage/dashboard/msme_list");
            }
        }

        if ($this->input->post("user_type") == 2) {
            $table = "tbl_channel_partner";
            $options["advisor_name"] = $this->input->post("advisor_name");
            $options["advisor_mob_no"] = $this->input->post("advisor_mob_no");
            $options["advisor_email"] = $this->input->post("advisor_email");
            $options["advisor_pan"] = $this->input->post("advisor_pan");
            $where['id'] = $this->input->post("id");
            $this->admin_model->updateUserDetails($table, $options, $where);
            unset($options, $table, $where);
            redirect("manage/dashboard/channel_partner_list");
        }

        if ($this->input->post("user_type") == 3) {
            $table = "tbl_analyst";
            $options["analyst_name"] = $this->input->post("analyst_name");
            $options["analyst_mob_no"] = $this->input->post("analyst_mob_no");
            $options["analyst_email"] = $this->input->post("analyst_email");
            $where['id'] = $this->input->post("id");
            $this->admin_model->updateUserDetails($table, $options, $where);
            unset($options, $table, $where);
            redirect("manage/dashboard/analyst_list");
        }

        if ($this->input->post("user_type") == 4) {
            $opt["bank_name"] = $this->input->post("bank_name");
            $opt["person_name"] = $this->input->post("person_name");
            $opt["email"] = $this->input->post("email");
            $opt["mob_no"] = $this->input->post("mob_no");
            $opt["branch"] = $this->input->post("branch");
            $opt["landline_no"] = $this->input->post("landline_no");
            $opt["designation"] = $this->input->post("designation");
            $opt["updated_dtm"] = date('Y-m-d H:i:s');
            $opt["status"] = 1;

            //for Nodal officer contact details
            $opt["nodal_person_name"] = $this->input->post("nodal_person_name");
            $opt["nodal_email"] = $this->input->post("nodal_email");
            $opt["nodal_mob_no"] = $this->input->post("nodal_mob_no");
            $opt["nodal_branch"] = $this->input->post("nodal_branch");
            $opt["nodal_designation"] = $this->input->post("nodal_designation");

            $wherebank['bank_id'] = $this->input->post("id");
            $table = "tbl_bank_master";
            $sdata = $this->admin_model->updateUserDetails($table, $opt, $wherebank);

            $other_tbl["tables"] = "TBL_BANK_MASTER";
            $op_data["bank_details"] = $this->admin_model->getUserDetails($bank_uid, $other_tbl);
            unset($other_tbl["tables"]);

            if ($this->input->post("password") != "") {
                $opt_user["password"] = $this->user_model->_prep_password($this->input->post("password"));
                $opt_user["email_id"] = $this->input->post("email");
                $opt_user["mobile_no"] = $this->input->post("mob_no");
                $whereuser['uid'] = $op_data["bank_details"][0]->uid;
                $sdata1 = $this->user_model->update_pass($opt_user, $whereuser);
            }

            $person_name = $this->input->post("emp_person_name");
            $email = $this->input->post("emp_email");
            $mob_no = $this->input->post("emp_mob_no");
            $branch = $this->input->post("emp_branch");
            $designation = $this->input->post("emp_designation");
            $emp_id = $this->input->post("emp_id");

            $person_name = array_values(array_filter($person_name));
            $email = array_values(array_filter($email));
            $mob_no = array_values(array_filter($mob_no));
            $branch = array_values(array_filter($branch));
            $designation = array_values(array_filter($designation));
            $emp_id = array_values(array_filter($emp_id));

            $i = 0;
            foreach ($person_name as $k => $row) {
                $empdata['person_name'] = $person_name[$i];
                $empdata['email'] = $email[$i];
                $empdata['mob_no'] = $mob_no[$i];
                $empdata['branch'] = $branch[$i];
                $empdata['designation'] = $designation[$i];
                $empdata['updated_dtm'] = date('Y-m-d H:i:s');
                $whereemp['id'] = $emp_id[$i];
                $table = "tbl_bank_employee";
                $sdata = $this->admin_model->updateUserDetails($table, $empdata, $whereemp);
                $i++;
            }

            redirect("manage/dashboard/bank_list");
        }

        if ($this->input->post("user_type") == 5) {
            $table = "tbl_admin";
            $options["person_name"] = $this->input->post("person_name");
            $options["designation"] = $this->input->post("designation");
            $options["mobile_no"] = $this->input->post("mobile_no");
            $options["email_id"] = $this->input->post("email_id");
            $options["branch"] = $this->input->post("branch");

            $this->admin_model->updateUserDetails($table, $options, $id);
            unset($options, $table);
            redirect("manage/dashboard");
        }
        //echo "<pre>"; print_r($data); exit;
        //$this->template->load('manage/main',"manage/msme_details",$data);
    }

    public function channel_partner_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $sel = 'id,advisor_name,advisor_email,';
        $data['channel_list'] = $this->admin_model->getRecords('tbl_channel_partner', '', $sel);
        $this->template->load('manage/main', 'manage/channel_partner_list', $data);
    }

    public function msme_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $sel = 'tbl_msme.id as msmeid,tbl_msme.enterprise_name,tbl_msme.channel_partner_id,tbl_channel_partner.advisor_name';
        $this->db->join('tbl_channel_partner', 'tbl_channel_partner.uid=tbl_msme.channel_partner_id', 'left');
        $data['msme_list'] = $this->admin_model->getRecords('tbl_msme', '', $sel);
        $this->template->load('manage/main', 'manage/msme_list', $data);
    }

    public function loan_application_list() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        if ($data["utype_id"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $bank['uid'] = $this->session->userdata('sesuserId');
            $bank_details = $this->admin_model->getUserDetails($bank, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_FILTER";
            $bank_filter['bank_id'] = $bank_details[0]->bank_id;
            $bankfilter_details = $this->admin_model->getUserDetails($bank_filter, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($bank_filter, $other);
            //echo "Rj";exit;
            //print_r($data["bank_application"]);exit;
            $sel = 'tbl_loan_application.application_id,tbl_enterprise_background.industry_segment,tbl_loan_requirement.Amount,tbl_enterprise_background.date_of_establishment,tbl_loan_application.status,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility,tbl_msme.enterprise_name,tbl_channel_partner.advisor_name';
            //$this->db->join('tbl_analyst_documents', 'tbl_analyst_documents.application_id=tbl_loan_application.application_id','inner');
            $this->db->join('tbl_upload_documents', 'tbl_upload_documents.application_id=tbl_loan_application.application_id', 'INNER');
            $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
            $this->db->join('tbl_enterprise_background', 'tbl_enterprise_background.application_id=tbl_loan_application.application_id', 'left');
            if (!empty($bankfilter_details)) {
                if (isset($bankfilter_details[0]->loan_product)) {
                    if ($bankfilter_details[0]->loan_product != 0) {
                        $loan_product = explode(",", $bankfilter_details[0]->loan_product);
                        $this->db->where_not_in("tbl_loan_requirement.type_of_facility", $loan_product);
                    }
                }
                if (isset($bankfilter_details[0]->industry)) {
                    if ($bankfilter_details[0]->industry != 0) {
                        $industry = explode(",", $bankfilter_details[0]->industry);
                        $this->db->where_not_in("tbl_enterprise_background.industry_segment", $industry);
                    }
                }

                if (isset($bankfilter_details[0]->from_year) && isset($bankfilter_details[0]->to_year)) {
                    if ($bankfilter_details[0]->to_year > $bankfilter_details[0]->from_year) {
                        $whs = "tbl_enterprise_background.date_of_establishment BETWEEN '" . date('Y-m-d', strtotime($bankfilter_details[0]->from_year)) . "' AND  '" . date('Y-m-d', strtotime($bankfilter_details[0]->to_year)) . "'";
                        $this->db->where($whs);
                    }
                }
                if (isset($bankfilter_details[0]->min_loan_amt) && isset($bankfilter_details[0]->max_loan_amt)) {
                    if ($bankfilter_details[0]->min_loan_amt > 0 && $bankfilter_details[0]->max_loan_amt > 0) {
                        $wh = "AND ";
                        $wh = "tbl_loan_requirement.Amount BETWEEN '" . str_replace(",", "", $bankfilter_details[0]->min_loan_amt) . "' AND  '" . str_replace(",", "", $bankfilter_details[0]->max_loan_amt) . "'";
                        $this->db->where($wh);
                    }
                }
                if (!empty($data["bank_application"]) && ($bankfilter_details[0]->loan_product != 0 || $bankfilter_details[0]->industry != 0 || $bankfilter_details[0]->to_year > $bankfilter_details[0]->from_year || $bankfilter_details[0]->min_loan_amt > 0 && $bankfilter_details[0]->max_loan_amt)) {
                    foreach ($data["bank_application"] as $val) {
                        $this->db->or_where("tbl_loan_application.application_id", $val->application_id);
                    }
                }
            }
        } else {
            //echo "singh";exit;
            $sel = 'tbl_loan_application.application_id,tbl_loan_application.status,tbl_loan_application.created_dtm,tbl_loan_requirement.type_of_facility,tbl_msme.enterprise_name,tbl_channel_partner.advisor_name';
            $this->db->join('tbl_loan_requirement', 'tbl_loan_requirement.application_id=tbl_loan_application.application_id', 'left');
        }
        $this->db->join('tbl_msme', 'tbl_msme.uid=tbl_loan_application.msme_id', 'left');
        $this->db->join('tbl_channel_partner', 'tbl_channel_partner.uid=tbl_loan_application.channel_partner_id', 'left');
        $this->db->where_not_in("tbl_loan_application.status", '3');
        $this->db->order_by('tbl_loan_application.application_id', 'DESC');
        $data['loan_list'] = $this->admin_model->getRecords('tbl_loan_application', '', $sel);
        //print_r($data['loan_list']);
        $this->template->load('manage/main', 'manage/loan_application_list', $data);
    }

    public function bank_application_status($application_id = NULL) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        $application_id = base64_decode($application_id);

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect("manage/dashboard/analyst_documents/" . base64_encode($application_id));
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_BANK_APPLICATION";
            if ($data["utype_id"] == 4) {
                $other["tables"] = "TBL_BANK_MASTER";
                $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                //print_r($data["bank_details"]);exit;
                $whereapplication['application_id'] = $application_id;
                $whereapplication['bank_id'] = $data["bank_details"][0]->bank_id;
            } else {
                $whereapplication['application_id'] = $application_id;
            }
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //print_r($data["bank_application"]);exit;
            unset($other["tables"], $whereapplication['bank_id']);
            $other["tables"] = "TBL_ANALYST_DOCUMENTS";
            $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (empty($data["analyst_documents"])) {
                redirect("manage/dashboard/analyst_documents/" . base64_encode($application_id));
                //----------------End-------------------
            }
        }

        $this->template->load('manage/main_loan', 'manage/bank_application_status', $data);
    }

    public function save_bank_status() {

        //echo "<pre>";print_r($_POST); exit;
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($data["utype_id"] == 5) {
            redirect("manage/dashboard/loan_application_list");
        }
        //---------end user type checking for view mode---------
        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;

        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
            $this->form_validation->set_rules('branch_details', 'Branch Details', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('preson_name', 'Person to Contact', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('person_mobile_no', 'Person Mobile No.', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('email_id', 'Person Email ID', 'trim|required|valid_email');

            if ($this->form_validation->run()) {
                $other["tables"] = "TBL_BANK_MASTER";
                $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);

                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $application_id["application_id"] = $this->input->post("application_id");
                $userdet["user_list"] = $this->admin_model->getUserDetails($application_id, $other);
                //print_r($userdet["user_details"]);
                //print_r($userdet["user_list"]); exit;
                unset($other["tables"]);

                $application_id = $this->input->post("application_id");

                $opt['application_id'] = $application_id;
                $opt['bank_id'] = $data["bank_details"][0]->bank_id;
                $opt["comment"] = $this->input->post("comment");
                $opt["branch_details"] = $this->input->post("branch_details");
                $opt["status"] = $this->input->post("status");
                $opt["preson_name"] = $this->input->post("preson_name");
                $opt["person_mobile_no"] = $this->input->post("person_mobile_no");
                $opt["email_id"] = $this->input->post("email_id");

                $add = $this->loan_application_model->addBank_status($opt);
                if ($add) {
                    if ($opt["status"] == 1) {
                        $stat = "approved";
                    } else {
                        $stat = "Rejected";
                    }
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true; // Enable SMTP authentication
                    $mail->Username = 'assocham01@gmail.com'; // SMTP username
                    $mail->Password = 'om123456';
                    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465; // TCP port to connect to
                    $mail->FromName = 'MyLoanassocham';

                    //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                    $mail->WordWrap = 50; // Set word wrap to 50 characters
                    $mail->IsHTML(true); // Set email format to HTML
                    $mail->SMTPKeepAlive = true; // Set email format to HTML

                    $wh["application_id"] = $this->input->post("application_id");
                    $other["tables"] = "TBL_LOAN_APPLICATION";
                    $loan_list = $this->admin_model->getUserDetails($wh, $other);
                    unset($other);

                    if ($loan_list[0]->channel_partner_id == 0) {
                        $where["uid"] = $loan_list[0]->msme_id;
                        $other["tables"] = "TBL_MSME";
                        $data["msme_details"] = $this->admin_model->getUserDetails($where, $other);
                        //print_r($data["user_details"]); exit;
                        $mail->addAddress($data["msme_details"][0]->owner_email);
                        $mail->Subject = 'Loan application #' . $application_id . ' status' . ' ' . $stat;
                        if ($opt["status"] == 1) {
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
								<tr>
									<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
								</tr>
								<tr>
									<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
										<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>

										<p>Congratulations, your loan application  #' . $application_id . ' has been in principle ' . $stat . ' by ' . $data["bank_details"][0]->bank_name . ' (name of bank).  The detailed terms of approval will be sent to you shortly  please access your myloanassocham account or your registered email to get further details.</p>

										<br/>Sincerely,
										<br/>MyLoanAssocham  Team


									</td>
								</tr>
								<tr>
									<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
									<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
								</tr>
							</table>';
                        } else {

                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
							<tr>
								<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
							</tr>
							<tr>
								<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
									<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>
									<p>We regret to inform you that after careful consideration your loan application  #' . $application_id . ' was not found suitable for further processing . Kindly contact our representatives for any further clarifications</p>

									<br/>Sincerely,
									<br/>MyLoanAssocham  Team


								</td>
							</tr>
							<tr>
								<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
								<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
							</tr>
						</table>';
                        }
                        //echo $mail->Body;die();
                        //Start for SMS
                        $phone_no = $data["msme_details"][0]->mob_no;

                        if ($opt["status"] == 1) {
                            $text = urlencode('Congratulations, your loan application # (' . $application_id . ') has been in principle ' . $stat . ' by (' . $data["bank_details"][0]->bank_name . '). The detailed terms of approval will be sent to you shortly pl access your myloanassocham account or your registered email to get further details');
                        } else {

                            $text = urlencode('We regret to inform you that after careful consideration your loan application # (' . $application_id . ') was not found suitable for further processing . Kindly contact our representatives for any further clarifications');
                        }
                        $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                        $response = file_get_contents($url);

                        //End for SMS
                    } else {
                        /* $where["uid"] = $loan_list[0]->channel_partner_id;
                        $other["tables"]="TBL_CHANNEL_PARTNER";
                        $data["channel_details"]=$this->admin_model->getUserDetails($where,$other); */

                        if (isset($loan_list[0]->channel_partner_id) && $loan_list[0]->channel_partner_id != 0) {
                            $op["uid"] = $loan_list[0]->channel_partner_id;
                            $other["tables"] = "TBL_CHANNEL_PARTNER";
                            $data["channel_details"] = $this->admin_model->getUserDetails($op, $other);
                            $phone_no = $data["channel_details"][0]->advisor_mob_no;

                            $mail->addAddress($data["channel_details"][0]->advisor_email);
                            $mail->Subject = 'Loan application #' . $wh["application_id"] . ' status' . ' ' . $stat;
                            if ($opt["status"] == 1) {
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
								<tr>
									<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
								</tr>
								<tr>
									<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
										<p>Dear ' . $data["channel_details"][0]->advisor_name . '</p>

										<p>Congratulations, your loan application  #' . $application_id . ' has been in principle ' . $stat . ' by ' . $data["bank_details"][0]->bank_name . '.  The detailed terms of approval will be sent to you shortly  pl access your myloanassocham account or your registered email to get further details.</p>

										<br/>Sincerely,
										<br/>MyLoanAssocham  Team


									</td>
								</tr>
								<tr>
									<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
									<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
								</tr>
							</table>';
                                //echo $mail->Body;die();
                            } else {
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
							<tr>
								<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
							</tr>
							<tr>
								<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
									<p>Dear ' . $data["channel_details"][0]->advisor_name . '</p>
									<p>We regret to inform you that after careful consideration your loan application  #' . $application_id . ' was not found suitable for further processing . Kindly contact our representatives for any further clarifications</p>

									<br/>Sincerely,
									<br/>MyLoanAssocham  Team


								</td>
							</tr>
							<tr>
								<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
								<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
							</tr>
						</table>';
                            }
                        } else {
                            $op["uid"] = $loan_list[0]->msme_id;
                            $other["tables"] = "TBL_MSME";
                            $data["enterprise_profile"] = $this->admin_model->getUserDetails($op, $other);
                            $phone_no = $data["msme_details"][0]->mob_no;
                            unset($other);

                            $mail->addAddress($data["msme_details"][0]->owner_email);
                            $mail->Subject = 'Loan application #' . $wh["application_id"] . ' status' . ' ' . $stat;
                            if ($opt["status"] == 1) {
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>

								<p>Congratulations, your loan application  #' . $application_id . ' has been in principle ' . $stat . ' by ' . $data["bank_details"][0]->bank_name . '.  The detailed terms of approval will be sent to you shortly  pl access your myloanassocham account or your registered email to get further details.</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team


							</td>
						</tr>
						<tr>
							<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
							<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
						</tr>
					</table>';
                                //echo $mail->Body;die();
                            } else {
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
					<tr>
						<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
					</tr>
					<tr>
						<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
							<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>
							<p>We regret to inform you that after careful consideration your loan application  #' . $application_id . ' was not found suitable for further processing . Kindly contact our representatives for any further clarifications</p>

							<br/>Sincerely,
							<br/>MyLoanAssocham  Team


						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                            }
                        }

                        //Start for SMS
                        //$phone_no = $data["channel_details"][0]->advisor_mob_no;

                        if ($opt["status"] == 1) {
                            $text = urlencode('Congratulations, your loan application # (' . $application_id . ') has been in principle ' . $stat . ' by (' . $data["bank_details"][0]->bank_name . '). The detailed terms of approval will be sent to you shortly pl access your myloanassocham account or your registered email to get further details');
                        } else {

                            $text = urlencode('We regret to inform you that after careful consideration your loan application # (' . $application_id . ') was not found suitable for further processing . Kindly contact our representatives for any further clarifications');
                        }
                        $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                        $response = file_get_contents($url);

                        //End for SMS
                    }

                    //start for sending Email......

                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        if ($mail->Send()) {
                            //echo $mail->Subject;
                            //echo $mail->Body;die();
                            $this->session->set_userdata('error_message', 1);
                            redirect("manage/dashboard/bank_application_status/" . base64_encode($this->input->post("application_id")));
                        }
                    } else {
                        if ($mail->Send()) {
                            $this->session->set_userdata('error_message', 1);
                            //redirect("manage/dashboard/loan_application_list/".base64_encode($this->input->post("application_id")));
                            redirect("manage/dashboard/bank_application_status/" . base64_encode($this->input->post("application_id")));
                        }
                    }
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/bank_application_status" . "/" . base64_encode($application_id));
                }
            } else {

                $application_id = $this->input->post("application_id");
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_BANK_APPLICATION";
                    if ($data["utype_id"] == 4) {
                        $other["tables"] = "TBL_BANK_MASTER";
                        $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
                        unset($other["tables"]);
                        //print_r($data["bank_details"]);exit;
                        $whereapplication['application_id'] = $application_id;
                        $whereapplication['bank_id'] = $data["bank_details"][0]->bank_id;
                    } else {
                        $whereapplication['application_id'] = $application_id;
                    }
                    $other["tables"] = "TBL_BANK_APPLICATION";
                    $data["bank_application"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //print_r($data["bank_application"]);exit;
                    unset($other["tables"], $whereapplication['bank_id']);
                    $other["tables"] = "TBL_ANALYST_DOCUMENTS";
                    $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["analyst_documents"])) {
                        redirect("manage/dashboard/analyst_documents/" . base64_encode($application_id));
                        //----------------End-------------------
                    }
                }
                $this->template->load('manage/main_loan', 'manage/bank_application_status', $data);
            }
        } else {
            //echo "ssadfasdf"; exit;
            //print_r($_POST); exit;
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
            $this->form_validation->set_rules('branch_details', 'Branch Details', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('preson_name', 'Person to Contact', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('person_mobile_no', 'Person Mobile No.', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('email_id', 'Person Email ID', 'trim|required|valid_email');

            if ($this->form_validation->run()) {
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $application_id["application_id"] = $this->input->post("application_id");
                $userdet["user_list"] = $this->admin_model->getUserDetails($application_id, $other);
                //print_r($userdet["user_details"]);
                //print_r($userdet["user_list"]); exit;
                unset($other["tables"]);

                $opt1["comment"] = $this->input->post("comment");
                $opt1["branch_details"] = $this->input->post("branch_details");
                $opt1["status"] = $this->input->post("status");
                $opt1["preson_name"] = $this->input->post("preson_name");
                $opt1["person_mobile_no"] = $this->input->post("person_mobile_no");
                $opt1["email_id"] = $this->input->post("email_id");
                $whereapplication["application_id"] = $this->input->post("application_id");
                $table = "tbl_bank_application";
                $update2 = $this->admin_model->updateUserDetails($table, $opt1, $whereapplication);

                if ($update2) {
                    //redirect("manage/dashboard/loan_application_list/".base64_encode($this->input->post("application_id")));

                    if ($opt["status"] == 1) {
                        $stat = "Approved";
                    } else {
                        $stat = "Rejected";
                    }
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true; // Enable SMTP authentication
                    $mail->Username = 'assocham01@gmail.com'; // SMTP username
                    $mail->Password = 'om123456';
                    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465; // TCP port to connect to
                    $mail->FromName = 'MyLoanassocham';

                    //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                    $mail->WordWrap = 50; // Set word wrap to 50 characters
                    $mail->IsHTML(true); // Set email format to HTML
                    $mail->SMTPKeepAlive = true; // Set email format to HTML

                    $wh["application_id"] = $this->input->post("application_id");
                    $other["tables"] = "TBL_LOAN_APPLICATION";
                    $loan_list = $this->admin_model->getUserDetails($wh, $other);
                    unset($other);

                    if ($loan_list[0]->channel_partner_id == 0) {
                        $where["uid"] = $loan_list[0]->msme_id;
                        $other["tables"] = "TBL_MSME";
                        $data["msme_details"] = $this->admin_model->getUserDetails($where, $other);
                        //print_r($data["user_details"]); exit;
                        $mail->addAddress($data["msme_details"][0]->owner_email);
                        $mail->Subject = 'Loan application #' . $application_id . ' status' . ' ' . $stat;
                        if ($opt["status"] == 1) {
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
								<tr>
									<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
								</tr>
								<tr>
									<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
										<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>

										<p>Congratulations, your loan application  #' . $application_id . ' has been in principle ' . $stat . ' by ' . $data["bank_details"][0]->bank_name . ' (name of bank).  The detailed terms of approval will be sent to you shortly  please access your myloanassocham account or your registered email to get further details.</p>

										<br/>Sincerely,
										<br/>MyLoanAssocham  Team


									</td>
								</tr>
								<tr>
									<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
									<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
								</tr>
							</table>';
                        } else {

                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
							<tr>
								<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
							</tr>
							<tr>
								<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
									<p>Dear ' . $data["msme_details"][0]->enterprise_name . '</p>
									<p>We regret to inform you that after careful consideration your loan application  #' . $application_id . ' was not found suitable for further processing . Kindly contact our representatives for any further clarifications</p>

									<br/>Sincerely,
									<br/>MyLoanAssocham  Team


								</td>
							</tr>
							<tr>
								<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
								<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
							</tr>
						</table>';
                        }
                        //echo $mail->Body;die();
                        //Start for SMS
                        $phone_no = $data["msme_details"][0]->mob_no;

                        if ($opt["status"] == 1) {
                            $text = urlencode('Congratulations, your loan application # (' . $application_id . ') has been in principle ' . $stat . ' by (' . $data["bank_details"][0]->bank_name . '). The detailed terms of approval will be sent to you shortly pl access your myloanassocham account or your registered email to get further details');
                        } else {

                            $text = urlencode('We regret to inform you that after careful consideration your loan application # (' . $application_id . ') was not found suitable for further processing . Kindly contact our representatives for any further clarifications');
                        }
                        $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                        $response = file_get_contents($url);

                        //End for SMS
                    } else {
                        $where["uid"] = $loan_list[0]->channel_partner_id;
                        $other["tables"] = "TBL_CHANNEL_PARTNER";
                        $data["channel_details"] = $this->admin_model->getUserDetails($where, $other);
                        $mail->addAddress($data["channel_details"][0]->advisor_email);
                        $mail->Subject = 'Loan application #' . $wh["application_id"] . ' status' . ' ' . $stat;
                        if ($opt["status"] == 1) {
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $data["channel_details"][0]->advisor_name . '</p>

								<p>Congratulations, your loan application  #' . $application_id . ' has been in principle ' . $stat . ' by ' . $data["bank_details"][0]->bank_name . ' (name of bank).  The detailed terms of approval will be sent to you shortly  please access your myloanassocham account or your registered email to get further details.</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team


							</td>
						</tr>
						<tr>
							<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
							<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
						</tr>
					</table>';
                            //echo $mail->Body;die();
                        } else {
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
					<tr>
						<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
					</tr>
					<tr>
						<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
							<p>Dear ' . $data["channel_details"][0]->advisor_name . '</p>
							<p>We regret to inform you that after careful consideration your loan application  #' . $application_id . ' was not found suitable for further processing . Kindly contact our representatives for any further clarifications</p>

							<br/>Sincerely,
							<br/>MyLoanAssocham  Team


						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                        }
                        //Start for SMS
                        $phone_no = $data["channel_details"][0]->advisor_mob_no;

                        if ($opt["status"] == 1) {
                            $text = urlencode('Congratulations, your loan application # (' . $application_id . ') has been in principle ' . $stat . ' by (' . $data["bank_details"][0]->bank_name . '). The detailed terms of approval will be sent to you shortly pl access your myloanassocham account or your registered email to get further details');
                        } else {

                            $text = urlencode('We regret to inform you that after careful consideration your loan application # (' . $application_id . ') was not found suitable for further processing . Kindly contact our representatives for any further clarifications');
                        }
                        $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                        $response = file_get_contents($url);
                        //End for SMS
                    }
                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        if ($mail->Send()) {
                            $this->session->set_userdata('error_message', 1);
                            redirect("manage/dashboard/loan_application_list/" . base64_encode($this->input->post("application_id")));
                        }
                        //redirect("manage/dashboard/loan_application_list/".base64_encode($this->input->post("application_id")));
                    } else {
                        if ($mail->Send()) {
                            $this->session->set_userdata('error_message', 1);
                            redirect("manage/dashboard/bank_application_status/" . base64_encode($this->input->post("application_id")));
                        }
                        //redirect("manage/dashboard/bank_application_status/".base64_encode($this->input->post("application_id")));
                    }
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                } else {
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/bank_application_status/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $application_id = $this->input->post("application_id");
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_BANK_APPLICATION";
                    if ($data["utype_id"] == 4) {
                        $other["tables"] = "TBL_BANK_MASTER";
                        $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
                        unset($other["tables"]);
                        //print_r($data["bank_details"]);exit;
                        $whereapplication['application_id'] = $application_id;
                        $whereapplication['bank_id'] = $data["bank_details"][0]->bank_id;
                    } else {
                        $whereapplication['application_id'] = $application_id;
                    }
                    $other["tables"] = "TBL_BANK_APPLICATION";
                    $data["bank_application"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //print_r($data["bank_application"]);exit;
                    unset($other["tables"], $whereapplication['bank_id']);
                    $other["tables"] = "TBL_ANALYST_DOCUMENTS";
                    $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["analyst_documents"])) {
                        redirect("manage/dashboard/analyst_documents/" . base64_encode($application_id));
                        //----------------End-------------------
                    }
                }
                $this->template->load('manage/main_loan', 'manage/bank_application_status', $data);
            }
        }
    }

    public function bank_filter($user_type = NULL, $id = NULL) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $ids["uid"] = $this->session->userdata('sesuserId');
        if ($data["utype_id"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $bank_details = $this->admin_model->getUserDetails($ids, $other);
            //print_r($bank_details);exit;
            $data['id'] = $bank_details[0]->bank_id;
        } else {
            $url = $this->uri->segment(5);
            $data['id'] = base64_decode($url);
        }
        $Details = $this->admin_model->getUsers($ids);
        $wh["bank_id"] = $data['id'];
        $other["tables"] = "TBL_BANK_FILTER";
        $data['bank_filter'] = $this->admin_model->getUserDetails($wh, $other);
        //print_r($data['bank_filter']);exit;
        $this->template->load('manage/main_filter', 'manage/bank_filter', $data);
    }

    public function save_bank_filter() {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $flag = $this->input->post('flag');
        //print_r($_POST);exit;

        if (empty($flag)) {
            if ($this->input->post('industry') != '') {
                $industry = implode(",", $this->input->post('industry'));
                $filterdata['industry'] = $industry;
            } else {
                $filterdata['industry'] = 0;
            }

            if ($this->input->post('loan_product') != '') {
                $loan_product = implode(",", $this->input->post('loan_product'));
                $filterdata['loan_product'] = $loan_product;
            } else {
                $filterdata['loan_product'] = 0;
            }

            if ($this->input->post('from_year') != '') {
                $from_year = new DateTime($this->input->post('from_year'));
                $filterdata['from_year'] = $from_year->format('Y-m-d');
            } else {
                $filterdata['from_year'] = "0000-00-00";
            }

            if ($this->input->post('to_year') != '') {
                $to_year = new DateTime($this->input->post('to_year'));
                $filterdata['to_year'] = $to_year->format('Y-m-d');
            } else {
                $filterdata['to_year'] = "0000-00-00";
            }

            if ($this->input->post('min_loan_amt') != '') {
                $filterdata['min_loan_amt'] = str_replace(",", "", $this->input->post('min_loan_amt'));
            } else {
                $filterdata['min_loan_amt'] = 0;
            }
            if ($this->input->post('max_loan_amt') != '') {
                $filterdata['max_loan_amt'] = str_replace(",", "", $this->input->post('max_loan_amt'));
            } else {
                $filterdata['max_loan_amt'] = 0;
            }

            $filterdata['bank_id'] = $this->input->post('id');
            $filterdata['created_date'] = date('Y-m-d');
            $add = $this->loan_application_model->addBank_filter($filterdata);
            if ($add && $data["utype_id"] == 4) {
                redirect('manage/dashboard');
            } else if ($add && $data["utype_id"] == 5) {
                redirect('manage/dashboard/bank_list');
            } else {
                $this->template->load('manage/main_filter', 'manage/bank_filter', $data);
            }
        } else {

            if ($this->input->post('industry') != '') {
                $industry = implode(",", $this->input->post('industry'));
                $filterdata['industry'] = $industry;
            } else {
                $filterdata['industry'] = 0;
            }

            if ($this->input->post('loan_product') != '') {
                $loan_product = implode(",", $this->input->post('loan_product'));
                $filterdata['loan_product'] = $loan_product;
            } else {
                $filterdata['loan_product'] = 0;
            }

            if ($this->input->post('from_year') != '') {
                $from_year = new DateTime($this->input->post('from_year'));
                $filterdata['from_year'] = $from_year->format('Y-m-d');
            } else {
                $filterdata['from_year'] = "0000-00-00";
            }

            if ($this->input->post('to_year') != '') {
                $to_year = new DateTime($this->input->post('to_year'));
                $filterdata['to_year'] = $to_year->format('Y-m-d');
            } else {
                $filterdata['to_year'] = "0000-00-00";
            }

            if ($this->input->post('min_loan_amt') != '') {
                $filterdata['min_loan_amt'] = str_replace(",", "", $this->input->post('min_loan_amt'));
            } else {
                $filterdata['min_loan_amt'] = 0;
            }

            if ($this->input->post('max_loan_amt') != '') {
                $filterdata['max_loan_amt'] = str_replace(",", "", $this->input->post('max_loan_amt'));
            } else {
                $filterdata['max_loan_amt'] = 0;
            }

            $filterdata['id'] = $this->input->post('id');
            $filterdata['created_date'] = date('Y-m-d');
            $whereapplication['id'] = $this->input->post('id');
            $table = "tbl_bank_filter";
            $update2 = $this->admin_model->updateUserDetails($table, $filterdata, $whereapplication);
            if ($update2 && $data["utype_id"] == 4) {
                redirect('manage/dashboard');
            } else if ($update2 && $data["utype_id"] == 5) {
                redirect('manage/dashboard/bank_list');
            } else {
                if ($data['utype_id'] == 4) {
                    $this->session->set_userdata('error_message', 1);
                    redirect('manage/dashboard/bank_filter');
                } else {
                    $wh["id"] = $this->input->post('id');
                    $other["tables"] = "TBL_BANK_FILTER";
                    $bank_filter = $this->admin_model->getUserDetails($wh, $other);
                    unset($other["tables"]);
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/bank_filter/" . base64_encode('4') . "/" . base64_encode($bank_filter[0]->bank_id));
                }
            }
        }
    }

    public function ajax_loan_application($application_id = NULL) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $application_id = base64_decode($application_id);
        $id["uid"] = $this->session->userdata('sesuserId');
        $msme["uid"] = $this->input->post("msme");
        //if($data["utype_id"]==1){
        $other["tables"] = "TBL_MSME";

        $data["user_details"] = $this->admin_model->getUserDetails($msme, $other);
        $data["state"] = $this->user_model->fetch_state();
        $op["c.id"] = $data["user_details"][0]->city;
        $data["city"] = $this->user_model->fetch_city_name($op);
        unset($other["tables"]);

        //}
        //print_r($data["user_details"]); exit;
        $this->load->view('manage/ajax_loan_application', $data);
    }

    public function loan_application($application_id = NULL) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $application_id = base64_decode($application_id);
        $id["uid"] = $this->session->userdata('sesuserId');

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if ($data["utype_id"] == 1) {
            $other["tables"] = "TBL_MSME";

            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            $data["state"] = $this->user_model->fetch_state();
            $op["c.id"] = $data["user_details"][0]->city;
            $data["city"] = $this->user_model->fetch_city_name($op);
            unset($other["tables"]);
            //-------------------Loan Details Fetching -------------------
            if (isset($application_id) && $application_id != '') {
                $other["tables"] = "TBL_LOAN_APPLICATION";
                $whereapplication['application_id'] = $application_id;
                $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                if (empty($data["enterprise_profile"])) {
                    //echo "rj";exit;
                    redirect("manage/dashboard/loan_application");
                }
                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
                //----------------End-------------------
            }
        } else if ($data["utype_id"] == 2) {
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $data["state"] = $this->user_model->fetch_state();
            //$data["city"] = $this->user_model->fetch_city_name();
            $data["city"] = $this->user_model->fetch_city_name();
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            //print_r($data["user_details"]); exit;
            unset($other["tables"]);
            //---------------Msme List-----------------------
            $channel_id["channel_partner_id"] = $data["user_details"][0]->uid;
            $other["tables"] = "TBL_MSME";
            $data["msme_list"] = $this->admin_model->getUserDetails($channel_id, $other);
            //print_r($data["msme_list"]); exit;
            unset($other["tables"]);
            //---------------End Msme List-----------------------
            //-------------------Loan Details Fetching -------------------
            if (isset($application_id) && $application_id != '') {
                $other["tables"] = "TBL_LOAN_APPLICATION";
                $whereapplication['application_id'] = $application_id;
                $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                if (empty($data["enterprise_profile"])) {
                    //echo "rj";exit;
                    redirect("manage/dashboard/loan_application");
                }
                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
            }
            //----------------End-------------------
        } else if ($data["utype_id"] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $data["state"] = $this->user_model->fetch_state();
            //$data["city"] = $this->user_model->fetch_city_name();
            $data["city"] = $this->user_model->fetch_city_name();
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            //print_r($data["user_details"]); exit;
            unset($other["tables"]);
            //-------------------Loan Details Fetching -------------------
            if (isset($application_id) && $application_id != '') {
                $other["tables"] = "TBL_LOAN_APPLICATION";
                $whereapplication['application_id'] = $application_id;
                $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
                if (empty($data["enterprise_profile"])) {
                    //echo "rj";exit;
                    redirect("manage/dashboard/loan_application");
                }
            }
        } else if ($data["utype_id"] == 4) {
            if (isset($application_id) && $application_id != '') {
                $data["state"] = $this->user_model->fetch_state();
                //$data["city"] = $this->user_model->fetch_city_name();
                $data["city"] = $this->user_model->fetch_city_name();
                $other["tables"] = "TBL_LOAN_APPLICATION";
                $whereapplication['application_id'] = $application_id;
                $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
                if (empty($data["enterprise_profile"])) {
                    //echo "rj";exit;
                    redirect("manage/dashboard/loan_application");
                }}
        } else {
            if (isset($application_id) && $application_id != '') {
                $data["state"] = $this->user_model->fetch_state();
                //$data["city"] = $this->user_model->fetch_city_name();
                $data["city"] = $this->user_model->fetch_city_name();
                $other["tables"] = "TBL_LOAN_APPLICATION";
                $whereapplication['application_id'] = $application_id;
                $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
                if (empty($data["enterprise_profile"])) {
                    //echo "rj";exit;
                    redirect("manage/dashboard/loan_application");
                }
            }
        }
        //print_r($data); exit;
        $this->template->load('manage/main_loan', 'manage/loan_application', $data);
    }

    public function loan_requirement($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $application_id = base64_decode($application_id);

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_LOAN_REQUIREMENT";
            $whereapplication['application_id'] = $application_id;
            $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_ENTERPRISE_PROFILE";
            $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (!empty($data["loan_requirement"])) {
                $op["c.id"] = $data["loan_requirement"][0]->city;
                $data["city"] = $this->user_model->fetch_city_name($op);
                $data["state"] = $this->user_model->fetch_state();
            } else if (empty($data["enterprise_profile"])) {
                redirect("manage/dashboard/loan_application" . "/" . base64_encode($application_id));
            }
            //print_r($data["loan_requirement"]);exit;
            unset($other["tables"]);
            //----------------End-------------------
        }

        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        $data["state"] = $this->user_model->fetch_state();
        //print_r($data); exit;
        $this->template->load('manage/main_loan', 'manage/loan_requirement', $data);
    }

    public function enterprise_background($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $application_id = base64_decode($application_id);

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
            $whereapplication['application_id'] = $application_id;
            $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //echo "<pre>";print_r($data["enterprise_background"]);exit;
            unset($other["tables"]);
            $other["tables"] = "TBL_LOAN_REQUIREMENT";
            $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (empty($data["loan_requirement"])) {
                redirect("manage/dashboard/loan_requirement" . "/" . base64_encode($application_id));
            }
            //----------------End-------------------
        }

        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        $data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main_loan', 'manage/enterprise_background', $data);
    }

    public function owner_details($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $application_id = base64_decode($application_id);

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_OWNER_DETAILS";
            $whereapplication['application_id'] = $application_id;
            $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //echo "<pre>";print_r($data["owner_details"]);exit;
            unset($other["tables"]);
            $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
            $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (empty($data["enterprise_background"])) {
                redirect("manage/dashboard/enterprise_background" . "/" . base64_encode($application_id));
            }
            //----------------End-------------------
        }

        $id["uid"] = $this->session->userdata('userId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        $data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main_loan', 'manage/owner_details', $data);
    }

    public function banking_credit_facilities($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $this->session->unset_userdata('ref_type');
        $application_id = base64_decode($application_id);

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }
        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
            $whereapplication['application_id'] = $application_id;
            $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //echo "<pre>";print_r($data["banking_credit_facilities"]);exit;
            unset($other["tables"]);
            $other["tables"] = "TBL_OWNER_DETAILS";
            $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (empty($data["owner_details"])) {
                redirect("manage/dashboard/owner_details" . "/" . base64_encode($application_id));
            }
            //----------------End-------------------
        }

        $id["uid"] = $this->session->userdata('userId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        //$data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main_loan', 'manage/banking_credit_facilities', $data);
    }

    public function upload_documents($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');
        $application_id = base64_decode($application_id);
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_UPLOAD_DOCUMENTS";
            $whereapplication['application_id'] = $application_id;
            $data["upload_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_OWNER_DETAILS";
            $whereapplication['application_id'] = $application_id;
            $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            if (!empty($data["owner_details"]) && !empty($data["upload_documents"])) {
                $other["tables"] = "TBL_UPLOAD_DOCUMENTS_OWNER";
                $whereowner['upload_id'] = $data["upload_documents"][0]->id;
                $data["owner_documents"] = $this->admin_model->getLoanDetails($whereowner, $other);
                unset($other["tables"]);
            }
            //print_r($data["owner_documents"]);exit;
            $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
            $whereapplication['application_id'] = $application_id;
            $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            unset($other["tables"]);
            if (!empty($data["upload_documents"])) {
                $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                $upload['upload_id'] = $data["upload_documents"][0]->id;
                $data["upload_add_more"] = $this->admin_model->getLoanDetails($upload, $other);
                unset($other["tables"]);

                $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                $uploads['upload_ids'] = $data["upload_documents"][0]->id;
                $data["additional_documents"] = $this->admin_model->getLoanDetails($uploads, $other);
                unset($other["tables"]);
            } else if (empty($data["banking_credit_facilities"])) {
                redirect("manage/dashboard/banking_credit_facilities" . "/" . base64_encode($application_id));
            }
            //echo "<pre>";print_r($data["upload_documents"]);"echo <br>";print_r($data["upload_add_more"]);exit;
        }
        //----------------End-------------------

        $id["uid"] = $this->session->userdata('userId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        //$data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main_loan', 'manage/upload_documents', $data);
    }

    public function analyst_documents($application_id = NUll) {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        $data["analyst_id"] = $this->session->userdata('sesuserId');

        $application_id = base64_decode($application_id);

        if (isset($application_id) && $application_id != '') {
            $where_bank['application_id'] = $application_id;
            $other["tables"] = "TBL_BANK_APPLICATION";
            $data["bank_application"] = $this->admin_model->getLoanDetails($where_bank, $other);
        }

        if (!empty($application_id)) {
            $data["application_id"] = $application_id;
        } else {
            redirect('manage/dashboard/loan_application');
        }

        //-------------------Loan Details Fetching -------------------
        if (isset($application_id) && $application_id != '') {
            $other["tables"] = "TBL_ANALYST_DOCUMENTS";
            $whereapplication['application_id'] = $application_id;
            $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //echo "<pre>";print_r($data["analyst_documents"]);
            unset($other["tables"]);
            $other["tables"] = "TBL_OWNER_DETAILS";
            $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            $other["tables"] = "TBL_ANALYST_DIRECTOR_DOCUMENTS";
            $data["analyst_director_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
            //echo "<pre>";print_r($data["analyst_director_documents"]);exit;
            unset($other["tables"]);
        }
        //----------------End-------------------

        $id["uid"] = $this->session->userdata('userId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        //$data["state"] = $this->user_model->fetch_state();

        $this->template->load('manage/main_loan', 'manage/analyst_documents', $data);
    }

    public function save_enterprise_profile() {

        //echo "<pre>";print_r($_POST); exit;
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($data["utype_id"] == 3 || $data["utype_id"] == 4 || $data["utype_id"] == 5) {
            redirect("manage/dashboard/loan_requirement/" . base64_encode($this->input->post("application_id")));
        }
        //---------end user type checking for view mode---------
        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;
        $v = $this->input->post('application_id');
        if (empty($v)) {
            //print_r($_POST);exit;
            $this->form_validation->set_rules('name_enterprise', 'Enterprise Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('legal_entity', ' Legal Entity', 'trim|required');
            $this->form_validation->set_rules('name_of_owner', 'Director Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('owner_email', 'Owner email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('contact_numbers', 'Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('pan_enterprise', 'PAN', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('office_address', 'Address', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('last_audited_trunover', 'Latest Audited Turnover', 'trim|required|max_length[11]');

            if ($this->form_validation->run()) {
                $opt["name_enterprise"] = $this->input->post("name_enterprise");
                $opt["pan_enterprise"] = $this->input->post("pan_enterprise");
                $opt["legal_entity"] = $this->input->post("legal_entity");
                $opt["state"] = $this->input->post("state");
                $opt["city"] = $this->input->post("city");
                $opt["pincode"] = $this->input->post("pincode");
                $opt["owner_email"] = $this->input->post("owner_email");
                $opt["name_of_owner"] = $this->input->post("name_of_owner");
                $opt["contact_numbers"] = $this->input->post("contact_numbers");
                $opt["office_address"] = $this->input->post("office_address");
                //$opt["last_audited_trunover"] = $this->input->post("last_audited_trunover");
                $opt["last_audited_trunover"] = str_replace(",", "", $this->input->post("last_audited_trunover"));

                $data["state"] = $this->user_model->fetch_state();

                $add = $this->loan_application_model->addEnterprise_Details($opt);
                if ($add) {
                    if ($data["utype_id"] == 1) {
                        $other["tables"] = "TBL_MSME";
                        $sdata["user_details"] = $this->admin_model->getUserDetails($id, $other);
                        $options["msme_id"] = $sdata["user_details"][0]->uid;
                        unset($other, $sdata);
                        $options["status"] = 0;
                        $options["created_dtm"] = date('Y-m-d H:i:s');
                        $options["updated_dtm"] = date('Y-m-d H:i:s');
                        $add1 = $this->loan_application_model->addLoan_application($options);
                        $app["application_id"] = $add1;
                        $where["id"] = $add;
                        $add2 = $this->loan_application_model->updateEnterprise_Details($app, $where);
                        if ($add2) {
                            $this->pdfgen(base64_encode($app["application_id"]));
                        }
                    } else {
                        $msme_list_id = $this->input->post("msme_list_id");
                        if (!empty($msme_list_id)) {
                            $options["msme_id"] = $this->input->post("msme_list_id");
                        } else {
                            $other["tables"] = "TBL_CHANNEL_PARTNER";
                            $sdata["user_details"] = $this->admin_model->getUserDetails($id, $other);
                            $options["channel_partner_id"] = $sdata["user_details"][0]->uid;
                            unset($other, $sdata);
                        }
                        $options["status"] = 0;
                        $options["created_dtm"] = date('Y-m-d H:i:s');
                        $options["updated_dtm"] = date('Y-m-d H:i:s');
                        $add1 = $this->loan_application_model->addLoan_application($options);
                        $app["application_id"] = $add1;
                        $where["id"] = $add;
                        $add2 = $this->loan_application_model->updateEnterprise_Details($app, $where);
                        if ($add2) {
                            $this->pdfgen(base64_encode($app["application_id"]));
                        }
                    }

                    $this->session->set_userdata('error_message', 1);

                    redirect("manage/dashboard/loan_requirement/" . base64_encode($add1));
                } else {
                    $this->template->load('manage/main_loan', 'manage/loan_application', $data);
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $this->session->unset_userdata('ref_type');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //$application_id=base64_decode($application_id);
                $id["uid"] = $this->session->userdata('sesuserId');
                if ($data["utype_id"] == 1) {
                    $other["tables"] = "TBL_MSME";

                    $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                    $data["state"] = $this->user_model->fetch_state();
                    $op["c.id"] = $data["user_details"][0]->city;
                    $data["city"] = $this->user_model->fetch_city_name($op);
                    unset($other["tables"]);
                } else if ($data["utype_id"] == 2) {
                    $other["tables"] = "TBL_CHANNEL_PARTNER";
                    $data["state"] = $this->user_model->fetch_state();
                    //$data["city"] = $this->user_model->fetch_city_name();
                    $data["city"] = $this->user_model->fetch_city_name();
                    $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                    //print_r($data["user_details"]); exit;
                    unset($other["tables"]);
                    //---------------Msme List-----------------------
                    $channel_id["channel_partner_id"] = $data["user_details"][0]->uid;
                    $other["tables"] = "TBL_MSME";
                    $data["msme_list"] = $this->admin_model->getUserDetails($channel_id, $other);
                    //print_r($data["msme_list"]); exit;
                    unset($other["tables"]);
                }
                $this->template->load('manage/main_loan', 'manage/loan_application', $data);
            }
        } else {

            //echo "rj";exit;
            $this->form_validation->set_rules('name_enterprise', 'Enterprise Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('legal_entity', ' Legal Entity', 'trim|required');
            $this->form_validation->set_rules('name_of_owner', 'Director Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('owner_email', 'Owner email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('contact_numbers', 'Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('pan_enterprise', 'PAN', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('office_address', 'Address', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('last_audited_trunover', 'Latest Audited Turnover', 'trim|required|max_length[11]');

            if ($this->form_validation->run()) {
                $opt["name_enterprise"] = $this->input->post("name_enterprise");
                $opt["pan_enterprise"] = $this->input->post("pan_enterprise");
                $opt["legal_entity"] = $this->input->post("legal_entity");
                $opt["state"] = $this->input->post("state");
                $opt["city"] = $this->input->post("city");
                $opt["pincode"] = $this->input->post("pincode");
                $opt["owner_email"] = $this->input->post("owner_email");
                $opt["name_of_owner"] = $this->input->post("name_of_owner");
                $opt["contact_numbers"] = $this->input->post("contact_numbers");
                $opt["office_address"] = $this->input->post("office_address");
                //$opt["last_audited_trunover"] = $this->input->post("last_audited_trunover");
                $opt["last_audited_trunover"] = str_replace(",", "", $this->input->post("last_audited_trunover"));
                $whereapplication["application_id"] = $this->input->post("application_id");
                $table = "tbl_enterprise_profile";
                $update2 = $this->admin_model->updateUserDetails($table, $opt, $whereapplication);
                if ($update2) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    redirect("manage/dashboard/loan_requirement/" . base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/loan_requirement/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $this->session->unset_userdata('ref_type');
                $data["utype_id"] = $this->session->userdata('utype_id');
                $application_id = $this->input->post("application_id");
                $id["uid"] = $this->session->userdata('sesuserId');
                if ($data["utype_id"] == 1) {
                    $other["tables"] = "TBL_MSME";

                    $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                    $data["state"] = $this->user_model->fetch_state();
                    $op["c.id"] = $data["user_details"][0]->city;
                    $data["city"] = $this->user_model->fetch_city_name($op);
                    unset($other["tables"]);
                } else if ($data["utype_id"] == 2) {
                    $other["tables"] = "TBL_CHANNEL_PARTNER";
                    $data["state"] = $this->user_model->fetch_state();
                    //$data["city"] = $this->user_model->fetch_city_name();
                    $data["city"] = $this->user_model->fetch_city_name();
                    $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                    //print_r($data["user_details"]); exit;
                    unset($other["tables"]);
                    //---------------Msme List-----------------------
                    $channel_id["channel_partner_id"] = $data["user_details"][0]->uid;
                    $other["tables"] = "TBL_MSME";
                    $data["msme_list"] = $this->admin_model->getUserDetails($channel_id, $other);
                    //print_r($data["msme_list"]); exit;
                    unset($other["tables"]);
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_LOAN_APPLICATION";
                    $whereapplication['application_id'] = $application_id;
                    $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);

                    $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                    $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                }

                //print_r($data["enterprise_profile"]);exit;
                unset($other["tables"]);
                $this->template->load('manage/main_loan', 'manage/loan_application', $data);
            }
        }
    }

    public function save_loan_requirement() {

        //echo "<pre>";print_r($_POST); exit;
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($data["utype_id"] == 3 || $data["utype_id"] == 4 || $data["utype_id"] == 5) {
            redirect("manage/dashboard/enterprise_background/" . base64_encode($this->input->post("application_id")));
        }
        //---------end user type checking for view mode---------
        $id["uid"] = $this->session->userdata('sesuserId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;

        $application_id = $this->input->post("application_id");
        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('type_of_facility', 'Type of Facility ', 'trim|required');
            $this->form_validation->set_rules('Amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
            $this->form_validation->set_rules('tenure_in_years', 'Tenure in Years', 'trim|required');

            if ($this->form_validation->run()) {
                $opt["application_id"] = $this->input->post("application_id");
                $opt["type_of_facility"] = $this->input->post("type_of_facility");
                //$opt["Amount"] = $this->input->post("Amount");
                $opt["Amount"] = str_replace(",", "", $this->input->post("Amount"));
                $opt["purpose"] = $this->input->post("purpose");
                $opt["tenure_in_years"] = $this->input->post("tenure_in_years");
                //$frm_date=new DateTime($this->input->post("tenure_in_years"));
                //$opt["tenure_in_years"] = $frm_date->format('Y-m-d');
                $opt["state"] = $this->input->post("state");
                $opt["district"] = $this->input->post("district");
                $opt["city"] = $this->input->post("city");
                $opt["branch"] = $this->input->post("branch");
                /* $opt["security_offered"] = $this->input->post("security_offered");
                $opt["primary_security"] = $this->input->post("primary_security");
                $opt["collateral_security"] = $this->input->post("collateral_security"); */
                //echo "<pre>";print_r($opt); exit;

                $data["state"] = $this->user_model->fetch_state();
                //--------------------Uniuqe Checking---------------------------
                $other["tables"] = "TBL_LOAN_REQUIREMENT";
                $whereapplication['application_id'] = $application_id;
                $loan_requirement = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                if (empty($loan_requirement)) {
                    $add = $this->loan_application_model->addLoan_requirement($opt);
                } else {
                    redirect("manage/dashboard/loan_requirement" . "/" . base64_encode($application_id));
                }
                //--------------------Uniuqe Checking---------------------------
                if ($add) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/enterprise_background" . "/" . base64_encode($application_id));
                } else {
                    $this->template->load('manage/main_loan', 'manage/loan_requirement', $data);
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_LOAN_REQUIREMENT";
                    $whereapplication['application_id'] = $application_id;
                    $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (!empty($data["loan_requirement"])) {
                        $op["c.id"] = $data["loan_requirement"][0]->city;
                        $data["city"] = $this->user_model->fetch_city_name($op);
                        $data["state"] = $this->user_model->fetch_state();
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                $data["state"] = $this->user_model->fetch_state();
                //print_r($data); exit;
                $this->template->load('manage/main_loan', 'manage/loan_requirement', $data);
            }
        } else {
            //echo "ssadfasdf"; exit;
            //print_r($_POST); exit;
            $this->form_validation->set_rules('type_of_facility', 'Type of Facility ', 'trim|required');
            $this->form_validation->set_rules('Amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
            $this->form_validation->set_rules('tenure_in_years', 'Tenure in Years', 'trim|required');

            if ($this->form_validation->run()) {
                $opt["application_id"] = $this->input->post("application_id");
                $opt["type_of_facility"] = $this->input->post("type_of_facility");
                $opt["Amount"] = str_replace(",", "", $this->input->post("Amount"));
                $opt["purpose"] = $this->input->post("purpose");
                $opt["tenure_in_years"] = $this->input->post("tenure_in_years");
                $opt["state"] = $this->input->post("state");
                $opt["district"] = $this->input->post("district");
                $opt["city"] = $this->input->post("city");
                $opt["branch"] = $this->input->post("branch");
                $whereapplication["application_id"] = $this->input->post("application_id");
                $table = "tbl_loan_requirement";
                $update2 = $this->admin_model->updateUserDetails($table, $opt, $whereapplication);
                if ($update2) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    redirect("manage/dashboard/enterprise_background/" . base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/enterprise_background/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_LOAN_REQUIREMENT";
                    $whereapplication['application_id'] = $application_id;
                    $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    $other["tables"] = "TBL_ENTERPRISE_PROFILE";
                    $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (!empty($data["loan_requirement"])) {
                        $op["c.id"] = $data["loan_requirement"][0]->city;
                        $data["city"] = $this->user_model->fetch_city_name($op);
                        $data["state"] = $this->user_model->fetch_state();
                    } else if (empty($data["enterprise_profile"])) {
                        redirect("manage/dashboard/loan_application" . "/" . base64_encode($application_id));
                    }
                    //print_r($data["loan_requirement"]);exit;
                    unset($other["tables"]);
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                $data["state"] = $this->user_model->fetch_state();
                //print_r($data); exit;
                $this->template->load('manage/main_loan', 'manage/loan_requirement', $data);
            }
        }
    }

    public function save_enterprise_background() {

        //echo "<pre>";print_r($_POST); exit;
        $this->session->unset_userdata('ref_type');
        $data["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($data["utype_id"] == 3 || $data["utype_id"] == 4 || $data["utype_id"] == 5) {
            redirect("manage/dashboard/owner_details/" . base64_encode($this->input->post("application_id")));
        }
        //---------end user type checking for view mode---------
        $id["uid"] = $this->session->userdata('userId');
        $name = $this->admin_model->getUsers($id);
        //$data["name"]=$name[0]->name;

        $application_id = $this->input->post("application_id");
        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('pan', 'PAN', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('vat', 'VAT', 'trim|max_length[15]');
            $this->form_validation->set_rules('industry_segment', 'Industry Segment', 'trim|required');
            $this->form_validation->set_rules('date_of_establishment', 'Date of Establishment', 'trim|required');

            if ($this->form_validation->run()) {
                $opt["application_id"] = $this->input->post("application_id");
                $opt["pan"] = $this->input->post("pan");
                //$opt["vat"] = $this->input->post("vat");
                $opt["vat"] = str_replace(",", "", $this->input->post("vat"));
                $opt["cin"] = $this->input->post("cin");
                //$opt["service_tax"] = $this->input->post("service_tax");
                $opt["service_tax"] = str_replace(",", "", $this->input->post("service_tax"));
                $opt["industry_segment"] = $this->input->post("industry_segment");
                $frm_date = new DateTime($this->input->post("date_of_establishment"));
                $opt["date_of_establishment"] = $frm_date->format('Y-m-d');
                $opt["adress_of_factoy"] = $this->input->post("adress_of_factoy");
                $opt["adress1"] = $this->input->post("adress1");
                $opt["adress2"] = $this->input->post("adress2");
                $opt["existing_activity"] = $this->input->post("existing_activity");
                //$opt["amount_invested_plant_machinery"] = $this->input->post("amount_invested_plant_machinery");
                //$opt["amount_invested_equipments"] = $this->input->post("amount_invested_equipments");
                $opt["amount_invested_plant_machinery"] = str_replace(",", "", $this->input->post("amount_invested_plant_machinery"));
                $opt["amount_invested_equipments"] = str_replace(",", "", $this->input->post("amount_invested_equipments"));
                $opt["geographical_areas"] = $this->input->post("geographical_areas");
                $opt["no_of_operating_states"] = $this->input->post("no_of_operating_states");
                $opt["are_you_sales"] = $this->input->post("are_you_sales");
                $opt["are_you_sales_a"] = $this->input->post("are_you_sales_a");
                $opt["key_products_services"] = $this->input->post("key_products_services");

                $data["state"] = $this->user_model->fetch_state();

                //--------------------Uniuqe Checking---------------------------
                $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
                $whereapplication['application_id'] = $application_id;
                $enterprise_background = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                if (empty($enterprise_background)) {
                    $add = $this->loan_application_model->addEnterprise_background($opt);
                } else {
                    redirect("manage/dashboard/enterprise_background" . "/" . base64_encode($application_id));
                }
                //--------------------End Uniuqe Checking---------------------------
                if ($add) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/owner_details" . "/" . base64_encode($application_id));
                } else {
                    $this->template->load('manage/main_loan', 'manage/enterprise_background', $data);
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
                    $whereapplication['application_id'] = $application_id;
                    $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["enterprise_background"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_LOAN_REQUIREMENT";
                    $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["loan_requirement"])) {
                        redirect("manage/dashboard/loan_requirement" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);

                $this->template->load('manage/main_loan', 'manage/enterprise_background', $data);
            }
        } else {
            $this->form_validation->set_rules('pan', 'PAN', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('vat', 'VAT', 'trim|max_length[15]');
            $this->form_validation->set_rules('industry_segment', 'Industry Segment', 'trim|required');
            $this->form_validation->set_rules('date_of_establishment', 'Date of Establishment', 'trim|required');

            if ($this->form_validation->run()) {
                $opt["application_id"] = $this->input->post("application_id");
                $opt["pan"] = $this->input->post("pan");
                //$opt["vat"] = $this->input->post("vat");
                $opt["vat"] = str_replace(",", "", $this->input->post("vat"));
                $opt["cin"] = $this->input->post("cin");
                //$opt["service_tax"] = $this->input->post("service_tax");
                $opt["service_tax"] = str_replace(",", "", $this->input->post("service_tax"));
                $opt["industry_segment"] = $this->input->post("industry_segment");
                $frm_date = new DateTime($this->input->post("date_of_establishment"));
                $opt["date_of_establishment"] = $frm_date->format('Y-m-d');
                $opt["adress_of_factoy"] = $this->input->post("adress_of_factoy");
                $opt["adress1"] = $this->input->post("adress1");
                $opt["adress2"] = $this->input->post("adress2");
                $opt["existing_activity"] = $this->input->post("existing_activity");
                //$opt["amount_invested_plant_machinery"] = $this->input->post("amount_invested_plant_machinery");
                //$opt["amount_invested_equipments"] = $this->input->post("amount_invested_equipments");
                $opt["amount_invested_plant_machinery"] = str_replace(",", "", $this->input->post("amount_invested_plant_machinery"));
                $opt["amount_invested_equipments"] = str_replace(",", "", $this->input->post("amount_invested_equipments"));
                $opt["geographical_areas"] = $this->input->post("geographical_areas");
                $opt["no_of_operating_states"] = $this->input->post("no_of_operating_states");
                $opt["are_you_sales"] = $this->input->post("are_you_sales");
                $opt["are_you_sales_a"] = $this->input->post("are_you_sales_a");
                $opt["key_products_services"] = $this->input->post("key_products_services");
                $whereapplication["application_id"] = $this->input->post("application_id");
                $table = "tbl_enterprise_background";
                $update2 = $this->admin_model->updateUserDetails($table, $opt, $whereapplication);
                if ($update2) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    redirect("manage/dashboard/owner_details/" . base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/owner_details/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
                    $whereapplication['application_id'] = $application_id;
                    $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["enterprise_background"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_LOAN_REQUIREMENT";
                    $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["loan_requirement"])) {
                        redirect("manage/dashboard/loan_requirement" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('sesuserId');
                $name = $this->admin_model->getUsers($id);

                $this->template->load('manage/main_loan', 'manage/enterprise_background', $data);
            }
        }
    }

    public function save_owner_details() {
        //echo "<pre>"; print_r($_POST); exit;
        //print_r($name);
        //exit;

        $sdata["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($sdata["utype_id"] == 3 || $sdata["utype_id"] == 4 || $sdata["utype_id"] == 5) {
            redirect("manage/dashboard/banking_credit_facilities/" . base64_encode($this->input->post("application_id")));
        }

        //---------end user type checking for view mode---------
        $application_id = $this->input->post("application_id");

        $name = $this->input->post("name");
        $dob_edit = $this->input->post("dob");

        /* $dob=implode("",$this->input->post("dob"));

        $dob=new DateTime($dob);
        $dob = @$dob->format('Y-m-d');  */

        $dob = $this->input->post("dob");
        $father_name = $this->input->post("father_name");
        $academic_qualification = $this->input->post("academic_qualification");
        $pan = $this->input->post("pan");
        $residentail_address = $this->input->post("residentail_address");
        $state = $this->input->post("state");
        $pincode = $this->input->post("pincode");
        $adress_proof_type = $this->input->post("adress_proof_type");
        $address_proof_id = $this->input->post("address_proof_id");
        $mobile_no = $this->input->post("mobile_no");
        $landline_no = $this->input->post("landline_no");
        $exp_in_line_activity = $this->input->post("exp_in_line_activity");
        $souce_of_other_income = $this->input->post("souce_of_other_income");
        $know_cibil_score = $this->input->post("know_cibil_score");
        $cibil_score = $this->input->post("cibil_score");
        /* if (array_key_exists("cibil_score",$_POST)){
        $cibil_score = $this->input->post("cibil_score");
        //$cibil_score1 = array_values(array_filter($cibil_score));
        $cibil_score1 = $cibil_score;
        //print_r($cibil_score1); //exit;
        }else{
        $cibil_score1 = 0;
        } */

        $cast = $this->input->post("cast");

        //$please_specify = $this->input->post("please_specify");
        if (array_key_exists("please_specify", $_POST)) {
            $please_specify = $this->input->post("please_specify");
            $please_specify = $please_specify;
        } else {
            $please_specify = 0;
        }
        //print_r($cibil_score); exit;
        if ($name[0] == "") {
            unset($please_specify[0]);
            //$please_specify[0] = $please_specify;
        }

        $application_id1 = $application_id;

        $name1 = array_values(array_filter($name));
        $dob1 = array_values(array_filter($dob));
        $dob2 = array_values(array_filter($dob_edit));
        $father_name1 = array_values(array_filter($father_name));
        $academic_qualification1 = array_values(array_filter($academic_qualification));
        $pan1 = array_values(array_filter($pan));
        $residentail_address1 = array_values(array_filter($residentail_address));
        $state1 = array_values(array_filter($state));
        $pincode1 = array_values(array_filter($pincode));
        $adress_proof_type1 = array_values(array_filter($adress_proof_type));
        $address_proof_id1 = array_values(array_filter($address_proof_id));
        $mobile_no1 = array_values(array_filter($mobile_no));
        $landline_no1 = array_values(array_filter($landline_no));
        $exp_in_line_activity1 = array_values(array_filter($exp_in_line_activity));
        $souce_of_other_income1 = array_values(array_filter($souce_of_other_income));
        //$know_cibil_score1 = array_values(array_filter($know_cibil_score));

        //$cast1 = array_values(array_filter($cast));
        $know_cibil_score1 = $know_cibil_score;
        $cibil_score1 = $cibil_score;
        $cast1 = $cast;
        //$please_specify1 = array_values(array_filter($please_specify));
        $please_specify1 = $please_specify;
        //print_r($name1); exit;
        //count($know_cibil_score1);exit;

        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('name[]', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob[]', 'DOB', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pan[]', 'PAN of the Promoter', 'trim|required|xss_clean');
            $this->form_validation->set_rules('adress_proof_type[]', 'Address Proof Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address_proof_id[]', 'Address Proof ID', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mobile_no[]', 'Mobile No.', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $i = 0;

                foreach ($name1 as $k => $row) {
                    $data['application_id'] = $application_id1;
                    $data['name'] = $name1[$k];
                    $data['dob'] = date('Y-m-d', strtotime($dob1[$k]));
                    @$data['father_name'] = $father_name1[$k];
                    @$data['academic_qualification'] = $academic_qualification1[$k];
                    $data['pan'] = $pan1[$k];
                    @$data['residentail_address'] = $residentail_address1[$k];
                    @$data['state'] = $state1[$k];
                    @$data['pincode'] = $pincode1[$k];
                    $data['adress_proof_type'] = $adress_proof_type1[$k];
                    $data['address_proof_id'] = $address_proof_id1[$k];
                    $data['mobile_no'] = $mobile_no1[$k];
                    @$data['landline_no'] = $landline_no1[$k];
                    @$data['exp_in_line_activity'] = $exp_in_line_activity1[$k];
                    @$data['souce_of_other_income'] = $souce_of_other_income1[$k];
                    //@$data['know_cibil_score'] = $know_cibil_score1[$k];
                    if (!empty($know_cibil_score1[$k])) {
                        @$data['know_cibil_score'] = $know_cibil_score1[$k];
                    } else {

                        $data['know_cibil_score'] = "";
                    }

                    if (!empty($cibil_score1[$k])) {
                        @$data['cibil_score'] = $cibil_score1[$k];
                    } else {

                        $data['cibil_score'] = "";
                    }
                    //@$data['cast'] = $cast1[$k];
                    if (!empty($cast1[$k])) {
                        @$data['cast'] = $cast1[$k];
                    } else {

                        $data['cast'] = "";
                    }
                    @$data['please_specify'] = $please_specify1[$k];
                    //print_r($data); exit;
                    $add = $this->db->insert(TBL_OWNER_DETAILS, $data);

                    $i++;
                }
                //}

                //$add = $this->loan_application_model->addEnterprise_background($opt);
                if ($add) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);

                    redirect("manage/dashboard/banking_credit_facilities" . "/" . base64_encode($application_id));
                } else {
                    $this->template->load('manage/main', 'manage/owner_details');
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $whereapplication['application_id'] = $application_id;
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["owner_details"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
                    $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["enterprise_background"])) {
                        redirect("manage/dashboard/enterprise_background" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                $data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/owner_details', $data);
            }
        } else {
            $this->form_validation->set_rules('name[]', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob[]', 'DOB', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pan[]', 'PAN of the Promoter', 'trim|required|xss_clean');
            $this->form_validation->set_rules('adress_proof_type[]', 'Address Proof Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address_proof_id[]', 'Address Proof ID', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mobile_no[]', 'Mobile No.', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $table = "tbl_owner_details";
                $application_id = $application_id1;
                $dele = $this->admin_model->delete_details($table, $application_id);

                $i = 0;

                foreach ($name1 as $k => $row) {
                    $data['application_id'] = $application_id1;
                    $data['name'] = $name1[$k];
                    $data['dob'] = date('Y-m-d', strtotime($dob2[$k]));
                    @$data['father_name'] = $father_name1[$k];
                    @$data['academic_qualification'] = $academic_qualification1[$k];
                    $data['pan'] = $pan1[$k];
                    @$data['residentail_address'] = $residentail_address1[$k];
                    @$data['state'] = $state1[$k];
                    @$data['pincode'] = $pincode1[$k];
                    $data['adress_proof_type'] = $adress_proof_type1[$k];
                    $data['address_proof_id'] = $address_proof_id1[$k];
                    $data['mobile_no'] = $mobile_no1[$k];
                    @$data['landline_no'] = $landline_no1[$k];
                    @$data['exp_in_line_activity'] = $exp_in_line_activity1[$k];
                    @$data['souce_of_other_income'] = $souce_of_other_income1[$k];
                    //@$data['know_cibil_score'] = $know_cibil_score1[$k];

                    if (!empty($know_cibil_score1[$k])) {
                        @$data['know_cibil_score'] = $know_cibil_score1[$k];
                    } else {

                        $data['know_cibil_score'] = "";
                    }

                    if (!empty($cibil_score1[$k])) {
                        @$data['cibil_score'] = $cibil_score1[$k];
                    } else {

                        $data['cibil_score'] = "";
                    }
                    //@$data['cast'] = $cast1[$k];
                    if (!empty($cast1[$k])) {
                        @$data['cast'] = $cast1[$k];
                    } else {

                        $data['cast'] = "";
                    }
                    @$data['please_specify'] = $please_specify1[$k];
                    //print_r($data); exit;
                    $update2 = $this->db->insert(TBL_OWNER_DETAILS, $data);

                    /*  $whereapplication["application_id"] = $this->input->post("application_id");
                    $table="tbl_owner_details";
                    $update2 = $this->admin_model->updateUserDetails($table,$data,$whereapplication);      */
                    $i++;
                }
                if ($update2) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/banking_credit_facilities/" . base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/banking_credit_facilities/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $whereapplication['application_id'] = $application_id;
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["owner_details"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
                    $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["enterprise_background"])) {
                        redirect("manage/dashboard/enterprise_background" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                $data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/owner_details', $data);
            }
        }
    }

    public function save_banking_credit_facilities() {
        //echo "<pre>"; print_r($_POST); exit;
        //print_r($name);
        //exit;
        $sdata["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($sdata["utype_id"] == 3 || $sdata["utype_id"] == 4 || $sdata["utype_id"] == 5) {
            redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
        }
        //---------end user type checking for view mode---------
        $application_id = $this->input->post("application_id");
        $type_of_facility = $this->input->post("type_of_facility");
        $limits = $this->input->post("limits");
        $outstanding_as_on = $this->input->post("outstanding_as_on");
        $outstanding_as_on_edit = $this->input->post("outstanding_as_on");
        $security_lodged = $this->input->post("security_lodged");

        $name_of_bank = $this->input->post("name_of_bank");
        $if_property_selected = $this->input->post("if_property_selected");
        $current_market_value = $this->input->post("current_market_value");
        $other_source_income = $this->input->post("other_source_income");
        $other_annual_income = str_replace(",", "", $this->input->post("other_annual_income"));

        $rate_of_interest = str_replace(",", "", $this->input->post("rate_of_interest"));
        //$monthly_emi_amount = $this->input->post("monthly_emi_amount");
        $monthly_emi_amount = str_replace(",", "", $this->input->post("monthly_emi_amount"));
        //$balance_tenure = $this->input->post("balance_tenure");
        $balance_tenure = str_replace(",", "", $this->input->post("balance_tenure"));
        $repayment_terms = $this->input->post("repayment_terms");
        $additional_loan_information = str_replace(",", "", $this->input->post("additional_loan_information"));

        $application_id1 = $application_id;
        $type_of_facility1 = array_values(array_filter($type_of_facility));
        /* $limits1 = array_values(array_filter($limits));
        $outstanding_as_on1 = array_values(array_filter($outstanding_as_on));
        $outstanding_as_on2 = array_values(array_filter($outstanding_as_on_edit));
        //$presently_banking_with1 = array_values(array_filter($presently_banking_with));
        //$security_lodged1 = array_values(array_filter($security_lodged));
        $rate_of_interest1 = array_values(array_filter($rate_of_interest));
        $monthly_emi_amount1 = array_values(array_filter($monthly_emi_amount));
        $balance_tenure1 = array_values(array_filter($balance_tenure));
        $repayment_terms1 = array_values(array_filter($repayment_terms)); */

        $limits1 = $limits;
        $outstanding_as_on1 = $outstanding_as_on;
        $outstanding_as_on2 = $outstanding_as_on_edit;
        //$presently_banking_with1 = array_values(array_filter($presently_banking_with));
        //$security_lodged1 = array_values(array_filter($security_lodged));
        $rate_of_interest1 = $rate_of_interest;
        $monthly_emi_amount1 = $monthly_emi_amount;
        $balance_tenure1 = $balance_tenure;
        $repayment_terms1 = $repayment_terms;
        $additional_loan_information1 = array_values(array_filter($additional_loan_information));

        $security_lodged1 = $security_lodged;
        $name_of_bank1 = $name_of_bank;
        $if_property_selected1 = $if_property_selected;
        $current_market_value1 = $current_market_value;
        $other_source_income1 = $other_source_income;
        $other_annual_income1 = $other_annual_income;

        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('type_of_facility[]', 'Type of Facility', 'trim|required|xss_clean');
            $this->form_validation->set_rules('outstanding_as_on[]', 'Outstanding as on', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $j = 0;
                $i = 0;
                @$data['additional_loan_information'] = $additional_loan_information1[$j];
                foreach ($type_of_facility1 as $k => $row) {
                    $data['application_id'] = $application_id1;
                    $data['type_of_facility'] = $type_of_facility1[$i];
                    @$data['limits'] = $limits1[$i];
                    $data['outstanding_as_on'] = date('Y-m-d', strtotime($outstanding_as_on1[$i]));
                    //$data['presently_banking_with'] = $presently_banking_with1[$i];
                    @$data['security_lodged'] = $security_lodged1[$i];
                    @$data['rate_of_interest'] = $rate_of_interest1[$i];
                    @$data['monthly_emi_amount'] = $monthly_emi_amount1[$i];
                    @$data['balance_tenure'] = $balance_tenure1[$i];
                    @$data['repayment_terms'] = $repayment_terms1[$i];

                    @$data['name_of_bank'] = $name_of_bank1[$i];
                    @$data['if_property_selected'] = $if_property_selected1[$i];
                    @$data['current_market_value'] = $current_market_value1[$i];
                    @$data['other_source_income'] = $other_source_income1[$i];
                    @$data['other_annual_income'] = $other_annual_income1[$i];

                    $add = $this->db->insert(TBL_BANKING_CREDIT_FACILITIES, $data);

                    $i++;
                }
                //}

                //$add = $this->loan_application_model->addEnterprise_background($opt);
                if ($add) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);

                    redirect("manage/dashboard/upload_documents" . "/" . base64_encode($application_id));
                } else {
                    $this->template->load('manage/main', 'loan_application/banking_credit_facilities');
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
                    $whereapplication['application_id'] = $application_id;
                    $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["banking_credit_facilities"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["owner_details"])) {
                        redirect("manage/dashboard/owner_details" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                $this->template->load('manage/main_loan', 'manage/banking_credit_facilities', $data);
            }
        } else {

            $this->form_validation->set_rules('type_of_facility[]', 'Type of Facility', 'trim|required|xss_clean');
            $this->form_validation->set_rules('outstanding_as_on[]', 'Outstanding as on', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {
                $table = "tbl_banking_credit_facilities";
                $application_id = $application_id1;
                $dele = $this->admin_model->delete_details($table, $application_id);

                $j = 0;
                $i = 0;
                $data['additional_loan_information'] = $additional_loan_information1[$j];
                foreach ($type_of_facility1 as $k => $row) {
                    $data['application_id'] = $application_id1;
                    $data['type_of_facility'] = $type_of_facility1[$i];
                    @$data['limits'] = $limits1[$i];
                    $data['outstanding_as_on'] = date('Y-m-d', strtotime($outstanding_as_on2[$i]));
                    //$data['presently_banking_with'] = $presently_banking_with1[$i];
                    @$data['security_lodged'] = $security_lodged1[$i];
                    @$data['rate_of_interest'] = $rate_of_interest1[$i];
                    @$data['monthly_emi_amount'] = $monthly_emi_amount1[$i];
                    @$data['balance_tenure'] = $balance_tenure1[$i];
                    @$data['repayment_terms'] = $repayment_terms1[$i];

                    @$data['name_of_bank'] = $name_of_bank1[$i];
                    @$data['if_property_selected'] = $if_property_selected1[$i];
                    @$data['current_market_value'] = $current_market_value1[$i];
                    @$data['other_source_income'] = $other_source_income1[$i];
                    @$data['other_annual_income'] = $other_annual_income1[$i];

                    $update2 = $this->db->insert(TBL_BANKING_CREDIT_FACILITIES, $data);

                    $i++;
                }
                if ($update2) {
                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                //-------------------Loan Details Fetching -------------------
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
                    $whereapplication['application_id'] = $application_id;
                    $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["banking_credit_facilities"]);exit;
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (empty($data["owner_details"])) {
                        redirect("manage/dashboard/owner_details" . "/" . base64_encode($application_id));
                    }
                    //----------------End-------------------
                }

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                $this->template->load('manage/main_loan', 'manage/banking_credit_facilities', $data);
            }
        }
    }

    public function save_upload_documents() {
        //echo "<pre>"; print_r($_POST); exit;
        //echo  "<pre>"; print_r($_FILES); exit;

        $data['application_id'] = $this->input->post("application_id");
        $sdata["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($sdata["utype_id"] == 3 || $sdata["utype_id"] == 4 || $sdata["utype_id"] == 5) {
            redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
        }
        //---------end user type checking for view mode---------
        $application_id = $this->input->post("application_id");

        //-----------------File Upload Section for Add and Edit Start Here----------------------------------
        $this->load->helper('form');
        $bank_name = $this->input->post("bank_name");
        $period_from_month = $this->input->post("period_from_month");
        $period_to_month = $this->input->post("period_to_month");
        $bank_name1 = array_values(array_filter($bank_name));
        //print_r($bank_name1); exit;
        $add_additional_documents_text2 = $this->input->post("add_additional_documents_text2");
        if (!empty($add_additional_documents_text2)) {
            $add_additional_documents_text21 = array_values(array_filter($add_additional_documents_text2));
        }

        //exit;
        //----------------------------End Upload TBL_UPLOAD_DOCUMENTS_OWNER-------------------------------
        if (!empty($_FILES['cibil_report'])) {
            if ($_FILES['cibil_report']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'loan_documents';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['cibil_report']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('cibil_report')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('err_message', $error);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data1["cibil_report"] = date('y-m-d-h-i-s') . $_FILES['cibil_report']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['pan_card'])) {
            if ($_FILES['pan_card']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'loan_documents';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['pan_card']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('pan_card')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('err_message', $error);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data1["pan_card"] = date('y-m-d-h-i-s') . $_FILES['pan_card']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['address_proof_company'])) {
            if ($_FILES['address_proof_company']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'loan_documents';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['address_proof_company']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('address_proof_company')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('err_message', $error);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data1["address_proof_company"] = date('y-m-d-h-i-s') . $_FILES['address_proof_company']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['vat_registration_certificate'])) {
            if ($_FILES['vat_registration_certificate']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'loan_documents';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['vat_registration_certificate']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('vat_registration_certificate')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('err_message', $error);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data1["vat_registration_certificate"] = date('y-m-d-h-i-s') . $_FILES['vat_registration_certificate']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['shop_establishment_certificate'])) {
            if ($_FILES['shop_establishment_certificate']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'loan_documents';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['shop_establishment_certificate']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('shop_establishment_certificate')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('err_message', $error);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data1["shop_establishment_certificate"] = date('y-m-d-h-i-s') . $_FILES['shop_establishment_certificate']['name'];
                }
                unset($config);
            }
        }

        //-----------------End File Upload Section for Add and Edit Start Here------------------------------
        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('bank_name[]', 'Bank Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('period_from_month[]', 'Period from month', 'trim|required');
            $this->form_validation->set_rules('period_to_month[]', 'Period to month', 'trim|required');
            if (empty($_FILES['upload_file']['name'])) {
                $this->form_validation->set_rules('upload_file[]', 'Upload file', 'trim|required');
            }
            if (empty($_FILES['pan_card']['name'])) {
                $this->form_validation->set_rules('pan_card', 'PAN card', 'trim|required');
            }
            if (empty($_FILES['address_proof_company']['name'])) {
                $this->form_validation->set_rules('address_proof_company', 'Address proof company', 'trim|required');
            }
            if (empty($_FILES['pan_card1']['name'])) {
                $this->form_validation->set_rules('pan_card1[]', 'Company PAN card', 'trim|required');
            }
            if (empty($_FILES['address_proof1']['name'])) {
                $this->form_validation->set_rules('address_proof1[]', 'Address proof', 'trim|required');
            }

            if ($this->form_validation->run()) {
                $add_additional_documents = $this->input->post("add_additional_documents");
                //Insert Command Here
                $data1["application_id"] = $application_id;
                $data1["add_additional_documents"] = $add_additional_documents;
                //--------------------Uniuqe Checking---------------------------
                $other["tables"] = "TBL_UPLOAD_DOCUMENTS";
                $whereapplication['application_id'] = $application_id;
                $upload_documents = $this->admin_model->getLoanDetails($whereapplication, $other);
                unset($other["tables"]);
                if (empty($upload_documents)) {
                    $add = $this->loan_application_model->addupload_doc($data1);
                } else {
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                }

                //--------------------END Uniuqe Checking---------------------------

                $data2["upload_id"] = $add;

                foreach ($bank_name1 as $key => $value) {
                    if (!empty($_FILES['upload_file']["name"][$key])) {
                        $files = $_FILES['upload_file'];
                        //print_r($files);exit;
                        $dir = './uploads/loan_documents/';
                        $newfilename = date('Y-m-d-h-i-s') . $_FILES["upload_file"]["name"][$key];
                        $direction = $dir . $newfilename;
                        move_uploaded_file($_FILES['upload_file']['tmp_name'][$key], $direction);
                        $data2['upload_file'] = $newfilename;
                    }
                    $data2['bank_name'] = $bank_name1[$key];
                    $data2['period_to_month'] = date('Y-m-d', strtotime($period_to_month[$key]));
                    $data2['period_from_month'] = date('Y-m-d', strtotime($period_from_month[$key]));
                    $table = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                    $add1 = $this->db->insert(TBL_UPLOAD_DOCUMENTS_ADDMORE, $data2);
                    unset($table);
                }

                $data3["upload_ids"] = $add;
                if ($this->input->post('add_additional_documents') == 1) {
                    //print_r($files);exit;
                    $dir = './uploads/loan_documents/';
                    foreach ($add_additional_documents_text21 as $key => $value) {
                        if (!empty($_FILES['add_additional_documents_file2']["name"][$key])) {
                            $files = $_FILES['add_additional_documents_file2'];
                            $newfilename = date('Y-m-d-h-i-s') . $_FILES["add_additional_documents_file2"]["name"][$key];
                            $direction = $dir . $newfilename;
                            move_uploaded_file($_FILES['add_additional_documents_file2']['tmp_name'][$key], $direction);
                            $data3['add_additional_documents_file2'] = $newfilename;
                        }
                        $data3['add_additional_documents_text2'] = $add_additional_documents_text21[$key];
                        $table = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                        $add1 = $this->db->insert(TBL_UPLOAD_DOCUMENTS_ADDITIONAL, $data3);
                        unset($table);
                    }
                }

                //if($_FILES['pan_card1']||$_FILES['address_proof1']||$_FILES['civil_score1']){
                //print_r($whereowner);exit;
                $whereowner = $this->input->post("ownerid");
                $dir = './uploads/loan_documents/';
                foreach ($whereowner as $key => $value) {
                    if (!empty($_FILES["pan_card1"]["name"][$key])) {
                        $pan_card1 = $_FILES['pan_card1'];
                        $newfilename = date('Y-m-d-h-i-s') . $_FILES["pan_card1"]["name"][$key];
                        $direction = $dir . $newfilename;
                        move_uploaded_file($_FILES['pan_card1']['tmp_name'][$key], $direction);
                        $ownerdata['pan_card1'] = $newfilename;
                        unset($newfilename);
                    }
                    if (!empty($_FILES['address_proof1']["name"][$key])) {
                        $address_proof1 = $_FILES['address_proof1'];
                        $newfilename1 = date('Y-m-d-h-i-s') . $_FILES["address_proof1"]["name"][$key];
                        $direction1 = $dir . $newfilename1;
                        move_uploaded_file($_FILES['address_proof1']['tmp_name'][$key], $direction1);
                        $ownerdata['address_proof1'] = $newfilename1;
                        unset($newfilename1);
                    }
                    if (!empty($_FILES['civil_score1']["name"][$key])) {
                        $civil_score1 = $_FILES['civil_score1'];
                        $newfilename2 = date('Y-m-d-h-i-s') . $_FILES["civil_score1"]["name"][$key];
                        $direction2 = $dir . $newfilename2;
                        move_uploaded_file($_FILES['civil_score1']['tmp_name'][$key], $direction2);
                        $ownerdata['civil_score1'] = $newfilename2;
                        unset($newfilename2);
                    }
                    $ownerdata['upload_id'] = $add;
                    //$table="TBL_UPLOAD_DOCUMENTS_OWNER";
                    $add3 = $this->db->insert(TBL_UPLOAD_DOCUMENTS_OWNER, $ownerdata);
                    unset($table, $ownerdata);
                }
                //}
                /*-----------end addmore------------------------*/

                if ($add || $add1 || $add3) {
                    $whereloan["application_id"] = $this->input->post("application_id");
                    $opt_loan['status'] = 1;
                    $table = "tbl_loan_application";
                    $update2 = $this->admin_model->updateUserDetails($table, $opt_loan, $whereloan);
                    unset($table);

                    $wh["application_id"] = $this->input->post("application_id");
                    /* $other["tables"]="TBL_ENTERPRISE_PROFILE";
                    $data["enterprise_profile"]=$this->admin_model->getUserDetails($wh,$other);
                    unset($other); */

                    $other["tables"] = "TBL_LOAN_APPLICATION";
                    $data["loan_list"] = $this->admin_model->getUserDetails($wh, $other);
                    unset($other);
                    //print_r($data["loan_list"]);

                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                    } else {

                        if ($sdata["utype_id"] == 1) {
                            $op["uid"] = $data["loan_list"][0]->msme_id;
                            $other["tables"] = "TBL_MSME";
                            $data["enterprise_profile"] = $this->admin_model->getUserDetails($op, $other);
                            unset($other);
                            //print_r($data["enterprise_profile"]); exit;

                            //start for sending Email......
                            $mail = new PHPMailer;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true; // Enable SMTP authentication
                            $mail->Username = 'assocham01@gmail.com'; // SMTP username
                            $mail->Password = 'om123456';
                            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 465; // TCP port to connect to
                            $mail->FromName = 'MyLoanassocham';
                            $mail->addAddress($data["enterprise_profile"][0]->owner_email);
                            //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                            $mail->WordWrap = 50; // Set word wrap to 50 characters
                            $mail->IsHTML(true); // Set email format to HTML
                            $mail->SMTPKeepAlive = true; // Set email format to HTML

                            $mail->Subject = 'New Loan Application # ' . $data["loan_list"][0]->application_id;
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
										<tr>
											<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
										</tr>
										<tr>
											<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
												<p style="display:block; margin:0; padding-top:10px;">Congratulations, Your loan application  #' . $data["loan_list"][0]->application_id . ' has been successfully submitted and we will get back to you in case of any additional information required by the bank</p>

												<br/>Sincerely,
												<br/>MyLoanAssocham  Team
											</p>

										</td>
									</tr>
									<tr>
										<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
										<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
									</tr>
								</table>';
                            //echo $mail->Body;die();

                            //Start for SMS
                            $phone_no = $data["enterprise_profile"][0]->mob_no;

                            $text = rawurlencode('Congratulations. Your loan application # (' . $data["loan_list"][0]->application_id . ') has been successfully submitted and we will get back to you in case of any additional information required by the bank');

                            $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                            $response = file_get_contents($url);

                            //End for SMS

                            if (!$mail->Send()) {
                                // $this->session->set_flashdata('notification', 'Please check your email to find new password');
                                //echo $mail->Body;die();
                                echo 'Message could not be sent.';
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                                exit;
                            } else {
                                //redirect("manage/dashboard");
                                $this->session->set_userdata('save_message', 1);
                                $this->pdfgen(base64_encode($this->input->post("application_id")));
                                redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                            }
                            //end for sending Email......
                        } else if ($sdata["utype_id"] == 2) {
                            if (isset($data["loan_list"][0]->channel_partner_id) && $data["loan_list"][0]->channel_partner_id != 0) {
                                $op["uid"] = $data["loan_list"][0]->channel_partner_id;
                                $other["tables"] = "TBL_CHANNEL_PARTNER";
                                $data["partner_profile"] = $this->admin_model->getUserDetails($op, $other);
                                $phone_no = $data["partner_profile"][0]->advisor_mob_no;

                                //start for sending Email......
                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true; // Enable SMTP authentication
                                $mail->Username = 'assocham01@gmail.com'; // SMTP username
                                $mail->Password = 'om123456';
                                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 465; // TCP port to connect to
                                $mail->FromName = 'MyLoanassocham';
                                $mail->addAddress($data["partner_profile"][0]->advisor_email);
                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $data["loan_list"][0]->application_id;
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
												<tr>
													<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
												</tr>
												<tr>
													<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
														<p style="display:block; margin:0; padding-top:10px;">Congratulations, Your loan application  #' . $data["loan_list"][0]->application_id . ' has been successfully submitted and we will get back to you in case of any additional information required by the bank</p>

														<br/>Sincerely,
														<br/>MyLoanAssocham  Team
													</p>

												</td>
											</tr>
											<tr>
												<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
												<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
											</tr>
										</table>';
                            } else {
                                $op["uid"] = $data["loan_list"][0]->msme_id;
                                $other["tables"] = "TBL_MSME";
                                $data["enterprise_profile"] = $this->admin_model->getUserDetails($op, $other);
                                unset($other);
                                $phone_no = $data["enterprise_profile"][0]->mob_no;

                                //start for sending Email......
                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true; // Enable SMTP authentication
                                $mail->Username = 'assocham01@gmail.com'; // SMTP username
                                $mail->Password = 'om123456';
                                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 465; // TCP port to connect to
                                $mail->FromName = 'MyLoanassocham';
                                $mail->addAddress($data["enterprise_profile"][0]->owner_email);
                                //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $data["loan_list"][0]->application_id;
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
												<tr>
													<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
												</tr>
												<tr>
													<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
														<p style="display:block; margin:0; padding-top:10px;">Congratulations, Your loan application  #' . $data["loan_list"][0]->application_id . ' has been successfully submitted and we will get back to you in case of any additional information required by the bank</p>

														<br/>Sincerely,
														<br/>MyLoanAssocham  Team
													</p>

												</td>
											</tr>
											<tr>
												<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
												<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
											</tr>
										</table>';
                            }

                            //echo $mail->Body;die();

                            //Start for SMS
                            //$phone_no = $data["enterprise_profile"][0]->mob_no;
                            //$phone_no = $data["partner_profile"][0]->advisor_mob_no;

                            $text = rawurlencode('Congratulations. Your loan application # (' . $data["loan_list"][0]->application_id . ') has been successfully submitted and we will get back to you in case of any additional information required by the bank');

                            $url = $this->sms_url . "&MobileNo=" . $phone_no . "&SenderID=ASSOCH&Message=" . $text . "&ServiceName=TEMPLATE_BASED";
                            $response = file_get_contents($url);

                            //End for SMS

                            if (!$mail->Send()) {
                                // $this->session->set_flashdata('notification', 'Please check your email to find new password');
                                //echo $mail->Body;die();
                                echo 'Message could not be sent.';
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                                exit;
                            } else {
                                //redirect("manage/dashboard");
                                $this->session->set_userdata('save_message', 1);
                                $this->pdfgen(base64_encode($this->input->post("application_id")));
                                redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                            }
                            //end for sending Email......
                        }

                        //redirect("manage/dashboard");
                    }
                } else {
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                //$application_id=base64_decode($application_id);
                $application_id = $this->input->post("application_id");
                $data["utype_id"] = $this->session->userdata('utype_id');

                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                //-------------------Loan Details Fetching -------------------
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_UPLOAD_DOCUMENTS";
                    $whereapplication['application_id'] = $application_id;
                    $data["upload_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $whereapplication['application_id'] = $application_id;
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    if (!empty($data["owner_details"]) && !empty($data["upload_documents"])) {
                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_OWNER";
                        $whereowner['upload_id'] = $data["upload_documents"][0]->id;
                        $data["owner_documents"] = $this->admin_model->getLoanDetails($whereowner, $other);
                        unset($other["tables"]);
                    }
                    //print_r($data["owner_documents"]);exit;
                    $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
                    $whereapplication['application_id'] = $application_id;
                    $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (!empty($data["upload_documents"])) {
                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                        $upload['upload_id'] = $data["upload_documents"][0]->id;
                        $data["upload_add_more"] = $this->admin_model->getLoanDetails($upload, $other);
                        unset($other["tables"]);

                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                        $uploads['upload_ids'] = $data["upload_documents"][0]->id;
                        $data["additional_documents"] = $this->admin_model->getLoanDetails($uploads, $other);
                        unset($other["tables"]);
                    } else if (empty($data["banking_credit_facilities"])) {
                        redirect("manage/dashboard/banking_credit_facilities" . "/" . base64_encode($application_id));
                    }
                    //echo "<pre>";print_r($data["upload_documents"]);"echo <br>";print_r($data["upload_add_more"]);exit;
                }
                //----------------End-------------------

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                //$data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/upload_documents', $data);
            }
        } else {

            $this->form_validation->set_rules('bank_name[]', 'Bank Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('period_from_month[]', 'Period from month', 'trim|required');
            $this->form_validation->set_rules('period_to_month[]', 'Period to month', 'trim|required');
            if ($this->form_validation->run()) {
                //----------------------------Upload TBL_UPLOAD_DOCUMENTS_ADDMORE-------------------------------
                if ($this->input->post('flag') == 1) {
                    $upload_more = $this->input->post("upload_more");
                    $bank_id = $this->input->post('bank_id');
                    $bank_add_more = $this->input->post('bank_add_more');
                    //print_r($bank_add_more);exit;
                    if (isset($bank_id) && $bank_id != '') {
                        $files = $_FILES['upload_file'];
                        //print_r($files);exit;
                        $dir = './uploads/loan_documents/';
                        foreach ($bank_id as $key => $value) {
                            if (!empty($_FILES['upload_file']["name"][$key])) {
                                $newfilename = date('Y-m-d-h-i-s') . $_FILES["upload_file"]["name"][$key];
                                $direction = $dir . $newfilename;
                                move_uploaded_file($_FILES['upload_file']['tmp_name'][$key], $direction);
                                $dataUpdate['upload_file'] = $newfilename;
                                unset($newfilename, $files);
                            }
                            $dataUpdate['bank_name'] = $bank_name1[$key];
                            $dataUpdate['period_to_month'] = date('Y-m-d', strtotime($period_to_month[$key]));
                            $dataUpdate['period_from_month'] = date('Y-m-d', strtotime($period_from_month[$key]));

                            $whereupdate["id"] = $bank_id[$key];
                            $table = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                            $add1 = $this->db->update(TBL_UPLOAD_DOCUMENTS_ADDMORE, $dataUpdate, $whereupdate);
                            unset($table);
                        }
                    }
                    if (isset($bank_add_more) && $bank_add_more != '') {
                        $files = $_FILES['upload_file1'];
                        $bank_names = $this->input->post("bank_name1");
                        $period_from_months = $this->input->post("period_from_month1");
                        $period_to_months = $this->input->post("period_to_month1");
                        $dir = './uploads/loan_documents/';
                        foreach ($bank_add_more as $key1 => $value) {
                            if (!empty($_FILES['upload_file1']["name"][$key1])) {
                                $newfilename = date('Y-m-d-h-i-s') . $_FILES["upload_file1"]["name"][$key1];
                                $direction = $dir . $newfilename;
                                move_uploaded_file($_FILES['upload_file']['tmp_name'][$key1], $direction);
                                $data2['upload_file'] = $newfilename;
                            }
                            $data2['bank_name'] = $bank_names[$key1];
                            $data2['period_to_month'] = date('Y-m-d', strtotime($period_from_months[$key1]));
                            $data2['period_from_month'] = date('Y-m-d', strtotime($period_to_months[$key1]));

                            $data2["upload_id"] = $upload_more;
                            //print_r($data2);exit;
                            $table = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                            $add1 = $this->db->insert(TBL_UPLOAD_DOCUMENTS_ADDMORE, $data2);
                            unset($table);
                        }
                    }
                    //----------------------------End Upload TBL_UPLOAD_DOCUMENTS_ADDMORE-------------------------------
                    //---------------------------Add Upload TBL_UPLOAD_DOCUMENTS_ADDITIONAL-----------------------------
                    if ($this->input->post('add_additional_documents') == 1) {
                        $additional_documents = $this->input->post("additional_documents");
                        $additional_documents_addmore = $this->input->post("additional_documents_addmore");
                        if (isset($additional_documents) && $additional_documents != '') {
                            //print_r($files);exit;
                            $dir = './uploads/loan_documents/';
                            foreach ($additional_documents as $dkey => $value) {
                                if (!empty($_FILES['add_additional_documents_file2']["name"][$dkey])) {
                                    $files = $_FILES['add_additional_documents_file2'];
                                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["add_additional_documents_file2"]["name"][$dkey];
                                    $direction = $dir . $newfilename;
                                    move_uploaded_file($_FILES['add_additional_documents_file2']['tmp_name'][$dkey], $direction);
                                    $data2update['add_additional_documents_file2'] = $newfilename;
                                    unset($newfilename, $files);
                                }
                                $data2update['add_additional_documents_text2'] = $add_additional_documents_text21[$dkey];
                                $whereadditional["id"] = $additional_documents[$dkey];
                                $table = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                                $update_additional = $this->db->update(TBL_UPLOAD_DOCUMENTS_ADDITIONAL, $data2update, $whereadditional);
                                unset($table);
                            }
                        }
                        if (isset($additional_documents_addmore) && $additional_documents_addmore != '') {
                            foreach ($additional_documents_addmore as $sdk => $row) {
                                $additional_text = $this->input->post("add_additional_documents_text21");
                                if (!empty($_FILES['add_additional_documents_file21']["name"][$sdk])) {
                                    $files = $_FILES['add_additional_documents_file21'];
                                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["add_additional_documents_file21"]["name"][$sdk];
                                    $direction = $dir . $newfilename;
                                    move_uploaded_file($_FILES['add_additional_documents_file21']['tmp_name'][$sdk], $direction);
                                    $datas5['add_additional_documents_file2'] = $newfilename;
                                    unset($newfilename, $files);
                                }
                                $datas5['add_additional_documents_text2'] = $additional_text[$sdk];
                                $datas5["upload_ids"] = $upload_more;
                                $table = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                                $add1 = $this->db->insert(TBL_UPLOAD_DOCUMENTS_ADDITIONAL, $datas5);
                                unset($table);
                            }
                        }
                    }
                    //---------------------------End Upload TBL_UPLOAD_DOCUMENTS_ADDITIONAL-----------------------------
                    //----------------------------Upload TBL_UPLOAD_DOCUMENTS_OWNER-------------------------------
                    //if($_FILES['pan_card1']||$_FILES['address_proof1']||$_FILES['civil_score1']){
                    $whereowner = $this->input->post('ownerid');
                    $whereownerid = $this->input->post('owner_documents_id');
                    //print_r($whereowner);exit;
                    $dir = './uploads/loan_documents/';
                    foreach ($whereownerid as $ownerkey => $value) {
                        if (!empty($_FILES['pan_card1']["name"][$ownerkey])) {
                            $pan_card1 = $_FILES['pan_card1'];
                            $newfilename = date('Y-m-d-h-i-s') . $_FILES["pan_card1"]["name"][$ownerkey];
                            $direction = $dir . $newfilename;
                            move_uploaded_file($_FILES['pan_card1']['tmp_name'][$ownerkey], $direction);
                            $ownerdata['pan_card1'] = $newfilename;
                            unset($newfilename);
                        }
                        if (!empty($_FILES['address_proof1']["name"][$ownerkey])) {
                            $address_proof1 = $_FILES['address_proof1'];
                            $newfilename = date('Y-m-d-h-i-s') . $_FILES["address_proof1"]["name"][$ownerkey];
                            $direction = $dir . $newfilename;
                            move_uploaded_file($_FILES['address_proof1']['tmp_name'][$ownerkey], $direction);
                            $ownerdata['address_proof1'] = $newfilename;
                            unset($newfilename);
                        }
                        if (!empty($_FILES['civil_score1']["name"][$ownerkey])) {
                            $civil_score1 = $_FILES['civil_score1'];
                            $newfilename = date('Y-m-d-h-i-s') . $_FILES["civil_score1"]["name"][$ownerkey];
                            $direction = $dir . $newfilename;
                            move_uploaded_file($_FILES['civil_score1']['tmp_name'][$ownerkey], $direction);
                            $ownerdata['civil_score1'] = $newfilename;
                            unset($newfilename);
                        }
                        //print_r($ownerdata);exit;
                        $table = "tbl_upload_documents_owner";
                        $whereownerdata['id'] = $whereownerid[$ownerkey];
                        if (!empty($ownerdata)) {
                            $add2 = $this->db->update(TBL_UPLOAD_DOCUMENTS_OWNER, $ownerdata, $whereownerdata);
                            unset($table, $ownerdata);
                        }
                    }
                    //}
                }

                $add_additional_documents = $this->input->post("add_additional_documents");
                //Insert Command Here
                $app["application_id"] = $application_id;

                $data1["add_additional_documents"] = $add_additional_documents;
                //$data1["add_additional_documents_text1"]=$add_additional_documents_text1;
                $table = "TBL_UPLOAD_DOCUMENTS";
                $add = $this->loan_application_model->updateupload($data1, $app, $table);
                unset($table);

                /*-----------end addmore------------------------*/
                //echo "rj";exit;
                if ($add || $add1) {
                    //$this->session->set_userdata('error_message',1);

                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        $this->pdfgen(base64_encode($this->input->post("application_id")));
                        $this->session->set_userdata('save_message', 1);
                        redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                    } else {
                        redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                    }
                } else {
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/upload_documents/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                //echo "dsfasdf"; exit;
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                //$application_id=base64_decode($application_id);
                $application_id = $this->input->post("application_id");
                $data["utype_id"] = $this->session->userdata('utype_id');

                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                //-------------------Loan Details Fetching -------------------
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_UPLOAD_DOCUMENTS";
                    $whereapplication['application_id'] = $application_id;
                    $data["upload_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $whereapplication['application_id'] = $application_id;
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    if (!empty($data["owner_details"]) && !empty($data["upload_documents"])) {
                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_OWNER";
                        $whereowner['upload_id'] = $data["upload_documents"][0]->id;
                        $data["owner_documents"] = $this->admin_model->getLoanDetails($whereowner, $other);
                        unset($other["tables"]);
                    }
                    //print_r($data["owner_documents"]);exit;
                    $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
                    $whereapplication['application_id'] = $application_id;
                    $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    unset($other["tables"]);
                    if (!empty($data["upload_documents"])) {
                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
                        $upload['upload_id'] = $data["upload_documents"][0]->id;
                        $data["upload_add_more"] = $this->admin_model->getLoanDetails($upload, $other);
                        unset($other["tables"]);

                        $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
                        $uploads['upload_ids'] = $data["upload_documents"][0]->id;
                        $data["additional_documents"] = $this->admin_model->getLoanDetails($uploads, $other);
                        unset($other["tables"]);
                    } else if (empty($data["banking_credit_facilities"])) {
                        redirect("manage/dashboard/banking_credit_facilities" . "/" . base64_encode($application_id));
                    }
                    //echo "<pre>";print_r($data["upload_documents"]);"echo <br>";print_r($data["upload_add_more"]);exit;
                }
                //----------------End-------------------

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                //$data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/upload_documents', $data);
            }
        }
    }

    public function save_analyst_upload_doc() {

        //echo "<pre>"; print_r($_POST); exit;
        //echo "<pre>"; print_r($_FILES); exit;

        $application_id = $this->input->post("application_id");
        $id["uid"] = $this->session->userdata('sesuserId');

        $sdata["utype_id"] = $this->session->userdata('utype_id');
        //---------user type checking for view mode---------
        if ($sdata["utype_id"] == 4 || $sdata["utype_id"] == 5) {
            redirect("manage/dashboard/bank_application_status/" . base64_encode($application_id));
        }
        //---------end user type checking for view mode---------

        $pan_card = $this->input->post("pan_card");
        //$pan_card_file = $this->input->post("pan_card_file");
        $address_proof_company = $this->input->post("address_proof_company");
        $vat_registration_certificate = $this->input->post("vat_registration_certificate");
        $shop_establishment_certificate = $this->input->post("shop_establishment_certificate");
        $cibil_report = $this->input->post("cibil_report");
        $defaulter_list = $this->input->post("defaulter_list");
        $type_of_defaulter = $this->input->post("type_of_defaulter");
        $director1_name_address = $this->input->post("director1_name_address");
        $director1_name_id = $this->input->post("director1_name_id");
        $director1_name_cibilscore = $this->input->post("director1_name_cibilscore");

        //-------------------------Analyst Documents Add and Edit------------------------------------
        if ($this->input->post("flag") != 1) {
            //echo "rj";exit;
            $ownerid = $this->input->post("ownerid");
            //print_r($_FILES['director1_name_address_file']["name"]);exit;
            $dir = './uploads/analyst_document/';
            foreach ($ownerid as $skey => $value) {
                //print_r($_FILES['director1_name_address_file']["name"][2]);exit;
                if (!empty($_FILES['director1_name_address_file']["name"][$skey])) {
                    //echo "rj";exit;
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_address_file"]["name"][$skey];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_address_file']['tmp_name'][$skey], $direction);
                    $data1['director1_name_address_file'] = $newfilename;
                    unset($newfilename);
                }
                //echo "singh";exit;
                if (!empty($_FILES['director1_name_file']["name"][$skey])) {
                    $director1_name_file = $_FILES['director1_name_file'];
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_file"]["name"][$skey];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_file']['tmp_name'][$skey], $direction);
                    $data1['director1_name_file'] = $newfilename;
                    unset($newfilename);
                }
                if (!empty($_FILES['director1_name_cibilscore_file']["name"][$skey])) {
                    $director1_name_cibilscore_file = $_FILES['director1_name_cibilscore_file'];
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_cibilscore_file"]["name"][$skey];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_cibilscore_file']['tmp_name'][$skey], $direction);
                    $data1['director1_name_cibilscore_file'] = $newfilename;
                    unset($newfilename);
                }
                $data1["application_id"] = $application_id;
                $data1["director1_name_address"] = $director1_name_address[$skey];
                $data1["director1_name_id"] = $director1_name_id[$skey];
                $data1["director1_name_cibilscore"] = $director1_name_cibilscore[$skey];
                if (!empty($data1)) {
                    $add1 = $this->db->insert('tbl_analyst_director_documents', $data1);
                    unset($data1);
                }
            }
        } else {
            $analyst_director_documents = $this->input->post("analyst_director");
            $dir = './uploads/analyst_document/';
            foreach ($analyst_director_documents as $key => $value) {
                if (!empty($_FILES['director1_name_address_file']["name"][$key])) {
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_address_file"]["name"][$key];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_address_file']['tmp_name'][$key], $direction);
                    $data1['director1_name_address_file'] = $newfilename;
                    unset($newfilename);
                }
                if (!empty($_FILES['director1_name_file']["name"][$key])) {
                    $director1_name_file = $_FILES['director1_name_file'];
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_file"]["name"][$key];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_file']['tmp_name'][$key], $direction);
                    $data1['director1_name_file'] = $newfilename;
                    unset($newfilename);
                }
                if (!empty($_FILES['director1_name_cibilscore_file']["name"][$key])) {
                    $director1_name_cibilscore_file = $_FILES['director1_name_cibilscore_file'];
                    $newfilename = date('Y-m-d-h-i-s') . $_FILES["director1_name_cibilscore_file"]["name"][$key];
                    $direction = $dir . $newfilename;
                    move_uploaded_file($_FILES['director1_name_cibilscore_file']['tmp_name'][$key], $direction);
                    $data1['director1_name_cibilscore_file'] = $newfilename;
                    unset($newfilename);
                }
                $data1["application_id"] = $application_id;
                $data1["director1_name_address"] = $director1_name_address[$key];
                $data1["director1_name_id"] = $director1_name_id[$key];
                $data1["director1_name_cibilscore"] = $director1_name_cibilscore[$key];
                $wheredata1["id"] = $analyst_director_documents[$key];
                if (!empty($data1)) {
                    $add1 = $this->db->update('tbl_analyst_director_documents', $data1, $wheredata1);
                    unset($data1);
                }
            }
        }

        $this->load->helper('form');
        if (!empty($_FILES['pan_card_file'])) {
            if ($_FILES['pan_card_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['pan_card_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('pan_card_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["pan_card_file"] = date('y-m-d-h-i-s') . $_FILES['pan_card_file']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['address_proof_company_file'])) {
            if ($_FILES['address_proof_company_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['address_proof_company_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('address_proof_company_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["address_proof_company_file"] = date('y-m-d-h-i-s') . $_FILES['address_proof_company_file']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['vat_registration_certificate_file'])) {
            if ($_FILES['vat_registration_certificate_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['vat_registration_certificate_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('vat_registration_certificate_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["vat_registration_certificate_file"] = date('y-m-d-h-i-s') . $_FILES['vat_registration_certificate_file']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['shop_establishment_certificate_file'])) {
            if ($_FILES['shop_establishment_certificate_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['shop_establishment_certificate_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('shop_establishment_certificate_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["shop_establishment_certificate_file"] = date('y-m-d-h-i-s') . $_FILES['shop_establishment_certificate_file']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['cibil_report_file'])) {
            if ($_FILES['cibil_report_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['cibil_report_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('cibil_report_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["cibil_report_file"] = date('y-m-d-h-i-s') . $_FILES['cibil_report_file']['name'];
                }
                unset($config);
            }
        }
        if (!empty($_FILES['type_of_defaulter_file'])) {
            if ($_FILES['type_of_defaulter_file']['error'] == 0) {
                $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
                $config['allowed_types'] = 'jpg|jpeg|JPEG|JPG|pdf|PDF';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = false;
                $config['upload_path'] = $sPath . 'analyst_document';
                $config['x_axis'] = '68';
                $config['y_axis'] = '68';
                $config['max_size'] = '2048';
                $config['file_name'] = date('y-m-d-h-i-s') . $_FILES['type_of_defaulter_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('type_of_defaulter_file')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('error_message', $error);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                } else {
                    $data["type_of_defaulter_file"] = date('y-m-d-h-i-s') . $_FILES['type_of_defaulter_file']['name'];
                }
                unset($config);
            }
        }
        //-------------------------End Analyst Documents Add and Edit--------------------------------

        if ($this->input->post("flag") != 1) {
            $this->form_validation->set_rules('pan_card', 'PAN Card', 'trim|required');
            $this->form_validation->set_rules('address_proof_company', 'Address Proof of Company', 'trim|required');
            $this->form_validation->set_rules('vat_registration_certificate', 'VAT Registration Certificate', 'trim|required');
            $this->form_validation->set_rules('shop_establishment_certificate', 'Shop Establishment Certificate', 'trim|required');
            $this->form_validation->set_rules('cibil_report', 'CIBIL Report', 'trim|required');
            $this->form_validation->set_rules('defaulter_list', 'Defaulter List', 'trim|required');
            /* $this->form_validation->set_rules('director1_name_address[]','Owner Address','trim|required|xss_clean');
            $this->form_validation->set_rules('director1_name_id[]','Owner Id','trim|required|xss_clean');
            $this->form_validation->set_rules('director1_name_cibilscore[]','Owner Cibilscore','trim|required|xss_clean'); */

            if ($this->form_validation->run()) {
                //Insert Command Here
                $other["tables"] = "TBL_ANALYST";
                $ot["user_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                $data["analyst_id"] = $ot["user_details"][0]->uid;
                $data["application_id"] = $application_id;

                $data["pan_card"] = $pan_card;
                $data["address_proof_company"] = $address_proof_company;
                $data["vat_registration_certificate"] = $vat_registration_certificate;
                $data["shop_establishment_certificate"] = $shop_establishment_certificate;
                $data["cibil_report"] = $cibil_report;
                $data["defaulter_list"] = $defaulter_list;
                $data["type_of_defaulter"] = $type_of_defaulter;

                $data1["application_id"] = $application_id;

                $add = $this->db->insert('tbl_analyst_documents', $data);

                if ($add1) {
                    $whereloan["application_id"] = $this->input->post("application_id");
                    $opt_loan['status'] = 2;
                    $table = "tbl_loan_application";
                    $update2 = $this->admin_model->updateUserDetails($table, $opt_loan, $whereloan);
                    unset($table);
                    $this->session->set_userdata('error_message', 1);
                    $other["tables"] = "TBL_ANALYST_DOCUMENTS";
                    $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereloan, $other);
                    //echo "<pre>";print_r($data["analyst_documents"]);
                    unset($other["tables"]);

                    if ($data["analyst_documents"][0]->pan_card != '') {
                        $pan_card = ($data["analyst_documents"][0]->pan_card == 1) ? "Incorrect" : "Correct";
                    }
                    if ($data["analyst_documents"][0]->shop_establishment_certificate != '') {
                        $shop_establishment_certificate = ($data["analyst_documents"][0]->shop_establishment_certificate == 1) ? "Incorrect" : "Correct";
                    }
                    if ($data["analyst_documents"][0]->cibil_report != '') {
                        $cibil_report = ($data["analyst_documents"][0]->cibil_report == 1) ? "Incorrect" : "Correct";
                    }
                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                    } else {
                        $other["tables"] = "TBL_BANK_MASTER";
                        $data["bank_list"] = $this->admin_model->getbank($other);
                        unset($other);
                        //for sms
                        $wh["application_id"] = $this->input->post("application_id");
                        $other["tables"] = "TBL_LOAN_APPLICATION";
                        $loan_list = $this->admin_model->getUserDetails($wh, $other);
                        unset($other);
                        if ($loan_list[0]->channel_partner_id == 0) {
                            $where["uid"] = $loan_list[0]->msme_id;
                            $other["tables"] = "TBL_MSME";
                            $data["msme_details"] = $this->admin_model->getUserDetails($where, $other);
                            $phone_no = $data["msme_details"][0]->mob_no;

                            $wh_loan["application_id"] = $this->input->post("application_id");
                            $other["tables"] = "TBL_LOAN_REQUIREMENT";
                            $loan = $this->admin_model->getLoanDetails($wh_loan, $other);
                            unset($other);

                            $op["uid"] = $loan_list[0]->msme_id;
                            $other["tables"] = "TBL_MSME";
                            $data["enterprise_profile"] = $this->admin_model->getUserDetails($op, $other);
                            unset($other);

                            //----------------------------Msme Email In case Of Analyst Doc-----------------------//
                            $mail = new PHPMailer;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true; // Enable SMTP authentication
                            $mail->Username = 'assocham01@gmail.com'; // SMTP username
                            $mail->Password = 'om123456';
                            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 465; // TCP port to connect to
                            $mail->FromName = 'MyLoanassocham';
                            $mail->addAddress($data["enterprise_profile"][0]->owner_email);
                            //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                            $mail->WordWrap = 50; // Set word wrap to 50 characters
                            $mail->IsHTML(true); // Set email format to HTML
                            $mail->SMTPKeepAlive = true; // Set email format to HTML

                            $mail->Subject = 'New Loan Application # ' . $loan_list[0]->application_id;
                            $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $data["enterprise_profile"][0]->owner_name . '</p>
								<p style="display:block; margin:0; padding-top:10px;">1.Pan Card uploaded  images is ' . $pan_card . '</p>
								<p style="display:block; margin:0; padding-top:10px;">2.Shop Establishment Certificate is ' . $shop_establishment_certificate . '</p>
								<p style="display:block; margin:0; padding-top:10px;">3.CIBIL Record uploaded file is ' . $cibil_report . '</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team
							</p>

						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                            //echo $mail->Body;die();
                            if (!$mail->Send()) {
                                echo 'Message could not be sent.';
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                                exit;
                            }
                            unset($mail);
                            //----------------------------End Msme Email In case Of Analyst Doc-----------------------//
                            /* $text    = urlencode('Dear user,
                            Your loan application forwarded to bank.
                            Your loan application ID : '.$whereloan["application_id"]);

                            $url = "http://sms.peakpoint.co/sendsmsv2.asp?user=datagrid&password=data%40%23123&phonenumber=".$phone_no."&sender=DATAGR&track=1&text=".$text;
                            $response = file_get_contents($url);  */
                            //end sms
                            foreach ($data["bank_list"] as $val) {
                                //print_r($val); exit;
                                //start for sending Email......
                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true; // Enable SMTP authentication
                                $mail->Username = 'assocham01@gmail.com'; // SMTP username
                                $mail->Password = 'om123456';
                                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 465; // TCP port to connect to
                                $mail->FromName = 'MyLoanassocham';
                                $mail->addAddress($val->email);
                                //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $whereloan["application_id"];
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $val->bank_name . '</p>

								<p style="display:block; margin:0; padding-top:10px;">Loan application # ' . $whereloan["application_id"] . ' from ' . $data["msme_details"][0]->enterprise_name . '(name of customer) for a ' . $loan[0]->type_of_facility . '(loan product) for Rs ' . $loan[0]->Amount . '  (loan amount)  has been forwarded to your bank . Please access your myloanassocham account for detailed application</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team
							</p>

						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                                //echo $mail->Body;die();

                                if (!$mail->Send()) {
                                    // $this->session->set_flashdata('notification', 'Please check your email to find new password');
                                    //echo $mail->Body;die();
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    exit;
                                } else {
                                    //redirect("manage/dashboard");
                                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                                    $this->session->set_userdata('save_message', 1);
                                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                                }
                                //end for sending Email......

                                //redirect("manage/dashboard");
                            }
                        } else {

                            if (isset($loan_list[0]->channel_partner_id) && $loan_list[0]->channel_partner_id != 0) {
                                $op["uid"] = $loan_list[0]->channel_partner_id;
                                $other["tables"] = "TBL_CHANNEL_PARTNER";
                                $data["channel_details"] = $this->admin_model->getUserDetails($op, $other);
                                $phone_no = $data["channel_details"][0]->advisor_mob_no;
                            } else {
                                $op["uid"] = $loan_list[0]->msme_id;
                                $other["tables"] = "TBL_MSME";
                                $data["enterprise_profile"] = $this->admin_model->getUserDetails($op, $other);
                                $phone_no = $data["msme_details"][0]->mob_no;
                                unset($other);
                            }

                            //----------------------------Msme Email In case Of Analyst Doc-----------------------//
                            $mail = new PHPMailer;
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true; // Enable SMTP authentication
                            $mail->Username = 'assocham01@gmail.com'; // SMTP username
                            $mail->Password = 'om123456';
                            $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 465; // TCP port to connect to
                            $mail->FromName = 'MyLoanassocham';
                            //$mail->addAddress($data["channel_details"][0]->advisor_email);
                            if (isset($data["loan_list"][0]->channel_partner_id) && $data["loan_list"][0]->channel_partner_id != 0) {
                                $mail->addAddress($data["partner_profile"][0]->advisor_email);

                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $loan_list[0]->application_id;
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $data["channel_details"][0]->advisor_name . '</p>
								<p style="display:block; margin:0; padding-top:10px;">1.Pan Card uploaded  images is ' . $pan_card . '</p>
								<p style="display:block; margin:0; padding-top:10px;">2.Shop Establishment certificate is ' . $shop_establishment_certificate . '</p>
								<p style="display:block; margin:0; padding-top:10px;">3.CIBIL Record uploaded file is ' . $cibil_report . '</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team
							</p>

						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                                //echo $mail->Body;die();
                                if (!$mail->Send()) {
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    exit;
                                }
                                unset($mail);
                            } else {
                                $mail->addAddress($data["enterprise_profile"][0]->owner_email);
                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $loan_list[0]->application_id;
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
						<tr>
							<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
						</tr>
						<tr>
							<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
								<p>Dear ' . $data["enterprise_profile"][0]->owner_name . '</p>
								<p style="display:block; margin:0; padding-top:10px;">1.Pan Card uploaded  images is ' . $pan_card . '</p>
								<p style="display:block; margin:0; padding-top:10px;">2.Shop Establishment certificate is ' . $shop_establishment_certificate . '</p>
								<p style="display:block; margin:0; padding-top:10px;">3.CIBIL Record uploaded file is ' . $cibil_report . '</p>

								<br/>Sincerely,
								<br/>MyLoanAssocham  Team
							</p>

						</td>
					</tr>
					<tr>
						<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
						<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
					</tr>
				</table>';
                                //echo $mail->Body;die();
                                if (!$mail->Send()) {
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    exit;
                                }
                                unset($mail);
                            }

                            //----------------------------End Msme Email In case Of Analyst Doc-----------------------//

                            /* $text    = urlencode('Dear user,
                            Your loan application forwarded to bank.
                            Your loan application ID : '.$whereloan["application_id"]);

                            $url = "http://sms.peakpoint.co/sendsmsv2.asp?user=datagrid&password=data%40%23123&phonenumber=".$phone_no."&sender=DATAGR&track=1&text=".$text;
                            $response = file_get_contents($url);  */
                            //end sms
                            foreach ($data["bank_list"] as $val) {
                                //print_r($val); exit;
                                //start for sending Email......
                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true; // Enable SMTP authentication
                                $mail->Username = 'assocham01@gmail.com'; // SMTP username
                                $mail->Password = 'om123456';
                                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 465; // TCP port to connect to
                                $mail->FromName = 'MyLoanassocham';
                                $mail->addAddress($val->email);
                                //$mail->AddAddress($options["email_id"]);                 // Add a recipient
                                $mail->WordWrap = 50; // Set word wrap to 50 characters
                                $mail->IsHTML(true); // Set email format to HTML
                                $mail->SMTPKeepAlive = true; // Set email format to HTML

                                $mail->Subject = 'New Loan Application # ' . $whereloan["application_id"];
                                $mail->Body = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
							<tr>
								<td height="70" colspan="2"><img src="' . base_url() . 'assets/front/images/logo.png"/></td>
							</tr>
							<tr>
								<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
									<p>Dear ' . $val->bank_name . '</p>

									<p style="display:block; margin:0; padding-top:10px;">Loan application # ' . $whereloan["application_id"] . ' from ' . $data["channel_details"][0]->advisor_name . '(name of customer) for a ' . $loan[0]->type_of_facility . '(loan product) for Rs ' . $loan[0]->Amount . '(loan amount)  has been forwarded to your bank . Please access your myloanassocham account for detailed application</p>

									<br/>Sincerely,
									<br/>MyLoanAssocham  Team
								</p>

							</td>
						</tr>
						<tr>
							<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
							<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
						</tr>
					</table>';
                                //echo $mail->Body;die();

                                if (!$mail->Send()) {
                                    // $this->session->set_flashdata('notification', 'Please check your email to find new password');
                                    //echo $mail->Body;die();
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    exit;
                                } else {
                                    //redirect("manage/dashboard");
                                    $this->pdfgen(base64_encode($this->input->post("application_id")));
                                    $this->session->set_userdata('save_message', 1);
                                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                                }
                                //end for sending Email......

                                //redirect("manage/dashboard");
                            }
                        }
                    }
                } else {
                    $this->template->load('manage/main', 'manage/analyst_documents', $data);
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                $data["analyst_id"] = $this->session->userdata('sesuserId');

                //$application_id=base64_decode($application_id);
                $application_id = $this->input->post("application_id");
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                //-------------------Loan Details Fetching -------------------
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_ANALYST_DOCUMENTS";
                    $whereapplication['application_id'] = $application_id;
                    $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["analyst_documents"]);
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    $other["tables"] = "TBL_ANALYST_DIRECTOR_DOCUMENTS";
                    $data["analyst_director_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["analyst_director_documents"]);exit;
                    unset($other["tables"]);
                }
                //----------------End-------------------

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                //$data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/analyst_documents', $data);
            }
        } else {
            $this->form_validation->set_rules('pan_card', 'PAN Card', 'trim|required');
            $this->form_validation->set_rules('address_proof_company', 'Address Proof of Company', 'trim|required');
            $this->form_validation->set_rules('vat_registration_certificate', 'VAT Registration Certificate', 'trim|required');
            $this->form_validation->set_rules('shop_establishment_certificate', 'Shop Establishment Certificate', 'trim|required');
            $this->form_validation->set_rules('cibil_report', 'CIBIL Report', 'trim|required');
            $this->form_validation->set_rules('defaulter_list', 'Defaulter List', 'trim|required');
            /* $this->form_validation->set_rules('director1_name_address[]','Owner Address','trim|required|xss_clean');
            $this->form_validation->set_rules('director1_name_id[]','Owner Id','trim|required|xss_clean');
            $this->form_validation->set_rules('director1_name_cibilscore[]','Owner Cibilscore','trim|required|xss_clean'); */

            if ($this->form_validation->run()) {
                $application_id = $this->input->post("application_id");

                $data["pan_card"] = $pan_card;
                $data["address_proof_company"] = $address_proof_company;
                $data["vat_registration_certificate"] = $vat_registration_certificate;
                $data["shop_establishment_certificate"] = $shop_establishment_certificate;
                $data["cibil_report"] = $cibil_report;
                $data["defaulter_list"] = $defaulter_list;
                $data["type_of_defaulter"] = $type_of_defaulter;
                //print_r($data);exit;
                $table = "TBL_ANALYST_DOCUMENTS";
                $whereapp['application_id'] = $application_id;
                $add = $this->loan_application_model->update_analyst_document($data, $whereapp, $table);
                unset($table);

                //Insert Command Here
                if ($add1 || $add) {
                    if (isset($_POST["submit"]) && $_POST["submit"] == 1) {
                        //redirect("manage/dashboard");
                        $this->session->set_userdata('save_message', 1);
                        $this->pdfgen(base64_encode($this->input->post("application_id")));
                        redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                    } else {

                        redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                    }
                } else {
                    $this->session->set_userdata('error_message', 1);
                    redirect("manage/dashboard/analyst_documents/" . base64_encode($this->input->post("application_id")));
                }
            } else {
                $data["sesuserId"] = $this->session->userdata('sesuserId');
                $data["sesuserName"] = $this->session->userdata('sesuserName');
                $data["utype_id"] = $this->session->userdata('utype_id');
                $data["analyst_id"] = $this->session->userdata('sesuserId');

                //$application_id=base64_decode($application_id);
                $application_id = $this->input->post("application_id");
                if (!empty($application_id)) {
                    $data["application_id"] = $application_id;
                }
                //-------------------Loan Details Fetching -------------------
                if (isset($application_id) && $application_id != '') {
                    $other["tables"] = "TBL_ANALYST_DOCUMENTS";
                    $whereapplication['application_id'] = $application_id;
                    $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["analyst_documents"]);
                    unset($other["tables"]);
                    $other["tables"] = "TBL_OWNER_DETAILS";
                    $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    $other["tables"] = "TBL_ANALYST_DIRECTOR_DOCUMENTS";
                    $data["analyst_director_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
                    //echo "<pre>";print_r($data["analyst_director_documents"]);exit;
                    unset($other["tables"]);
                }
                //----------------End-------------------

                $id["uid"] = $this->session->userdata('userId');
                $name = $this->admin_model->getUsers($id);
                //$data["name"]=$name[0]->name;
                //$data["state"] = $this->user_model->fetch_state();

                $this->template->load('manage/main_loan', 'manage/analyst_documents', $data);
            }
        }
    }

    public function changepassword() {

        $data["utype_id"] = $this->session->userdata('utype_id');
        $id["u.uid"] = $this->session->userdata('sesuserId');
        $Details = $this->admin_model->getUsers($id);
        $data["name"] = $Details[0]->name;

        $this->form_validation->set_rules('currpassword', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required');
        $this->form_validation->set_rules('conpassword', 'Confirm Password', 'trim|required|matches[newpassword]');
        //$print_r($data);
        if ($this->form_validation->run()) {
            $currpassword = $_POST['currpassword'];
            $newpassword = $_POST['newpassword'];
            $conpassword = $_POST['conpassword'];

            $option = ['password' => $this->admin_model->_prep_password($currpassword)];
            $user = $this->admin_model->getUsers($option);
            if ($user) {
                $where = ['uid' => $this->session->userdata('sesuserId')];
                //print_r($where);die();
                $option = ['password' => $this->admin_model->_prep_password($newpassword)];
                $this->admin_model->updatePassword($option, $where);
                $data["message"] = "You have successfully changed your Password";
                $this->template->load('manage/main', 'manage/changepassword', $data);
            } else {

                $data["error"] = "You have entered wrong Password";
                $this->template->load('manage/main', 'manage/changepassword', $data);
            }
        } else {
            $this->template->load('manage/main', 'manage/changepassword', $data);
        }
    }

    public function mydetails($msg = "") {

        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $data["utype_id"] = $this->session->userdata('utype_id');
        $id["uid"] = $this->session->userdata('sesuserId');
        $Details = $this->admin_model->getUsers($id);
        //$data["name"]=$Details[0]->name;
        $data["state"] = $this->user_model->fetch_state();
        //$data["city"] = $this->user_model->fetch_city_name();

        if ($data["utype_id"] == 1) {
            $other["tables"] = "TBL_MSME";
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            $op["c.id"] = $data["user_details"][0]->city;
            $data["city"] = $this->user_model->fetch_city_name($op);
            unset($other["tables"]);
            //echo "<pre>"; print_r($data); exit;
            $this->template->load('manage/main', "manage/msme_details", $data);
        } else if ($data["utype_id"] == 2) {
            $other["tables"] = "TBL_CHANNEL_PARTNER";
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $data["msg"] = "data save";
            $this->template->load('manage/main', "manage/channel_partner_details", $data);
        } else if ($data["utype_id"] == 3) {
            $other["tables"] = "TBL_ANALYST";
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            //print_r($data); exit;
            $this->template->load('manage/main', "manage/analyst_details", $data);
        } else if ($data["utype_id"] == 4) {
            $other["tables"] = "TBL_BANK_MASTER";
            $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_BANK_EMPLOYEE";
            $data["emp_details"] = $this->admin_model->getUserDetails($id, $other);
            //print_r($data["emp_details"]);
            $this->template->load('manage/main_filter', "manage/bank_details", $data);
        } else {
            unset($data["state"], $data["city"]);
            $other["tables"] = "TBL_ADMIN";
            $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
            unset($other["tables"]);
            //print_r($data); exit;
            $this->template->load('manage/main', "manage/admin_details", $data);
        }
    }

    public function save_details() {
        //print_r($_POST); exit;
        $data["utype_id"] = $this->session->userdata('utype_id');
        $data["sesuserId"] = $this->session->userdata('sesuserId');
        $data["sesuserName"] = $this->session->userdata('sesuserName');

        $id["uid"] = $this->session->userdata('sesuserId');
        $Details = $this->admin_model->getUsers($id);
        $data["name"] = $Details[0]->name;
        $data["state"] = $this->user_model->fetch_state();
        $data["city"] = $this->user_model->fetch_city_name();
        if ($data["utype_id"] == 1) {
            $this->form_validation->set_rules('enterprise_name', 'Enterprise Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('constitution', ' Legal Entity', 'trim|required');
            $this->form_validation->set_rules('owner_name', 'Director Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('owner_email', 'Owner email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('mob_no', 'Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('pan_firm', 'PAN of Firm', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('latest_audited_turnover', 'Latest Audited Turnover', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('password', 'Select Password', 'trim');
            $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');

            if ($this->form_validation->run()) {
                $table = "tbl_msme";
                $options["enterprise_name"] = $this->input->post("enterprise_name");
                $options["owner_name"] = $this->input->post("owner_name");
                $options["constitution"] = $this->input->post("constitution");
                //$options["category"]    =     $this->input->post("category");
                $options["pan_firm"] = $this->input->post("pan_firm");
                $options["owner_email"] = $this->input->post("owner_email");
                $options["address1"] = $this->input->post("address1");
                $options["address2"] = $this->input->post("address2");
                $options["state"] = $this->input->post("state");
                $options["city"] = $this->input->post("city");
                $options["pincode"] = $this->input->post("pincode");
                $options["mob_no"] = $this->input->post("mob_no");
                $options["landline_no"] = $this->input->post("landline_no");
                //$options["latest_audited_turnover"]    =     $this->input->post("latest_audited_turnover");
                $options["latest_audited_turnover"] = str_replace(",", "", $this->input->post("latest_audited_turnover"));
                $this->admin_model->updateUserDetails($table, $options, $id);

                unset($options, $table);
                $user["name"] = $this->input->post("enterprise_name");
                $whereuser['uid'] = $Details[0]->uid;
                $table = "tbl_user";
                $sdata2 = $this->admin_model->updateUserDetails($table, $user, $whereuser);

                $sdata1 = 0;
                if ($this->input->post("password") != "") {
                    $opt_user["password"] = $this->user_model->_prep_password($this->input->post("password"));
                    $opt_user["email_id"] = $this->input->post("owner_email");
                    $opt_user["mobile_no"] = $this->input->post("mob_no");
                    $whereuser['uid'] = $Details[0]->uid;
                    $sdata1 = $this->user_model->update_pass($opt_user, $whereuser);
                }

                if ($sdata1 == 1) {
                    $this->session->set_userdata('pass_message', 1);
                } else if ($sdata1 == 0) {
                    $this->session->set_userdata('error_message', 1);
                }
                redirect("manage/dashboard/mydetails");
            } else {
                $other["tables"] = "TBL_MSME";
                $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                $op["c.id"] = $data["user_details"][0]->city;
                $data["city"] = $this->user_model->fetch_city_name($op);
                unset($other["tables"]);
                $this->template->load('manage/main', "manage/msme_details", $data);
            }
        }

        if ($data["utype_id"] == 2) {
            $this->form_validation->set_rules('advisor_name', 'Advisor Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('advisor_mob_no', 'Advisor Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('advisor_email', 'Advisor Email Id', 'trim|required|valid_email');
            $this->form_validation->set_rules('advisor_pan', 'Advisor PAN', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('password', 'Select Password', 'trim');
            $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');

            if ($this->form_validation->run()) {
                $table = "tbl_channel_partner";
                $options["advisor_name"] = $this->input->post("advisor_name");
                $options["advisor_mob_no"] = $this->input->post("advisor_mob_no");
                $options["advisor_email"] = $this->input->post("advisor_email");
                $options["advisor_pan"] = $this->input->post("advisor_pan");

                $this->admin_model->updateUserDetails($table, $options, $id);
                unset($options, $table);

                $user["name"] = $this->input->post("advisor_name");
                $whereuser['uid'] = $Details[0]->uid;
                $table = "tbl_user";
                $sdata2 = $this->admin_model->updateUserDetails($table, $user, $whereuser);

                $sdata1 = 0;
                if ($this->input->post("password") != "") {
                    $opt_user["password"] = $this->user_model->_prep_password($this->input->post("password"));
                    $opt_user["email_id"] = $this->input->post("advisor_email");
                    $opt_user["mobile_no"] = $this->input->post("advisor_mob_no");
                    $whereuser['uid'] = $Details[0]->uid;
                    $sdata1 = $this->user_model->update_pass($opt_user, $whereuser);
                }

                if ($sdata1 == 1) {
                    $this->session->set_userdata('pass_message', 1);
                } else if ($sdata1 == 0) {
                    $this->session->set_userdata('error_message', 1);
                }
                redirect("manage/dashboard/mydetails");
            } else {
                $other["tables"] = "TBL_CHANNEL_PARTNER";
                $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                $this->template->load('manage/main', "manage/channel_partner_details", $data);
            }
        }

        if ($data["utype_id"] == 3) {
            $this->form_validation->set_rules('analyst_name', 'Analyst Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('analyst_mob_no', 'Analyst Mobile Number', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('analyst_email', 'Analyst Email Id', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'New Password', 'trim');
            $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');

            if ($this->form_validation->run()) {
                $table = "tbl_analyst";
                $options["analyst_name"] = $this->input->post("analyst_name");
                $options["analyst_mob_no"] = $this->input->post("analyst_mob_no");
                $options["analyst_email"] = $this->input->post("analyst_email");

                $this->admin_model->updateUserDetails($table, $options, $id);
                unset($options, $table);

                $user["name"] = $this->input->post("analyst_name");
                $whereuser['uid'] = $Details[0]->uid;
                $table = "tbl_user";
                $sdata2 = $this->admin_model->updateUserDetails($table, $user, $whereuser);

                $sdata1 = 0;
                if ($this->input->post("password") != "") {
                    $opt_user["password"] = $this->user_model->_prep_password($this->input->post("password"));
                    $opt_user["email_id"] = $this->input->post("analyst_email");
                    $opt_user["mobile_no"] = $this->input->post("analyst_mob_no");
                    $whereuser['uid'] = $Details[0]->uid;
                    $sdata1 = $this->user_model->update_pass($opt_user, $whereuser);
                }

                if ($sdata1 == 1) {
                    $this->session->set_userdata('pass_message', 1);
                } else if ($sdata1 == 0) {
                    $this->session->set_userdata('error_message', 1);
                }
                redirect("manage/dashboard/mydetails");
            } else {
                $other["tables"] = "TBL_ANALYST";
                $data["user_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                $this->template->load('manage/main', "manage/analyst_details", $data);
            }
        }

        if ($data["utype_id"] == 4) {
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('person_name', 'Person Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
            $this->form_validation->set_rules('mob_no', 'Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('branch', 'branch', 'trim|required');
            $this->form_validation->set_rules('landline_no', 'landline_no', 'trim|required|max_length[11]|numeric');
            $this->form_validation->set_rules('password', 'Select Password', 'trim');
            $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');

            $this->form_validation->set_rules('nodal_person_name', 'Nodal Person Name', 'trim|required|max_length[50]|alpha');
            $this->form_validation->set_rules('nodal_designation', 'Nodal Designation', 'trim|required');
            $this->form_validation->set_rules('nodal_mob_no', 'Nodal Mobile No', 'trim|required|max_length[10]|numeric');
            $this->form_validation->set_rules('nodal_email', 'Nodal Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('nodal_branch', 'Nodal Branch', 'trim|required');
            //print_r($_REQUEST);exit;
            if ($this->form_validation->run()) {
                $opt["bank_name"] = $this->input->post("bank_name");
                $opt["person_name"] = $this->input->post("person_name");
                $opt["email"] = $this->input->post("email");
                $opt["mob_no"] = $this->input->post("mob_no");
                $opt["branch"] = $this->input->post("branch");
                $opt["landline_no"] = $this->input->post("landline_no");
                $opt["designation"] = $this->input->post("designation");
                $opt["updated_dtm"] = date('Y-m-d H:i:s');
                //for Nodal officer contact details
                $opt["nodal_person_name"] = $this->input->post("nodal_person_name");
                $opt["nodal_email"] = $this->input->post("nodal_email");
                $opt["nodal_mob_no"] = $this->input->post("nodal_mob_no");
                $opt["nodal_branch"] = $this->input->post("nodal_branch");
                $opt["nodal_designation"] = $this->input->post("nodal_designation");

                $table = "tbl_bank_master";
                $opt["status"] = 1;
                $wherebank['bank_id'] = $this->input->post("id");
                $sdata = $this->admin_model->updateUserDetails($table, $opt, $wherebank);
                unset($table);

                $user["name"] = $this->input->post("bank_name");
                $whereuser['uid'] = $Details[0]->uid;
                $table = "tbl_user";
                $sdata2 = $this->admin_model->updateUserDetails($table, $user, $whereuser);

                $sdata1 = 0;
                if ($this->input->post("password") != "") {
                    $opt_user["password"] = $this->user_model->_prep_password($this->input->post("password"));
                    $opt_user["email_id"] = $this->input->post("email");
                    $opt_user["mobile_no"] = $this->input->post("mob_no");
                    $whereuser['uid'] = $Details[0]->uid;
                    $sdata1 = $this->user_model->update_pass($opt_user, $whereuser);
                }

                $person_name = $this->input->post("emp_person_name");
                $email = $this->input->post("emp_email");
                $mob_no = $this->input->post("emp_mob_no");
                $branch = $this->input->post("emp_branch");
                $designation = $this->input->post("emp_designation");
                $emp_id = $this->input->post("emp_id");

                $person_name = array_values(array_filter($person_name));
                $email = array_values(array_filter($email));
                $mob_no = array_values(array_filter($mob_no));
                $branch = array_values(array_filter($branch));
                $designation = array_values(array_filter($designation));
                $emp_id = array_values(array_filter($emp_id));

                $i = 0;
                foreach ($person_name as $k => $row) {
                    $empdata['person_name'] = $person_name[$i];
                    $empdata['email'] = $email[$i];
                    $empdata['mob_no'] = $mob_no[$i];
                    $empdata['branch'] = $branch[$i];
                    $empdata['designation'] = $designation[$i];
                    $empdata['updated_dtm'] = date('Y-m-d H:i:s');
                    $whereemp['id'] = $emp_id[$i];
                    $table = "tbl_bank_employee";
                    $update = $this->admin_model->updateUserDetails($table, $empdata, $whereemp);
                    $i++;
                }

                if ($sdata1 == 1) {
                    $this->session->set_userdata('pass_message', 1);
                } else if ($sdata1 == 0) {
                    $this->session->set_userdata('error_message', 1);
                }
                redirect("manage/dashboard/mydetails");
            } else {
                $other["tables"] = "TBL_BANK_MASTER";
                $data["bank_details"] = $this->admin_model->getUserDetails($id, $other);
                unset($other["tables"]);
                $other["tables"] = "TBL_BANK_EMPLOYEE";
                $data["emp_details"] = $this->admin_model->getUserDetails($id, $other);
                //print_r($data["emp_details"]);
                $this->template->load('manage/main_filter', "manage/bank_details", $data);
            }
        }

        if ($data["utype_id"] == 5) {
            $table = "tbl_admin";
            $options["person_name"] = $this->input->post("person_name");
            $options["designation"] = $this->input->post("designation");
            $options["mobile_no"] = $this->input->post("mobile_no");
            $options["email_id"] = $this->input->post("email_id");
            $options["branch"] = $this->input->post("branch");

            $this->admin_model->updateUserDetails($table, $options, $id);
            unset($options, $table);

            if ($sdata1 == 1) {
                $this->session->set_userdata('pass_message', 1);
            } else if ($sdata1 == 0) {
                $this->session->set_userdata('error_message', 1);
            }
            redirect("manage/dashboard/mydetails");
        }
        //echo "<pre>"; print_r($data); exit;
        //$this->template->load('manage/main',"manage/msme_details",$data);
        //echo $sdata1; exit;
        /* if($sdata1==1){
        $this->session->set_userdata('pass_message',1);
        }else if($sdata1==0){
        $this->session->set_userdata('error_message',1);
        }
        redirect("manage/dashboard/mydetails"); */
        //}
    }

    public function ajax_call() {

        if (isset($_POST) && isset($_POST['city'])) {
            $city = $_POST['city'];
            $arrCitys = $this->user_model->fetch_city($city);

            /* foreach ($arrCitys as $citys) {
            $arrCitys[$citys->city] = $citys->city;
            } */

            // print form_dropdown('city',$arrCitys);
            $values = '<option value="">--select--</option> ';
            foreach ($arrCitys as $val) {
                $values .= '<option value="' . $val->id . '">' . $val->name . '</option>';
            }
            echo $values;
            exit;
        }
        /* else {
    redirect('site');
    } */
    }

    // update company type

    public function updatePa() {

        $this->form_validation->set_rules('date_created', 'Application Date', 'trim|required');

        if ($this->form_validation->run()) {
            $Data['date_created'] = $this->input->post('date_created');
            $Data['fname'] = $this->input->post('fname');
            $Data['sname'] = $this->input->post('sname');
            $where['id'] = $this->input->post('id');
            $sdata = $this->parequest_model->updatePA($Data, $where);

            if ($sdata) {
                echo "<script>parent.refress();parent.closeFB();</script>";
            } else {
                $this->edit_parequest($this->input->post('id'), "You have not change Company Type Name");
            }
        } else {
            echo "<script>parent.refress();parent.closeFB();</script>";
        }
    }

    public function verify($verificationText = NULL) {
        $noRecords = $this->user_model->verifyEmailAddress($verificationText);
        if ($noRecords > 0) {
            $error = "Email Verified Successfully!";
        } else {
            //$error = array( 'error' => "Sorry Unable to Verify Your Email!");
            $error = "Your account already is activated!";
        }
        $data['errormsg'] = $error;
        //print_r($data); //exit;
        $this->load->view('mail_message.php', $data);
    }

    /* function sendVerificationEmail(){
    $this->sendVerificatinEmail("msme@gmail.com","13nRGi7UDv4CkE7JHP1o");
    $this->load->view('mail_message.php', $data);
    } */

    public function sendVerificatinEmail($email, $verificationText, $password = "") {

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'assocham01@gmail.com'; // SMTP username
        $mail->Password = 'om123456';
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to
        $mail->FromName = 'MyLoanassocham';
        $mail->addAddress($email);
        //$mail->AddAddress($options["email_id"]);                 // Add a recipient
        $mail->WordWrap = 50; // Set word wrap to 50 characters
        $mail->IsHTML(true); // Set email format to HTML
        $mail->SMTPKeepAlive = true;
        // Set email format to HTML

        $mail->Subject = 'Email Verification';
        $mail->Body = '<p style="font-size:11px; font-family:arial; line-height:13px;">This is a system generated email. Please do not reply to this email address.</p>

				<div><img src="' . base_url() . 'assets/front/images/logo.png" alt=""></div><div style="margin-top:5px; background:#cccccc; height:50px; border-bottom:3px solid #3A002C;"></div>

				<div style="font-size:14px; font-family:arial; line-height:20px;">
					<p style="display:block; margin:0; padding-top:5px;">Dear user,</p>

					<p style="display:block; margin:0; padding-top:10px;"><strong>Your Email Id : ' . $email . '</strong></p>
					<p style="display:block; margin:0; padding-top:10px;"><strong>Your Password : ' . $password . '</strong></p>
					<p style="display:block; margin:0; padding-top:10px;"><strong>Please click to active below link.</strong></p>
					<a href="' . base_url() . 'home/verify/' . $verificationText . '" target="_blank">' . base_url() . 'home/verify/' . $verificationText . '</a>
					<p style="display:block; margin:0; padding-top:10px;">Please click on the following link to access the system:<br />
						<a href="' . base_url() . '" target="_blank">' . base_url() . '</a></p>

						<p style="display:block; margin:0; padding-top:10px;">Regards, </p>
						<p style="display:block; margin:0; padding-top:10px;">Administrator</p>
						<div style="margin-top:10px; background:#cccccc; height:50px; border-top:3px solid #666;"></div>

					</div>';

        //echo $mail->Body;die();
        $mail->Send();
    }

    //-------------Added For Pdf Generation of Loan Document---------------------------------

    public function pdfgen($id = NULL) {

        $this->load->helper(['dompdf', 'file']);

        $application_id = base64_decode($id);

        //-------------------------Loan Application Section------------------------------------

        $other["tables"] = "TBL_LOAN_APPLICATION";

        $whereapplication['application_id'] = $application_id;

        $data["application_id"] = $this->admin_model->getLoanDetails($whereapplication, $other);

        unset($other["tables"]);

        //For name who has created

        $wh["application_id"] = $application_id;
        $other["tables"] = "TBL_LOAN_APPLICATION";
        $loan_list = $this->admin_model->getUserDetails($wh, $other);
        unset($other);

        //print_r($loan_list);exit;
        if ($loan_list[0]->channel_partner_id == 0) {
            $where["uid"] = $loan_list[0]->msme_id;
            $other["tables"] = "TBL_USER";
            $data["msme_details"] = $this->admin_model->getUsers($where, $other);
        } else {
            $where["uid"] = $loan_list[0]->channel_partner_id;
            $other["tables"] = "TBL_USER";
            $data["channel_name"] = $this->admin_model->getUsers($where, $other);
        }
        //print_r($data["msme_details"]);exit;
        //
        $other["tables"] = "TBL_ENTERPRISE_PROFILE";
        $data["enterprise_profile"] = $this->admin_model->getLoanDetails($whereapplication, $other);
        unset($other["tables"]);
        //fetch state and city
        $op["s.id"] = $data["enterprise_profile"][0]->state;
        $data["state"] = $this->user_model->fetch_state($op);

        $op1["c.id"] = $data["enterprise_profile"][0]->city;
        $data["city"] = $this->user_model->fetch_city_name($op1);

        //end

        $other["tables"] = "TBL_LOAN_REQUIREMENT";
        $whereapplication1['application_id'] = $application_id;
        $data["loan_requirement"] = $this->admin_model->getLoanDetails($whereapplication1, $other);
        unset($other["tables"]);
        //fetch state and city
        if (!empty($data["loan_requirement"])) {
            $opt1["s.id"] = $data["loan_requirement"][0]->state;
            $data["rec_state"] = $this->user_model->fetch_state($opt1);

            $opt2["c.id"] = $data["loan_requirement"][0]->city;
            $data["rec_city"] = $this->user_model->fetch_city_name($opt2);
        }

        //end

        $other["tables"] = "TBL_ENTERPRISE_BACKGROUND";
        $whereapplication2['application_id'] = $application_id;
        $data["enterprise_background"] = $this->admin_model->getLoanDetails($whereapplication2, $other);
        unset($other["tables"]);
        $other["tables"] = "TBL_OWNER_DETAILS";
        $whereapplication3['application_id'] = $application_id;
        $data["owner_details"] = $this->admin_model->getLoanDetails($whereapplication3, $other);
        unset($other["tables"]);
        foreach ($data["owner_details"] as $val) {
            $valop["s.id"] = $data["owner_details"][0]->state;
            $data["owner_state"] = $this->user_model->fetch_state($valop);
            $data["owner_name"] = $val->name;
        }

        $other["tables"] = "TBL_BANKING_CREDIT_FACILITIES";
        $whereapplication4['application_id'] = $application_id;
        $data["banking_credit_facilities"] = $this->admin_model->getLoanDetails($whereapplication4, $other);
        unset($other["tables"]);
        $other["tables"] = "TBL_UPLOAD_DOCUMENTS";
        $whereapplication5['application_id'] = $application_id;
        $data["upload_documents"] = $this->admin_model->getLoanDetails($whereapplication5, $other);
        unset($other["tables"]);
        if (!empty($data["upload_documents"])) {
            $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDMORE";
            $upload['upload_id'] = $data["upload_documents"][0]->id;
            $data["upload_add_more"] = $this->admin_model->getLoanDetails($upload, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_UPLOAD_DOCUMENTS_ADDITIONAL";
            $uploads['upload_ids'] = $data["upload_documents"][0]->id;
            $data["additional_documents"] = $this->admin_model->getLoanDetails($uploads, $other);
            unset($other["tables"]);
            $other["tables"] = "TBL_UPLOAD_DOCUMENTS_OWNER";
            $data["owner_documents"] = $this->admin_model->getLoanDetails($upload, $other);
            unset($other["tables"]);
        }

        //-------------------------Loan Application Section------------------------------------

        //-------------------------Analyst Section------------------------------------

        $other["tables"] = "TBL_ANALYST_DOCUMENTS";
        $data["analyst_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
        unset($other["tables"]);
        $other["tables"] = "TBL_ANALYST_DIRECTOR_DOCUMENTS";
        $data["analyst_director_documents"] = $this->admin_model->getLoanDetails($whereapplication, $other);
        unset($other["tables"]);

        //-------------------------End Analyst Section------------------------------------

        //-------------------------Bank Section-------------------------------------------

        $other["tables"] = "TBL_BANK_APPLICATION";
        $data["bank_application"] = $this->admin_model->getLoanDetails($whereapplication, $other);
        unset($other["tables"]);

        //-------------------------End Bank Section---------------------------------------

        $sPath = realpath(dirname('uploads')) . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;

        //print_r($data);exit;

        $html = $this->load->view('manage/loan_pdf', $data, true);
        pdf_create($html, 'Loan-Application-ID-' . $application_id);
        $pdf1 = $sPath . "loan_doc" . DIRECTORY_SEPARATOR . "Loan-Application-ID-" . $application_id . ".pdf";
        $output_pdf = $sPath . "loan_doc" . DIRECTORY_SEPARATOR . "Loan-Application-ID-" . $application_id . ".pdf";
        rename($pdf1, $output_pdf);

        return true;
    }

    public function email_checking_msme() {
        $check_email["email_id"] = $this->input->post("owner_email");
        $dat = $this->user_model->chekuser($check_email);
        if ($dat) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function pan_checking_msme() {
        $check_pan["pan_firm"] = $this->input->post("pan_firm");
        $dat = $this->user_model->chek_msme_pan($check_pan);
        if ($dat) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function mobile_checking_msme() {
        $check_mobile["mobile_no"] = $this->input->post("mob_no");
        $dat = $this->user_model->chekuser_mobile_no($check_mobile);
        if ($dat) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
