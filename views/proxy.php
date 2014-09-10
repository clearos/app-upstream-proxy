<?php

/**
 * Upstream proxy view.
 *
 * @category   apps
 * @package    upstream-proxy
 * @subpackage views
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
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('base');
$this->lang->load('network');


///////////////////////////////////////////////////////////////////////////////
// Form modes
///////////////////////////////////////////////////////////////////////////////

if ($form_type === 'edit') {
    $read_only = FALSE;
    $buttons = array(
        form_submit_update('submit'),
        anchor_cancel('/app/upstream_proxy'),
    );
} else if ($form_type === 'add') {
    $read_only = FALSE;
    $buttons = array(
        form_submit_add('submit'),
        anchor_cancel('/app/upstream_proxy'),
    );
} else {
    $read_only = TRUE;
    if ($is_wizard) {
        $buttons = array(
            anchor_custom('#', lang('base_skip'), 'high', array('id' => 'wizard_skip')),
            anchor_custom('/app/upstream_proxy/edit', lang('upstream_proxy_configure_proxy'), 'low')
        );
    } else {
        $buttons = array(
            anchor_edit('/app/upstream_proxy/edit'),
        );
    }
}

if ($read_only)
    $password = str_repeat('*', strlen($password));

///////////////////////////////////////////////////////////////////////////////
// Form
///////////////////////////////////////////////////////////////////////////////

echo form_open('/upstream_proxy/edit', array('id' => 'proxy_form', 'autocomplete' => 'off'));
echo form_header(lang('base_settings'));

echo field_input('server', $server, lang('network_proxy_server'), $read_only);
echo field_input('port', $port, lang('network_port'), $read_only);
echo field_input('username', $username, lang('base_username'), $read_only);
echo field_password('password', $password, lang('base_password'), $read_only);

echo field_button_set($buttons);

echo form_footer();
echo form_close();
