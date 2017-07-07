<div class="mfmc" id="mfmc-leadNewsletter">
	<div id="newsLetterHeader">
		<p>Subscribe to our Newsletter</p>
	</div>
	
	<div id="newsLetterContainer">
		<form action="" id="newLetterForm" name="newLetterForm" onsubmit="subNewsLetter();return false">
			<label for="newsEmail" id="newsEmailLabel">Newsletter Email</label>
			<input 
				id="newsEmail" 
				type="text" 
				value="Enter Your Email Address Here"
				 name="newsEmail"
				 onclick="this.value=''"
			/>
			<input type="button" value="Sign Me Up!" onclick="subNewsLetter()"/>
		</form>
	</div>
</div>