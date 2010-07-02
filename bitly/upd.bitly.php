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
class Bitly_upd {
		
	var $version        = '1.0'; 
	var $module_name = "Bitly";
	
    function Bitly_upd( $switch = TRUE ) 
    { 
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
    } 

    /**
     * Installer for the Bitly module
     */
    function install() 
	{				
						
		$data = array(
			'module_name' 	 => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y'
		);

		$this->EE->db->insert('modules', $data);		
		
		$this->EE->load->dbforge();
		
		$bitly_fields = array(
		    'bitly_id' => array(
		        'type' => 'int',
		        'constraint' => '10',
		        'unsigned' => TRUE,
		        'auto_increment' => TRUE,),
		    'long_url' => array(
		        'type' => 'varchar',
		        'constraint' => '255',
		        'null' => FALSE,),
		    'short_url' => array(
		        'type' => 'varchar',
		        'constraint' => '255',
		        'null' => FALSE,),
		);
		
		$this->EE->dbforge->add_field($bitly_fields);
		$this->EE->dbforge->add_key('bitly_id', TRUE);
		$this->EE->dbforge->create_table('bitly');		
		
		return TRUE;
	}

	
	/**
	 * Uninstall the Bitly module
	 */
	function uninstall()
	{
	    $this->EE->load->dbforge();
	
	    $this->EE->db->select('module_id');
	    $query = $this->EE->db->get_where('modules', array('module_name' => $this->module_name));
	
	    $this->EE->db->where('module_id', $query->row('module_id'));
	    $this->EE->db->delete('module_member_groups');
	
	    $this->EE->db->where('module_name', $this->module_name);
	    $this->EE->db->delete('modules');
	
	    $this->EE->db->where('class', $this->module_name);
	    $this->EE->db->delete('actions');
	
	    $this->EE->db->where('class', $this->module_name.'_mcp');
	    $this->EE->db->delete('actions');
	
	    $this->EE->dbforge->drop_table('bitly');
	
	    return TRUE;
	}
	
	
	/**
	 * Update the Bitly module
	 * 
	 * @param $current current version number
	 * @return boolean indicating whether or not the module was updated 
	 */
	
	function update($current = '')
	{
		return FALSE;
	}
    
}

/* End of file upd.bitly.php */ 
/* Location: ./system/expressionengine/third_party/bitly/upd.bitly.php */ 