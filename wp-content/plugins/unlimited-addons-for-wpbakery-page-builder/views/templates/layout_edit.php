<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');

$isNew = empty($layoutID);


$styleNew = "";
$styleExisting = " style='display:none'";

if($isNew == false){
    $styleNew = " style='display:none'";
    $styleExisting = "";
}

    
$addHtml = "";
if(!empty($layoutID))
	$addHtml = "data-layoutid=\"{$layoutID}\"";

$urlLayoutsList = HelperUC::getViewUrl_LayoutsList();

//for new page
$urlPreview = HelperUC::getViewUrl_LayoutPreview(0, true);

if($this->isEditMode){
	$urlPreview = HelperUC::getViewUrl_LayoutPreview($layoutID, true);
}

//box and live tabs
$urlLiveView = HelperUC::getViewUrl_Layout($layoutID,"viewmode=live");
$urlBoxView = HelperUC::getViewUrl_Layout($layoutID, "viewmode=box");

$urlBoxView = htmlspecialchars($urlBoxView);
$urlLiveView = htmlspecialchars($urlLiveView);


if($this->isLiveView == false){		//box view
	
	$textEditMode = __("Live", ADDONLIBRARY_TEXTDOMAIN);
	$classEditMode = "uc-editmode-live";
	$titleEditMode = __("To Live View", ADDONLIBRARY_TEXTDOMAIN);
	$redirectMessage = __("Redirecting to Live View", ADDONLIBRARY_TEXTDOMAIN);
	$iconEditMode = "fa fa-desktop";
	$editViewMode = "box";
}
else{	//live view
	
	$textEditMode = __("Box", ADDONLIBRARY_TEXTDOMAIN);
	$classEditMode = "uc-editmode-box";	
	$titleEditMode = __("To Box View", ADDONLIBRARY_TEXTDOMAIN);
	$redirectMessage = __("Redirecting to Box View", ADDONLIBRARY_TEXTDOMAIN);
	$iconEditMode = "fa fa-th-large";	
	$editViewMode = "live";
}


?>

<div class="unite-content-wrapper unite-inputs uc-content-layout">

		<div id="uc_edit_layout_wrapper" <?php echo $addHtml?>>
			
			<div class="uc-edit-layout-panel">
				
				<!-- left buttons  -->
				
            	<a href="<?php echo $urlLayoutsList?>" class="uc-toppanel-button unite-float-left">
	                <i class="fa fa-bars" aria-hidden="true"></i>
	            	<span><?php _e("Pages",ADDONLIBRARY_TEXTDOMAIN)?></span>
            	</a>
			
				
            	<a id="uc_button_export_layout" href="javascript:void(0)" class="uc-toppanel-button unite-float-left uc-layout-existingpage" <?php echo $styleExisting?> >
                	<em><i class="fa fa-download" aria-hidden="true"></i></em>
            		<span><?php _e("Export",ADDONLIBRARY_TEXTDOMAIN)?></span>
            	</a>  
	          	
	     		<a id="uc_button_import_layout" href="javascript:void(0)" class="uc-toppanel-button unite-float-left uc-layout-existingpage" <?php echo $styleExisting?>>
                	<em><i class="fa fa-upload" aria-hidden="true"></i></em>
            		<span><?php _e("Import",ADDONLIBRARY_TEXTDOMAIN)?></span>
            	</a>
            	
				
				<!-- left buttons end -->
	            
	            
            	<!-- page title panel -->
            	<?php $this->putLayoutTitleWindow($title)?>
            	
            
				<!-- right buttons -->
				
             	<a href="javascript:void(0)" id="uc_button_update_layout" class="uc-toppanel-button unite-float-right">
                	
                	<i id="uc_layout_save_button_icon" class="fa fa-check-square" aria-hidden="true"></i>
                	<i id="uc_layout_save_button_loader" class="fa fa-spinner" style='display:none'></i>
                	
            		<span><?php _e("Save",ADDONLIBRARY_TEXTDOMAIN)?></span>
            	</a>
	         
	         
            	<a id="uc-button-preview-layout" href="<?php echo $urlPreview?>" target="_blank" class="uc-toppanel-button unite-float-right uc-layout-existingpage" <?php echo $styleExisting?>>
	                <i class="fa fa-eye" aria-hidden="true"></i>
	            	<span><?php _e("Preview",ADDONLIBRARY_TEXTDOMAIN)?></span>
	        	</a>
	         
	            
            	<a id="uc_button_edit_mode" class="uc-toppanel-button unite-float-right uc-link-editmode <?php echo $classEditMode?>" data-message="<?php echo $redirectMessage?>" data-urlbox="<?php echo $urlBoxView?>" data-urllive="<?php echo $urlLiveView?>" data-mode="<?php echo $editViewMode?>" href="javascript:void(0)" title="<?php echo $titleEditMode?>" >
                	<i class="<?php echo $iconEditMode?>" aria-hidden="true"></i>
            		<span><?php echo $textEditMode ?></span>
            	</a>
	           	            	
            	<a id="uc_button_grid_settings" href="javascript:void(0)" class="uc-toppanel-button unite-float-right">
	                <i class="fa fa-cog" aria-hidden="true"></i>
	            	<span><?php _e("Grid",ADDONLIBRARY_TEXTDOMAIN)?></span>
            	</a>
            	
			</div>
			
		       
		<?php UniteProviderFunctionsUC::putInitHelperHtmlEditor()?>


			<div class="unite-clear"></div>
							
		<!-- right buttons end -->
		
			<?php 
				$objGridEditor->putGrid();
			?>
			
		<div class="uc-layout-statuses">
	        
	        <div id="uc_layout_status_loader" class="uc-save-status" style="display:none">
	        	<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
	        	<span><?php _e("Saving...", ADDONLIBRARY_TEXTDOMAIN)?></span>
	        </div>
	        
	        <div id="uc_layout_status_success" class="uc-save-status" style="display:none"></div>
	        
	        <div id="uc_layout_status_error" class="uc-save-status uc-status-error" style="display:none">
		        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-color:red; margin-left: 0;"></i>
		        <span class="uc-layout-error-message"></span>
		        <a href="javascript:void(0)" class="uc-save-status-close" >X</a>
	        </div>
  		 
  		 </div>
  		 
  		 
	</div>	<!-- layout edit wrapper --> 
</div>

<?php 

		$objLayouts->putDialogImportLayout();
		
		if($this->isEditMode)
		  UniteProviderFunctionsUC::doAction(UniteCreatorFilters::ACTION_LAYOUT_EDIT_HTML);

?>
	

<script type="text/javascript">

	jQuery(document).ready(function(){

		var objAdmin = new UniteCreatorAdmin_Layout();
		objAdmin.initLayoutView();
	});


</script>
