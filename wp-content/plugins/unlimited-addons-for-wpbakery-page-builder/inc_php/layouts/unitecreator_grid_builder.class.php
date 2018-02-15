<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');


class UniteCreatorGridBuilder{

	const ID_PREFIX = "uc_grid_builder";
	private static $serial = 0;
	
	private $optionPanelHiddenAtStart = true;
	private $optionPanelInitWidth = 278;
	
	
	private $gridID;
	private $initData;
	private $putJs = false;
	private $isLiveView = false;
	
	protected $showGridSettingButton = true;
	protected $browserAddonType = null;
	
	
	/**
	 * constructor
	 */
	public function __construct(){
		
		$this->browserAddonType = GlobalsUC::$layoutsAddonType;
		
	}
	
	
	/**
	 * set grid ID
	 */
	public function setGridID($gridID){
		$this->gridID = $gridID;
	}
	
	/**
	 * switch to live view
	 */
	public function setLiveView(){
		$this->isLiveView = true;
	}
	
	
	/**
	 * set to put js init
	 */
	public function putJsInit(){
		$this->putJs = true;
	}
	
	
	/**
	 * set the layout object
	 */
	public function initByLayout(UniteCreatorLayout $objLayout){
		
		$addAddonContent = $this->isLiveView;
		
		$this->initData = $objLayout->getGridDataForEditor($addAddonContent);
		
		//dmp($this->initData);exit();
	}
	
	
	/**
	 * put top panel
	 */
	private function putTopPanel(){
		?>
				
		<div class="uc-grid-builder-top-panel">
			
			<a id="uc_button_grid_settings" href="javascript:void(0)" class="unite-button-secondary unite-float-right"><?php _e("Grid Settings",ADDONLIBRARY_TEXTDOMAIN)?></a>
			
		<div class="unite-clear"></div>
		</div>
		
		
		<?php 
	}
	
		
	
	/**
	 * put js init
	 */
	private function putJs(){
		?>
			<script type="text/javascript">

				jQuery(document).ready(function(){

					var objBuilder = new UniteCreatorGridBuilder();
					objBuilder.init("#<?php echo $this->gridID?>");
					
				});
							
			</script>
		
		<?php 
	}
	
		
	/**
	 * put global settings dialog. stand alone function
	 */
	public function putLayoutsGlobalSettingsDialog(){
		
		$settingsGeneral = UniteCreatorLayout::getGlobalSettingsObject();
		
		$outputGeneralSettings = new UniteSettingsOutputWideUC();
		$outputGeneralSettings->setShowSaps(true);
		$outputGeneralSettings->init($settingsGeneral);
		
		?>
		
		<div id="uc_dialog_layout_global_settings" title="<?php HelperUC::putText("layouts_global_settings"); ?>" class="unite-inputs" style="display:none">
				
				<div class="unite-dialog-inner-constant">
		
				<?php 		
					$outputGeneralSettings->draw("uc_layout_general_settings", true);
					
				?>
				</div>
				
				<?php 
					$prefix = "uc_dialog_layout_global_settings";
					$buttonTitle = __("Update Global Settings", ADDONLIBRARY_TEXTDOMAIN);
					$loaderTitle = __("Updating...", ADDONLIBRARY_TEXTDOMAIN);
					$successTitle = __("Settings Updated", ADDONLIBRARY_TEXTDOMAIN);
					HelperHtmlUC::putDialogActions($prefix, $buttonTitle, $loaderTitle, $successTitle);
				?>
				
		</div>		
		
		
		<?php
	}
	
	
	/**
	 * get grid options - from global object and grid settings
	 * they can be not overriden because they will be overriden in the front
	 * only keys will be overriden
	 */
	private function getGridCombinedOptions(){
		
		$optionsGlobal = UniteCreatorLayout::getGridGlobalOptions();
		$optionsGrid = UniteCreatorLayout::getGridSettingsOptions();
		
		
		//merge only missing keys
		foreach($optionsGrid as $key=>$value){
			
			if(array_key_exists($key, $optionsGlobal) == false)
				$optionsGlobal[$key] = $value;
		}
		
		return($optionsGlobal);
	}
	
	
	/**
	 * modify grid settings for dialog
	 */
	private function modifyGridDialogSettings($objGridSettings){
		
		$arrSettings = $objGridSettings->getArrSettings();
		
		$descPrefix = __(". If %s, it will be set to global value: ", ADDONLIBRARY_TEXTDOMAIN);
		
		$optionsGlobal = UniteCreatorLayout::getGridGlobalOptions();
		
		//$arrExceptToEmpty = array("show_row_titles");
		$arrExceptToEmpty = array();
		
		foreach($arrSettings as $setting){
		
			$name = UniteFunctionsUC::getVal($setting, "name");
		
			//set replace sign
			switch($name){
				default:
					$replaceSign = "empty";
				break;
			}
		
			$descActualPrefix = sprintf($descPrefix, $replaceSign);
		
			//handle excepts
			$globalOptionExists = array_key_exists($name, $optionsGlobal);
			if($globalOptionExists == false)
				continue;
		
			$globalValue = UniteFunctionsUC::getVal($optionsGlobal, $name);
			$setting["description"] .=  $descActualPrefix.$globalValue;
			$setting["placeholder"] =  $globalValue;
		
			//handle to empty excerpts
			$isExceptEmpty = array_search($name, $arrExceptToEmpty);
			if($isExceptEmpty === false){
				$setting["value"] = "";
				$setting["default_value"] = "";
			}
		
			$objGridSettings->updateArrSettingByName($name, $setting);
		
		}
		
		
		return($objGridSettings);
	}	
	
	
	
