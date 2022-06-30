<?php

/**
 * This is the model class for table "usuarios_empresas_passwds".
 *
 * The followings are the available columns in table 'usuarios_empresas_passwds':
 * @property integer $id_usuario_passwd
 * @property integer $id_usuario
 * @property string $pw_passwd
 * @property string $modificado
 * @property string $pw_user_ip
 * @property integer $pw_sis_id
 *
 * The followings are the available model relations:
 * @property UsuariosEmpresas $idUsuario
 */
class UsuariosEmpresasPasswds extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_empresas_passwds';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, pw_sis_id', 'numerical', 'integerOnly'=>true),
			array('pw_passwd', 'length', 'max'=>40),
			array('pw_user_ip', 'length', 'max'=>15),
			array('modificado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario_passwd, id_usuario, pw_passwd, modificado, pw_user_ip, pw_sis_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idUsuario' => array(self::BELONGS_TO, 'UsuariosEmpresas', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario_passwd' => 'Id Usuario Passwd',
			'id_usuario' => 'Id Usuario',
			'pw_passwd' => 'Pw Passwd',
			'modificado' => 'Modificado',
			'pw_user_ip' => 'Pw User Ip',
			'pw_sis_id' => 'Pw Sis',
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

		$criteria->compare('id_usuario_passwd',$this->id_usuario_passwd);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('pw_passwd',$this->pw_passwd,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('pw_user_ip',$this->pw_user_ip,true);
		$criteria->compare('pw_sis_id',$this->pw_sis_id);
		//$criteria->condition = "";		
		//$criteria->order = "";
		
		$session=new CHttpSession;
		$session->open();		
		$session['UsuariosEmpresasPasswds_records'] = $criteria;		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosEmpresasPasswds the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
