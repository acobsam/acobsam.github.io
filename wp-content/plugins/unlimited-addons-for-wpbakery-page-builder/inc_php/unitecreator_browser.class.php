<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');

class UniteCreatorBrowser extends HtmlOutputBaseUC{
	
	private $selectedCatNum = "";
	
	private $addonType = "";
	private $webAPI;
	
	private static $isPutOnce = false;
	
	const STATE_INSTALLED = "installed";
	const STATE_FREE = "free";
	const STATE_PRO = "pro";
	
	
	/**
	 * constructor
	 */
	public function __construct(){
		
		$this->webAPI = new UniteCreatorWebAPI();
	}
	
	
	/**
	 * get html tabs header
	 */
	private function getHtmlCatalogHeader(){
		
		$html = "";
		
		$textBlox = __("Blox", ADDONLIBRARY_TEXTDOMAIN);
		$textShowAll = __("Show All", ADDONLIBRARY_TEXTDOMAIN);
		$textInstalled = __("Installed", ADDONLIBRARY_TEXTDOMAIN);
		$textFree = __("Free", ADDONLIBRARY_TEXTDOMAIN);
		$textPro = __("Pro", ADDONLIBRARY_TEXTDOMAIN);
		$textBuy = __("Buy Blox PRO", ADDONLIBRARY_TEXTDOMAIN);
		$textAlreadyBought = __("Already bought Blox PRO?", ADDONLIBRARY_TEXTDOMAIN);
		$textTheProductActive = __("The product is Active!", ADDONLIBRARY_TEXTDOMAIN);
		$textDeactivate = __("Deactivate", ADDONLIBRARY_TEXTDOMAIN);
		$textCheckUpdate = __("Check Catalog Update", ADDONLIBRARY_TEXTDOMAIN);
		$textClear = __("Clear", ADDONLIBRARY_TEXTDOMAIN);
		
		
		$urlBuy = GlobalsUC::URL_BUY;
		
		$htmlAccount = "";
		if(GlobalsUC::$isProductActive == false){
			$htmlAccount = "
			 <div class='uc-header-gotopro'>
			      <a id='link_activate_pro' href='javascript:void(0)' class='uc-link-activate-pro'>{$textAlreadyBought}</span>
			      <a href='{$urlBuy}' target='_blank' class='uc-button-buy-pro'>{$textBuy}</a>
			 </div>
		";
		}
		else{		//product is active
			$htmlAccount = "
			<div class='uc-header-gotopro'>
				<span class='uc-catalog-active-text'>{$textTheProductActive}</span>
				<a id='uc_link_deactivate' href='javascript:void(0)' class='uc-link-deactivate'>{$textDeactivate}</a>
			</div>
			";
		}
										
		
		$html .= "<div class='uc-catalog-header unite-inputs unite-clearfix'>

		 		<div class='uc-catalog-logo'></div>
	    		<div class='uc-catalog-search'>
					<i id='uc_catalog_search_icon' class='fa fa-search' aria-hidden='true'></i> &nbsp;
	    			<input id='uc_catalog_search_input' type='text'>
	    			<a id='uc_catalog_search_clear' href='javascript:void(0)' class='unite-button-secondary button-disabled' style='display:none;'>{$textClear}</a>
	    		</div>
	    		
	    		<div class='uc-catalog-header-menu'>
	     			<a href='javascript:void(0)' class='uc-menu-active' onfocus='this.blur()' data-state='all'>{$textShowAll}</a>
	      	  		<a href='javascript:void(0)' onfocus='this.blur()' data-state='installed'>{$textInstalled}</a>
	      	  		<a href='javascript:void(0)' onfocus='this.blur()' data-state='free'>{$textFree}</a>
	       	 		<a href='javascript:void(0)' onfocus='this.blur()' data-state='pro'>{$textPro}</a>
				</div>
								
		   	 	<a href='javascript:void(0)' onfocus='this.blur()' class='uc-catalog-button-close'>
		   	 		<i class='fa fa-times' aria-hidden='true'></i>
			 	</a>
				
				<a id='uc_button_catalog_update' class='uc-link-update-catalog' title='{$textCheckUpdate}' href='javascript:void(0)' onfocus='this.blur()'><i class='fa fa-download' aria-hidden='true'></i></a>
			 	
			 	{$htmlAccount}
			 	
		</div>";
		
		return($html);
	}
	
	
	
