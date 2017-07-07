<div id="beanstreamPageOutter">
	<div id="beanstreamPageInner">
		<form name="beanstreamForm" id="beanstreamForm" action="return%20false" autocomplete="on">
			<fieldset>
				<h2>Client Information</h2>
				<div class="field">
					<label class="requiredLabel" for="name">Client Name *</label>
					<input type="text" name="name" id="name" class="invalid" placeholder="Full Name" title=""/>
				</div>
				<div class="field">
					<label class="requiredLabel" for="order_number">Policy Number *</label>
					<input type="text"   name="order_number" id="order_number" class="invalid" placeholder="Example: abcdefghi12jk" maxlength="13" title=""/>
				</div>
				<div class="field">
					<label class="requiredLabel" for="email">Email Address  *</label>
					<input type="email"   name="email" id="email" class="invalid" placeholder="Email Address" />
				</div>
				<div class="field">
					<label class="requiredLabel" for="emailValid">Email Address Verification *</label>
					<input type="email"   name="emailValid" id="emailValid" class="invalid" placeholder="Email Address Verification" />
				</div>
				<div class="field">
					<label class="requiredLabel" for="phoneNumber">Phone Numbr *</label>
					<input type="tel" min="1" step="any"  name="phoneNumber" id="phoneNumber" class="invalid" placeholder="(306) 555 5555"/>
				</div>
				<div class="field">
					<label class="requiredLabel" for="amount">Payment Amount *</label>
					<input type="number" min="1" step="any"   name="amount" id="amount" class="invalid" placeholder="Payment Amount"/>
				</div>
				<p>*A copy of your receipt will be emailed to the email address provided above.</p>
				<h2>Billing Information</h2>
				<div class="field">
					<label class="requiredLabel" for="ccName">Name on Credit Card *</label>
					<input type="text"   name="ccName" id="ccName" class="invalid" placeholder="Name On Card"/>
				</div>
				<div class='field'>
					<label for="ccNumber">Card Number *</label>
					<input  placeholder="" maxlength="19" autocomplete="cc-number" type="text" class="" name="ccNumber" id="ccNumber">
				</div>
				<div class='field select'>
					<label>Expiry *</label>
					<select name="ccMonth" id="ccMonth" onchange="" size="1">
						<option   disabled selected>~ Please Select a Month ~</option>
						<option value="01">01 - January</option>
						<option value="02">02 - February</option>
						<option value="03">03 - March</option>
						<option value="04">04 - April</option>
						<option value="05">05 - May</option>
						<option value="06">06 - June</option>
						<option value="07">07 - July</option>
						<option value="08">08 - August</option>
						<option value="09">09 - September</option>
						<option value="10">10 - October</option>
						<option value="11">11 - November</option>
						<option value="12">12 - December</option>
					</select>
					<select name="ccYear" id="ccYear" onchange="" size="1">
						<option   disabled selected="selected">~ Please Select a Year ~</option>
						<?php for($year = (int)date("Y"); $year < ((int)date("Y"))+10; $year++): ?>
						<option value="<?=$year?>">
						<?=$year?>
						</option>
						<?php endfor; ?>
						</option>
					</select>
				</div>
				<div class='field'>
					<label for="ccCvv">CVV *</label>
					<input id="ccCvv" name="ccCvv" placeholder="" autocomplete="cc-csc" type="number" maxlength="3" min="100" max="999">
				</div>
				<p>When you submit your payment, your information will be sent to a third-party processor (TD Payment Processing) for verification and will not be retained by SMI or your broker.
</p>
				<!--<script src='https://payform.beanstream.com/payfields/beanstream_payfields.js'></script>-->
				<div> <a class="btn button1" onclick="sendBeansteamValues($('#beanstreamForm'))">Submit</a> </div>
			</fieldset>
		</form>
	</div>
</div>
