<?php

/**
 * Transmission controller.
 *
 * @category   apps
 * @package    transmission
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/transmission/
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

// Exceptions
//-----------

use \clearos\apps\base\Engine_Exception as Engine_Exception;

clearos_load_library('base/Engine_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Transmission setting controller.
 *
 * @category   apps
 * @package    transmission
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/transmission/
 */

class Setting extends ClearOS_Controller
{
    /**
     * Transmission default controller
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->load->library('transmission/Transmission');
        $this->lang->load('transmission');

        // Set validation rules
        //---------------------
         
        if ($this->input->post('submit')) {
            $this->form_validation->set_policy('password', 'transmission/Transmission', 'validate_password', TRUE);
            $this->form_validation->set_policy('verify', 'transmission/Transmission', 'validate_password', TRUE);
        }

        $form_ok = $this->form_validation->run();

        // Extra validation
        //-----------------

        if ($this->input->post('submit')) {
            $password = $this->input->post('password');
            $verify = $this->input->post('verify');
        }

        if ($form_ok) {
            if ($password !== $verify) {
                $this->form_validation->set_error('new_verify', lang('base_password_and_verify_do_not_match'));
                $this->form_validation->set_error('verify', lang('base_password_and_verify_do_not_match'));
                $form_ok = FALSE;
            }
        }

        // Handle form submit
        //-------------------

        if (($this->input->post('submit')) && $form_ok) {
            try {
                $this->transmission->set_password($password);

                $this->page->set_message(lang('transmission_password_updated'), 'info');
                redirect('/transmission');
            } catch (Exception $e) {
                $this->page->view_exception($e);
            }
        }

        // Load view data
        //---------------

        try {
            $is_running = $this->transmission->get_running_state();
            //$data['is_password_set'] = $this->backuppc->is_root_password_set();
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }


        // Load views
        //-----------

        $this->page->view_form('transmission/setting', $data, lang('transmission_app_name'));
    }
}
