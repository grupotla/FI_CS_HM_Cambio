<?php

class MasterUsuariosEmpresasController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','update','GeneratePdf','GenerateExcel'),
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','admin'),//,''), //, 'loadMasterUsuariosEmpresasByAjax', 'loadRoutingsByAjax', 'loadNavierasCreditoByAjax', 'loadCreditosClientesByAjax', 'loadCreditosByAjax', 'loadCreditosByAjax', 'loadCarriersCreditoByAjax', 'loadAvisosByAjax', 'loadAgentesByAjax', 'loadAgentesByAjax', 'loadMasterUsuariosEmpresasLogByAjax'),
				'users'=>array('@'),
			),						
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>Yii::app()->session['permisos'],
				'users'=>array('user'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),				
		);
	}
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{	
		$model = $this->loadModel($id);
	    if (Yii::app()->request->isAjaxRequest) {
	        $this->renderPartial('view',array(
	            'model'=>$model,
	        ), false, true);
	    } else {
			if (!empty($_GET['asDialog']))
		        $this->layout = '//layouts/iframe';	    	

	        $this->render('view',array(
	            'model'=>$model,
	        ));
	    }		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MasterUsuariosEmpresas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MasterUsuariosEmpresas']))
		{
			$model->attributes=$_POST['MasterUsuariosEmpresas'];
			
/*
	
				if (isset($_POST['MasterUsuariosEmpresas']))
	            {
	                $model->MasterUsuariosEmpresas = $_POST['MasterUsuariosEmpresas'];
	                $model->saveWithRelated('MasterUsuariosEmpresas');
	            }

	
				if (isset($_POST['Routings']))
	            {
	                $model->routings = $_POST['Routings'];
	                $model->saveWithRelated('routings');
	            }

	
				if (isset($_POST['NavierasCredito']))
	            {
	                $model->navierasCreditos = $_POST['NavierasCredito'];
	                $model->saveWithRelated('navierasCreditos');
	            }

	
				if (isset($_POST['CreditosClientes']))
	            {
	                $model->creditosClientes = $_POST['CreditosClientes'];
	                $model->saveWithRelated('creditosClientes');
	            }

	
				if (isset($_POST['Creditos']))
	            {
	                $model->creditoses = $_POST['Creditos'];
	                $model->saveWithRelated('creditoses');
	            }

	
				if (isset($_POST['Creditos']))
	            {
	                $model->creditoses = $_POST['Creditos'];
	                $model->saveWithRelated('creditoses');
	            }

	
				if (isset($_POST['CarriersCredito']))
	            {
	                $model->carriersCreditos = $_POST['CarriersCredito'];
	                $model->saveWithRelated('carriersCreditos');
	            }

	
				if (isset($_POST['Avisos']))
	            {
	                $model->avisoses = $_POST['Avisos'];
	                $model->saveWithRelated('avisoses');
	            }

	
				if (isset($_POST['Agentes']))
	            {
	                $model->agentes = $_POST['Agentes'];
	                $model->saveWithRelated('agentes');
	            }

	
				if (isset($_POST['Agentes']))
	            {
	                $model->agentes = $_POST['Agentes'];
	                $model->saveWithRelated('agentes');
	            }

	
				if (isset($_POST['MasterUsuariosEmpresasLog']))
	            {
	                $model->MasterUsuariosEmpresasLogs = $_POST['MasterUsuariosEmpresasLog'];
	                $model->saveWithRelated('MasterUsuariosEmpresasLogs');
	            }


*/

			$model->id_usuario_reg = Yii::app()->user->id;
			$model->modificado = date("Y-m-d h:i:s");
				
			if($model->save()){
	            if (!empty($_GET['asDialog']))
	            {
	                //Close the dialog, reset the iframe and update the grid
	                echo CHtml::script("	                
	                window.parent.$('#cru-dialog').dialog('close');
	                window.parent.$('#cru-frame').attr('src','');
	                window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
	                ");
	                Yii::app()->end();
	            }
	            else
					$this->redirect(array('view','id'=>$model->id_usuario));
			}
		}

		if( Yii::app()->request->isAjaxRequest )
	    {
	        $this->renderPartial('create',array(
	            'model'=>$model,
	        ), false, true);
	    }
	    else
	    {
		    if (!empty($_GET['asDialog']))
		        $this->layout = '//layouts/iframe';

	        $this->render('create',array(
	            'model'=>$model,
	        ));
	    }		
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MasterUsuariosEmpresas']))
		{
			$model->attributes=$_POST['MasterUsuariosEmpresas'];
			
/*
	
				if (isset($_POST['MasterUsuariosEmpresas']))
	            {
	                $model->MasterUsuariosEmpresas = $_POST['MasterUsuariosEmpresas'];
	                $model->saveWithRelated('MasterUsuariosEmpresas');
	            }

	
				if (isset($_POST['Routings']))
	            {
	                $model->routings = $_POST['Routings'];
	                $model->saveWithRelated('routings');
	            }

	
				if (isset($_POST['NavierasCredito']))
	            {
	                $model->navierasCreditos = $_POST['NavierasCredito'];
	                $model->saveWithRelated('navierasCreditos');
	            }

	
				if (isset($_POST['CreditosClientes']))
	            {
	                $model->creditosClientes = $_POST['CreditosClientes'];
	                $model->saveWithRelated('creditosClientes');
	            }

	
				if (isset($_POST['Creditos']))
	            {
	                $model->creditoses = $_POST['Creditos'];
	                $model->saveWithRelated('creditoses');
	            }

	
				if (isset($_POST['Creditos']))
	            {
	                $model->creditoses = $_POST['Creditos'];
	                $model->saveWithRelated('creditoses');
	            }

	
				if (isset($_POST['CarriersCredito']))
	            {
	                $model->carriersCreditos = $_POST['CarriersCredito'];
	                $model->saveWithRelated('carriersCreditos');
	            }

	
				if (isset($_POST['Avisos']))
	            {
	                $model->avisoses = $_POST['Avisos'];
	                $model->saveWithRelated('avisoses');
	            }

	
				if (isset($_POST['Agentes']))
	            {
	                $model->agentes = $_POST['Agentes'];
	                $model->saveWithRelated('agentes');
	            }

	
				if (isset($_POST['Agentes']))
	            {
	                $model->agentes = $_POST['Agentes'];
	                $model->saveWithRelated('agentes');
	            }

	
				if (isset($_POST['MasterUsuariosEmpresasLog']))
	            {
	                $model->MasterUsuariosEmpresasLogs = $_POST['MasterUsuariosEmpresasLog'];
	                $model->saveWithRelated('MasterUsuariosEmpresasLogs');
	            }


*/

			$model->id_usuario_reg = Yii::app()->user->id;
			$model->modificado = date("Y-m-d h:i:s");


			if($model->save()){
	            if (!empty($_GET['asDialog']))
	            {
	                //Close the dialog, reset the iframe and update the grid
	                echo CHtml::script("	                
	                window.parent.$('#cru-dialog').dialog('close');
	                window.parent.$('#cru-frame').attr('src','');
	                window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
	                ");
	                Yii::app()->end();
	            }
	            else
					$this->redirect(array('view','id'=>$model->id_usuario));
			}
		}

	    if( Yii::app()->request->isAjaxRequest )
	        {
	        $this->renderPartial('update',array(
	            'model'=>$model,
	        ), false, true);
	    }
	    else
	    {
		    if (!empty($_GET['asDialog']))
		        $this->layout = '//layouts/iframe';
	    	
	        $this->render('update',array(
	            'model'=>$model,
	        ));
	    }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(!isset($_GET['asDialog'])) $_GET['asDialog'] = "";
		$dataProvider=new CActiveDataProvider('MasterUsuariosEmpresas');
	    if (Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('index',array(
				'dataProvider'=>$dataProvider,
				'asDialog'=>'',
			));	        
	    } else {
			if (!empty($_GET['asDialog']))
		        $this->layout = '//layouts/iframe';	    	
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'asDialog'=>$_GET['asDialog'],
			));
	    }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MasterUsuariosEmpresas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MasterUsuariosEmpresas']))
			$model->attributes=$_GET['MasterUsuariosEmpresas'];
		$this->layout = '//layouts/column1';
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MasterUsuariosEmpresas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MasterUsuariosEmpresas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La pagina solicitada no existe.');
		return $model;
	}

    public function actionGenerateExcel()
	{
		$session=new CHttpSession;
		$session->open();		

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); 
		
		if(isset($session['MasterUsuariosEmpresas_records']))
			$model = MasterUsuariosEmpresas::model()->findAll($session['MasterUsuariosEmpresas_records']);
		else
			$model = MasterUsuariosEmpresas::model()->findAll();
		
		Yii::app()->request->sendFile('PDF_MasterUsuariosEmpresas_'.date('YmdHis').'.xls',
			$this->renderPartial('reportExcel', array(
				'model'=>$model
			), true)
		);
	}	

   
    public function actionGeneratePdf() 
	{
		$session=new CHttpSession;
		$session->open();
		
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); 
		
		if(isset($session['MasterUsuariosEmpresas_records']))
			$model = MasterUsuariosEmpresas::model()->findAll($session['MasterUsuariosEmpresas_records']);
		else
			$model = MasterUsuariosEmpresas::model()->findAll();
			
		if (count($model) > 500) {		
			throw new CHttpException(405,'La pagina solicitada es demasiado extensa minimize los datos. ('.count($model).')');			
		} else {		
									//$orientation,$format,$langue,$unicode,$encoding,$marges
			$html2pdf = Yii::app()->ePdf->HTML2PDF('P','A4','en',true,'UTF-8',array(5,5,5,5));
	       	$html2pdf->pdf->SetTitle('PDF_MasterUsuariosEmpresas');
	       	$html2pdf->pdf->SetDisplayMode('fullpage');
	        $html = $this->renderPartial('reportPdf', array('model'=>$model,'title'=>'MasterUsuariosEmpresas'), true);	        
	        $html2pdf->WriteHTML($html);
	        $html2pdf->Output('PDF_MasterUsuariosEmpresas_'.date('YmdHis').'.pdf');
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param MasterUsuariosEmpresas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-empresas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
/*

	
			public function actionLoadMasterUsuariosEmpresasByAjax($index)
			{
				$model = new MasterUsuariosEmpresas;
				$this->renderPartial('/MasterUsuariosEmpresas/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadRoutingsByAjax($index)
			{
				$model = new Routings;
				$this->renderPartial('/Routings/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadNavierasCreditoByAjax($index)
			{
				$model = new NavierasCredito;
				$this->renderPartial('/NavierasCredito/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadCreditosClientesByAjax($index)
			{
				$model = new CreditosClientes;
				$this->renderPartial('/CreditosClientes/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadCreditosByAjax($index)
			{
				$model = new Creditos;
				$this->renderPartial('/Creditos/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadCreditosByAjax($index)
			{
				$model = new Creditos;
				$this->renderPartial('/Creditos/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadCarriersCreditoByAjax($index)
			{
				$model = new CarriersCredito;
				$this->renderPartial('/CarriersCredito/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadAvisosByAjax($index)
			{
				$model = new Avisos;
				$this->renderPartial('/Avisos/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadAgentesByAjax($index)
			{
				$model = new Agentes;
				$this->renderPartial('/Agentes/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadAgentesByAjax($index)
			{
				$model = new Agentes;
				$this->renderPartial('/Agentes/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

	
			public function actionLoadMasterUsuariosEmpresasLogByAjax($index)
			{
				$model = new MasterUsuariosEmpresasLog;
				$this->renderPartial('/MasterUsuariosEmpresasLog/child_form', array(
					'model' => $model,
					'index' => $index,
					'call' => 'MasterUsuariosEmpresas',
				));
			}

*/
}