	/**
	 * get tabs html
	 */
	private function getHtmlTabs($arrCats){
		
		$html = "";
				
		$numCats = count($arrCats);
		
		$addHtml = "";
				
		$isFirst = true;
		
		$counter = 0;
		$totalAddons = 0;
		$htmlTabs = "";
		foreach($arrCats as $catTitle=>$cat){
			
			$arrAddons = UniteFunctionsUC::getVal($cat, "addons");
			
			$numAddons = 0;
			if(!empty($arrAddons)){
				$numAddons = count($arrAddons);
				$totalAddons += $numAddons;
			}
			
			$counter++;
			
			if(empty($this->selectedCatNum) && $isFirst == true){
				$isFirst = false;
				$this->selectedCatNum = $counter;
			}
			
			$isSelected = false;
			if($this->selectedCatNum === $counter)
				$isSelected = true;
			
			if(empty($catTitle))
				$catTitle = UniteFunctionsUC::getVal($cat, "title");
			
			if(empty($catTitle)){
				$id = UniteFunctionsUC::getVal($cat, "id");
				if(empty($id))
					$id = $counter;
				
				$catTitle = __("Category", ADDONLIBRARY_TEXTDOMAIN)." {$id}";
			}
			
			$catShowTitle = $catTitle;
			
			if(!empty($numAddons))
				$catShowTitle .= " ($numAddons)";
			
			$catTitle = htmlspecialchars($catTitle);
			$catShowTitle = htmlspecialchars($catShowTitle);
			
			$addClass = "";
			if($isSelected == true)
				$addClass = " uc-tab-selected";
			
			$htmlTabs .= self::TAB5."<div class='uc-tab-item' data-catid='{$counter}' data-title='{$catTitle}'><a href=\"javascript:void(0)\" onfocus=\"this.blur()\" class=\"uc-browser-tab{$addClass}\" data-catid=\"{$counter}\">{$catShowTitle}</a></div>".self::BR;
		}

		$htmlTitleCategories = __("Categories", ADDONLIBRARY_TEXTDOMAIN);
		if(!empty($totalAddons))
			$htmlTitleCategories .= " ($totalAddons)";
		
		
		$html .= self::TAB3."<div class=\"uc-browser-tabs-wrapper\" {$addHtml}>".self::BR;
		
		$html .= self::TAB3."	<div class='uc-browser-tabs-heading'>{$htmlTitleCategories}</div>".self::BR;
				
		$html .= $htmlTabs;
		
		$html .= self::TAB3."<div class='unite-clear'></div>".self::BR;
		
		
		$html .= self::TAB3."</div>".self::BR;	//end tabs
				
		return($html);
	}

	
	
	
	/**
	 * get content html
	 */
	private function getHtmlContent($arrCats){
		
		$html = "";
				
		$numCats = count($arrCats);
		
		$addHtml = "";
		
		$html .= self::TAB2."<div class=\"uc-browser-content-wrapper\" {$addHtml}>".self::BR;
				
		//output addons
		$counter = 0;
		foreach($arrCats as $cat){
			
			$counter++;
			
			$title = UniteFunctionsUC::getVal($cat, "title");
			$title = htmlspecialchars($title);
			
			$style = " style=\"display:none\"";
			if($counter === $this->selectedCatNum || $numCats <= 1)
				$style = "";
			
			$arrAddons = UniteFunctionsUC::getVal($cat, "addons");
						
			$html .= self::TAB3."<div id=\"uc_browser_content_{$counter}\" class=\"uc-browser-content\" data-cattitle='{$title}' {$style} >".self::BR;
			
			if(empty($arrAddons)){
				
				$html .= __("No addons in this category", ADDONLIBRARY_TEXTDOMAIN);
			}
			else{
				
				if(is_array($arrAddons) == false)
					UniteFunctionsUC::throwError("The cat addons array should be array");
				
				foreach($arrAddons as $addon){
				
					$htmlAddon = $this->getHtmlAddon($addon);
				
					$html .= $htmlAddon;
				}
				
			}
		
			$html .= self::TAB3."</div>".self::BR;
		}
		
		$html .= self::TAB2."<div class='unite-clear'></div>".self::BR;
		
		$html .= self::TAB2."</div>".self::BR; //content wrapper
        $html .= "</div>";
		
		return($html);
	}
	
