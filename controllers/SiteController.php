<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		
		unset(Yii::app()->session['selected']);
		unset(Yii::app()->session['name']);
		unset(Yii::app()->session['database']);	
		
				
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				if (!empty($_GET['asDialog']))
			        $this->layout = '//layouts/iframe';	    	
				$this->render('error', $error);
			}
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {

				Yii::app()->user->setFlash("success", "Contraseña de correo cambiada satisfactoriamente." );	 
				$this->redirect(array("login"));
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	

	public function actionRecuperar()
	{
		$login=new LoginForm;
		
		$login->setScenario('ScenarioRescue');
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$login->attributes=$_POST['LoginForm'];						
			$login->email = strtolower(trim($login->email));			
			$username = explode("@",$login->email);			
			$model = MasterUsuariosEmpresas::model()->find('LOWER(pw_name)=? AND LOWER(dominio)=?',array(strtolower($username[0]),strtolower($username[1])));		
			
					
			if ($model) {
				
				
				if ($model->pw_activo == 1) {
				
					
					if ($model->pw_correo == 1) {
					
				
						if (empty($model->locode)) $model->locode = '.';
						
						$length = rand(8, 10);
						$new_password = substr(str_shuffle ("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);				
						$password = $model->pw_passwd;
						
						$model->pw_passwd = md5($new_password);
						
						$model->pw_sis_id = 0; //flag para reinicio de contraseña, no hace update a fecha
						
						if ($model->save()) {
						
							//se comenta temporalmente porque no es posible hacer este reset en cuenta de correo 2016-06-14
							//Yii::app()->session['url'] = "https://mail2.aimargroup.com/qmailadmin/index.cgi/passwd/?address=".$model->pw_name."@".$model->dominio."&oldpass=".$password."&newpass1=".$new_password."&newpass2=".$new_password;
													
							
							//$name='=?UTF-8?B?'.base64_encode($model->username).'?=';
							//$subject='=?UTF-8?B?'.base64_encode("Reinicio de Contraseña").'?=';
							//$headers="From: $name <{Yii::app()->params['adminEmail']}>\r\n".
							//	"Reply-To: {Yii::app()->params['adminEmail']}\r\n".
							//	"MIME-Version: 1.0\r\n".
							//	"Content-Type: text/plain; charset=UTF-8";
							//mail($model->email,$subject,$temp_pass,$headers);
							
							//Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
							
							//logo & firma auto replace 
							$html = "
							<img src='data:image/jpeg;base64,#*logo*#' />
							<p>Estimado Usuario " . $model->pw_gecos. " : </p>
								
							<p>Fue enviada una solicitud de reinicio de contraseña desde ".$_SERVER['REMOTE_ADDR']."</p>
							<p>Se ha reiniciado su contraseña de forma temporal.</p>
							<p>La contraseña temporal es : $new_password</p>
							<p>Para desbloquear su usuario y asignar una contraseña personal, por favor acceder <a href='http://10.10.1.20/catalogo_admin/cambio/index.php'><font color=red>AQUI</font></a>.</p>
								
							</p>Atentamente,</p>
							</p>#*firma*#</p>
							</p><strong>IMPORTANTE:</strong>
							Favor no responder este email ya que fue enviado desde un sistema automaticamente y no tendrá respuesta desde esta dirección de correo.</p>";

							
							try {

								/*
								require_once('phpmailer/class.phpmailer.php');							
								$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch	
						        $mail->CharSet 	= "utf-8";
						        $mail->From     = 'tracking@aimargroup.com';
						        $mail->FromName = 'Reinicio de Contraseña';
						        $mail->Host     = "mail.aimargroup.com";
						        $mail->Port     = 25;
						        $mail->Mailer   = "smtp";
							    $mail->Subject	= "Reinicio de Contraseña AIMAR";
								$mail->IsHTML(true);
								$mail->AddAddress($login->email,$username[0]);
								$mail->Body = $html;								
								$res = $mail->Send();								
								if ($res)
									Yii::app()->user->setFlash("success", "Se envio una contraseña temporal al correo ".$login->email.", porfavor revisar." );	
								else 
									Yii::app()->user->setFlash("error", "Contraseña fue reiniciada correctamente ($new_password)".$res);								
								*/


								//$url = "http://10.10.1.32:60982/SendParametros.asmx?wsdl";//desarrollo					
								$url = "http://10.10.1.21:7480/SendParametros.asmx?wsdl";//produccion
	
								$client_mail = new SoapClient($url);   
																
		
								$load = $client_mail->SendMail(
									array(
										'pais_iso' => $model->pais,
										'to' => $login->email,
										'subject' => "Reinicio de Contraseña #*firma*# ", //auto replace 
										'body' => base64_encode($html),
										'fromName' => '', //le asigna la firma automatica
										'sistema' => 'CAMBIO', 
										'user' => $model->pw_name, 
										'ip' => $_SERVER['REMOTE_ADDR'], 
									)
								);
							
								$result = $load->SendMailResult;
		
								if ($result->stat == 1)
									Yii::app()->user->setFlash("success", "Se envio una contraseña temporal al correo ".$login->email.", porfavor verificar." );	
								else 
									Yii::app()->user->setFlash("error", "Contraseña fue reiniciada correctamente ($new_password) <br>Nota : " . $result->msg);

									print_r($result);
								
								
							} catch (phpmailerException $e) {		  	
							
								Yii::app()->user->setFlash("error", "Contraseña fue reiniciada correctamente ($new_password)".$e->errorMessage());
								$this->redirect(array("recuperar"));	
								
							} catch (Exception $e) {		  
							  	
							  	Yii::app()->user->setFlash("error", "Contraseña fue reiniciada correctamente ($new_password)".$e->errorMessage());
							  	$this->redirect(array("recuperar"));	
							}						
													
						} else {		
							
							Yii::app()->user->setFlash("error", $user->getErrors());
						}
						
					} else {
						
						Yii::app()->user->setFlash("error", "Usuario ".$username[0]." no tiene correo.");
					}

				} else {
								
					Yii::app()->user->setFlash("error", "Usuario ".$username[0]." no esta activo.");
				}
			
			} else {
	
				Yii::app()->user->setFlash("error", "Email ".$login->email." no encontrado o no valido.");
			}
			
			$this->redirect(array("recuperar"));	
		}
		
		$this->render('recuperar',array('model'=>$login));
	}
	
	
	public function actionCheck_email_address($email) {		
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
	    
	    if (isset($email_array[1]))
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
	
		

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function exit_load($view,$title,$msg)
	{			
		$session=new CHttpSession;
		$session->open();			
		$session['message'] = $msg;
		$session['title'] = $title;
		$this->redirect(array($view,'exit_load'=>1));		
	}

	/*
	public function actionChangepassword()
	{      
	
		if (isset($_GET['var'])) {
			$var = explode("&",base64_decode($_GET['var']));	
			foreach ($var as $field => $value) {			
				list($field,$value) = explode("=",$value);			
				$_GET[$field] = $value;
			}		
			
			//echo "<pre>";
			//print_r($_GET);
			//echo "</pre>";
			//die();
			
		}
	
	
		if(isset($_POST['MasterUsuariosEmpresas'])) $process = "Procesando Contraseñas"; else $process="Validando Datos";
		
		if (!isset($_GET['id_usuario'])) 
			$this->exit_load('notallowed',$process,'No hay usuario valido');			
			
		if (!isset($_GET['pw_passwd_fecha'])) 
			$this->exit_load('notallowed',$process,'No hay fecha inicial');			
			
		if (!isset($_GET['pw_solicitud'])) 
			$this->exit_load('notallowed',$process,'No hay fecha solicitud');		
		
		$now = date("Y-m-d H:i:s");	//24 hrs format		
		
		//$_GET['pw_solicitud'] = substr($_GET['pw_solicitud'],0,19);
		
		$minutos = (strtotime($now) - strtotime($_GET['pw_solicitud'])) / 60;
					

				
		if ($minutos > 30) 
			$this->exit_load('notallowed',$process,'El Cambio Contraseña tenia un tiempo limitado para realizarse.<br>Su session ya vencio.');
			
			//."<br><br>(" . $now  . ")(". $_GET['pw_solicitud'] . ")<br>(" . strtotime($now) . ")(" . strtotime($_GET['pw_solicitud']) . ")(".$minutos.")");
		
		$model = MasterUsuariosEmpresas::model()->findByPk($_GET['id_usuario']);
	
		if (!$model) 
			$this->exit_load('notallowed',$process,'No hay registro valido!!');			

		if ($dias < $model->pw_passwd_dias) 
			$this->exit_load('notallowed',$process,'Acceso invalido password no ha caducado');
					
		if (trim($model->pw_passwd_fecha) != trim($_GET['pw_passwd_fecha']))
			$this->exit_load('notallowed',$process,'Acceso invalido fecha no coincide ');//.$model->pw_passwd_fecha.' '.$_GET['pw_passwd_fecha']);				
					
		$dias = (strtotime($_GET['pw_solicitud'])-strtotime($_GET['pw_passwd_fecha']))/86400;
	
		$dias = abs($dias); 
		$dias = floor($dias);
			
		$model->setScenario('changePwd');
		
		if(isset($_POST['MasterUsuariosEmpresas'])){
			
			//print_r($_GET);
			//die();

			$model->attributes = $_POST['MasterUsuariosEmpresas'];

			$pass = $model->new_password;
			$str[] = '0,1,2,3,4,5,6,7,8,9';
			$str[] = 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z';
			$str[] = '!,@,#,$,%,&';
			$str[] = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
			$c = 0;
			foreach ($str as $string) {
				foreach (explode(',',$string) as $char) {
					if (strpos($pass,$char)) {
						$c++;
						break;
					}
				}
			}
			
			if ($c == count($str)) {

				$valid = $model->validate();

				if($valid){
			  		
					//$model->id_usuario_reg = Yii::app()->user->id;
					//$model->modificado = date("Y-m-d h:i:s");
					
			  		$model->pw_passwd = md5($model->new_password);
			  		
			  		if($model->save()) {
				  		
						//Yii::app()->user->logout();
			    		//$this->redirect(array('/site/login'));
			    		
			    		$this->exit_load('success',$process,'Contraseña fue cambiada correctamente');
						
					} else {
			  			
			    		$this->exit_load('notallowed',$process,'Ocurrio un error, contraseña no fue cambiada');
						
					}
					
			    } else {

			    	$this->exit_load('notallowed',$process,'Ocurrio un error, cierre esta ventana e inicie de nuevo '.print_r($valid));					
				}
				
			} else {

		    	$this->exit_load('notallowed',$process,'Debe ingresar al menos un numero, una letra minuscula, una letra mayuscula, un caracter !@#$%&');
				
			}
						
		}

		$this->layout = '//layouts/column1';	    	
		
		$this->render('changepassword',array('model'=>$model)); 
			
	}	
	
	public function actionnotallowed()
	{		
		if (!isset($_REQUEST['exit_load'])) {
			$session=new CHttpSession;
			$session->open();
			$session['title'] = "Acceso invalido";
			$session['message'] = "Ninguna accion que realizar!<br>".$_SERVER['REMOTE_ADDR']."<br>".date("d/m/Y H:i:s");
		}
		$this->render('notallowed');
	}	

	public function actionSuccess()
	{
		$this->render('success');
	}	
	*/
				
}

