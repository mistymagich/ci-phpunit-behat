<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Autoloader Class
 *
 * Autoload Base classes with PHP5's native autoload.
 *
 * @package			CodeIgniter
 * @subpackage		MyAutoload
 * @category		Hooks
 * @author			Shane Pearson <bubbafoley@gmail.com>
 * @license			http://philsturgeon.co.uk/code/dbad-license
 */
class Spl_class_loader {
    private $_include_paths = array();

    /**
     * Register
     *
     * Register the autoloader function.
     * 
     * @access public
     * @param  array  include paths
     * @return void
     */
    public function register(array $paths = array())
    {
        $this->_include_paths = $paths;
        spl_autoload_register(array($this, 'loadClass'));
        spl_autoload_register(array($this, 'loadModelClass'));
    }

    // --------------------------------------------------------------------

    public function loadClass($class) {
        if(class_exists($class, FALSE))
        {
            return;
        }

        foreach($this->_include_paths as $path)
        {
            $filepath = $path . $class . '.php';

            if(is_file($filepath))
            {
                include_once($filepath);
                break;
            }
        }
    }

    public function loadModelClass($class) 
    {
        if(class_exists($class, FALSE))
        {
            return;
        }

        $filename = strtolower($class) . EXT;
        $file     = APPPATH . 'models/' . $filename;
        if (!file_exists($file)) {
            return false;
        }

        if (!class_exists('CI_Model', FALSE)) {
            load_class('Model', 'core'); 
        }

        include_once $file;
    }
} // end class Spl_class_loader

/* End of file Spl_class_loader.php */
/* Location: ./application/hooks/Spl_class_loader.php */
