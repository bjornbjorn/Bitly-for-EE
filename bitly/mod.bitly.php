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
class Bitly {

	var $return_data;
	var $bitly_login; 
	var $bitly_api_key;
	
	function Bitly()
	{		
		$this->EE =& get_instance(); // Make a local reference to the ExpressionEngine super object
		
		$url = urlencode($this->_get_param('url', $this->EE->functions->fetch_current_uri()));

		$this->bitly_login = $this->_get_param('bitly_login');
		$this->bitly_api_key = $this->_get_param('bitly_api_key');
		
		if(!$this->bitly_login) // if not specified, might be use in a wootheme so try to find info in global vars
		{
			if(isset($this->EE->config->_global_vars['woo_bitly_login']))
			{
					$this->bitly_login = $this->EE->config->_global_vars['woo_bitly_login'];
					$this->bitly_api_key = $this->EE->config->_global_vars['woo_bitly_api_key'];

			}
		}
		
		if($url && $this->bitly_login && $this->bitly_api_key)
		{
			$q = $this->EE->db->get_where('bitly', array('long_url' => $url));	// first check the local cache
			if($q->num_rows() > 0)
			{
				$this->return_data = $q->row('short_url');
			}
			else
			{
				$this->return_data = $this->_shorten_url($url);
			}
		}
		else
		{
			$this->EE->TMPL->log_item('bitly ERROR: login/or api missing in parameter');
			$this->return_data = $url;			
		}
		
		return $this->return_data;
	}
	
	function _shorten_url($url)
	{
		$api_call_url = 'http://api.bit.ly/v3/shorten?login='.$this->bitly_login.'&apiKey='.$this->bitly_api_key.'&longUrl='.$url.'&format=txt';
		$short_url = trim(@file_get_contents($api_call_url));
		if($short_url)
		{
			// got short url, cache it so we don't have to ask bitly again
			$this->EE->db->insert('bitly', array('long_url' => $url, 'short_url' => $short_url));
			return $short_url;
		}
		else
		{
			$this->EE->TMPL->log_item('bitly ERROR: could not get short url (check your API details?)');
			return $url;	// something went wrong, API key error maybe? if so just return the long url
		}
	}
	
		
	/**
     * Helper function for getting a parameter
	 */		 
	function _get_param($key, $default_value = '')
	{
		$val = $this->EE->TMPL->fetch_param($key);
		
		if($val == '') {
			return $default_value;
		}
		return $val;
	}

	/**
	 * Helper funciton for template logging
	 */	
	function _error_log($msg)
	{		
		$this->EE->TMPL->log_item("bitly ERROR: ".$msg);		
	}		
}

/* End of file mod.bitly.php */ 
/* Location: ./system/expressionengine/third_party/bitly/mod.bitly.php */ 