<?php
	class clickSlide{	
	
		#our JS object name and the prefix for the HTML id's
		public $idClassPrefix;
		
		public $slideQty;
		
		public function __construct($idcp,$sq){
			$this->idClassPrefix = $idcp;
			$this->slideQty = $sq;
		}
		
		public function getClickSlide($cdData,$multiID){
			
			#primary container that displays our images
			$clickSlide = ' 
			<div 
				id="' . $this->idClassPrefix . '-CSContain-' . $multiID . '" 
				class="' . $this->idClassPrefix . '-CSContain"
			>
				<!--left button-->
				<div 
					class="' . $this->idClassPrefix  . '-CSLeft ' . $this->idClassPrefix  . '-CSArrow" 
					id="' . $this->idClassPrefix  . '-CSLeft-' . $multiID . '" 
					onclick="' . $this->idClassPrefix  . '_' . $multiID . '.csSlide(0)"
				>
				</div>
				<div 
					id="' . $this->idClassPrefix  . '-CSRail-' . $multiID . '" 
					class="' . $this->idClassPrefix  . '-CSRail"
				>';
							
			$clickSlideContent = "";
			
			#what element we're at in the CSBaseContainer
			$baseCnt = 1;
			#how many elements we're currently at
			$currentCnt = 1;
			#what CSBaseContainer we're at
			$containCnt = 0;
			#how many elements we have to add
			$dataLen = count($cdData);
			
			/*the only item in the CSRail at the start is the firt CSBaseContainer
			the others are loaded into the storage container*/
			foreach($cdData as $d){
				if($baseCnt==1){
					$clickSlideContent .= '<div 
												class="' . $this->idClassPrefix  . '-CSBaseContainer" 
												id="' . $this->idClassPrefix  . '-CSBaseContainer-' . $multiID . '-' . $containCnt . '"
											>';
				}
				
				#base click slide object
				foreach($d as $i){
					$clickSlideContent .= $i;
				}
				
				#this CSBaseContainer is full, close it and reset counter
				if($baseCnt==$this->slideQty){
					$clickSlideContent .= '</div>';
					#load the rest into the storage container
					if($containCnt == 0){
						$clickSlideContent .= '</div><div 
													class="CSStorageContainer"
													id="' . $this->idClassPrefix  . '-CSStorageContainer-' . $multiID . '"
												>';
					}
					$baseCnt = 1;
					$containCnt++;
				}
				#looped through all base objects
				elseif($baseCnt < $this->slideQty && $dataLen == $currentCnt){
					$clickSlideContent .= '</div>';
				}
				else{
					$baseCnt++;
				}
				$currentCnt++;
				
			}
			
			$clickSlide .= $clickSlideContent . '</div>
				<!--right button-->
				<div 
					class="' . $this->idClassPrefix  . '-CSRight ' . $this->idClassPrefix  . '-CSArrow" 
					id="' . $this->idClassPrefix  . '-CSRight-' . $multiID . '" 
					onclick="' . $this->idClassPrefix . '_' . $multiID . '.csSlide(1)"
				>
				</div>
			</div>';
			
			
			return $clickSlide;
		}
	}
		
	/*ajax, our first parameter is the function name, the other parameters are parameters for that function*/
	if(isset($_REQUEST["function"])){
		$moduleObj = new clickSlide(true);
		require_once($_SERVER['DOCUMENT_ROOT'].'/cmsAPI/ajaxParse.php');
	}	
?>