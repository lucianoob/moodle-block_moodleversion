<?php
if (!defined('MOODLE_INTERNAL'))
    die('Direct access to this script is forbidden.');

class block_moodleversion_edit_form extends block_edit_form {
 
	function specific_definition($mform){
 
		$mform->addElement('header','configheader', get_string('blocksettings', 'block'));
 
		$mform->addElement('advcheckbox', 'config_phpversion', get_string('form_checkbox_php_version', 'block_moodleversion'), '', array('group' => 1), array(0, 1));
		$mform->addElement('advcheckbox', 'config_mysqlversion', get_string('form_checkbox_mysql_version', 'block_moodleversion'), '', array('group' => 1), array(0, 1));
		$mform->addElement('advcheckbox', 'config_phpextensions', get_string('form_checkbox_php_extensions', 'block_moodleversion'), '', array('group' => 1), array(0, 1));
		$mform->addElement('advcheckbox', 'config_phpsettings', get_string('form_checkbox_php_settings', 'block_moodleversion'), '', array('group' => 1), array(0, 1));
	}
}
?>


