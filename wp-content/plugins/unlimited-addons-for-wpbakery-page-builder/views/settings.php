<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');



class UniteCreatorViewGeneralSettings extends UniteCreatorSettingsView{
	
	
	/**
	 * draw additional tabs
	 */
	protected function drawAdditionalTabs(){
	}
	
	
	/**
	 * function for override
	 */
	protected function drawAdditionalTabsContent(){
		
	}
	
	
	/**
	 * constructor
	 */
	public function __construct(){
		
		$this->headerTitle = __("General Settings", ADDONLIBRARY_TEXTDOMAIN);
		$this->saveAction = "update_general_settings";
		
		//set settings
		$operations = new UCOperations();
		$this->objSettings = $operations->getGeneralSettingsObject();
		
		
		$this->display();
	}
	
	
	
}

$filepathViewSettingsProvider = GlobalsUC::$pathProviderViews."general_settings.php";

if(isset($filepathViewSettingsProvider)){
	require $filepathViewSettingsProvider;
		
	new UniteCreatorViewGeneralSettingsProvider();
}else{
	
	new UniteCreatorViewGeneralSettings();
}
	