	/**
	 * put browser dialog
	 */
	private function putBrowserDialog(){
		
		$objBrowser = new UniteCreatorBrowser();
		$objBrowser->initAddonType($this->browserAddonType);
		$objBrowser->putBrowser();
		
	}
	
	
	/**
	 * put layout select dialog
	 */
	private function putLayoutDialog(){
		
		$titleText = __("Choose Row Layout", ADDONLIBRARY_TEXTDOMAIN);
		
		?>
		
        <div id="uc_dialog_row_layout" class='uc-dialog-row-layout'  title="<?php echo $titleText?>" style="display:none">
                
                <div class="uc-dialog-columns-wrapper">
                
                    <div class='uc-layout-column'>
                        
                        <div class='uc-layout-row' data-layout-type="1_1">
                            <div class="uc-layout-col uc-layout-column-size-1_1"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_4-1_4-1_4-1_4">
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_4-3_4">
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-3_4"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_4-1_4-1_2">
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_2"></div>
                        </div>
                    </div>
                    
                    <div class='uc-layout-column'>
                        <div class='uc-layout-row' data-layout-type="1_2-1_2">
                             <div class="uc-layout-col uc-layout-column-size-1_2"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_2"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="2_3-1_3">
                            <div class="uc-layout-col uc-layout-column-size-2_3"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_3"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="3_4-1_4">
                            <div class="uc-layout-col uc-layout-column-size-3_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_4-1_2-1_4">
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_2"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                        </div>
                        
                    </div>
                    
                    <div class='uc-layout-column'>
                        
                        <div class='uc-layout-row' data-layout-type="1_3-1_3-1_3">
                            <div class="uc-layout-col uc-layout-column-size-1_3"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_3"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_3"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_3-2_3">
                            <div class="uc-layout-col uc-layout-column-size-1_3"></div>
                            <div class="uc-layout-col uc-layout-column-size-2_3"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="1_2-1_4-1_4">
                            <div class="uc-layout-col uc-layout-column-size-1_2"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                            <div class="uc-layout-col uc-layout-column-size-1_4"></div>
                        </div>
                        
                        <div class='uc-layout-row' data-layout-type="empty" onclick="jQuery(this).unbind('click')">
                            <div class="uc-layout-col uc-layout-column-size-1_1" style="background-color: #fff" onclick=""></div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>   
		
		<?php 
	}
		
	
	
	private function __________PANEL_________(){}
	
	
	
