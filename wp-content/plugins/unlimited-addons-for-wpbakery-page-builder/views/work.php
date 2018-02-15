<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');


//all the web library related code need to be in this class
$objLibrary = new UniteCreatorWebAPI();

?>

<style>
	.browser-section{
		padding:5px;width:800px;height:400px;overflow:auto;border:1px solid black;		
	}
	.error-message{color:red}
</style>

<h2>Users Acivation</h2><br>

	<!--  statuses: not activated, activated: Max -->

	<span id="user_status" class="user-status">Non Activated</span>
	
	<input id="button_activate" type="button" value="Activate User">	
	<input id="button_deactivate" type="button" value="Deactivate User">
	
	<div id="dialog_activate" title="Activate User" style="display:none">
		<br>Email:<br>
		<input type="text" name="user_email">
		
		<br><br>Activation Key<br>
		<input type="text" name="activation_key">
				
		<br><br>
		<a href="javascript:void(0)" class="unite-button-primary">Activate User</a>		
		
		<div id="activation_error" class="error-message"></div>
		
	</div>

<br><br><h2>Web Library Update</h2><br>

	<span id="web_status" class="web-status">Up To Date</span>
	<input type="button" value="Check New Version">
	<input type="button" value="Update Web Library">


<br><br><h2>Broswer</h2>

<div class="browser-section">
<?php 

	$browser = new UniteCreatorBrowser();
	$browser->putScriptsAndBrowser();

?>

</div>

<script>

var g_browser = new UniteCreatorBrowser();

function initView(){

	//init browser
	var objBrowserWrapper = jQuery(".uc-browser-wrapper");
	g_browser.init(objBrowserWrapper);

	jQuery("#button_activate").click(function(){

		jQuery("#dialog_activate").dialog();
		
	});
	
}

jQuery(document).ready(initView);

</script>

