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
		
		$version = explode(" (Build: ", substr($CFG->release, 0, strlen($CFG->release)-1));
		$dt = new stdClass();
		$dt->year = substr($version[1], 0, 4);
		$dt->month = substr($version[1], 4, 2);
		$dt->date = substr($version[1], 6, 2);
		$mysql = $DB->get_record_sql('SHOW VARIABLES LIKE "version"');
		
		$this->content         =  new stdClass;
		$this->content->text   = get_string('version', 'block_moodleversion')."<b>".$version[0]." (".$CFG->version.")</b>";
		$this->content->text   .= "<br>".get_string('release', 'block_moodleversion')."<b>".get_string('date_release', 'block_moodleversion', $dt)."</b>";
		$this->content->text   .= "<br>PHP: <b>".phpversion()."</b>";
		$this->content->text   .= "<br>MySQL: <b>".$mysql->value."</b>";
		
		return $this->content;
	}
}
?>