	/**
	 * put side panel
	 */
	private function putSidePanel(){
	    		
		$objSidePanel = new UniteCreatorGridBuilderPanel();

		//add grid settings pane
		$objGridSettings = UniteCreatorLayout::getGridSettingsObject();
	    $objGridSettings = $this->modifyGridDialogSettings($objGridSettings);
	    
	    $title = __("Grid Settings", ADDONLIBRARY_TEXTDOMAIN);
	    
	    $objSidePanel->addPane("grid-settings", $title, $objGridSettings, "uc_settings_grid");
		
	    //add row settings
		
	    $objRowSettings = HelperUC::getSettingsObject("layout_row_settings");
	    $title = __("Row Settings", ADDONLIBRARY_TEXTDOMAIN);
	
	    $objSidePanel->addPane("row-settings", $title, $objRowSettings, "uc_settings_row");
		
	    //add column settings
	    $objColumnSettings = HelperUC::getSettingsObject("layout_column_settings");
	    $title = __("Column Settings", ADDONLIBRARY_TEXTDOMAIN);
	
	    $objSidePanel->addPane("col-settings", $title, $objColumnSettings, "uc_settings_col");

	    //add addon container settings
	    $objColumnSettings = HelperUC::getSettingsObject("layout_addon_container_settings");
	    $title = __("Addon Container Settings", ADDONLIBRARY_TEXTDOMAIN);
	    
	    $objSidePanel->addPane("addon-container-settings", $title, $objColumnSettings, "uc_settings_addon_container");
	    
	    //add addon settings
	    $title = __("Addon Settings", ADDONLIBRARY_TEXTDOMAIN);
	    $objSidePanel->addPane("addon-settings", $title, "get_addon_settings_html", "uc_settings_addon");
	    
	    
		//init
		$objSidePanel->init();
		
		if($this->optionPanelHiddenAtStart == true)
			$objSidePanel->setHiddenAtStart();
		
		$objSidePanel->setInitWidth($this->optionPanelInitWidth);
		
		//put html
		$objSidePanel->putHtml();
	}
	
	
	/**
	 * get behaviour options
	 */
	private function getBuilderOptions(){
		
		$options = array();
		$options["indev"] = GlobalsUC::$inDev;
		
		return($options);
	}
	
	
	/**
	 * put grid
	 */
	public function putGrid(){
		
		if(empty($this->gridID)){
			self::$serial++;
			$this->gridID = self::ID_PREFIX.self::$serial;
		}
		
		$gridID = $this->gridID;
		
		$classAdd = " uc-grid-box";
		
		$addHtml = " data-liveview='false'";
		if($this->isLiveView == true){
			$addHtml = " data-liveview='true'";
			$classAdd = " uc-grid-live";
		}
		
		//get data-init='...'
		
		$initData = "";
		if(!empty($this->initData)){
			$initData = UniteFunctionsUC::jsonEncodeForHtmlData($this->initData, "init");
		}
		
		//get grid options
		$options = $this->getGridCombinedOptions();
		
		$dataOptions = UniteFunctionsUC::jsonEncodeForHtmlData($options, "options");
		
		//get builder options
		$builderOptions = $this->getBuilderOptions();
		$dataBuilderOptions = UniteFunctionsUC::jsonEncodeForHtmlData($builderOptions, "builder-options");
		
		
		$addClass = " uc-sidepanel-enabled";
		
		$outerAddHtml = "";
		
		if($this->optionPanelHiddenAtStart == false){
		    
			$paddingLeft = $this->optionPanelInitWidth;
			$outerAddHtml .= "style='padding-left:{$paddingLeft}px'";
		}
		
		?>
			<div class="uc-grid-builder-wrapper<?php echo $addClass?>" >
				
				
				<style type="text/css"></style>
								
				<span class="uc-grid-row-styles"></span>
				<span class="uc-grid-col-styles"></span>
				
				<?php 
				
				if($this->showGridSettingButton == true)
					$this->putTopPanel();
				
				$this->putSidePanel();
				?>
				
				<div class="uc-grid-builder-outer" <?php echo $outerAddHtml?>>
					<div id="<?php echo $gridID?>" class="uc-grid-builder<?php echo $classAdd?>" <?php echo $initData.$dataOptions.$dataBuilderOptions.$addHtml?> ></div>
				</div>
				
				<?php 
				
				$this->putBrowserDialog();
                $this->putLayoutDialog();
				
				?>
				
			</div>
			
			
			<?php 
				if($this->putJs == true)
					$this->putJs();
		
	}
	
	
}