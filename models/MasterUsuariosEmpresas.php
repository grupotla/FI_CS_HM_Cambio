<?php

/**
 * This is the model class for table "usuarios_empresas".
 *
 * The followings are the available columns in table 'usuarios_empresas':
 * @property string $id_usuario
 * @property string $pw_name
 * @property string $pw_passwd
 * @property integer $pw_uid
 * @property integer $pw_gid
 * @property string $pw_gecos
 * @property string $pw_dir
 * @property string $pw_shell
 * @property integer $tipo_usuario
 * @property string $pais
 * @property string $dominio
 * @property integer $level
 * @property integer $pw_activo
 * @property string $pw_codigo_tributario
 * @property integer $pw_correo
 * @property integer $id_usuario_reg
 * @property string $modificado
 * @property string $locode
 * @property integer $planilla_numero
 *
 * The followings are the available model relations:
 * @property Catalogos[] $catalogoses
 * @property DefinicionUsuario $tipoUsuario
 * @property MasterUsuariosEmpresas $idUsuarioReg
 * @property MasterUsuariosEmpresas[] $MasterUsuariosEmpresas
 * @property UsuariosPaises $pais0
 * @property Routings[] $routings
 * @property NavierasCredito[] $navierasCreditos
 * @property CreditosClientes[] $creditosClientes
 * @property Creditos[] $creditoses
 * @property Creditos[] $creditoses1
 * @property CarriersCredito[] $carriersCreditos
 * @property Avisos[] $avisoses
 * @property Agentes[] $agentes
 * @property Agentes[] $agentes1
 * @property MasterUsuariosEmpresasLog[] $MasterUsuariosEmpresasLogs
 */
class MasterUsuariosEmpresas extends CActiveRecord
{
	
	
	public $old_password;
    public $new_password;
    public $repeat_password;
    
    	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_empresas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$disabled = array('','disabled');				
		if (Yii::app()->user->name  != "admin1") 
			$disabled = array('pw_name, pw_passwd, pw_gecos, dominio, level, pw_dir, locode, tipo_usuario, pais, pw_activo', 'disabled', 'on'=>'update');
						
