<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/common.php');
	
	class moduleSettings extends common{	
		public $moduleTable = "settings_modules";
		public $moduleName;
		
		public function __construct($isAjax,$moduleName){
			parent::__construct($isAjax);
			$this->moduleName = $moduleName;
			$this->moduleSettingsArray = $this->getSettings();
		}
	}
?>