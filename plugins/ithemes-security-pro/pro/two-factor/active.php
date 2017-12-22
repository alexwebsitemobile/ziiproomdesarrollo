<?php

// Set up Two Factor Scheduling
require_once( 'class-itsec-two-factor.php' );
$itsec_two_factor = new ITSEC_Two_Factor();
$itsec_two_factor->run( ITSEC_Core::get_instance() );
