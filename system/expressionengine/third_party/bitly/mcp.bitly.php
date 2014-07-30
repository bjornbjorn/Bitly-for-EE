<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bitlyfy URLs on the fly (with cache)
 *
 * @package		Bitly
 * @subpackage	ThirdParty
 * @category	Modules
 * @author		bjorn
 * @link		http://ee.bybjorn.com/bitly
 */
class Bitly_mcp 
{
	var $base;			// the base url for this module			
	var $form_base;		// base url for forms
	var $module_name = "bitly";	

	function Bitly_mcp( $switch = TRUE )
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance(); 
		$this->base	 	 = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name;
		$this->form_base = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.$this->module_name;
		
	}

	function empty_cache()
	{
		$this->EE->db->truncate('bitly'); 
		$this->EE->session->set_flashdata(array(
                    'message_success' => lang('cache_emptied')
        ));
        $this->EE->functions->redirect($this->base);		
	}
	
	function index() 
	{
        $this->EE->load->library('table');
        $this->EE->load->library('javascript');
        $this->EE->jquery->tablesorter('.mainTable', '{           
            widgets: ["zebra"]
        }');
        $this->EE->javascript->compile();        
		$this->EE->load->helper('form');		
		$vars = array();
				
		$this->EE->db->from('bitly');
		$vars['num_cached'] = $this->EE->db->count_all_results();
		
		return $this->content_wrapper('index', 'welcome', $vars);
	}

	
	function content_wrapper($content_view, $lang_key, $vars = array())
	{
		$vars['content_view'] = $content_view;
		$vars['_base'] = $this->base;
		$vars['_form_base'] = $this->form_base;
		$this->EE->cp->set_variable('cp_page_title', lang($lang_key));
		$this->EE->cp->set_breadcrumb($this->base, lang('bitly_module_name'));

		return $this->EE->load->view('_wrapper', $vars, TRUE);
	}
	
}

/* End of file mcp.bitly.php */ 
/* Location: ./system/expressionengine/third_party/bitly/mcp.bitly.php */ 