<?php

/**
 * Implico Email Framework
 * 
 * @package Config - Project configuration, including paths
 * @author Bartosz Sak <info@implico.pl>
 * 
*/

namespace Implico\Email;


class Config implements \ArrayAccess
{
	
	
	protected $data;
	
	public function __construct($project, $projectsDir = null)
	{
		$this->data = array();

		if (!$projectsDir) {
			$projectsDir = IE_PROJECTS_DIR;
		}
		else {
			$projectsDir .= DIRECTORY_SEPARATOR;
		}
		
		$this->data['name'] = $project;
		$this->data['dir'] = $projectsDir . $project . '/';							//project main dir
		$this->data['configsDir'] = $this['dir'] . 'configs/';					//config (PHP & Smarty) dir
		$this->data['configsScriptsDir'] = $this['configsDir'] . 'scripts/';	//script-specific config dir (overrides main config)
		$this->data['layoutsDir'] = $this['dir'] . 'layouts/';					//layout dir
		$this->data['scriptsDir'] = $this['dir'] . 'scripts/';					//script dir
		$this->data['stylesDir'] = $this['dir'] . 'styles/';						//styles dir (for RWD), also compiled by Smarty
		$this->data['outputsDir'] = $this['dir'] . 'outputs/';					//output (html) dir
		$this->data['senderDir'] = $this['dir'] . 'sender/';						//sender dir (logs)
		
	}
	
	
	/**
	 * Returns project init errors
	 * 
	 * @return mixed 			false if success, error name (string) if failure: projectNotFound
	 */
	public function getErrors()
	{
		$ret = false;
		
		if (!file_exists($this->data['dir'] . '.')) {
			$ret = 'projectNotFound';
		}
		
		return $ret;
		
	}
	

	//ArrayAccess methods
	public function offsetSet($offset, $value)
	{
		if (is_null($offset))
			$this->data[] = $value;
		else $this->data[$offset] = $value;
	}
	
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}
	
	public function offsetUnset($offset)
	{
		return isset($this->data[$offset]);
	}
	
	public function offsetGet($offset)
	{
		return $this->offsetExists($offset) ? $this->data[$offset] : null;
	}
	
}