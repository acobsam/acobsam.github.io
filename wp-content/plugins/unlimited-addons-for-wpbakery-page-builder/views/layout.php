<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');



class AddonLibraryViewLayout{
	
	protected $showButtons = true;
	protected $isEditMode = false;
	protected $isLiveView = false;
	protected $showHeader = true;
	protected $layoutID;
	protected $objLayout;
	protected $shortcodeWrappers = "{}";
	
	
	/**
	 * the constructor
	 */
	public function __construct(){
		
		$layoutID = UniteFunctionsUC::getGetVar("id", null, UniteFunctionsUC::SANITIZE_ID);
		$this->layoutID = $layoutID;
		
		$this->objLayout = null;
		
		if(!empty($layoutID)){
			$this->objLayout = new UniteCreatorLayout();
			$this->objLayout->initByID($layoutID);
		}
			
	}
	
	/**
	 * put layout title edit window
	 */
	protected function putLayoutTitleWindow($title){
	    
	    $isNew = empty($this->layoutID);
	    
	    
	    $styleNew = "";
	    $styleExisting = " style='display:none'";
	    
	    if($isNew == false){
	        $styleNew = " style='display:none'";
	        $styleExisting = "";
	    }
	        
	    
		?>
		            
    		<div class='uc-layout-title-panel'>
    			
                <div class="uc-visible-part">
    				
	    			<span id="uc_page_title"><?php echo UniteFunctionsUC::sanitizeAttr($title)?></span>
	                	<i class="fa fa-angle-down" aria-hidden="true"></i>
					</div>
					
					<div id="uc_layout_title_box" class="uc-layout-title-box">
					
	                	<div class="uc-layout-title-box-inner unite-ui">
	                		
	                		<!-- page name -->
	                		<div class='uc-page-name-wrapper'>
	                        	 <div class="uc-titlebox-label"><?php _e("Page Name", ADDONLIBRARY_TEXTDOMAIN)?>:</div>
	                        	 <input type="text" class="unite-input-regular" value="<?php echo UniteFunctionsUC::sanitizeAttr($title)?>" id="uc_layout_title" placeholder="<?php _e("New Page", ADDONLIBRARY_TEXTDOMAIN)?>">
	                        	 <a id="uc_button_rename_page" href="javascript:void(0)" class="unite-button-primary" ><?php echo _e("Save", ADDONLIBRARY_TEXTDOMAIN)?></a>
	                        	 <span id="uc_button_rename_page_loader" class="loader_text" style="display:none"><?php _e("Saving", ADDONLIBRARY_TEXTDOMAIN)?>...</span>
                        	 </div>
                        	 
                        
                        	<!-- shortcode -->
                        	 <div class="uc-titlebox-label uc-label-shortcode"><?php _e("Shortcode:", ADDONLIBRARY_TEXTDOMAIN)?></div> 
                        	 
                        	 <div class="uc-layout-newpage" <?php echo $styleNew?> >
                        	 
                            	 <div class="vert_sap10"></div>
                            	 	
                            	 	<div class="uc-titlebox-text">
                            		 	<?php _e("The shortcode will be availble after save page")?>
                            	  </div>
                            	  
                        	 </div>
                        	 
                        	 <div class="uc-layout-existingpage" <?php echo $styleExisting?> >
                        	 
                            	 <input type="text" id="uc_layout_shortcode" class="uc-input-shortcode unite-input-regular"  data-shortcode="<?php echo GlobalsUC::$layoutShortcodeName?>" data-wrappers="<?php echo $this->shortcodeWrappers?>" readonly onfocus="this.select()" value="" title="<?php echo UniteFunctionsUC::sanitizeAttr($title)?>">
                        		 
                        		 <div class="vert_sap10"></div>
                        		 
                        		 <a id="uc_link_copy_shortcode" class="uc-shortcode-text-copy"><?php _e("Copy shortcode to clipoard", ADDONLIBRARY_TEXTDOMAIN)?></a>
    	                	
    	                	</div>	
                        	 		                		
	                		
                		</div>
                	
				</div>
	                     	                
            </div>
		
		<?php 
	}
	
	/**
	 * get header title
	 */
	protected function getHeaderTitle(){
		
		if(empty($this->objLayout)){
			
			$title = HelperUC::getText("new_layout");
			
		}else{
			$title = HelperUC::getText("edit_layout")." - ";
			$title .= $this->objLayout->getTitle();
		}
		
		return($title);
	}
	
	
	/**
	 * set view mode
	 */
	protected function setViewMode(){
		
		$stateName = "layout_view_mode";
		
		//check live mode
		$viewMode = UniteFunctionsUC::getGetVar("viewmode", "",UniteFunctionsUC::SANITIZE_KEY);
		
		//save view mode
		if(!empty($viewMode)){
			HelperUC::setState($stateName, $viewMode);
		}else{
			$viewMode = helperUC::getState($stateName);
		}
				
		if(empty($viewMode))
			$viewMode = "live";
		
		$this->isLiveView = true;
		if($viewMode == "box")
			$this->isLiveView = false;
		
	}
		
	
	/**
	 * display
	 */
	protected function display(){
		
		$layoutID = $this->layoutID;
		
		$this->setViewMode();
		
		
		$objGridEditor = new UniteCreatorGridBuilderProvider();
		$objGridEditor->setGridID("uc_grid_builder");
		
		if($this->isLiveView == true)
			$objGridEditor->setLiveView();
		
		$title = null;
		
		$objLayout = $this->objLayout;
		if(empty($objLayout))
			$objLayout = new UniteCreatorLayout();
		
		
		//init the layout object if in edit mode
		if(!empty($layoutID)){
			$this->isEditMode = true;
			
			$objGridEditor->initByLayout($objLayout);
		
			$title = $objLayout->getTitle();
		}else{
			
			//if new mode - get new title
			$title = $objLayout->getNewLayoutTitle();
		}
		
		
		require HelperUC::getPathViewObject("layouts_view.class");
		require HelperUC::getPathViewProvider("provider_layouts_view.class");
		$objLayouts = new UniteCreatorLayoutsViewProvider();
		
		require HelperUC::getPathTemplate("layout_edit");
		
	}
	
	
}

$pathProviderLayout = GlobalsUC::$pathProvider."views/layout.php";

require_once $pathProviderLayout;

new AddonLibraryViewLayoutProvider();
