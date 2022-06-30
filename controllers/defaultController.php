<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class defaultController extends Controller
{
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('check_email_address'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actioncheck_email_address($email) {		
		$resul = true;
	
	    // First, we check that there's one @ symbol, and that the lengths are right
	    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
	        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
	        $resul = false;
	    }
	    // Split it into sections to make life easier
	    $email_array = explode("@", $email);
	    $local_array = explode(".", $email_array[0]);
	    for ($i = 0; $i < sizeof($local_array); $i++) {
	        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
	            $resul = false;
	        }
	    }
	    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
	        $domain_array = explode(".", $email_array[1]);
	        if (sizeof($domain_array) < 2) {
	            $resul = false; // Not enough parts to domain
	        }
	        for ($i = 0; $i < sizeof($domain_array); $i++) {
	            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
	                $resul = false;
	            }
	        }
	    }

        echo json_encode(array("res"=>$resul));
        die();	    	
	}
	
		
}