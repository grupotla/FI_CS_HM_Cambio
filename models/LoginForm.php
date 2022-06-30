<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $old_password;
    public $new_password;
    public $repeat_password;
    public $email;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, new_password, repeat_password', 'required'),
	
			array('email', 'required', 'on'=>'ScenarioRescue'),
			
			// password needs to be authenticated
			array('password', 'authenticate'),			
			
			array('repeat_password', 'compare', 'compareAttribute'=>'new_password'),
			
			array('new_password', 'length', 'min'=>7, 'max'=>20),
			
			array('new_password', 'match', 'pattern'=>'/^[A-Za-z0-9_!@#%^&*()+=?.,]+$/u', 'message'=>'Contraseña nueva, caracteres permitidos : A-Za-z0-9_!@#%^&*()+=?.,'),
			
			//array('new_password', 'match', 'pattern'=>'((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,10})', 'message'=>'Contraseña nueva, no es valida'),
			
						
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'Usuario',
			'password'=>'Contraseña',
	        'new_password' => 'Contraseña Nueva <small style="color:silver;">numeros, letras, signos</small>',//A-Za-z0-9!@#$%^&*()+=?.,
	        'repeat_password' =>'Repetir Contraseña Nueva',			
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	 
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			
			$this->_identity->putNewPassword($this->new_password);
			
			$res = $this->_identity->authenticate();

			/*echo "<pre>";
			print_r($res);
			echo "</pre>";*/			
						
			switch ($res) {
			case 0: //cambio exitoso, luego realiza el cambio en correo, el url se ejecuta al salir de aca				
				$model=MasterUsuariosEmpresas::model()->find('LOWER(pw_name)=? AND pw_passwd=?',array(strtolower($this->username), md5($this->new_password)));
				if ($model) {		
					if ($model->pw_correo == 1)
						Yii::app()->session['url'] = "https://mail2.aimargroup.com/qmailadmin/index.cgi/passwd/?address=".$model->pw_name."@".$model->dominio."&oldpass=".$this->password."&newpass1=".$this->new_password."&newpass2=".$this->new_password;
				}
				break;
			
			case 1:	$this->addError('username','Usuario no Registrado'); break;
			case 2:	$this->addError('password','Usuario no Validado'); break;
			//case 2:	$this->addError('password','Contraseña incorrecta'); break;
			case 98:$this->addError('new_password','La nueva contraseña debe ser distinta a la actual'); 	break;
			case 99:$this->addError('repeat_password','Error al guardar la nueva contraseña'); 				break;
			case 97:$this->addError('new_password','Contraseña se ha usado anteriormente'); 				break;
			case 96:$this->addError('username','Usuario inactivo'); 										break;
			case 95:$this->addError('new_password','Contraseña nueva debe contener al menos un numero, una letra minuscula, una letra mayuscula y un caracter !@#$%&');	break;
			
			default:
				$this->addError('repeat_password','Error no definido' . $res ); 
				break;
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			
			//$this->_identity->putNewPassword($this->new_password);
			
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration = 0;
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
