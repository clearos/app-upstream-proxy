<?php

/**
 * Upstream proxy controller.
 *
 * @category   apps
 * @package    upstream-proxy
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upstream_proxy/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Upstream proxy controller.
 *
 * @category   apps
 * @package    upstream-proxy
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/upstream_proxy/
 */

class Upstream_Proxy extends ClearOS_Controller
{
    /**
     * Upstream proxy overview.
     *
     * @return view
     */

    function index()
    {
        $this->_common('view');
    }

    /**
     * Edit view.
     *
     * @return view.
     */

    function edit()
    {
        $this->_common('edit');
    }

    /**
     * View view.
     *
     * @return view.
     */

    function view()
    {
        $this->_common('view');
    }

    ///////////////////////////////////////////////////////////////////////////////
    // P R I V A T E
    ///////////////////////////////////////////////////////////////////////////////

    /** 
     * Common form handler.
     *
     * @param string $form_type form type
     *
     * @return view
     */

    function _common($form_type)
    {
        // Load libraries
        //---------------

        $this->lang->load('upstream_proxy');
        $this->load->library('upstream_proxy/Proxy');

        // Set validation rules
        //---------------------
         
        $this->form_validation->set_policy('server', 'upstream_proxy/Proxy', 'validate_server');
        $this->form_validation->set_policy('port', 'upstream_proxy/Proxy', 'validate_port');
        $this->form_validation->set_policy('username', 'upstream_proxy/Proxy', 'validate_username');
        $this->form_validation->set_policy('password', 'upstream_proxy/Proxy', 'validate_password');
        $form_ok = $this->form_validation->run();

        // Handle form submit
        //-------------------

        if (($this->input->server('REQUEST_METHOD') === 'POST') && $form_ok) {
            try {
                $this->proxy->set_server($this->input->post('server'));
                $this->proxy->set_port($this->input->post('port'));
                $this->proxy->set_username($this->input->post('username'));
                $this->proxy->set_password($this->input->post('password'));
                $this->proxy->write_profile();

                $this->page->set_status_updated();

                if ($this->session->userdata('wizard_redirect'))
                    redirect($this->session->userdata('wizard_redirect'));
                else
                    redirect('/upstream_proxy');
            } catch (Engine_Exception $e) {
                $this->page->view_exception($e->get_message());
                return;
            }
        }

        // Load view data
        //---------------

        try {
            $data['form_type'] = $form_type;
            $data['server'] = $this->proxy->get_server();
            $data['port'] = $this->proxy->get_port();
            $data['username'] = $this->proxy->get_username();
            $data['password'] = $this->proxy->get_password();

            $data['is_wizard'] = ($this->session->userdata('wizard')) ? TRUE : FALSE;
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }

        // Load views
        //-----------

        if (clearos_console())
            $options['type'] = MY_Page::TYPE_CONSOLE;

        $this->page->view_form('upstream_proxy/proxy', $data, lang('upstream_proxy_app_name'), $options);
    }
}