	/**
	 * check if the web addon is free
	 */
	public static function isWebAddonFree($addon){
		
		if(GlobalsUC::$isProductActive == true)
			return(true);
		
		$isFree = UniteFunctionsUC::getVal($addon, "isfree");
		$isFree = UniteFunctionsUC::strToBool($isFree);
		
		return($isFree);
	}
	
	
	/**
	 * get catalog addon state html
	 */
	public static function getCatalogAddonStateData($state){
        
		$addonHref = "javascript:void(0)";
        $linkAddHtml = "";
		
		$output = array();
		$output["html_state"] = "";
		$output["html_additions"] = "";
		$output["addon_href"] = "javascript:void(0)";
		$output["link_addhtml"] = "";
		$output["state"] = $state;
		
        //installed
        switch($state){
        	case self::STATE_FREE:
        		$label = 'free';
        		$labelText = 'Free';
        		$hoverText = 'This Addon Is Free<br>To use it click install';
        		$hoverIcon = '<i class="fa fa-cloud-download" aria-hidden="true"></i>';
        		$action = "Install";
        		
        		if(GlobalsUC::$isProductActive){
        			$labelText = 'Web';
        			$hoverText = 'You can install this addon<br>To use it click install';        			
        		}
        		        		
        	break;
        	case self::STATE_PRO:
        		$label = 'pro';
        		$labelText = 'Pro';
        		$hoverText = 'This addon is available<br>for Blox PRO users only.';
        		$hoverIcon = '<i class="fa fa-lock" aria-hidden="true"></i>';
        		$action = __("Buy Blox PRO", ADDONLIBRARY_TEXTDOMAIN);
        		$addonHref = GlobalsUC::URL_BUY;
        		$linkAddHtml = " target='_blank'";
        	break;
        	default:
        		return($output);
        	break;
        }
		
		$htmlState = "<div class='uc-state-label uc-state-{$label}'>
			<div class='uc-state-label-text'>{$labelText}</div>
		</div>";			
        
		//make html additions
		
		$htmlAdditions = "";
        
		$htmlAdditions .= "<div class='uc-hover-label uc-hover-{$label} hidden'>
					{$hoverIcon}
					<span>{$hoverText}</span>
					<div class=\"uc-addon-button uc-button-{$label}\">{$action}</div>
				</div>";
		
		$textInstalling = __("Installing", ADDONLIBRARY_TEXTDOMAIN);
		
		$htmlAdditions .= "<div class='uc-installing' style='display:none'>
					   <div class='uc-bar'></div>
					   <i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>
					   <span>{$textInstalling}...</span>
					   <h3 style='display:none'></h3>
				  </div>";
		
		
		$output["html_state"] = $htmlState;
		$output["html_additions"] = $htmlAdditions;
		$output["addon_href"] = $addonHref;
		$output["link_addhtml"] = $linkAddHtml;
		
		return($output);
	}
	
	
	/**
	 * get addon html
	 * @param $addon
	 */
	private function getHtmlAddon($arrAddon){
	
		$html = "";
		
		$isFromWeb = UniteFunctionsUC::getVal($arrAddon, "isweb");
		$isFromWeb = UniteFunctionsUC::strToBool($isFromWeb);
		
		if($isFromWeb == true)
			$isFree = self::isWebAddonFree($arrAddon);
		
		/*
		if($isFromWeb == false){
			dmp($arrAddon);
			exit();
		}
		*/
		
		$name = UniteFunctionsUC::getVal($arrAddon,"name");
		$name = UniteFunctionsUC::sanitizeAttr($name);
		
		$title = UniteFunctionsUC::getVal($arrAddon, "title");
		$title = UniteFunctionsUC::sanitizeAttr($title);
		
		$paramImage = "preview";
		if($isFromWeb == true){
			$paramImage = "image";
		}
		
		$urlPreviewImage = UniteFunctionsUC::getVal($arrAddon, $paramImage);
		$urlPreviewImage = UniteFunctionsUC::sanitizeAttr($urlPreviewImage);
		
		$id = UniteFunctionsUC::getVal($arrAddon, "id");
				
		
		//get state
		$state = self::STATE_INSTALLED;
		
		if($isFromWeb){
					
			if($isFree == true)
				$state = self::STATE_FREE;
			else
				$state = self::STATE_PRO;
		}
        
		$stateData = self::getCatalogAddonStateData($state);
		
		$addonHref = $stateData["addon_href"];
		$linkAddHtml = $stateData["link_addhtml"];
		
		$classAdd = "";
		if($isFromWeb == true)
			$classAdd = "uc-web-addon";
        
		$html .= self::TAB4."<a class=\"uc-browser-addon uc-addon-thumbnail {$classAdd}\" href=\"{$addonHref}\" {$linkAddHtml} data-state=\"{$state}\" data-id=\"$id\" data-name=\"{$name}\" data-title=\"{$title}\">".self::BR;
		
		if($state != self::STATE_INSTALLED){
			$html .= $stateData["html_state"];
		}
				
		$html .= self::TAB6."<div class=\"uc-browser-addon-image\" style=\"background-image:url('{$urlPreviewImage}')\"></div>".self::BR;
		$html .= self::TAB6."<div class=\"uc-browser-addon-title\">{$title}</div>".self::BR;
		
		
		if($state != self::STATE_INSTALLED){
			$html .= $stateData["html_additions"];
		}
		
		$html .= self::TAB4."</a>".self::BR;
	
	
		return($html);
	}
	
	
	/**
	 * get addon config html
	 */
	private function getHtmlAddonConfig($putMode = false){
		
		$html = "";
		
		$html .= self::BR.self::TAB2."<!-- start addon config -->".self::BR;
		
		//output back button
		$html .= self::TAB2."<div class='uc-browser-dialog-config'>".self::BR;
		$html .= self::TAB2."<div class='uc-dialog-config-inner'>";
		
		$html .= self::TAB4."<span id='uc_browser_loader' class='uc-browser-loader loader_text' style='display:none'>".__("Loading Addon...",ADDONLIBRARY_TEXTDOMAIN)."</span>".self::BR;
		$html .= self::TAB4."<div id='uc_browser_error' class='uc-browser-error unite_error_message' style='display:none'></div>".self::BR;
		$html .= self::TAB3."<div class='uc-browser-addon-config-wrapper'></div>".self::BR;
		
		$html .= self::TAB2."</div>".self::BR;	// inner end
		$html .= self::TAB2."</div>".self::BR;	// dialog end
		
		$html .= self::TAB2."<!-- end addon config -->".self::BR;
		
		if($putMode == true)
			echo $html;
		else
			return($html);
	}
	
