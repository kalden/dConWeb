<?php

	// Will return the html for a captcha form.
	function GetCaptcha() {
		print '<p>';
		switch(rand(1,5)) {
			case 1:
				#define
				print '<img src="captchas/1.png"><br><input type="hidden" name="answer" value="'.md5("define").'">';
				break;
			case 2:
				#domain
				print '<img src="captchas/2.png"><br><input type="hidden" name="answer" value="'.md5("domain").'">';
				break;
			case 3:
				#evolution
				print '<img src="captchas/3.png"><br><input type="hidden" name="answer" value="'.md5("evolution").'">';
				break;
			case 4:
				#proteasome
				print '<img src="captchas/4.png"><br><input type="hidden" name="answer" value="'.md5("proteasome").'">';
				break;
			case 5:
				#protein
				print '<img src="captchas/5.png"><br><input type="hidden" name="answer" value="'.md5("protein").'">';
				break;
		}
		print '
		Enter the word shown above:<br>
		<input type="text" name="responce">
		</p>
		';
	}
	
	// Will validate a captcha
	function ValidateCaptcha($answer, $responce) {
		if($answer == md5($responce)){
			return true;
		}
		return false;
	}
	
?>