		return array(
			$disabled,
			array('id_usuario_reg, modificado', 'disabled'),
		
	        array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
	        array('old_password', 'findPasswords', 'on' => 'changePwd'),
	        array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changePwd'),
			array('new_password', 'length', 'min'=>7, 'max'=>20),
			
			array('new_password', 'match', 'pattern'=>'/^[A-Za-z0-9_!@#$%^&*()+=?.,]+$/u', 'message'=>'Espacios o caracteres especiales no son permitidos'),
			
			array('pw_name, pw_passwd, pw_gecos, tipo_usuario, pais, dominio, locode', 'required'),
			array('pw_uid, pw_gid, tipo_usuario, level, pw_activo, pw_correo, id_usuario_reg, planilla_numero', 'numerical', 'integerOnly'=>true),
			array('pw_name', 'length', 'max'=>32),
			array('pw_passwd', 'length', 'max'=>40),
			array('pw_gecos', 'length', 'max'=>48),
			array('pw_dir', 'length', 'max'=>160),
			array('pw_shell', 'length', 'max'=>20),
			array('pais', 'length', 'max'=>5),
			array('dominio, pw_codigo_tributario', 'length', 'max'=>30),
			array('locode', 'length', 'max'=>3),
			array('modificado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, pw_name, pw_passwd, pw_uid, pw_gid, pw_gecos, pw_dir, pw_shell, tipo_usuario, pais, dominio, level, pw_activo, pw_codigo_tributario, pw_correo, id_usuario_reg, modificado, locode, planilla_numero', 'safe', 'on'=>'search'),
		);
	}


	//matching the old password with your existing password.
    public function findPasswords($attribute, $params)
    {
        $user = MasterUsuariosEmpresas::model()->findByPk($_GET['id_usuario']);
        if ($user->pw_passwd != md5($this->old_password))
            $this->addError($attribute, CHtml::encode($this->getAttributeLabel('old_password')) . ', is incorrecto.');
    }


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catalogoses' => array(self::MANY_MANY, 'Catalogos', 'usuarios_catalogos(id_usuario, id_catalogo)'),
			'tipoUsuario' => array(self::BELONGS_TO, 'MasterDefinicionUsuario', 'tipo_usuario'),
			'idUsuarioReg' => array(self::BELONGS_TO, 'MasterUsuariosEmpresas', 'id_usuario_reg'),
			'MasterUsuariosEmpresas' => array(self::HAS_MANY, 'MasterUsuariosEmpresas', 'id_usuario_reg'),
			'pais0' => array(self::BELONGS_TO, 'MasterUsuariosPaises', 'pais'),
			'routings' => array(self::HAS_MANY, 'Routings', 'vendedor_id'),
			'navierasCreditos' => array(self::HAS_MANY, 'NavierasCredito', 'id_usuario'),
			'creditosClientes' => array(self::HAS_MANY, 'CreditosClientes', 'id_usuario'),
			'creditoses' => array(self::HAS_MANY, 'Creditos', 'id_usuario_autoriza'),
			'creditoses1' => array(self::HAS_MANY, 'Creditos', 'id_usuario_crea'),
			'carriersCreditos' => array(self::HAS_MANY, 'CarriersCredito', 'id_usuario'),
			'avisoses' => array(self::HAS_MANY, 'Avisos', 'id_usuario'),
			'agentes' => array(self::HAS_MANY, 'Agentes', 'id_usuario_creacion'),
			'agentes1' => array(self::HAS_MANY, 'Agentes', 'id_usuario_modificacion'),
			'MasterUsuariosEmpresasLogs' => array(self::HAS_MANY, 'MasterUsuariosEmpresasLog', 'user_id'),
			
			//'division'=>array(self::HAS_MANY, 'ContactosDivisiones', 'id_usuario', 'condition'=>"division.catalogo = 'USUARIO'",'on'=>'id_usuario = division.id_catalogo' ),
			
			
			'division' => array(self::HAS_MANY, 'ContactosDivisiones', '', 'foreignKey' => array('id_catalogo'=>'id_usuario'),'condition'=>"catalogo = 'USUARIO'"),
			
			
    			
			//'usuariosDivisiones'=>array(self::HAS_ONE, 'Divisiones', ['id_catalogo'=>'id_usuario'], 'condition'=>"catalogo = 'USUARIO'" ),

			//'usuariosDivisiones'=>array(self::HAS_MANY, 'Divisiones', ['id_catalogo'=>'id_usuario'] ),
			
			
			//'divisiones'=>array(self::HAS_MANY, 'Diviciones', ('id_catalogo'='id_usuario') ),
		);
	
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Id Usuario',
			'pw_name' => 'Pw Name',
			'pw_passwd' => 'Pw Passwd',
			'pw_uid' => 'Pw Uid',
			'pw_gid' => 'Pw Gid',
			'pw_gecos' => 'Pw Gecos',
			'pw_dir' => 'Pw Dir',
			'pw_shell' => 'Pw Shell',
			'tipo_usuario' => 'Tipo Usuario',
			'pais' => 'Pais',
			'dominio' => 'Dominio',
			'level' => 'Level',
			'pw_activo' => 'Pw Activo',
			'pw_codigo_tributario' => 'Pw Codigo Tributario',
			'pw_correo' => 'Pw Correo',
			'id_usuario_reg' => 'Id Usuario Reg',
			'modificado' => 'Modificado',
			'locode' => 'Locode',
			'planilla_numero' => 'Planilla Numero',
			

	        'old_password' => 'Password Actual',
	        'new_password' => 'Password Nuevo',
	        'repeat_password' =>'Repeat Password Nuevo',
	        			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('pw_name',$this->pw_name,true);
		$criteria->compare('pw_passwd',$this->pw_passwd,true);
		$criteria->compare('pw_uid',$this->pw_uid);
		$criteria->compare('pw_gid',$this->pw_gid);
		$criteria->compare('pw_gecos',$this->pw_gecos,true);
		$criteria->compare('pw_dir',$this->pw_dir,true);
		$criteria->compare('pw_shell',$this->pw_shell,true);
		$criteria->compare('tipo_usuario',$this->tipo_usuario);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('dominio',$this->dominio,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('pw_activo',$this->pw_activo);
		$criteria->compare('pw_codigo_tributario',$this->pw_codigo_tributario,true);
		$criteria->compare('pw_correo',$this->pw_correo);
		$criteria->compare('id_usuario_reg',$this->id_usuario_reg);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('locode',$this->locode,true);
		$criteria->compare('planilla_numero',$this->planilla_numero);
		//$criteria->condition = "";		
		//$criteria->order = "";
		
		$session=new CHttpSession;
		$session->open();		
		$session['MasterUsuariosEmpresas_records'] = $criteria;		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterUsuariosEmpresas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
/** 2015-08-28
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		//return CPasswordHelper::verifyPassword($password,$this->us_pass);
		return md5($password)===$this->pw_passwd || $password===$this->pw_passwd; 
	}

	/** 
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
		
	/*
    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior')
        );
    }
    */	
	
}
