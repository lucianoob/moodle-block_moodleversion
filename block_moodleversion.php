<?php
class block_moodleversion extends block_base 
{
	public function init() 
	{
		$this->title = get_string('moodleversion', 'block_moodleversion');
	}
	public function get_content() 
	{
		global $CFG, $DB;
		
		if ($this->content !== null) 
		{
			return $this->content;
		}
		if (empty($this->config)) {
			$this->config = new stdClass();
		}
		if (empty($this->config->phpversion))
			$this->config->phpversion = false;
		if (empty($this->config->mysqlversion))
			$this->config->mysqlversion = false;
		if (empty($this->config->phpextensions))
			$this->config->phpextensions = false;
		if (empty($this->config->phpsettings))
			$this->config->phpsettings = false;
		
		$version = explode(" (Build: ", substr($CFG->release, 0, strlen($CFG->release)-1));
		$dt = new stdClass();
		$dt->year = substr($version[1], 0, 4);
		$dt->month = substr($version[1], 4, 2);
		$dt->date = substr($version[1], 6, 2);
		$mysql = $DB->get_record_sql('SELECT version();');
		if(empty($mysql)){
			$mysql = $DB->get_record_sql('Select @@version');
		}
		
		$this->content =  new stdClass;
		$this->content->text   = get_string('version', 'block_moodleversion')."<b>".$version[0]." (".$CFG->version.")</b>";
		$this->content->text   .= "<br>".get_string('release', 'block_moodleversion')."<b>".get_string('date_release', 'block_moodleversion', $dt)."</b>";
		if(!$this->config->phpversion)
			$this->content->text   .= "<br>PHP: <b>".phpversion()."</b>";
		if(!$this->config->mysqlversion)
			$this->content->text   .= "<br>MySQL: <b>".$mysql->value."</b>";
		if($this->config->phpextensions) {
			$php_extensions_recommended = array("mbstring", "openssl", "tokenizer", "xmlrpc", "soap", "zlib", "intl");
			$php_extensions_check = array();
			foreach($php_extensions_recommended as $value) {
				if(!in_array($value, get_loaded_extensions()))
					array_push($php_extensions_check, $value);
			}
			$ok_extensions_help = get_string('php_status_ok_extensions', 'block_moodleversion');
			$ok_extensions = "<span title='$ok_extensions_help' alt='$ok_extensions_help'><font color='blue'>".get_string('php_status_ok', 'block_moodleversion')."</font></span>";
			$error_extensions_help = get_string('php_status_error_extensions', 'block_moodleversion', implode(", ", $php_extensions_check));
			$error_extensions = "<a href='$CFG->wwwroot/admin/environment.php' title='$error_extensions_help' alt='$error_extensions_help'><font color='red'>".get_string('php_status_error', 'block_moodleversion')."</font></a>";
			$this->content->text .= "<br>".get_string('php_extensions', 'block_moodleversion')."<b>".(empty($php_extensions_check) ? $ok_extensions : $error_extensions)."</b>";
		}
		
		if($this->config->phpsettings) {
			$php_settings_check = array();
			if(intval(ini_get('memory_limit')) < 128)
				array_push($php_settings_check, 'memory_limit');
			if(intval(ini_get('safe_mode')) != 0)
				array_push($php_settings_check, 'safe_mode');
			if(intval(ini_get('file_uploads')) < 1)
				array_push($php_settings_check, 'file_uploads');
			$ok_settings_help = get_string('php_status_ok_settings', 'block_moodleversion');
			$ok_settings = "<span title='$ok_settings_help' alt='$ok_settings_help'><font color='blue'>".get_string('php_status_ok', 'block_moodleversion')."</font></span>";	
			$error_settings_help = get_string('php_status_error_settings', 'block_moodleversion', implode(", ", $php_settings_check));
			$error_settings = "<a href='$CFG->wwwroot/admin/environment.php' title='$error_settings_help' alt='$error_settings_help'><font color='red'>".get_string('php_status_error', 'block_moodleversion')."</font></a>";
			$this->content->text .= "<br>".get_string('php_settings', 'block_moodleversion')."<b>".(empty($php_settings_check) ? $ok_settings : $error_settings)."</b>";
		}
		
		return $this->content;
	}
}
?>