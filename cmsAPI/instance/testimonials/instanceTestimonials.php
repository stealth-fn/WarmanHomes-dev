<?php	
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/testimonials/testimonials.php');
	
	class instanceTestimonial extends testimonial{	
		public $moduleTable = "instance_testimonials";
		
		public function __construct($isAjax,$instanceID){		
			parent::__construct($isAjax);
			
			$this->setInstance($instanceID);
		}
	}

	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){
		$moduleObj = new instanceTestimonial(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}
	elseif(isset($_REQUEST["modData"])){
		$moduleObj = new instanceTestimonial(true,isset($_REQUEST["pmpmID"]) ? $_REQUEST["pmpmID"] : 1);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/JSONParse.php');
	}
?>