	/**
	 * sort catalog items
	 */
	public function sortCatalogItems($key1, $key2){
		
		if(strtolower($key1) == "basic")
			return(-1);
		
		if(strtolower($key2) == "basic")
			return(1);
		
		return strcmp($key1, $key2);
	}

	
	/**
	 * sort the categories
	 */
	private function sortCatalog($arrCats){
		
		uksort($arrCats, array($this,"sortCatalogItems"));
				
		return($arrCats);
	}
	
	/**
	 * remove empty cats
	 */
	private function removeEmptyCatalogCats($arrCats){
		
		foreach($arrCats as $key=>$cat){
			
			$addons = UniteFunctionsUC::getVal($cat, "addons");
			if(empty($addons))
				unset($arrCats[$key]);			
		}
		
		return($arrCats);
	}
	
	
	/**
	* get catalog html
	 */
	private function getHtmlCatalog($putMode = false){

		//get categories
		$objAddons = new UniteCreatorAddons();
		$arrCats = $objAddons->getAddonsWidthCategories(true, true, $this->addonType);
		
		if(GlobalsUC::$enableWebCatalog == true)
			$arrCats = $this->webAPI->mergeCatsAndAddonsWithCatalog($arrCats);
		
		$arrCats = $this->removeEmptyCatalogCats($arrCats);
		
		$arrCats = $this->sortCatalog($arrCats);
		
		$numCats = count($arrCats);
		
		
		$html = "";
		
		$html .= self::BR.self::TAB2."<!-- start addon catalog -->".self::BR;
		
		$html .= self::TAB2."<div class='uc-catalog'>".self::BR;
		
		$html .= $this->getHtmlCatalogHeader();
		
		
		$html .= self::TAB2."<div class='uc-browser-body unite-clearfix'>".self::BR;
		
		//output tabs
		$html .= $this->getHtmlTabs($arrCats);
		
		//output content
		$html .= $this->getHtmlContent($arrCats);
		
		$html .= self::TAB2."</div>".self::BR;	//end body
		
		$html .= self::TAB2."</div>".self::BR;	//end catalog
		
		$html .= self::BR.self::TAB2."<!-- end addon catalog -->".self::BR;
		
		return($html);
	}
	
	
	/**
	 * get browser html
	 */
	private function getHtml($putMode = false){
		
		if(self::$isPutOnce == true)
			UniteFunctionsUC::throwError("You can put the addon browser only once per page");

		$htmlCatalog = $this->getHtmlCatalog();
		
		
		$html = "";
		$html .= self::TAB."<!-- start addon browser --> ".self::BR;
		
		$addHtml = "";
		if(!empty($this->inputIDForUpdate))
			$addHtml .= " data-inputupdate=\"".$this->inputIDForUpdate."\"";
		
		
		$addonType = $this->addonType;
		$addHtml .= " data-addontype='{$addonType}'";
		
		$html .= self::TAB."<div id=\"uc_addon_browser\" class=\"uc-browser-wrapper\" {$addHtml} style='display:none'>".self::BR;
		
		if($putMode == true){
			echo $html;
			$html = "";
		}
		
		$html .= $this->getHtmlAddonConfig($putMode);
		$html .= $htmlCatalog;
				
		$html .= self::TAB."</div>"; //wrapper
		
		if($putMode == true)
			echo $html;
		else
			return($html);
	}
	
	
	/**
	 * put html
	 */
	private function putHtml(){
		
		$this->getHtml(true);
	}
	
	
	/**
	 * put scripts
	 */
	public function putScripts(){
		
		UniteCreatorAdmin::onAddScriptsBrowser();
	}
	
	
	/**
	 * set browser addon type
	 */
	public function initAddonType($addonType){
		$this->addonType = $addonType;
	}
	
	
	/**
	 * put browser
	 */
	public function putBrowser($putMode = true){
				
		if($putMode == false){
			$html = $this->getHtml();
			return($html);
		}
		
		
		$this->putHtml();
		$this->putActivateProDialog();
		$this->putCatalogUpdateDialog();
		
	}
	
	
	/**
	 * put scripts and browser
	 */
	public function putScriptsAndBrowser($getHTML = false){
		
		try{
			
			$this->putScripts();
			$html = $this->putBrowser($getHTML);
			
			if($getHTML == true)
				return($html);
			else
				echo $html;
			
		}catch(Exception $e){
			
			$message = $e->getMessage();
			
			$trace = "";
			if(GlobalsUC::SHOW_TRACE == true)
				$trace = $e->getTraceAsString();
			
			$htmlError = HelperUC::getHtmlErrorMessage($message, $trace);
			
			return($htmlError);
		}
		
	}
	
	
	/**
	 * put activate dialog
	 */
	private function putActivateProDialog() {
		
		$urlPricing = GlobalsUC::URL_BUY;
		$urlSupport = GlobalsUC::URL_SUPPORT;
		
		?>
           <div class="activateProDialog" title="Activate Your Pro Account">
           
           <div class="uc-popup-container start hidden">
                <div class="uc-popup-content">
                    <div class="uc-popup-holder">
                        <div class="xlarge-title">GO PRO</div>
                        <div class="popup-text">Unleash access to +600 addons <br>and +20 templates</div>
                        <div class="popup-form">
                                <label>Paste your activation key here:</label>
                                <input id="uc_activate_pro_code" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" value="">
                                <input id="uc_button_activate_pro" type="button" class='uc-button-activate' value="Activate Blox Pro">
                                <span id="uc_loader_activate_pro" class='loader_text' style='display:none'>Activating...</span>
                        </div>
                        <div class="bottom-text">Don't have a pro activation key?<br>
                        <a href="<?php echo $urlPricing?>" target="_blank" class="blue-text">View our pricing plans</a></div>
                    </div>
                </div>
            </div>
            
            <div class="uc-popup-container fail hidden">
                <div class="uc-popup-content">
                    <div class="uc-popup-holder">
                        <div class="large-title">Ooops.... <br>Activation Failed :(</div>
                        <div class="popup-error"></div>
                        <div class="popup-text">You probably got you activation code wrong <br>to try again <a id="activation_link_try_again" href="javascript:void(0)">click here</a></div>
                        <div class="bottom-text">or contact our <a href="<?php echo $urlSupport?>" target="_blank">support center</a></div>
                    </div>
                </div>
            </div>
            
            <div class="uc-popup-container activated hidden">
                <div class="uc-popup-content">
                    <div class="uc-popup-holder">
                        <div class="xlarge-title">Hi Five!</div>
                        <div class="popup-text small-padding">Your pro account is activated for the next</div>
                        <div class="days"></div>
                        <span>DAYS</span>
                        <br>
                        <a href="javascript:location.reload()" class="btn">Refresh page to View Your Pro Catalog</a>
                    </div>
                </div>
            </div>
            
            </div>
		
		<?php 
	}
	
	
	/**
	 * put check udpate dialog
	 */
	private function putCatalogUpdateDialog(){
				
		?>
		
			<div id="uc_dialog_catalog_update" title="<?php _e("Check And Update Catalog")?>" class="unite-inputs" style="display:none">
				<div class="unite-dialog-inside">
					
					<span id="uc_dialog_catalog_update_loader" class="loader_text">
						<?php _e("Checking Update", ADDONLIBRARY_TEXTDOMAIN)?>...
					</span>
					
					<div id="uc_dialog_catalog_update_error" class="error-message"></div>
					
					<div id="uc_dialog_catalog_update_message" class="uc-catalog-update-message"></div>
					
				</div>
				
			</div>		
		<?php 
	}
	
}