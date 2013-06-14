<?php

class MY_Output extends CI_Output
{
    public function _display($output = '')
    {
        $CI =& get_instance();

        // for session driver
        if (isset($CI->session)) {
            $CI->session->sess_write();
        }

        if (ENVIRONMENT != 'testing') {
            parent::_display($output);
        }
    }
}
