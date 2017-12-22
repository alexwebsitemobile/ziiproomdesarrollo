<?php

final class ITSEC_Two_Factor_Settings extends ITSEC_Settings {
	public function get_id() {
		return 'two-factor';
	}
	
	public function get_defaults() {
		return array(
			'enabled-providers' => array(
				'Two_Factor_Totp',
				'Two_Factor_Email',
				'Two_Factor_Backup_Codes',
			),
		);
	}
}

ITSEC_Modules::register_settings( new ITSEC_Two_Factor_Settings() );
