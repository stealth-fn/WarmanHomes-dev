<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Image Size</title>
		
		<style type="text/css">
			div.slider{ 
				width:256px; 
				margin:10px 0; 
				background-color:#ccc; 
				height:10px; 
				position: relative; 
			}
			
			div.slider div.handle{ 
				width:10px; 
				height:15px; 
				background-color:#f00; 
				cursor:move; 
				position: absolute; 
			}
			
			div#zoom_element_small{ 
				width:50px; 
				height:50px; 
				background:#2d86bd; 
				position:relative; 
			}
			
			div#zoom_element_medium{ 
				width:175px; 
				height:175px; 
				background:#FF6633; 
				position:relative; 
			}
			
			div#zoom_element_large{ 
				width:335px; 
				height:335px; 
				background:#0066FF;
				position:relative; 
			}
		</style>
		
		<!--javascript effects-->
		<script src="/js/scriptaculous-js-1.8.3/lib/prototype.js" type="text/javascript"></script>
		<script src="/js/scriptaculous-js-1.8.3/src/scriptaculous.js" type="text/javascript"></script>
		
		<script language="javascript" type="text/javascript">	
			function setImgValue(sizeID,dimensions){								
				if(sizeID == 1){
					window.opener.document.getElementById("thumbWidth").value = dimensions;
					window.opener.document.getElementById("thumbHeight").value = dimensions;
				}
				else if(sizeID == 2){
					window.opener.document.getElementById("mediumWidth").value = dimensions;
					window.opener.document.getElementById("mediumHeight").value = dimensions;
				}
				else if(sizeID == 3){
					window.opener.document.getElementById("largeWidth").value = dimensions;
					window.opener.document.getElementById("largeHeight").value = dimensions;
				}			
				window.close();			
			}
		</script>		
	</head>	
	<body>	
		<?php
			if($_GET["size"] == 1){
				echo '
				<input type="button" id="valBtn" name="valBtn" onclick="setImgValue(\'1\',document.getElementById(\'zoom_element_small\').offsetWidth)" value="Set Size"/>
				<p>Use the slider to adjust the thumbnail sizes.</p>
				<div id="zoom_slider_small" class="slider">
					<div class="handle"></div>
				</div>
				<div id="zoom_element_small"></div>
			<script type="text/javascript">
			  (function() {
				var zoom_slider_small = $("zoom_slider_small"),
					box_small = $("zoom_element_small");
			
				new Control.Slider(zoom_slider_small.down(".handle"), zoom_slider_small, {
				  range: $R(40, 160),
				  sliderValue: 50,
				  onSlide: function(value) {
					box_small.setStyle({ width: value + "px", height: value + "px" });
				  },
				  onChange: function(value) { 
					box_small.setStyle({ width: value + "px", height: value + "px" });
				  }
				});
			
			  })();
			 </script>';
			}
		?>
		
		<?php
			if($_GET["size"] == 2){	
				echo '
				<input type="button" onclick="setImgValue(\'2\',document.getElementById(\'zoom_element_medium\').offsetWidth)" value="Set Size"/>
				<p>Use the slider to adjust the medium sizes.</p>
				<div id="zoom_slider_medium" class="slider">
					<div class="handle"></div>
				</div>
				<div id="zoom_element_medium"></div>
			
			<script language="javascript" type="text/javascript">  
				(function() {
				var zoom_slider_medium = $("zoom_slider_medium"),
					box_medium = $("zoom_element_medium");
			
				new Control.Slider(zoom_slider_medium.down(".handle"), zoom_slider_medium, {
				  range: $R(160, 300),
				  sliderValue: 175,
				  onSlide: function(value) {
					box_medium.setStyle({ width: value + "px", height: value + "px" });
				  },
				  onChange: function(value) { 
					box_medium.setStyle({ width: value + "px", height: value + "px" });
				  }
				});
			
			  })();
			</script>';
			}
		?>
			
		<?php
			if($_GET["size"] == 3){	
				echo '
				<input type="button" onclick="setImgValue(\'3\',document.getElementById(\'zoom_element_large\').offsetWidth)" value="Set Size"/>
				<p>Use the slider to adjust the large sizes.</p>
				<div id="zoom_slider_large" class="slider">
					<div class="handle"></div>
				</div>
				<div id="zoom_element_large"></div>
				
			<script language="javascript" type="text/javascript">	
				  (function() {
				var zoom_slider_large = $("zoom_slider_large"),
					box_large = $("zoom_element_large");
			
				new Control.Slider(zoom_slider_large.down(".handle"), zoom_slider_large, {
				  range: $R(300, 640),
				  sliderValue: 335,
				  onSlide: function(value) {
					box_large.setStyle({ width: value + "px", height: value + "px" });
				  },
				  onChange: function(value) { 
					box_large.setStyle({ width: value + "px", height: value + "px" });
				  }
				});
			
			
			  })();
		</script>';
			}
		?>
	</body>
</html>