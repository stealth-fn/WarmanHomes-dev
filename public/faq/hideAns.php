<?php

	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faq.php");

	$faqObj = new faq(false);

	$primaryModuleQuery = $faqObj->getAllRecords();

	

	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/faq/faqCategories.php");

	$faqCategoryObj = new faqCategory(false);

	$faqCatInfo = $faqCategoryObj->getAllRecords();



	include($_SERVER['DOCUMENT_ROOT']."/cmsAPI/instance/faq/instanceFaq.php");

	$instanceFaq = new instanceFaq(false);

	?>

	<div id="faqContainer">

    <?php

		for($i = $_GET["displayQty"]; $i > 0; $i--){					

			$pointer = $_REQUEST["pagPage"] * $_GET["displayQty"] - $i;	

		

			if($pointer+1 <= mysqli_num_rows($primaryModuleQuery)){

				mysqli_data_seek($primaryModuleQuery,$pointer);

				$x = mysqli_fetch_array($primaryModuleQuery);

				#different css class to style every other one differently

				if($i % 2 == 0){

					$oddEven = "even";

				} 

				else{

					$oddEven = "odd";

				}

				?>

                <div

                    class="mi mi-<?php echo $oddEven;?> mi-<?php echo $_GET["className"];?>"

                    <div 

                        id="faqQuestion<?php echo $x["priKeyID"];?>" 

                        class="faqQuestion"

                        <?php 

						#we set whether the onclick function is active in the instance table

                        if($instanceFaq->showHideOnOff == 1){

                        ?>

							onclick="toggleFAQChild(<?php echo $x["priKeyID"];?>); return false;)"

                         <?php

						}

						?>

                     >

                        <?php echo $x["faqQuestion"];?>

                	</div>

                    <div 

                    	id="faqAnswer<?php echo $x["priKeyID"];?>" 

                        class="faqAns" 

                        <?php

						#display none is only necessary when show hide is on

                        if($instanceFaq->showHideOnOff == 1){

                        ?>

							style="display: none;"

                    	<?php

						}

						?>

                    >

                    	<?php echo $x["faqAnswer"];?>

                    </div>

                </div>

				<?php

            }

		}

	?>

	</div>

    <?php

	if($instanceFaq->categoriesOnOff == 1){

	?>

        <div 

            class="fawCategories-<?php echo $_GET["className"];?>"

        >

            <p 

                class="faqCategory"

            >

            	faqs

            </p>

            <?php

                if(mysqli_num_rows($faqCatInfo) > 0){

                    while($x = mysqli_fetch_array($faqCatInfo)){

                        ?>

                        <p 

                            id="faqCategory <?php echo $x["priKeyID"];?>" 

                            class="faqCategory faqCategory-<?php echo $_GET["className"]; ?>" 

                            onclick='getFAQCat('<?php echo $x["priKeyID"];?>');return false;'>";

                            <?php echo $x["faqCategory"];?>

                        </p>

                        <?php

                    }

                }

            ?>

        </div>

    <?php

	}

	?>