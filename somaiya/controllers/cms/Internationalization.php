<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Internationalization extends Somaiya_Controller {

    function __construct()
    {
        parent::__construct('backend');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
    }

    function countries()
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "tieups";
        $this->data['child_menu_type'] = "countries";
        $this->data['sub_child_menu_type'] = "countries";

        validate_permissions('Internationalization', 'countries', $this->config->item('method_for_view'));

        $this->data['data_list']    = $this->get_countries('', ['public !' => '-1'], 'id desc');
        $this->data['title']        = 'Countries';
        $this->data['page']         = 'internationalization';
        $this->data['content']      = $this->load->view('cms/internationalization'.'/countries', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managecountry($id='')
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "tieups";
        $this->data['child_menu_type'] = "countries";
        $this->data['sub_child_menu_type'] = "save_country";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Internationalization', 'managecountry', $per_action);

        $this->data['title']                = 'Manage Country';
        $this->data['page']                 = 'internationalization';
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['public']  = 1;

        if($id)
        {
            $countrydata = $this->get_countries($id, ['public !' => '-1']);
            $this->data['post_data'] = isset($countrydata[0]) ? $countrydata[0] : [];

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Country not found']);
                redirect(base_url().'cms/internationalization/countries/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('country', 'Country', 'required|max_length[300]');
        $this->form_validation->set_rules('marker', 'Marker', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('internationalization_countries');
                if($id)
                {
                    $update['country']          = $this->input->post('country');
                    $update['university_for']   = $this->input->post('university_for');
                    $update['marker']           = $this->input->post('marker');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Country successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['country']          = $this->input->post('country');
                    $insert['university_for']   = $this->input->post('university_for');
                    $insert['marker']           = $this->input->post('marker');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Country successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/internationalization/countries/');
            }
        }

        $this->data['content']      = $this->load->view('cms/internationalization'.'/form_country', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function deletecountry($id=0)
    {
        validate_permissions('Internationalization', 'deletecountry', $this->config->item('method_for_delete'));

        $this->common_model->set_table('internationalization_countries');
        $response = $this->common_model->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/internationalization/countries/');
    }

    function get_countries($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT c.* FROM internationalization_countries c WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND c.'.$key.'= "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND c.id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY c.id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function universities()
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "tieups";
        $this->data['child_menu_type'] = "universities";
        $this->data['sub_child_menu_type'] = "universities";

        validate_permissions('Internationalization', 'universities', $this->config->item('method_for_view'));

        $this->data['data_list']    = $this->get_universities('', ['public !' => '-1'], 'id desc');
        $this->data['title']        = 'Universities';
        $this->data['page']         = 'internationalization';
        $this->data['content']      = $this->load->view('cms/internationalization'.'/universities', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function manageuniversity()
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "tieups";
        $this->data['child_menu_type'] = "universities";
        $this->data['sub_child_menu_type'] = "save_university";

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Internationalization', 'manageuniversity', $per_action);

        $this->data['title']                = 'Manage University';
        $this->data['page']                 = 'internationalization';
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['public']  = 1;

        if($id)
        {
            $universitydata = $this->get_universities($id, ['public !' => '-1']);
            $this->data['post_data'] = isset($universitydata[0]) ? $universitydata[0] : [];

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'University not found']);
                redirect(base_url().'cms/internationalization/universities/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('country_id', 'Country', 'required');
        $this->form_validation->set_rules('university_name', 'University Name', 'required');
        $this->form_validation->set_rules('university', 'University Address', 'required');
        $this->form_validation->set_rules('lat', 'Latitude', '');
        $this->form_validation->set_rules('long', 'Longitude', '');
        $this->form_validation->set_rules('url', 'Url', '');
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('logo', 'Logo', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('internationalization_universities');
                if($id)
                {
                    $update['country_id']       = $this->input->post('country_id');
                    $update['university_for']   = $this->input->post('university_for');
                    $update['university_name']  = $this->input->post('university_name');
                    $update['university']       = $this->input->post('university');
                    $update['lat']              = $this->input->post('lat');
                    $update['long']             = $this->input->post('long');
                    $update['url']              = $this->input->post('url');
                    $update['description']      = $this->input->post('description');
                    $update['logo']             = $this->input->post('logo');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'University successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['country_id']       = $this->input->post('country_id');
                    $insert['university_for']   = $this->input->post('university_for');
                    $insert['university_name']  = $this->input->post('university_name');
                    $insert['university']       = $this->input->post('university');
                    $insert['lat']              = $this->input->post('lat');
                    $insert['long']             = $this->input->post('long');
                    $insert['url']              = $this->input->post('url');
                    $insert['description']      = $this->input->post('description');
                    $insert['logo']             = $this->input->post('logo');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'University successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/internationalization/universities/');
            }
        }

        $this->data['countries']    = $this->get_countries('', ['public' => '1'], 'country asc');
        $this->data['content']      = $this->load->view('cms/internationalization'.'/form_university', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function deleteuniversity($id=0)
    {
        validate_permissions('Internationalization', 'deleteuniversity', $this->config->item('method_for_delete'));

        $this->common_model->set_table('internationalization_universities');
        $response = $this->common_model->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/internationalization/universities/');
    }

    function get_universities($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT u.*, (SELECT c.country FROM internationalization_countries c WHERE c.id = u.country_id) as country FROM internationalization_universities u WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND u.'.$key.'= "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND u.id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY u.id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }
}
