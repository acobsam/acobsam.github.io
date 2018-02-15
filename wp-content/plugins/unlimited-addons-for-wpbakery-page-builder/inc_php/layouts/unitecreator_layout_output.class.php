<?php
/**
 * @package Blox Page Builder
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');

class UniteCreatorLayoutOutputWork extends HtmlOutputBaseUC{
	
	protected $layout, $gridHtmlID, $isScriptsHardCoded = true;
	protected $cssToBody = false;	//put addon and layout css to body
	protected $gridOptionsDiff, $gridOptionsAll;
	protected static $serial = 0;
	protected $addonType = null;
	
	
	const COLSIZE_PREFIX = "uc-colsize-";
	const HIDE_ELEMENT = "uc_hide_element";
	
	
	/**
	 * validate that the layout output inited
	 */
	private function validateInited(){
		
		if(empty($this->layout))
			UniteFunctionsUC::throwError("The layout output is not inited");
		
	}
	
	
	/**
	 * init by layout object
	 */
	public function initByLayout(UniteCreatorLayout $objLayout){
		
		//init grid ID
		$prefix = "uc_grid_";
		self::$serial++;
		
		$this->gridHtmlID = $prefix.self::$serial;
		
		$this->layout = $objLayout;
		
		$this->addonType = $this->layout->getAddonType();
		
		$this->gridOptionsDiff = $this->layout->getGridOptionsDiff();
		$this->gridOptionsAll = $this->layout->getAllGridOptions();
		
	}
	
	/**
	 * set addon type
	 */
	public function setAddonType($addonType){
		$this->addonType = $addonType;
	}
	
	
	/**
	 * output layout css
	 */
	public static function putIncludeScripts(){
		$urlCss = GlobalsUC::$url_assets_internal."css/uc_front.css";
		
		HelperUC::addStyleAbsoluteUrl($urlCss, "unitecreator_css_front");
	}
	
	
	/**
	 * get option
	 */
	private function getOption($name = ""){
		
		if(empty($name))
			return($this->gridOptionsAll);
		
		$value = UniteFunctionsUC::getVal($this->gridOptionsAll, $name);
		
		return($value);
	}
	
	
	/**
	 * get col class according the number of cols
	 */
	private function getColSizeClass($numCols){
		
		$colSize = "";
		
		switch($numCols){
			case 1:
				$colSize = "1_1";
			break;
			case 2:
				$colSize = "1_2";
			break;
			case 3:
				$colSize = "1_3";
			break;
			case 4:
				$colSize = "1_4";
			break;
			case 5:
				$colSize = "1_5";
			break;
			case 6:
				$colSize = "1_6";
			break;
			default:
				UniteFunctionsUC::throwError("Invalid number of columns: $numCols");
			break;
		}
		
		$colSize  = self::COLSIZE_PREFIX.$colSize;
		
		return($colSize);
	}
	
	
	/**
	 * get output process type, back or front
	 */
	public function getOutputProcessType(){
		
		$isAdmin = UniteProviderFunctionsUC::isAdmin();
		$processType = UniteCreatorParamsProcessor::PROCESS_TYPE_OUTPUT;
		
		if($isAdmin == true)
			$processType = UniteCreatorParamsProcessor::PROCESS_TYPE_OUTPUT_BACK;
		
		return($processType);
	}
	
	/**
	 * get addon output
	 */
	public function getAddonOutput($objAddon){
		
		if(empty($processType))
			$processType = $this->getOutputProcessType();
		
		$objOutput = new UniteCreatorOutput();
		$objOutput->setProcessType($processType);
		
		$objOutput->initByAddon($objAddon);
		
		$params = array("wrap_js_timeout"=> true);
		
		$htmlAddon = $objOutput->getHtmlBody(true,false,true,$params);
				
		$arrIncludes = $objOutput->getProcessedIncludes(true);
		$arrConstantData = $objOutput->getConstantData();
		
		$arr = array();
		$arr["html"] = $htmlAddon;
		$arr["includes"] = $arrIncludes;
		$arr["constants"] = $arrConstantData;
		
		return($arr);
	}
	
	
	/**
	 * get addon contents
	 */
	public function getAddonContents($addonData){
		
		try{
			$objAddons = new UniteCreatorAddons();
			$objAddon = $objAddons->prepareAddonByData($addonData);
			
		}catch(Exception $e){
			
			$addonName = UniteFunctionsUC::getVal($addonData, "name");
			
			$htmlAddon = $addonName .__(" addon not found", ADDONLIBRARY_TEXTDOMAIN);
			
			$arr = array();
			$arr["html"] = $htmlAddon;
			return($arr);
		}
		
		$arr = $this->getAddonOutput($objAddon);
		
		return($arr);
	}
	
	
	
	
	private function a_______CSS_______(){}
	
		
	
	/**
	 * get row inline css
	 * 
	 */
	private function getRowInlineCss($row){
		
		$arrRow = array();
		$arrContainer = array();
		$arrCols = array();
		$arrColAddons = array();
		
		$settings = UniteFunctionsUC::getVal($row, "settings", array());
		if(empty($settings))
			$settings = array();
		
		foreach($settings as $key=>$value){
			
			$value = trim($value);
			
			switch($key){
				case "row_container_width":
					if($value !== "")
						$arrContainer["max-width"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "row_padding_top":
					if($value !== "")
						$arrRow["padding-top"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "row_padding_bottom":
					if($value !== "")
						$arrRow["padding-bottom"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "col_gutter":
					if($value !== ""){
						$arrCols["padding-left"] = UniteFunctionsUC::normalizeSize($value);
						$arrCols["padding-right"] = UniteFunctionsUC::normalizeSize($value);
					}
				break;
				case "space_between_addons":
					if($value !== "")
						$arrColAddons["margin-top"] = UniteFunctionsUC::normalizeSize($value);
				break;
			}
			
		}
		
		$arrRowBG = $this->getBackgroundCss($settings);
		if(!empty($arrRowBG))
		    $arrRow = array_merge($arrRow, $arrRowBG);
		
		
		$rowAddCss = UniteFunctionsUC::getVal($settings, "row_css");
		$containerAddCss = UniteFunctionsUC::getVal($settings, "row_container_css");
		
		$cssRow = UniteFunctionsUC::arrStyleToStrInlineCss($arrRow, $rowAddCss);
		$cssContainer = UniteFunctionsUC::arrStyleToStrInlineCss($arrContainer, $containerAddCss);
		
		$cssCols = UniteFunctionsUC::arrStyleToStrInlineCss($arrCols);
		
		
		$output = array();
		$output["row"] = $cssRow;
		$output["container"] = $cssContainer;
		$output["cols"] = $cssCols;
		$output["arrCols"] = $arrCols;
		$output["arrAddons"] = $arrColAddons;
		return($output);
	}
	
	
	/**
	 * get general element css from options
	 */
	private function getCommonElementCss($options){
		
		if(empty($options))
			return(array());
		
		$arrSizePairs = array();
		$arrSizePairs["padding_top"] = "padding-top";
		$arrSizePairs["padding_bottom"] = "padding-bottom";
		$arrSizePairs["padding_left"] = "padding-left";
		$arrSizePairs["padding_right"] = "padding-right";
		$arrSizePairs["margin_right"] = "margin-right";
		$arrSizePairs["margin_left"] = "margin-left";
		$arrSizePairs["margin_top"] = "margin-top";
		$arrSizePairs["margin_bottom"] = "margin-bottom";
		
		$arrRegularPairs = array();
		$arrRegularPairs["text_align"] = "text-align";
		
		$arrCss = array();
		
		foreach($options as $key=>$value){
			
			$value = trim($value);
			if($value === "")
				continue;
			
			//put size elements
			$cssSizeKey = UniteFunctionsUC::getVal($arrSizePairs, $key);
			if(!empty($cssSizeKey)){
					$arrCss[$cssSizeKey] = UniteFunctionsUC::normalizeSize($value);
				continue;
			}
			
			//put regular elements
			$cssRegularPairKey = UniteFunctionsUC::getVal($arrRegularPairs, $key);
			if(!empty($cssRegularPairKey)){
					$arrCss[$cssRegularPairKey] = $value;
			}
			
		}
		
		//add background
		$arrBG = $this->getBackgroundCss($options);
		if(!empty($arrBG))
			$arrCss = array_merge($arrCss, $arrBG);
				
		
		return($arrCss);
	}
	
	

	
	/**
	 * get addon inline css
	 */
	private function getElementInlineStyle($arrCss, $options, $prefix=null){
		
		if(empty($arrCss))
			$arrCss = array();
		
		$commonCss = $this->getCommonElementCss($options);
		if(!empty($commonCss))	
			$arrCss = array_merge($arrCss, $commonCss);
		
		$customCss = "";
		if(!empty($prefix))
			$customCss = UniteFunctionsUC::getVal($options, $prefix."_css"); 
		
		$addStyle = UniteFunctionsUC::arrStyleToStrInlineCss($arrCss, $customCss);

		return($addStyle);
	}
	
	
	
	/**
	 * get column inline style array
	 */
	private function getColAddonsInlineStyle($optionsCol, $arrAddonStylesFromRow){
		
		if(empty($arrAddonStylesFromRow))
			$arrAddonStylesFromRow = array();
		
		$spaceBetweenAddons = UniteFunctionsUC::getVal($optionsCol, "col_space_between_addons");
		if($spaceBetweenAddons != "")
			$arrAddonStylesFromRow["margin-top"] = $spaceBetweenAddons."px";
					
		
		return($arrAddonStylesFromRow);
	}
	
	
	/**
	 * get background css
	 */
	private function getBackgroundCss($options){
	    
	    $css = array();
	    
	    $oldColor = UniteFunctionsUC::getVal($options, "row_background_color");

	    if(!empty($oldColor)){
	    	$enableBG = true;
	    }else{
		    $enableBG = UniteFunctionsUC::getVal($options, "bg_enable");
		    $enableBG = UniteFunctionsUC::strToBool($enableBG);
	    }
	    
	    if($enableBG == false)
	        return(false);
	    
	    //set color
	    $color = UniteFunctionsUC::getVal($options, "bg_color");
	    if(empty($color))
	    	$color = $oldColor;
	    
	    
	    if($color)
	        $css["background-color"] = $color;
	   
	    //set image
	    
	    $urlImage = UniteFunctionsUC::getVal($options, "bg_image_url");
	    if($urlImage){
	        $urlImage = HelperUC::URLtoFull($urlImage);
	        
	        $imageSize = UniteFunctionsUC::getVal($options, "bg_image_size");
	        $imagePosition = UniteFunctionsUC::getVal($options, "bg_image_position");
	        $imageRepeat = UniteFunctionsUC::getVal($options, "bg_image_repeat");
	        $imageBlend = UniteFunctionsUC::getVal($options, "bg_image_blend");
	        $imageParallax = UniteFunctionsUC::getVal($options, "bg_image_parallax");
	        
	        
	        $css["background-image"] = "url('{$urlImage}')";
	        
	        if($imageSize)
	            $css["background-size"] = $imageSize;
	            
	        if($imagePosition)
	            $css["background-position"] = $imagePosition;
	                
	        if($imageRepeat)
	            $css["background-repeat"] = $imageRepeat;
	        
	        if($imageBlend && $imageBlend != "normal")
	            $css["background-blend-mode"] = $imageBlend;
	        
	        $imageParallax = UniteFunctionsUC::strToBool($imageParallax);
	        
	        if($imageParallax === true)
	            $css["background-attachment"] = "fixed";
	                
	    }
	    
	    $enableGradient = UniteFunctionsUC::getVal($options, "bg_gradient_enable");
	    $enableGradient = UniteFunctionsUC::strToBool($enableGradient);
	    
	    if($enableGradient == true){
	    	$gradientReverse = UniteFunctionsUC::getVal($options, "bg_gradient_reverse");
	    	$gradientReverse = UniteFunctionsUC::strToBool($gradientReverse);
	    	
	    	if($gradientReverse == false){
		    	$gradientColor1 = UniteFunctionsUC::getVal($options, "bg_gradient_color1");
		    	$gradientColor2 = UniteFunctionsUC::getVal($options, "bg_gradient_color2");
	    	}else{
		    	$gradientColor1 = UniteFunctionsUC::getVal($options, "bg_gradient_color2");
		    	$gradientColor2 = UniteFunctionsUC::getVal($options, "bg_gradient_color1");
	    	}
	    	
	    	$gradientStartPos = UniteFunctionsUC::getVal($options, "bg_gradient_start_pos");
	    	$gradientEndPos = UniteFunctionsUC::getVal($options, "bg_gradient_end_pos");
	    	$gradientLinearDirection = UniteFunctionsUC::getVal($options, "bg_gradient_linear_direction");
	    	$gradientRadialDirection = UniteFunctionsUC::getVal($options, "bg_gradient_radial_direction");

	    	$gradientType = UniteFunctionsUC::getVal($options, "bg_gradient_type");
	    	
	    	$strGradient = "";
	    	$strGradient .= "{$gradientType}-gradient(";
	    	
	    	if($gradientType == "linear")
	    		$strGradient .= "{$gradientLinearDirection}deg, ";
	    	else
	    	 $strGradient .= "circle at {$gradientRadialDirection}, ";
	    	 
	    	$strGradient .= "{$gradientColor1} {$gradientStartPos}%, ";
	    	$strGradient .= "{$gradientColor2} {$gradientEndPos}%";
	    	
	    	$strGradient .= ")";
	    	
	    	$backgroundImage = UniteFunctionsUC::getVal($css, "background-image");
	    	if(!empty($backgroundImage))
	    		$backgroundImage .= ", ";
	    	
	    	$backgroundImage .= $strGradient;
	    	
	    	$css["background-image"] = $backgroundImage;
	    }
	    
	    return($css);	    
	}
	
	
	/**
	 * get grid inline css
	 */
	private function getGridCss($wrap = false){
		
		$css = "";
		$options = $this->gridOptionsDiff;
		
		
		if(empty($options))
			return("");
		
		$arrRowStyles = array();
		$arrContainerStyles = array();
		$arrColStyles = array();
		$arrFirstColStyles = array();
		$arrLastColStyles = array();
		$arrAddonsStyles = array();
		
		foreach($options as $key => $value){
			
			switch($key){
				case "row_container_width":
					$arrContainerStyles["max-width"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "col_gutter":
					$arrColStyles["padding-left"] = UniteFunctionsUC::normalizeSize($value);
					$arrColStyles["padding-right"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "col_border_gutter":
					$arrFirstColStyles["padding-left"] = UniteFunctionsUC::normalizeSize($value);
					$arrLastColStyles["padding-right"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "row_padding_top":
					$arrRowStyles["padding-top"] = UniteFunctionsUC::normalizeSize($value);
				break;
                case "row_padding_bottom":
					$arrRowStyles["padding-bottom"] = UniteFunctionsUC::normalizeSize($value);
				break;
				case "space_between_addons":
					$arrAddonsStyles["margin-top"] = UniteFunctionsUC::normalizeSize($value);
				break;
			}
		}
		
		$gridID = "#".$this->gridHtmlID;
		
		$css = "";
		
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrRowStyles, "{$gridID} .uc-grid-row");
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrContainerStyles, "{$gridID} .uc-grid-row .uc-grid-row-container");
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrColStyles, "{$gridID} .uc-grid-row .uc-grid-col");
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrFirstColStyles, "{$gridID} .uc-grid-row .uc-grid-col.uc-col-first");
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrLastColStyles, "{$gridID} .uc-grid-row .uc-grid-col.uc-col-last");
		$css .= UniteFunctionsUC::arrStyleToStrStyle($arrAddonsStyles, "{$gridID} .uc-grid-col .uc-grid-col-addon");
		
		//add custom css
		$customCss = UniteFunctionsUC::getVal($this->gridOptionsAll, "page_css");
		
		if(!empty($customCss)){
			if(!empty($css))
				$css .= "\n";
			$css .= $customCss;
		}
		
		if($wrap == false || empty($css))
			return($css);
		
		//wrap the css with the style tag
		$cssWrap = "<style type='text/css'>".self::BR;
		$cssWrap .= self::TAB2."/* layout grid styles */".self::BR;
		$cssWrap .= $css;
		$cssWrap .= "</style>".self::BR;
			
		return($cssWrap);
	}
	
	
	/**
	 * put grid inline css
	 */
	private function putGridCss(){
		
		$css = $this->getGridCss();
		
		HelperUC::putInlineStyle($css);
		
	}
	
	
	private function a_________HTML________(){}
	
	
	/**
	 * get columns html
	 */
	private function getHtmlCols($arrCols, $styleCols = "", $arrStylesAddons = array(), $arrStyleCols = array()){
		
		if(!is_array($arrCols))
			UniteFunctionsUC::throwError("The columns should be array");
		
		if(empty($arrCols))
			UniteFunctionsUC::throwError("The row should have at least one column");

		$numCols = count($arrCols);
		
		$colSizeClass = $this->getColSizeClass($numCols);
		if(!empty($styleCols))
			$styleCols = " ".$styleCols;
		
		$html = "";
		foreach($arrCols as $numCol => $col){
			
			$isFirst = ($numCol == 0);
			$isLast = ($numCol == ($numCols-1));
			
			$class = "uc-grid-col ";
			
			if($isFirst)
				$class .= "uc-col-first ";
			
			if($isLast)
				$class .= "uc-col-last ";
			
			$size = UniteFunctionsUC::getVal($col, "size");
			if(!empty($size))
			    $colSizeClass = self::COLSIZE_PREFIX.$size;
			    
			//set add style
			$addStyle = $styleCols;
			$colSettings = UniteFunctionsUC::getVal($col, "settings");
			if(!empty($colSettings))
				$addStyle = $this->getElementInlineStyle($arrStyleCols, $colSettings, "col");
			
			$class .= $colSizeClass;
			
			//add custom class
			$addClas = UniteFunctionsUC::getVal($colSettings, "col_class");
			if(!empty($addClas)){
				$class .= " {$addClas}";
			}
			
			if(!empty($addStyle))
				$addStyle = " {$addStyle}";
			
			$colID = UniteFunctionsUC::getVal($colSettings, "col_id");
			if(!empty($colID))
				$colID = "id='$colID' ";
			
			$html .= self::TAB3."<div {$colID}class=\"{$class}\"{$addStyle}>";
			
			$colHtml = $this->getColHtml($col, $arrStylesAddons);
			
			$html .= $colHtml;
			$html .= "</div>".self::BR;
			
		}
		
		if(!empty($arrCols)){
			$html .= "<div class=\"uc-col-clear\"></div>".self::BR;
		}
		
		return($html);
	}
	
		
	
	/**
	 * check row animations, if exists, add files to class and animation includes
	 */
	private function checkItemAnimation($arrSettings, $class, $addHtml){
		
		$output = array();
		$output["class"] = $class;
		$output["addhtml"] = $addHtml;
		
		$animationType = UniteFunctionsUC::getVal($arrSettings, "animation_type");
		$animationType = trim($animationType);
		
		
		if(empty($animationType))
			return($output);
		
		$delay = UniteFunctionsUC::getVal($arrSettings, "animation_delay");
		$duration = UniteFunctionsUC::getVal($arrSettings, "animation_duration");
		
		$delay = trim($delay);
		$duration = trim($duration);
		
		HelperUC::putAnimationIncludes();
		
		$class .= " wow {$animationType}";
		
		if(is_numeric($delay))
			$addHtml .= " data-wow-delay=\"{$delay}s\"";
		
		if(is_numeric($duration))
			$addHtml .= " data-wow-duration=\"{$duration}s\"";
		
		//output
		$output["class"] = $class;
		$output["addhtml"] = $addHtml;		
			
		return($output);
	}
	
	
	/**
	 * get visibility add class
	 */
	private function addVisibilityClass($class, $settings){
		
		$hideDesktop = UniteFunctionsUC::getVal($settings, "hide_in_desktop");
		$hideDesktop = UniteFunctionsUC::strToBool($hideDesktop);
		
		$hideMobile = UniteFunctionsUC::getVal($settings, "hide_in_mobile");
		$hideMobile = UniteFunctionsUC::strToBool($hideMobile);
		
		$hideTablet = UniteFunctionsUC::getVal($settings, "hide_in_tablet");
		$hideTablet = UniteFunctionsUC::strToBool($hideTablet);
		
		if($hideDesktop && $hideMobile && $hideTablet)
			return(self::HIDE_ELEMENT);
		
		$arrClasses = array($class);
		if($hideDesktop == true)
			$arrClasses[] = "uc-hide-desktop";
		
		if($hideTablet == true)
			$arrClasses[] = "uc-hide-tablet";
			
		if($hideMobile == true)
			$arrClasses[] = "uc-hide-mobile";
			
		$class = implode(" ", $arrClasses);
		
		return($class);
	}
	
	
	/**
	 * output front rows
	 */
	private function getHtmlRows($rows){
		
		$html = "";
		
		$numRows = count($rows);
		
		
		foreach($rows as $key => $row){
			
			$arrRowCss = $this->getRowInlineCss($row);
			
			$styleRow = $arrRowCss["row"];
			$styleContainer = $arrRowCss["container"];
			$styleCols = $arrRowCss["cols"];
			$arrStyleCols = $arrRowCss["arrCols"];
			$arrStyleAddons = $arrRowCss["arrAddons"];
			
			
			$settings = UniteFunctionsUC::getVal($row, "settings");
			
			//get row class and attribute
			$rowID = UniteFunctionsUC::getVal($settings, "row_id");
			$rowClass = UniteFunctionsUC::getVal($settings, "row_class");
			
			$rowID = UniteFunctionsUC::sanitizeAttr($rowID);
			$rowClass = UniteFunctionsUC::sanitizeAttr($rowClass);
			
			$class = "uc-grid-row";
			
			if(!empty($rowClass))
				$class .= " ".$rowClass;
			
			$class = $this->addVisibilityClass($class, $settings);
			if($class == self::HIDE_ELEMENT)
				continue;
			
			if(!empty($rowID))
				$rowID = "id=\"{$rowID}\"";
			
			$addHtml = "";
			$output = $this->checkItemAnimation($settings, $class, $addHtml);
			$class = $output["class"];
			$addHtml = $output["addhtml"];
			
			$html .= self::TAB2."<div {$rowID} class=\"{$class}\" {$addHtml} {$styleRow}>".self::BR;
			$html .= self::TAB3."<div class=\"uc-grid-row-container\" {$styleContainer}>".self::BR;
			
			
			//------------ draw columns---------------
			
			$arrCols = UniteFunctionsUC::getVal($row, "cols");
			UniteFunctionsUC::validateNotEmpty($arrCols, "row columns");
			
			$html .= $this->getHtmlCols($arrCols, $styleCols, $arrStyleAddons, $arrStyleCols);
			
			$html .= self::TAB3."</div>".self::BR;
			$html .= self::TAB2."</div>".self::BR;
			
		}
		
		return($html);
	}
	
	
	
	
	/**
	 * get column addon html 
	 */
	private function getColHtml($col, $arrAddonStyles){
		
		$addonsData = UniteFunctionsUC::getVal($col, "addon_data");
		$colSettings = UniteFunctionsUC::getVal($col, "settings");
		
		//backward compatable
		$isSingle = isset($addonsData["config"]);
		if($isSingle)
			$addonsData = array($addonsData);
		
		$arrColumnsCss = $this->getColAddonsInlineStyle($colSettings, $arrAddonStyles);
		
		$addonHtml = "";
		
		
		foreach($addonsData as $index => $addonData){
			
			$arrOptions = UniteFunctionsUC::getVal($addonData, "options");
			
			$arrCss = $arrColumnsCss;
			if($index == 0)
				unset($arrCss["margin-top"]);
		    
			$addStyle = $this->getElementInlineStyle($arrCss, $arrOptions,"addon");
			
			//set addon class
			$addonClass = "uc-grid-col-addon";
			
			$addHtml = "";
			$output = $this->checkItemAnimation($arrOptions, $addonClass, $addHtml);
			$addonClass = $output["class"];
			$addHtml = $output["addhtml"];
			
			$addonHtml .= "<div class='{$addonClass}' {$addHtml} {$addStyle}>";
			
			$addonHtml .= $this->getAddonHtml($addonData);
			
			$addonHtml .= "</div>";
		}
			
		
				
		$html = "";
		$html .= "<div class=\"uc-grid-col-inner\">";
		$html .= $addonHtml;
		$html .= "</div>";
		
		return($html);
	}
	
	
	/**
	 * get addon html
	 */
	private function getAddonHtml($addonData){
		
		//if no addon name - return empty string
		if(empty($addonData))
			return("");
		
		
		$addonName = UniteFunctionsUC::getVal($addonData, "name");
		
		if(empty($addonName))
			return("");
		
		$html = "";
		
		//output addon
		try{
			$objAddons = new UniteCreatorAddons();
			
			$objAddon = $objAddons->prepareAddonByData($addonData);
			
		}catch(Exception $e){
						
			//if addon not found - return it's name
			$html .= $addonName .__(" addon not found", ADDONLIBRARY_TEXTDOMAIN);
			
			return($html);
		}
		
		//process includes and get html
		
		$objOutput = new UniteCreatorOutput();
		$objOutput->initByAddon($objAddon);
		
		$htmlAddon = $objOutput->getHtmlBody($this->isScriptsHardCoded, $this->cssToBody, $this->cssToBody);
		
		$objOutput->processIncludes();
		
		$html .= $htmlAddon;
		
		return($html);
	}
	
	
	
	
	/**
	 * get html output
	 */
	public function getHtml(){
		
		$this->validateInited();
		
		self::putIncludeScripts();
		
		$css = "";
		
		if($this->cssToBody == false)
			$this->putGridCss();
		else
			$css = $this->getGridCss(true);
		
		
		$rows = $this->layout->getRowsFront();
				
		$gridID = $this->gridHtmlID;
				
		$html = "";
		if(!empty($css))
			$html .= $css;
		
		$html .= self::TAB."<div id=\"{$gridID}\" class=\"uc-grid-front\">".self::BR;
		$html .= $this->getHtmlRows($rows);
		$html .= self::TAB.'</div>'.self::BR;
		
		return($html);
	}
	
	
	/**
	 * output layout front
	 */
	public function putHtml(){
		
		$html = $this->getHtml();
		
		echo $html;
	}
	
	
}