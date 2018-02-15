
function UniteCreatorGridBuilder(){

	var g_objGrid, g_objStyle, g_options, g_objWrapper, g_objParent;
	var g_optionsCustom = {}, g_objRowStyleContainer, g_objColStyleContainer;
	var g_gridID, g_objSettingsGrid = new UniteSettingsUC();
	var g_objBrowser = new UniteCreatorBrowser();
	var g_objAddonConfig = new UniteCreatorAddonConfig();
	var g_objSettingsRow = new UniteSettingsUC(), g_panel = new UniteCreatorGridPanel();
	var g_objDialogRowSettings, g_objDialogRowLayout;
	
	var t = this;
	
	var g_vars = {
			class_col: "uc-grid-col",
			class_first_col: "uc-col-first",
			class_last_col: "uc-col-last",
			class_empty: "uc-col-empty",
			class_first_row: "uc-row-first",
			class_last_row: "uc-row-last",
			class_size_prefix:"uc-colsize-",
			id_prefix: "uc_addon_",
			addon_conetentid_prefix: "uc_addon_contentid",
			max_cols: 6,
			serial: 0		//give serial numbers to addons
	};
	
	var g_temp = {
		is_live_view: false,
		indev: false
	};
	
	this.events = {
			ROW_COLUMNS_UPDATED: "ROW_COLUMNS_UPDATED",
			ROWS_UPDATED: "ROWS_UPDATED",			//add, remove, reorder row
			ROW_ADDED: "ROW_ADDED",
			COL_ADDED: "COL_ADDED",
			COL_ADDONS_UPDATED: "ADDONS_UPDATED",
			BEFORE_REMOVE_ADDON: "BEFORE_REMOVE_ADDON",
			ELEMENT_REMOVED: "ELEMENT_REMOVED",		//on some addons removed
			ADDON_ADDED: "ADDON_ADDED",	//before duplicated addon data inserted
			ADDON_DUPLICATED: "ADDON_DUPLICATED",	//before duplicated addon data inserted
			COL_DUPLICATED: "COL_DUPLICATED",		//before duplicated column data added
			ROW_DUPLICATED: "ROW_DUPLICATED",		//before duplicated row data added
			ROW_SETTINGS_UPDATED: "ROW_SETTINGS_UPDATED"	//on row settings updated
	};
	
	if(!g_ucAdmin)
		var g_ucAdmin = new UniteAdminUC();
	
	
	function ____________GENERAL______________(){}
	
	
	/**
	 * get element type - column, addon, row, undefined
	 */
	function getElementType(element){
		
		if(!element)
			return("undefined");
		
		if(element.hasClass("uc-grid-col"))
			return("column");
		
		if(element.hasClass("uc-grid-col-addon"))
			return("addon");

		if(element.hasClass("uc-grid-row"))
			return("row");
				
		return("undefined");
	}
	
	
	/**
	 * do grid action
	 */
	function doGridAction(action, parentRow){
		
		switch(action){
			case "add_row":
				addRow(parentRow);
			break;
			default:
				throw new Error("Wrong grid action: "+action);
			break;
		}
		
	}
	
	
	/**
	 * get element addons (grid, row, col)
	 */
	function getElementAddons(objElement){
		
		var objAddons = objElement.find(".uc-grid-col-addon").not(".uc-grid-overlay-empty");
		
		return(objAddons);
	}
	
	/**
	 * show error message from the parent object
	 */
	function showErrorMessage(message){
		
		if(!g_objParent){
			alert(message);
			return(false);
		}
		
		g_objParent.showErrorMessage(message);
			
	}
	
	function ____________ROW______________(){}
	
	
	/**
	 * validate row
	 */
	function validateRow(objRow){
		
		if(!objRow)
			throw new Error("Empty Row Found: "+objRow);
		
		if(objRow.hasClass("uc-grid-row") == false)
			throw new Error("Wrong Row: "+objRow);
		
	}
	
	
	/**
	 * get row html
	 */
	function getHtmlRow(){
		
		g_vars.serial++;
		var rowID = g_gridID+"_row_"+g_vars.serial;
		
		rowID = rowID.replace("#", "");
		
		var html = "";
		html += "<div id='"+rowID+"' class='uc-grid-row'>";
		
		html += "<div class='uc-grid-row-hover uc-hover-top'></div>";
		html += "<div class='uc-grid-row-hover uc-hover-bottom'></div>";
		html += "<div class='uc-grid-row-hover uc-hover-left'></div>";
		html += "<div class='uc-grid-row-hover uc-hover-right'></div>";
		
		
		//add row panel
		html += "	<div class='uc-grid-row-panel'>";
		html += "			<a href='javascript:void(0)' title='"+g_uctext.move_row+"' class=\"uc-row-icon uc-grid-icon-move uc-row-icon-move uc-tip\" ><i class=\"fa fa-arrows\" aria-hidden=\"true\"></i></a> ";
		html += "			<a href='javascript:void(0)' data-action='delete_row' data-actiontype='row' title='"+g_uctext.delete_row+"' class=\"uc-row-icon uc-grid-action-icon uc-tip\" ><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a> ";
		html += "			<a href='javascript:void(0)' data-action='duplicate_row' data-actiontype='row' title='"+g_uctext.duplicate_row+"' class=\"uc-row-icon uc-grid-action-icon uc-tip\" ><i class=\"fa fa-clone\" aria-hidden=\"true\"></i></a> ";
		html += "			<a href='javascript:void(0)' data-action='row_settings' data-actiontype='row' title='"+g_uctext.settings+"' class=\"uc-row-icon uc-grid-action-icon uc-tip\" ><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></a> ";
        html += "			<a href='javascript:void(0)' data-action='row_layout' data-actiontype='row' title='' class=\"uc-row-icon uc-grid-action-icon uc-tip\" ><i class=\"fa fa-th-list\" aria-hidden=\"true\"></i></a> ";
		html += "	</div>";
		
		//add container
		html += "	<div class='uc-grid-row-container unite-clearfix'>";
		html += "	</div>";
		
		// add row
		html += "	<a href='javascript:void(0)' data-action='add_row' data-actiontype='grid' title='Add Row' class='uc-btn-wrap uc-grid-action-icon uc-button-addrow-wrapper'><span class='uc-btn uc-btn-round uc-btn-primary'><i class='fa fa-plus' aria-hidden='true'></i></span></a>";
		
		
		html += "</div>";
		
		return(html);
	}
	
	
	/**
	 * add empty row
	 */
	function addEmptyRow(parentRow){
		var html = getHtmlRow();
		
		var objRow = jQuery(html);
		
        if(typeof parentRow === 'undefined') {
		g_objGrid.append(objRow);
        } else {
            objRow.insertAfter(parentRow);
        }
		
		triggerEvent(t.events.ROW_ADDED, objRow);
		triggerEvent(t.events.ROWS_UPDATED);
		
		return(objRow);
	}
	
	
	/**
	 * add row to the end
	 */
	function addRow(parentRow){
		
        var objRow = addEmptyRow(parentRow);
				
		addColumn(objRow);
		
	}
	
	
	/**
	 * get all rows
	 */
	function getRows(){
		
		var objRows = g_objGrid.children(".uc-grid-row");
		
		return(objRows);
	}
	
	
	/**
	 * get number of rows
	 */
	function getNumRows(){
		
		var objRows = getRows();
		
		var numRows = objRows.length;
		
		return(numRows);
	}
	
	
	
	/**
	 * get row bu number
	 */
	function getRow(num){
		
		if(!num)
			var num = 0;
		
		var objRows = getRows();
		
		if(num >= objRows.length)
			throw new Error("getRow error: Row "+num+" don't exists");
		
		var objRow = jQuery(objRows[num]);
		
		return(objRow);
	}
	
	
	/**
	 * get row container
	 * @param objRow
	 */
	function getRowContainer(objRow){
		var objContainer = objRow.find(".uc-grid-row-container");
		g_ucAdmin.validateDomElement(objContainer, "Row Container");
		return(objContainer);
	}
	
	
	/**
	 * get parent row
	 */
	function getParentRow(objChild){
		
		var objRow = objChild.parents(".uc-grid-row");
		
		return(objRow);
	}
	
	
	
	
	/**
	 * get row addons
	 */
	function getRowAddons(objRow){
		validateRow(objRow);
		
		var objAddons = getElementAddons(objRow);
		
		return(objAddons);
	}
	
	
	/**
	 * get number of row addons
	 */
	function getNumRowAddons(objRow){
		
		var objAddons = getRowAddons(objRow);
		return(objAddons.length);
	}
	
	
	/**
	 * delete row
	 */
	function deleteRow(objRow){
		
		validateRow(objRow);
		
		var rowID = objRow.prop("id");
		
		objRow.remove();
		
		var numRows = getNumRows();
		if(numRows == 0)
			addRow();	//triggers the updated event
		else
			triggerEvent(t.events.ROWS_UPDATED);
		
		triggerEvent(t.events.ELEMENT_REMOVED, rowID);
	}
	
	
	
	/**
	 * duplicate row
	 */
	function duplicateRow(objRow){
		
		g_vars.serial++;
		var rowID = g_gridID+"_row_"+g_vars.serial;
		
		var objRowCopy = objRow.clone(true, true);
		
		objRowCopy.attr("id", rowID);
		
		triggerEvent(t.events.ROW_DUPLICATED, objRowCopy);
		
		objRowCopy.insertAfter(objRow);
			
		triggerEvent(t.events.ROWS_UPDATED);
		
	}
	
	
    
	/**
	 * set row hover second mode
	 */
	function setRowHoverSecondMode(){
		var objRow = jQuery(this);
		if(objRow.hasClass("uc-grid-row") == false)
			objRow = getParentRow(objRow);
		
		objRow.addClass("uc-over-mode2");
		
	}
    
	
	/**
	 * unset row hover second mode
	 */
	function unsetRowHoverSecondMode(event, objRow){
		
		if(!objRow)
			var objRow = jQuery(this);
		
		if(objRow.hasClass("uc-grid-row") == false)
			objRow = getParentRow(objRow);
		
		objRow.removeClass("uc-over-mode2");
	}
	
	
	/**
	 * do action
	 */
	function doRowAction(action, objRow){
		
		switch(action){
			case "add_row":
				addRow(objRow);
			break;
			case "delete_row":
				deleteRow(objRow);
			break;
			case "duplicate_row":
				duplicateRow(objRow);
			break;
			case "row_settings":				
				openRowSettingsPanel(objRow);
			break;
            case "row_layout":
                openRowLayoutDialog(objRow);
			break;
			default:
				trace("wrong row action: " + action);
			break;
		}
		
	}
	
	
	function ____________ROW_LAYOUT______________(){}
	
	
	
    /**
     * row layout
     */
    function selectLayout(objRow){
        jQuery('.selectLayout').toggleClass("hidden");
    }
	
    /**
     * open row layout dialog
     */
    function openRowLayoutDialog(objRow){
        
    	var dialogOptions = {
            minWidth:1000,
            buttons:{}
        };
        
        // g_objDialogRowLayout.data("active_row", objRow);
        g_ucAdmin.openCommonDialog("#uc_dialog_row_layout", function(){
            jQuery(".uc-layout-row").unbind("click");
			jQuery(".uc-layout-row").click({ row: objRow }, choseRowLayout);
		}, dialogOptions, true);
        
    }
    
    /**
	 * init grid layout
     */
    function initRowLayout(){
    	
        g_objDialogRowLayout = jQuery("#uc_dialog_row_settings");
        g_ucAdmin.validateDomElement(g_objDialogRowLayout, "row layout dialog");
        
        var objLayoutWrapper = jQuery("#uc_layout_grid_row");
        g_ucAdmin.validateDomElement(objLayoutWrapper, "row layout wrapper");
	}
	
    /**
	 * row layout chosen
     */
    function choseRowLayout(event) {
    	
        var objLayout = jQuery(this);
        var objRow = event.data.row;
        var layoutType = objLayout.data("layout-type");
        var columnsSize = layoutType.split('-');
        var numCols = getNumCols(objRow);
        var newNumCols = columnsSize.length;
        
        if(numCols == newNumCols){
        	
            columnsSize.forEach(function (item, index) {
                var objCol = getCol(objRow, index);
                setColSize(objCol, item);
            });
            
		}
        else if(numCols < newNumCols) {
        	
            columnsSize.forEach(function (item, index) {
                try{
                    var objCol = getCol(objRow, index);
                    setColSize(objCol, item);
                } catch (e){
                	addLayoutColumn(objRow, item);
				}
            });
            
        }
        else{
        	
        	var isOK = true;
        	var numAddons = getNumRowAddons(objRow);
        	if(numAddons > 1)
        		isOK = confirm("Replace Addons?");
        	
        	if(isOK == true) {
                for (var i = numCols - 1; i >= 0; i--) {
                    var objCol = getCol(objRow, i);
                    if (i < columnsSize.length)
                        setColSize(objCol, columnsSize[i]);
                    else {
                        var objAddons = getColAddonsData(objCol);
                        var lastObjCol = getCol(objRow, columnsSize.length - 1);
                        if (objAddons.length)
                            objAddons.forEach(function (item, index) {
                                addColAddon(lastObjCol, item, true);
                            });
                        deleteCol(objCol);
                    }
                }
            }
		}
        
        jQuery("#uc_dialog_row_layout").dialog("close");
    }
    
	
	function ____________ROW_UPDATE_VISUAL______________(){}
	
	
	/**
	 * get background css
	 */
	function getBackgroundCss(options){
		
		var css = {};
		
		var oldColor = g_ucAdmin.getVal(options, "row_background_color");
		if(oldColor == true){
			var enableBG = true;
		}else
			var enableBG = g_ucAdmin.getVal(options, "bg_enable",true, g_ucAdmin.getvalopt.FORCE_BOOLEAN);
		
		if(enableBG == false)
			return(css);
		
		//set color
		var color = g_ucAdmin.getVal(options, "bg_color");
		if(!color)
			color = oldColor;
		
		if(color)
			css["background-color"] = color;
				
		//set image
		var urlImage = g_ucAdmin.getVal(options, "bg_image_url");
		if(urlImage){
			
			urlImage = g_ucAdmin.urlToFull(urlImage);
			
			var imageSize = g_ucAdmin.getVal(options, "bg_image_size");
			var imagePosition = g_ucAdmin.getVal(options, "bg_image_position");
			var imageRepeat = g_ucAdmin.getVal(options, "bg_image_repeat");
			var imageBlend = g_ucAdmin.getVal(options, "bg_image_blend");
			var imageParallax = g_ucAdmin.getVal(options, "bg_image_parallax", false, g_ucAdmin.getvalopt.FORCE_BOOLEAN);
			
			
			css["background-image"] = "url('"+urlImage+"')";
			
			if(imageSize)
				css["background-size"] = imageSize;
			
			if(imagePosition)
				css["background-position"] = imagePosition;
			
			if(imageRepeat)
				css["background-repeat"] = imageRepeat;
			
			if(imageBlend && imageBlend != "normal")
				css["background-blend-mode"] = imageBlend;
			
			if(imageParallax === true)
				css["background-attachment"] = "fixed";
			
		}
		
		//set gradient
		var enableGradient = g_ucAdmin.getVal(options, "bg_gradient_enable",false, g_ucAdmin.getvalopt.FORCE_BOOLEAN);
		if(enableGradient == true){
			
			var gradientReverse = g_ucAdmin.getVal(options, "bg_gradient_reverse", false, g_ucAdmin.getvalopt.FORCE_BOOLEAN); 
			
			if(gradientReverse == true){
				var gradientColor2 = g_ucAdmin.getVal(options, "bg_gradient_color1"); 
				var gradientColor1 = g_ucAdmin.getVal(options, "bg_gradient_color2"); 
			}else{
				var gradientColor1 = g_ucAdmin.getVal(options, "bg_gradient_color1"); 
				var gradientColor2 = g_ucAdmin.getVal(options, "bg_gradient_color2"); 
			}
			
			var gradientStartPos = g_ucAdmin.getVal(options, "bg_gradient_start_pos"); 
			var gradientEndPos = g_ucAdmin.getVal(options, "bg_gradient_end_pos"); 
			var gradientLinearDir = g_ucAdmin.getVal(options, "bg_gradient_linear_direction"); 
			var gradientRadialDir = g_ucAdmin.getVal(options, "bg_gradient_radial_direction"); 
			
			var gradientType = g_ucAdmin.getVal(options, "bg_gradient_type"); 
			
			var strGradient = "";
			strGradient += gradientType+"-gradient(";
			if(gradientType == "linear"){
				strGradient += gradientLinearDir+"deg, ";
			}else
				strGradient += "circle at "+gradientRadialDir+", ";
			
			strGradient += gradientColor1+" "+gradientStartPos+"%, ";
			strGradient += gradientColor2+" "+gradientEndPos+"%";
			
			strGradient += ")";
			
			var bgImageContent = g_ucAdmin.getVal(css, "background-image");
			if(bgImageContent)
				bgImageContent += ", ";
			
			bgImageContent += strGradient;
			
			css["background-image"] = bgImageContent;
			
		}
		
		
		return(css);
	}
	
	
	/**
	 * update row visual css
	 */
	function updateRowVisual_css(objRow, objSettings){
		
		var rowID = objRow.prop("id");
		
		//back color
		var cssRow = {};
		
		cssRow = g_ucAdmin.addCssSetting(objSettings, cssRow, "row_padding_top", "padding-top","px");
		cssRow = g_ucAdmin.addCssSetting(objSettings, cssRow, "row_padding_bottom", "padding-bottom","px");
		
		var cssRowBG = getBackgroundCss(objSettings);
		if(cssRowBG)
			jQuery.extend(cssRow, cssRowBG);
		
		//remove style
		objRow.removeAttr("style");
		
		//add additional css
		var rowAddCss = g_ucAdmin.getVal(objSettings, "row_css", null);
		if(rowAddCss){
			rowAddCss = g_ucAdmin.removeLineBreaks(rowAddCss);
			objRow.prop("style", rowAddCss);
		}
		
		objRow.css(cssRow);
		
		//------ row columns ---- 
		
		var cssCol = {};
		cssCol = g_ucAdmin.addCssSetting(objSettings, cssCol, "col_gutter", "padding-left","px");
		cssCol = g_ucAdmin.addCssSetting(objSettings, cssCol, "col_gutter", "padding-right","px");
		
		var colSelector = g_gridID+" .uc-grid-row#"+rowID+" .uc-grid-col";
		var strCss = g_ucAdmin.arrCssToStrCss(cssCol, colSelector);
		
		
		//------ row addons ---- 
		
		var addonBoxStyle = "";
		var spaceBetweenAddons = g_ucAdmin.getVal(objSettings, "space_between_addons", null);
		
		if(spaceBetweenAddons){
			spaceBetweenAddons = g_ucAdmin.normalizeSizeValue(spaceBetweenAddons);
			addonBoxStyle += "margin-top:" + spaceBetweenAddons+";";
		}
		
		if(addonBoxStyle){
			if(strCss)
				strCss += "\n";
			
			var addonsSelector = g_gridID+" .uc-grid-row#"+rowID+" .uc-grid-col .uc-grid-col-addon + .uc-grid-col-addon";
			strCss += addonsSelector+"{"+addonBoxStyle+"}";
		}
		
		//------ print inner objects css ---- 
		
		
		g_ucAdmin.printCssStyle(strCss, rowID, g_objRowStyleContainer);
		
		
		//----------- Container
		
		var strStyleContainer = "";
		var containerWidth = g_ucAdmin.getVal(objSettings, "row_container_width", null);
		if(containerWidth){
			containerWidth = g_ucAdmin.normalizeSizeValue(containerWidth);
			strStyleContainer += "width:" + containerWidth+";";
		}
		
		
		//add container css
		var containerAddCss = g_ucAdmin.getVal(objSettings, "row_container_css", null);
		if(containerAddCss){
			containerAddCss = g_ucAdmin.removeLineBreaks(containerAddCss);
			strStyleContainer += containerAddCss;
		}
		
		//container width
		var objContainer = getRowContainer(objRow);
		
		//remove style
		objContainer.removeAttr("style");
		
		if(strStyleContainer){
			objContainer.prop("style", strStyleContainer);
		}
		
		
	}
	
	
	/**
	 * check buttons intersection
	 */
	function updateRowVisual_buttons(objRow){
		
		if(objRow.index() != 0)
			return(false);
		
		validateRow(objRow);
		
		$buttonInPlace = true;
		
		$numCols = getNumCols(objRow);
		
		//check situations where button not in place
		if($numCols %2 != 0){
			//$buttonInPlace = false;
			var rowPaddingBottom = getRowSetting(objRow, "row_padding_bottom", true);
			if(rowPaddingBottom < 12)
				$buttonInPlace = false;
		}
				
		var objButton = objRow.find(".uc-button-addrow-wrapper");
		
		if($buttonInPlace == false)
			objButton.addClass("uc-button-intersect");
		else
			objButton.removeClass("uc-button-intersect");
		
	}
	
	
	/**
	 * update row css
	 */
	function updateRowVisual(objRow, settings){
		
		var objSettings = settings || objRow.data("settings");
				
		updateRowVisual_css(objRow, objSettings);
		updateRowVisual_buttons(objRow, objSettings);
	}
	
	
	
	function ____________ROW_SETTINGS______________(){}
	
	/**
	 * set row settings, update css
	 */
	function updateRowSettings(objRow, objSettings){
		
		objRow.data("settings", objSettings);
		
		updateRowVisual(objRow, objSettings);
	}
	
	
	/**
	 * get row settings, combined with grid settings
	 */
	function getRowSettings(objRow, addGridOptions, arrFilter){
		
		var objRowSettings = objRow.data("settings");
		
		var objSettings = {};
		
		if(objRowSettings)
			jQuery.extend(objSettings, objRowSettings);
		
		//old Color fix
		var oldColor = g_ucAdmin.getVal(objSettings, "row_background_color");
		if(oldColor)
			objSettings["bg_color"] = oldColor;
		
		
		//add grid options
		if(addGridOptions === true){
			var options = getCombinedOptions();
			jQuery.each(options, function(key, value){
				var rowOption = g_ucAdmin.getVal(objSettings, key);
				if(rowOption === "")
					objSettings[key] = value;
			});
		}
		
		if(arrFilter)
			objSettings = g_ucAdmin.filterObjectByKeys(objSettings, arrFilter);
		
		return(objSettings);
	}
	
	
	
	/**
	 * get row setting
	 */
	function getRowSetting(objRow, settingName, isNumeric){
		
		var objSettings = getRowSettings(objRow, true);
		
		var getValOpt = null;
		if(isNumeric === true)
			getValOpt = g_ucAdmin.getvalopt.FORCE_NUMERIC;
		
		var value = g_ucAdmin.getVal(objSettings, settingName, 0, getValOpt);
		
		return(value);
	}
	
	
	/**
	 * open row settings dialog
	 */
	function openRowSettingsPanel(objRow){
		
		var objSettingsData = getRowSettings(objRow);
		var rowID = objRow.prop("id");
				
		g_panel.toggle("row-settings", objSettingsData, rowID);
		
	}
	
	
	/**
	 * get column settings object
	 */
	function getColSettings(objCol){
		validateCol(objCol);
		
		var objSettings = objCol.data("settings");
		
		if(!objSettings)
			objSettings = {};
		
		return(objSettings);
	}
	
	
	/**
	 * apply row settings from panel
	 */
	function applyRowSettings(){
		
		var data = g_panel.getPaneData("row-settings");
		var rowID = data.objectID;
		var objRow = jQuery("#"+rowID);
		
		if(objRow.length == 0)
			return(false);
		
		
		updateRowSettings(objRow, data.settings);
	}
	
	
	
	function ____________MULTIPLE_ROWS______________(){}
	
	/**
	 * update all rows visual
	 */
	function updateAllRowsVisual(){
		var rows = getRows();
				
		jQuery.each(rows,function(index, row){
			var objRow = jQuery(row);
			updateRowVisual(objRow);
		});
	}
	
	/**
	 * update classes of all rows
	 */
	function updateRowsClasses(){
		
		var objRows = getRows();
		
		var numRows = getNumRows();
		jQuery.each(objRows, function(key, row){
			var rowClass = "uc-grid-row";
			
			if(key == 0)
				rowClass += " uc-row-first";
			
			if(key == (numRows-1))
				rowClass += " uc-row-last";
			
			row.className = rowClass;
		});
		
		
	}
	
	
	function ____________COLUMN______________(){}
	
	/**
	 * validate that the object is column
	 */
	function validateCol(objCol){
		
		g_ucAdmin.validateDomElement(objCol, "column");
		
		if(objCol.hasClass("uc-grid-col") == false)
			throw new Error("The object is not column type");
	}
	
    /**
	 * add columns for layout
     */
    function addLayoutColumn(objRow, colClass){
        if(objRow){
            var numCols = getNumCols(objRow);
            var htmlCol = getHtmlColumn();
            var objNewCol = jQuery(htmlCol).addClass("uc-col-last uc-colsize-"+colClass+" uc-col-trans");
            objNewCol.hide();
            var objCol = getCol(objRow, numCols - 1);
            jQuery(objCol).removeClass("uc-col-last");
            objNewCol.insertAfter(objCol);
            updateColOperationButtons(objRow);
            setTimeout(function(){
                objNewCol.show();
            },350);
		}
	}

	
	
	/**
	 * get html columns
	 */
	function getHtmlColumn(){
		
		g_vars.serial++;
		
		var colID = g_gridID+"_col_"+g_vars.serial;
		colID = colID.replace("#", "");
		
		var html = "";
		html += "<div id='"+colID+"' class=\"uc-grid-col\">";
		
		html += "<div class=\"uc-grid-box-wrapper\">";
        html += "			<a href='javascript:void(0)' data-action='addcol_before' data-actiontype='col' title='"+g_uctext.add_column+"' class=\"uc-icon-addcol uc-addcol-before uc-grid-action-icon\" ><span class='uc-btn uc-btn-round uc-btn-success'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></span></a> ";
		html += "			<a href='javascript:void(0)' data-action='addcol_after' data-actiontype='col' title='"+g_uctext.add_column+"' class=\"uc-icon-addcol uc-addcol-after uc-grid-action-icon\" ><span class='uc-btn uc-btn-round uc-btn-success'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></span></a>";
		
		html += "<div class='uc-grid-col-hover uc-hover-left'></div>";
		html += "<div class='uc-grid-col-hover uc-hover-top'></div>";
		html += "<div class='uc-grid-col-hover uc-hover-right'></div>";
		html += "<div class='uc-grid-col-hover uc-hover-bottom'></div>";
		
		//top panel
		html += "		<div class = \"uc-grid-col-panel\">";
		html += "			<a href='javascript:void(0)' title='"+g_uctext.move_column+"' class=\"uc-col-icon uc-grid-icon-move uc-col-icon-move uc-tip\"><i class=\"fa fa-arrows\" aria-hidden=\"true\"></i></a> ";
		
		html += "			<a href='javascript:void(0)' data-action='settings' data-actiontype='col' title='"+g_uctext.column_settings+"' class=\"uc-col-icon uc-grid-action-icon uc-tip\"><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></a> ";
		
		html += "			<a href='javascript:void(0)' data-action='duplicate' data-actiontype='col' title='"+g_uctext.duplicate_column+"' class=\"uc-col-icon uc-grid-action-icon uc-tip\"><i class=\"fa fa-clone\" aria-hidden=\"true\"></i></a> ";
		html += "			<a href='javascript:void(0)' data-action='delete' data-actiontype='col' title='"+g_uctext.delete_column+"' class=\"uc-col-icon uc-grid-action-icon uc-tip\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a> ";
		html += "		</div>";
		
		html += "		<a href='javascript:void(0)' onfocus='this.blur()' data-action='add_col_addon' data-actiontype='col' title='"+g_uctext.add_addon_to_column+"' class=\"uc-col-icon uc-grid-action-icon uc-tip uc-icon-add-more-addon\" style='display:none'><span class='uc-btn uc-btn-round uc-btn-major'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></span></a> ";
				
		html += "		<div class=\"uc-grid-col-addons\">";
		
		//set addon
		html += "			<div class=\"uc-grid-col-addon uc-grid-overlay-empty uc-grid-action-icon\" data-actiontype='col' data-action='add_col_addon' >";
		html += "				<div class=\"uc-grid-col-addon-html\">";
		html +=	"					<div class=\"uc-overlay-empty-content\">";
		html += "						<span class='uc-overlay-empty-button uc-btn uc-btn-round uc-btn-muted'>";
		html += "							<span class='fa fa-plus'></span>";
		html += "						</span>";
		html += "						<i class='uc-overlay-empty-loader fa fa-spinner'></i>";
		html +=	"         </div>";
		html +=	"				</div>";
		html +=	"				<div class=\"uc-grid-overlay-edit\" style=\"display: none;\"></div>"; 
		html += "			</div>";
		
		html += "		</div>";	//col addons
				
		
		html += "	</div>";	//box wrapper end
        //add columns buttons
		html += "</div>";	//col;
		
		return(html);
	}
	
	
	/**
	 * get num columns in row
	 */
	function getCols(objRow, novalidate){
		
		var objContainer = getRowContainer(objRow);
		
		var objCols = objContainer.children(".uc-grid-col");
		
		if(objCols.length == 0 && !novalidate)
			throw new Error("getCols error - row should have at least 1 column");
		
		return(objCols);
	}
	
	
	/**
	 * get column by number
	 */
	function getCol(objRow, numCol){
		
		var objCols = getCols(objRow);
		if(numCol >= objCols.length)
			throw new Error("There is no col number: "+numCol+" in the row");
		
		var objCol = jQuery(objCols[numCol]);
		
		return(objCol);
	}
	
	
	
	/**
	 * get parent column
	 */
	function getParentCol(objChild){
		
		var objCol = objChild.parents(".uc-grid-col");
		
		return(objCol);
	}
	
	
	/**
	 * get number of columns in row
	 */
	function getNumCols(objRow){
		
		validateRow(objRow);
		
		var objCols = getCols(objRow, true);
		
		var numCols = objCols.length;
		
		return(numCols);
	}
	
	/**
	 * get addons wrapper
	 */
	function getColAddonsWrapper(objCol){
		
		var objAddonsWrapper = objCol.find(".uc-grid-col-addons");
		
		g_ucAdmin.validateDomElement(objAddonsWrapper, "col addons wrapper");
		
		return(objAddonsWrapper);
	}
	
		
	
	/**
	 * check if it's first column
	 */
	function isFirstCol(objCol){
		var isFirst = objCol.hasClass("uc-col-first");
		
		return isFirst;
	}
	
	
	/**
	 * check if it's last column
	 */
	function isLastCol(objCol){
		var isLast = objCol.hasClass("uc-col-last");
		
		return isLast;
	}
	
	
	/**
	 * add empty column
	 * the mode can be: empty, before, after
	 */
	function addColumn(objRow, objCol, mode){
		
		if(!objRow){
			if(objCol)
				var objRow = getParentRow(objCol);
			else
				var objRow = getRow();
		}
				
		//check the limits
		var numCols = getNumCols(objRow);
				
		if(numCols == g_vars.max_cols)
			return(false);
				
		//add the column
		var htmlCol = getHtmlColumn();
		
		var objNewCol = jQuery(htmlCol);
		
		//insert before or after column
		objNewCol.hide();
		
		if(objCol){
			
			switch(mode){
				case "before":
					objNewCol.insertBefore(objCol);
				break;
				case "after":
					objNewCol.insertAfter(objCol);
				break;
				default:
				break;
			}
			
			
		}else{	//insert last column
			
			var objContainer = getRowContainer(objRow);
			
			objContainer.append(objNewCol);
			
		}
		
		triggerEvent(t.events.ROW_COLUMNS_UPDATED, objRow);
		triggerEvent(t.events.COL_ADDED, objNewCol);
		
		//show the column after transition
		setTimeout(function(){
			objNewCol.show();
		},350);
		
		return(objNewCol);
	}
	
	
	/**
	 * duplicate column
	 */
	function duplicateCol(objCol){
		
		var objRow = getParentRow(objCol);
        //check the limits
		var numCols = getNumCols(objRow);
		
		if(numCols == g_vars.max_cols)
			return(false);
		
		var objColCopy = objCol.clone(true, true);
        objColCopy.hide();
		
        g_vars.serial++;
		var colID = g_gridID+"_col_"+g_vars.serial;
		
		objColCopy.attr("id", colID);
		
		triggerEvent(t.events.COL_DUPLICATED, objColCopy);
		
		objColCopy.insertAfter(objCol);
        objRow.addClass('duplicating');
		
		triggerEvent(t.events.ROW_COLUMNS_UPDATED, objRow);
		triggerEvent(t.events.COL_ADDED, objColCopy);
		
		//show the column after transition
		setTimeout(function(){
			objColCopy.show();
            objRow.removeClass('duplicating');
		},450);    
	}
	
	
	/**
	 * 
	 * @param objCol
	 */
	function deleteCol(objCol){
		
		var objRow = getParentRow(objCol);
		var numCols = getNumCols(objRow);
		var colID = objCol.prop("id");
		
		if(numCols <= 1){
			
			deleteRow(objRow);
			return(false);
		}
		
		objCol.remove();
		
		triggerEvent(t.events.ROW_COLUMNS_UPDATED, objRow);
		triggerEvent(t.events.ELEMENT_REMOVED, colID);
	}
	
	
	
	/**
	 * do column action
	 */
	function doColAction(objCol, action){
		
		switch(action){
			case "delete":
				
				deleteCol(objCol);
				
			break;
			case "duplicate":
				
				duplicateCol(objCol);
			
			break;
			case "addcol_before":
				
				addColumn(null, objCol, "before");
			
			break;
			case "addcol_after":
			
				addColumn(null, objCol, "after");
				
			break;
			case "add_col_addon":
				openAddonsBrowser(objCol, true);				
			break;
			case "settings":
				openColSettingsPanel(objCol);				
			break;
			default:
				trace("wrong col action: "+action);
			break;
		}
		
	}
	
	
	/**
	 * update row columns classes
	 */
	function updateColsClasses(objRow){
				
		var objCols = getCols(objRow);
		
		var numCols = objCols.length;
		
		var colWidth = 1;	//temp value, num cells that it take
		
		var classColSize = g_vars.class_size_prefix + colWidth+ "_" + numCols;
		
		objCols.each(function(num, col){
			
			var isFirst = (num == 0);
			var isLast = (num == numCols-1);
			
			var objCol = jQuery(col);
			var isEmpty = objCol.hasClass(g_vars.class_empty);
			
			//set class
			var classCol = g_vars.class_col;

			if(isFirst)
				classCol += " "+g_vars.class_first_col;
			
			if(isLast)
				classCol += " "+g_vars.class_last_col;
			
			if(isEmpty)
				classCol += " "+g_vars.class_empty;
			
			classCol += " " + classColSize;
			
			classCol += " uc-col-trans";
			
			col.className = classCol;
			
		});
		
	}
	
	
	/**
	 * set the add col icon active / not active
	 */
	function activateAddColIcon(objIcon, isActivate){
		
		if(isActivate){
			objIcon.addClass("uc-icon-active");
		}
		else{
			objIcon.removeClass("uc-icon-active");
		}
		
	}
	
	
	/**
	 * check row related buttons after the row is changed
	 */
	function updateColOperationButtons(objRow){
	
		var numCols = getNumCols(objRow);
		
		var objCols = getCols(objRow);

		var isHideAll = false;
		if(numCols >= g_vars.max_cols)
			isHideAll = true;
			
		jQuery.each(objCols, function(key, col){
			
			var objCol = jQuery(col);
			
			var showLeftIcon = false;
			var showRightIcon = true;
			
			if(isHideAll == true){
				showRightIcon = false;
			}else
			  if(isFirstCol(objCol) == true)
				showLeftIcon = true;
			
			//show the buttons
			var objLeftIcon = objCol.find(".uc-icon-addcol.uc-addcol-before");
			var objRightIcon = objCol.find(".uc-icon-addcol.uc-addcol-after");
			
			
			activateAddColIcon(objLeftIcon, showLeftIcon);
			activateAddColIcon(objRightIcon, showRightIcon);
			
		});
		
	}
	
	/**
	 * set col empty state visual
	 */
	function setColEmptyStateVisual(objCol, isEmpty){
		
		var objOverlayEmpty = objCol.find(".uc-grid-overlay-empty");
		var objIconAddMore =  objCol.find(".uc-icon-add-more-addon");
		
		if(isEmpty == true){
			objOverlayEmpty.show();
			objIconAddMore.hide();			//empty column
		}else{
			objOverlayEmpty.hide();			//has addons
			objIconAddMore.show();
		}
		
	}
	
	
	/**
	 * set column empty state loading
	 */
	function setColEmptyStateLoading(objCol, isLoading){
				
		validateCol(objCol);
		
		var objOverlayEmptyContent = objCol.find(".uc-grid-overlay-empty .uc-overlay-empty-content");
		
		if(isLoading == true)
			objOverlayEmptyContent.addClass("uc-state-loading");
		else
			objOverlayEmptyContent.removeClass("uc-state-loading");
		
	}
	
	
	/**
	 * set row hover second mode
	 */
	function setColHoverSecondMode(event, objCol){
		
		if(!objCol)
			var objCol = jQuery(this);
		
		if(objCol.hasClass("uc-grid-col") == false)
			objCol = getParentCol(objCol);
		
		objCol.addClass("uc-over-mode2");
		
	}
    
	
	/**
	 * unset row hover second mode
	 */
	function unsetColHoverSecondMode(event, objCol){
		
		if(!objCol)
			var objCol = jQuery(this);
		
		if(objCol.hasClass("uc-grid-col") == false)
			objCol = getParentCol(objCol);
		
		objCol.removeClass("uc-over-mode2");
	}
	
	
	/**
	 * get column size from the column
	 */
	function getColSize(objCol){
		
		validateCol(objCol);
		
		var arrClasses = objCol[0].className.match(/\buc-colsize\S+/ig);
		
		if(arrClasses.length == 0)
			return(null);
		
		var className = arrClasses[0];
		var size = className.replace("uc-colsize-", "");
		
		return(size);
	}
	
	

	/**
	 * update row  layout columns classes
     */
	function setColSize(objCol, size){
		
		validateCol(objCol);
		
		var className = objCol[0].className;
		
        objCol[0].className = className.replace(/\buc-colsize\S+/ig,"uc-colsize-" + size);
        
	}
	
	function ______COLUMN_SETTINGS_______(){}
	
	
	/**
	 * set column settings placeholders
	 */
	function setColumnPlaceholders(objCol){
		
		var objRow = getParentRow(objCol);
		var filter = ["space_between_addons", "col_gutter"];
		var rowSettings = getRowSettings(objRow, true, filter);
		
		var objPlaceholders = {};
		objPlaceholders["col_space_between_addons"] = g_ucAdmin.getVal(rowSettings, "space_between_addons");
		
		var colPaddingSides = g_ucAdmin.getVal(rowSettings, "col_gutter");
		objPlaceholders["padding_left"] = colPaddingSides;
		objPlaceholders["padding_right"] = colPaddingSides;
		
		g_panel.updatePlaceholders("col-settings", objPlaceholders);
	}
	
	
	/**
	 * open col settings panel
	 */
	function openColSettingsPanel(objCol){
		validateCol(objCol);
		var colID = objCol.prop("id");
		var colSettings = getColSettings(objCol);
				
		//set column placeholders
		setColumnPlaceholders(objCol);
		
		g_panel.toggle("col-settings", colSettings, colID);
	}
	
	
	/**
	 * update object visual
	 */
	function updateElementVisual(objElement, objCss, objSettings, prefix){
				
		objCss = g_ucAdmin.addCssSetting(objSettings, objCss, "padding_top", "padding-top","px");
		objCss = g_ucAdmin.addCssSetting(objSettings, objCss, "padding_bottom", "padding-bottom","px");
		objCss = g_ucAdmin.addCssSetting(objSettings, objCss, "padding_left", "padding-left","px");
		objCss = g_ucAdmin.addCssSetting(objSettings, objCss, "padding_right", "padding-right","px");
		objCss = g_ucAdmin.addCssSetting(objSettings, objCss, "text_align", "text-align");
		
		
		var cssBG = getBackgroundCss(objSettings);
		if(cssBG)
			jQuery.extend(objCss, cssBG);

		//remove style
		objElement.removeAttr("style");
		
		//add css
		var strAddCss = g_ucAdmin.getVal(objSettings, prefix+"_css", null);
		if(strAddCss){
			strAddCss = g_ucAdmin.removeLineBreaks(strAddCss);
			objElement.prop("style", strAddCss);
		}
		
		
		objElement.css(objCss);
	}
	
	
	/**
	 * update column visual
	 */
	function updateColVisual(objCol, objSettings){
		
		if(!objSettings)
			var objSettings = objCol.data("settings");
		
		var cssCol = {};
		updateElementVisual(objCol, cssCol, objSettings, "col");
		
		var strCss = "";
		
		//--- column addons elements
		
		var addonBoxStyle = "";
		
		var colID = objCol.prop("id");
		var objRow = getParentRow(objCol);
		var rowID = objRow.prop("id");
		
		var spaceBetweenAddons = g_ucAdmin.getVal(objSettings, "col_space_between_addons", null);
		if(spaceBetweenAddons){
			spaceBetweenAddons = g_ucAdmin.normalizeSizeValue(spaceBetweenAddons);
			addonBoxStyle += "margin-top:" + spaceBetweenAddons+";";
			
			var addonsSelector = g_gridID+" .uc-grid-row#"+rowID+" .uc-grid-col#"+colID+" .uc-grid-col-addon + .uc-grid-col-addon";
			strCss += addonsSelector+"{"+addonBoxStyle+"}";
		}
		
		g_ucAdmin.printCssStyle(strCss, colID, g_objColStyleContainer);
				
	}
	
	
	/**
	 * update column settings
	 */
	function updateColSettings(objCol, settings){
		
		validateCol(objCol);
		
		objCol.data("settings", settings);
		
		updateColVisual(objCol, settings);
	}
	
	
	/**
	 * apply column settings
	 */
	function applyColSettings(){
		
		var data = g_panel.getPaneData("col-settings");
		var colID = data.objectID;
		var objCol = jQuery("#"+colID);
		
		if(objCol.length == 0)
			return(false);
				
		updateColSettings(objCol, data.settings);
	}
	
	
	function ____________ADDON_HTML______________(){}
	
	
	/**
	 * get the html
	 */
	function generateAddonHtml_wrapAddonHtml(addon_name, htmlAddon, addonData, onlyInner){
		
		if(!onlyInner)
			var onlyInner = false;
		
		var classAdd = "";
		
		var serialID = addonData.extra.serial_id;
		var addonID = g_vars.id_prefix + serialID;
		
		var html = "";
		
		if(onlyInner == false)
			html += "		<div id='"+addonID+"' class=\"uc-grid-col-addon\" data-name='"+addon_name+"'>";
		
		html += "			<div class=\"uc-grid-col-addon-html unite-clearfix "+classAdd+"\" >";
		
		html += htmlAddon;
		
		html += "			</div>";
		
		html += "			<div class=\"uc-grid-addon-hover uc-hover-left\" ></div>";
		html += "			<div class=\"uc-grid-addon-hover uc-hover-right\" ></div>";
		html += "			<div class=\"uc-grid-addon-hover uc-hover-top\" ></div>";
		html += "			<div class=\"uc-grid-addon-hover uc-hover-bottom\" ></div>";
		
		html += "			<div class='uc-grid-addon-panel'>";
		html += "					<a href=\"javascript:void(0)\" data-actiontype='addon' data-action='edit_addon' title=\""+g_uctext.edit_addon+"\" class=\"uc-grid-action-icon \"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></a>";
		html += "					<a href=\"javascript:void(0)\" data-actiontype='addon' data-action='addon_container_settings' title=\""+g_uctext.addon_container_settings+"\" class=\"uc-grid-action-icon \"><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></a>";
		html += "					<a href=\"javascript:void(0)\" data-actiontype='addon' data-action='delete_addon' title=\""+g_uctext.delete_addon+"\" class=\"uc-grid-action-icon \"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";
		html += "					<a href=\"javascript:void(0)\" data-actiontype='addon' data-action='duplicate_addon' title=\""+g_uctext.duplicate_addon+"\" class=\"uc-grid-action-icon \"><i class=\"fa fa-clone\" aria-hidden=\"true\"></i></a>";
		html += "					<a href='javascript:void(0)' title='"+g_uctext.move_addon+"' class=\"uc-addon-icon-move uc-grid-icon-move uc-tip\"><i class=\"fa fa-arrows\" aria-hidden=\"true\"></i></a> ";
		html += "			</div>";
		
		if(onlyInner == false)
			html += "		</div>";
		
		return(html);
	}
	
	
	/**
	 * get box html desciprion, by values and admin labels
	 */
	function getBoxHtmlDescription(addonData){
		
		var extra = g_ucAdmin.getVal(addonData, "extra");
		
		var adminLabels = g_ucAdmin.getVal(extra, "admin_labels");
		var config = g_ucAdmin.getVal(addonData, "config");
		var items = g_ucAdmin.getVal(addonData, "items");
		
		if(!adminLabels || adminLabels.length == 0)
			return("");
		
		//combine description
		
		var desc = "";
				
		jQuery.each(adminLabels, function(index, arrLabel){
			
			var value = "";
			
			var key = arrLabel[0];
			var title = arrLabel[1];
			
			//take number of items
			if(key == "uc_num_items"){
				var numItems = 0;
				if(typeof items == "object")
					numItems = items.length;
				
				desc = numItems+ " "+title;
				return(true);
			}
			
			//get from config
				
			value = g_ucAdmin.getVal(config, key);
			
			//check for value2 (select field alternative)
			var value2 = g_ucAdmin.getVal(config, key+"_unite_selected_text");
			if(value2)
				value = value2;
			
			else{	//check for post field
				
				var value2 = g_ucAdmin.getVal(config, key+"_post_title");
				if(value2)
					value = value2;
			}
			
			
			value = jQuery.trim(value);
			value = g_ucAdmin.stripTags(value, "b,strong,i");
			
			if(!value || value == "")
				return(true);
			
			if(desc)
				desc += " | ";
			
			desc += title + ": " + value;
			
		});
				
		return(desc);
	}
	
	
	/**
	 * get box view html
	 */
	function generateAddonHtml_getBoxHtml(url_icon, title, addonData){
		
		url_icon = 	g_ucAdmin.escapeDoubleQuote(url_icon);
		title = g_ucAdmin.htmlspecialchars(title);
		
		var description = getBoxHtmlDescription(addonData);
		
		//title = addonData.extra.serial_id;	//remove me
		
		html = "";
		html += "				<img src=\""+url_icon+"\">";
		html += "				<span class='uc-grid-addon-title'>"+title+"</span>";
		
		if(description)
			html += "				<span class='uc-grid-addon-description'>"+description+"</span>";
		
		return(html);
	}
	
		
	/**
	 * put addon includes
	 */
	function putAddonLiveModeIncludes(addonData, objIncludes, funcOnLoaded){
		
		var isLoadOneByOne = true;
		
		var serialID = addonData.extra.serial_id;
		var handlePrefix = "uc_include_";
		
		g_ucAdmin.validateNotEmpty(serialID, "serial ID");
		
		//make a list of js handles
		var arrHandles = {};
		jQuery.each(objIncludes, function(event, objInclude){
			
			var handle = handlePrefix + objInclude.type + "_" + objInclude.handle;
			
			if( !(objInclude.type == "js" && objInclude.handle == "jquery") )
				arrHandles[handle] = objInclude;
		});
				
		var isAllFilesLoaded = false;
		
		//inner function that check that all files loaded by handle
		function checkAllFilesLoaded(){
			
			if(isAllFilesLoaded == true)
				return(false);
			
			if(!jQuery.isEmptyObject(arrHandles))
				return(false);
			
			isAllFilesLoaded = true;
			
			if(!funcOnLoaded)
				return(false);
			
			funcOnLoaded();
			
		}
		
		
		/**
		 * on js file loaded - load first js file, from available handles
		 * in case that loading one by one
		 */
		function onJsFileLoaded(){
			
			for(var index in arrHandles){
				var objInclude = arrHandles[index];
				
				if(objInclude.type == "js"){
					loadIncludeFile(objInclude);
					return(false);
				}
				
			}
			
		}
		
		
		/**
		 * load include file
		 */
		function loadIncludeFile(objInclude){
			
			var url = objInclude.url;
			var handle = handlePrefix + objInclude.type + "_" + objInclude.handle;
			var type = objInclude.type;
			
			//skip jquery for now
			if(objInclude.handle == "jquery"){
				
				checkAllFilesLoaded();
				
				if(isLoadOneByOne)
					onJsFileLoaded();
				
				return(true);
			}
			
			var data = {
					replaceID:handle,
					name: "uc_include_file"
			};
			
			//onload throw event when all scripts loaded
			data.onload = function(obj, handle){
								
				var objDomInclude = jQuery(obj);
						
				objDomInclude.data("isloaded", true);
								
				//delete the handle from the list, and check for all files loaded
				if(arrHandles.hasOwnProperty(handle) == true){
										
					delete arrHandles[handle];
					
					checkAllFilesLoaded();
					
				}//end checking
				
				if(isLoadOneByOne){
					var tagName = objDomInclude.prop("tagName").toLowerCase();
					if(tagName == "script")
						onJsFileLoaded();
				}
				
			};
			
			
			//if file not included - include it
			var objDomInclude = jQuery("#"+handle);
			
			if(objDomInclude.length == 0){
				
				objDomInclude = g_ucAdmin.loadIncludeFile(type, url, data);
			}
			else{
				
				//if the files is in the loading list but still not loaded, 
				//wait until they will be loaded and then check for firing the finish event (addons with same files)
				
				//check if the file is loaded
				var isLoaded = objDomInclude.data("isloaded");
				if(isLoaded == true){
					
					//if it's already included - remove from handle
					if(arrHandles.hasOwnProperty(handle) == true)
						delete arrHandles[handle];
					
					if(isLoadOneByOne){
						var tagName = objDomInclude.prop("tagName").toLowerCase();
						if(tagName == "script")
							onJsFileLoaded();
					}
					
					
				}else{
					
					var timeoutHandle = setInterval(function(){
						var isLoaded = objDomInclude.data("isloaded");
						
						if(isLoaded == true){
							clearInterval(timeoutHandle);
							
							if(arrHandles.hasOwnProperty(handle) == true)
								delete arrHandles[handle];
							
							checkAllFilesLoaded();
							
							if(isLoadOneByOne){
								var tagName = objDomInclude.prop("tagName").toLowerCase();
								if(tagName == "script")
									onJsFileLoaded();
							}
							
						}
						
					},100);
										
				}
								
			}			
			
			
			//add addon serialID to the include
			var arrSerials = objDomInclude.data("serials");
			
			if(!arrSerials)
				arrSerials = {};
			
			if(arrSerials.hasOwnProperty(serialID) == false)
				arrSerials[serialID] = true;
			
			
			objDomInclude.data("serials", arrSerials);
			
		}
		
		if(isLoadOneByOne == false){
			
			jQuery.each(objIncludes, function(event, objInclude){
				loadIncludeFile(objInclude);
			});
			
		}else{
			
			//load css files and first js files
			var isFirstJS = true;
			
			jQuery.each(objIncludes, function(event, objInclude){
				if(objInclude.type == "css")
					loadIncludeFile(objInclude);
				else{		//js file, load first only
					
					if(isFirstJS == true){
						loadIncludeFile(objInclude);
						isFirstJS = false;
					}
					
				}
			});
			
			
		}
		
		
		//check if all files loaded
		checkAllFilesLoaded();
		
	}
	
	
	/**
	 * check and remove addon includes if needed
	 * this function called on addon delete
	 */
	function checkRemoveLiveModeIncludes(){
		
		var objIncludes = jQuery("script[name='uc_include_file']").add("link[name='uc_include_file']");
				
		//check if there is addon serial in include.
		//if do - remove it, if no more serials - delete the include
		
		jQuery.each(objIncludes, function(event, objInclude){
			
			objInclude = jQuery(objInclude);
			var arrSerials = objInclude.data("serials");
			
			jQuery.each(arrSerials, function(serial, value){
				
				//search addon by id
				var addonID = g_vars.id_prefix + serial;
				var objAddon = jQuery("#"+addonID);
				if(objAddon.length == 0)
					delete arrSerials[serial];					
			});
			
			if(jQuery.isEmptyObject(arrSerials)){
				
				objInclude.remove();
				
			}else{	//insert serials data bacl
				objInclude.data("serials", arrSerials);
			}
			
		});
		
	}
	
	
	/**
	 * modify addon html, replace the id's to unique
	 * the html is get from server
	 */
	function modifyAddonLiveHtml(html, addonData, outputData){
		
		var resultID = addonData.extra.serial_contentid;
		var sourceID = outputData.constants.uc_id;
		
		html = g_ucAdmin.replaceAll(html, sourceID, resultID);
		
		return(html);
	}
	
		
	
	/**
	 * handle output data when generate html
	 */
	function generateAddonHtml_handleAddonOutputData(outputData, addonData, onFinish, onlyInner){
		
		var addon_name = addonData.name;
		
		var htmlLive = g_ucAdmin.getVal(outputData, "html");
		
		htmlLive = modifyAddonLiveHtml(htmlLive, addonData, outputData);
		
		var objIncludes = g_ucAdmin.getVal(outputData, "includes");
		var objConstants = g_ucAdmin.getVal(outputData, "constants");
		
		//replace constants in html		
		var htmlColAddon = generateAddonHtml_wrapAddonHtml(addon_name, htmlLive, addonData, onlyInner);
		
		//put includes, on all scripts loaded put html
		putAddonLiveModeIncludes(addonData, objIncludes, function(){
			
			//put html
			onFinish(htmlColAddon);
		});
		
	}
	
	
	/**
	 * generate addon html
	 * after finish, call a function
	 */
	function generateAddonHtml(addonData, onFinish, onlyInner){
		
		var title = addonData.extra.title;
		var url_icon = addonData.extra.url_icon;
		var addon_name = addonData.name;
		
		if(onFinish && typeof onFinish != "function")
			throw new Error("The second param should be a function");
		
		
		//box view
		if(g_temp.is_live_view == false){
			
			var htmlBox = generateAddonHtml_getBoxHtml(url_icon, title, addonData);
			var htmlColAddon = generateAddonHtml_wrapAddonHtml(addon_name, htmlBox, addonData, onlyInner);
			
			if(onFinish)
				onFinish(htmlColAddon);
			else
				return(htmlColAddon);
			
		}else{	//live view
			
			if(typeof onFinish != "function")
				throw new Error("The second param should be a function");
			
			//do without ajax
			var output = g_ucAdmin.getVal(addonData, "output");
			
			if(output){	
				generateAddonHtml_handleAddonOutputData(output, addonData, onFinish, onlyInner);
			}
			else{	//call ajax
				g_ucAdmin.ajaxRequest("get_addon_output_data", addonData, function(response){
					
					//save output data
					addonData["output"] = response;
					generateAddonHtml_handleAddonOutputData(response, addonData, onFinish, onlyInner);
					
				});
			}
			
		}
		
	}
	
	
	/**
	 * set duplicated addon html, before insert it into dome
	 */
	function setDuplicatedAddonHtml(objAddon, addonData){
		
		delete addonData["output"];
		
		var addonID = g_vars.id_prefix + addonData.extra.serial_id;
		objAddon.attr("id", addonID);
		
		if(g_temp.is_live_view == false){		//box view
			
			var newHTML = generateAddonHtml(addonData, null, true);
			objAddon.html(newHTML);
			
		}else{
			
			var newHTML = generateAddonHtml(addonData, function(newHTML){
								
				objAddon.html(newHTML);
			}, true);
			
		}
		
		
	}
	
	
	function ____________COL_ADDON_ELEMENT______________(){}
	
	/**
	 * validate that the column element is col addon type
	 */
	function validateColAddonElement(objElement){
		
		//validate type
		var type = getElementType(objElement);
		if(type != "addon")
			throw new Error("The element must be addons type");
		
		//validate single
		if(objElement.length > 1){
			trace(objElement);
			throw new Error("The addon element should be sinlge");
		}
		
	}
	
	
	
	/**
	 * get col addons data
	 */
	function getColAddons(objCol){
		
		validateCol(objCol);
		
		var objAddonsWrapper = getColAddonsWrapper(objCol);
				
		var objAddons = getElementAddons(objAddonsWrapper);
		
		return(objAddons);
	}
	
		
	
	/**
	 * get number of col addons
	 */
	function getNumColAddons(objCol){
		
		validateCol(objCol);
		
		var objAddons = getColAddons(objCol);
		var numAddons = objAddons.length;
		
		return(numAddons);
	}
	
	
	
	
	/**
	 * get parent row
	 */
	function getParentAddonElement(objChild){
		
		var objAddon = objChild.parents(".uc-grid-col-addon");
		
		g_ucAdmin.validateDomElement(objAddon, "addon holder");
		
		return(objAddon);
	}
	
	
	/**
	 * show/hide move icon when number addons = 1,columns = 1,rows = 1
	 */
	function isSingleAddonInGrid(objAddon){
	        
			var objCol = getParentCol(objAddon);
			
			var numRows = getNumRows();
			
			if(numRows>1)
				return(false);
			
			var objRow = getParentRow(objCol);
			
			var numColums = getNumCols(objRow);
			
			if(numColums >1)
				return(false);
			
			var numAddons = getNumColAddons(objCol);
			
			if(numAddons > 1)
				return(false);
			
			return(true);
	}
	
	
	/**
	 * delete column addon
	 */
	function deleteColAddon(objAddon){
		
		validateColAddonElement(objAddon);
		
		var addonID = objAddon.prop("id");
		
		var objCol = getParentCol(objAddon);
		
		objAddon.remove();
		
		var numAddons = getNumColAddons(objCol);
		
		triggerEvent(t.events.COL_ADDONS_UPDATED, objCol);
		triggerEvent(t.events.ELEMENT_REMOVED, addonID);
	}
	
	
	/**
	 * duplicate col addon
	 */
	function duplicateColAddon(objAddon){
		
		validateColAddonElement(objAddon);
		
		var objAddonCopy = objAddon.clone(true, true);
		
		triggerEvent(t.events.ADDON_DUPLICATED, objAddonCopy);
				
		//hide overlay
		//showAddonOverlay(objAddonCopy, false);
		
		//insert new addon
		objAddonCopy.insertAfter(objAddon);
		
		var objCol = getParentCol(objAddon);
		triggerEvent(t.events.COL_ADDONS_UPDATED, objCol);
	}
	
		
	
	/**
	 * do addon element related action
	 */
	function doAddonAction(objAddon, action){
		
		validateColAddonElement(objAddon);
		
		switch(action){
			case "edit_addon":
				openAddonsBrowser(objAddon);
			break;
			case "addon_container_settings":
				openAddonContainerSettingsPanel(objAddon);
			break;
			case "delete_addon":
				deleteColAddon(objAddon);
			break;
			case "duplicate_addon":
				duplicateColAddon(objAddon);
			break;
			default:
				throw new Error("Wrong addon action: "+action);
			break;
		}
		
	}

	function ____________ADDONS_SETTINGS______________(){}
	
	
	/**
	 * update addon container visual
	 */
	function updateAddonContainerVisual(objAddon, objSettings){
		
		if(!objSettings)
			var objSettings = objAddon.data("addon_settings");
		
		var cssAddon = {};
		updateElementVisual(objAddon, cssAddon, objSettings, "addon");
	}
	
	
	/**
	 * update addon container settings
	 */
	function updateAddonContainerSettings(objAddon, settings){
		
		validateColAddonElement(objAddon);
		
		objAddon.data("addon_settings", settings);
		
		updateAddonContainerVisual(objAddon, settings);
	}
	
	
	/**
	 * apply column settings
	 */
	function applyAddonContainerSettings(){
		
		var data = g_panel.getPaneData("addon-container-settings");
		
		var addonID = data.objectID;
		var objAddon = jQuery("#"+addonID);
		
		if(objAddon.length == 0)
			return(false);
		
		updateAddonContainerSettings(objAddon, data.settings);
		
	}
	
	
	/**
	 * open addon container settings
	 */
	function openAddonContainerSettingsPanel(objAddon){
		
		var addonID = objAddon.prop("id");
		
		var addonContainerSettings = objAddon.data("addon_settings");
		
		g_panel.toggle("addon-container-settings", addonContainerSettings, addonID);
	}
	
	
	/**
	 * apply addon settings
	 */
	function applyAddonSettings(params){
		
		var isInstant = params["is_instant"];
		var addonID = params["object_id"];
		var objAddon = jQuery("#"+addonID);
		if(objAddon.length == 0)
			return(false);
		
		//try instant update
		
		if(isInstant == true){
			return(false);
		}
		
		var data = g_panel.getPaneData("addon-settings");
		
		var settings = data.settings;
		
		var addonDataNew = g_objAddonConfig.getAddonDataFromSettingsValues(settings);
		
		var addonData = getColAddonData(objAddon);
		
		addonData = g_objAddonConfig.setNewAddonData(addonData, addonDataNew);
				
		saveAddonElementData(objAddon, addonData);
		
		redrawAddon(objAddon);
		
	}
	
	
	/**
	 * open addon settings panel from addon object
	 * the command will send command to later
	 */
	function openAddonSettingsPanel(objAddon, command){
		
		validateColAddonElement(objAddon);
				
		var addonData = getColAddonData(objAddon);
		
		var title = g_objAddonConfig.getAddonTitle(addonData);
		title = g_uctext["edit_addon"] + ": "+title;
		
		var sendData = g_objAddonConfig.getSendDataFromAddonData(addonData);
		
		var addonID = objAddon.prop("id");
		
		var data = {};
		if(command)
			data.command = command;
		
		var panelData = g_objAddonConfig.getPanelData(addonData);
		if(panelData)
			jQuery.extend(data, panelData);
				
		g_panel.toggle("addon-settings", sendData, addonID, title, data);
	}
	
	
	function ____________ADDONS______________(){}
	
	
	/**
	 * get col addon data
	 */
	function getColAddonData(objAddon, funcModify){
		
		validateColAddonElement(objAddon);
		
		var objData = objAddon.data("addon_data");
		
		var options = objAddon.data("addon_settings");
		if(options){
			if(!objData)
				objData = {};
			
			objData.options = options;
		}
		
		//set options
		if(!objData)
			objData = null;
		
		if(funcModify && typeof funcModify == "function"){
			var returnData = funcModify(objData);
			return(returnData);
		}
				
		return(objData);
	}
	
	
	/**
	 * get col addons data
	 */
	function getColAddonsData(objCol, funcModify){
		
		var objAddons = getColAddons(objCol);
		
		var arrData = [];
		
		jQuery.each(objAddons, function(index, addon){
			var objAddon = jQuery(addon);
			var objData = getColAddonData(objAddon, funcModify);
			
			arrData.push(objData);
		});
		
		return(arrData);
	}
	
	
	/**
	 * generate serial ID from data and serial
	 */
	function generateAddonSerialID(addonData){
		
		var name = addonData.name;
		g_vars.serial++;
		
		var serialID = name+"_"+g_vars.serial;
		
		return(serialID);
	}

	
	/**
	 * modify addon data before adding addon
	 */
	function modifyAddonDataBeforeAdd(addonData){
		
		var extra = g_ucAdmin.getVal(addonData,"extra",{});
		if(!extra)
			extra = {};
		
		extra["serial_id"] = generateAddonSerialID(addonData);
		extra["serial_contentid"] = g_vars.addon_conetentid_prefix + "_"+addonData.name + "_" + g_vars.serial;
		
		addonData.extra = extra;
		
		return(addonData);
	}
	
	
	/**
	 * modify addon data before save
	 * remove everything except the real data
	 */
	function modifyAddonDataBeforeSave(addonData){
		
		if(!addonData)
			return(null);
		
		var arrDeleteFields = ["output","extra"];
		
		var addonDataOutput = {};
		
		jQuery.each(addonData,function(key,value){
			
			if(arrDeleteFields.indexOf(key) == -1)
				addonDataOutput[key] = addonData[key];
		});
				
		return(addonDataOutput);
	}	
	
	
	/**
	 * save addon element data
	 */
	function saveAddonElementData(objAddon, addonData){
		
		validateColAddonElement(objAddon);
		
		var newAddonData = jQuery.extend({}, addonData);
		
		var addonName = newAddonData.name;
		
		objAddon.data("addon_name", addonName);
		objAddon.data("addon_data", newAddonData);
		
		var options = g_ucAdmin.getVal(addonData, "options");
		if(options)
			objAddon.data("addon_settings", options);
		
	}
	
	/**
	 * get addon error message html
	 */
	function getHtmlAddonError(message, addonData){
		
		var title = addonData.name;
		var extra = g_ucAdmin.getVal(addonData, "extra");
		var extraTitle = g_ucAdmin.getVal(extra, "title");
		if(extraTitle)
			title = extraTitle;
		
		
		var html = "<div class='uc-grid-addon-error'>";
		html += "Error in "+title+" addon: <br>";
		html += message;
		html += "</div>";
		
		return(html);
	}
	
	
	/**
	 * update column with addon data
	 */
	function addColAddon(objCol, addonData, isGridInit){
		
		if(jQuery.isArray(addonData))
			return(false);
		
		addonData = modifyAddonDataBeforeAdd(addonData);
		
		var objAddonsWrapper = getColAddonsWrapper(objCol);
		
		//save data
		generateAddonHtml(addonData, function(htmlAddon){
						
			var objHtml = jQuery(htmlAddon);
			
			saveAddonElementData(objHtml, addonData);
			
			var errorReturned = null;
			
			try{
				
				var objAddon = jQuery(objHtml);
				
				//set options if available
				
				objAddonsWrapper.append(objHtml);
				
				triggerEvent(t.events.ADDON_ADDED, {"addon":objAddon,"is_grid_init":isGridInit});
			
			}catch(error){
				
				var htmlErrorMessage = getHtmlAddonError(error, addonData);
				objHtml.append(htmlErrorMessage);
				
				trace("js error in "+addonData.name+" addon: "+error);
				
				errorReturned = "Javascript Error Occured: "+error;
			}
			
			triggerEvent(t.events.COL_ADDONS_UPDATED, objCol);
			
			if(errorReturned)
				throw errorReturned;
			
		});
		
	}
	
	
	/**
	 * redraw addon
	 */
	function redrawAddon(objAddon){
		
		validateColAddonElement(objAddon);
		
		//remove the output
		var addonData = getColAddonData(objAddon);
		addonData["output"] = null;
		saveAddonElementData(objAddon, addonData);
		
		//generate html
		generateAddonHtml(addonData, function(htmlAddon){
			
			objAddon.html(htmlAddon);
			
		}, true);
		
	}
	
	
	/**
	 * update obj addon with new one
	 */
	function updateColAddon(objAddon, addonData){
		
		g_ucAdmin.validateNotEmpty(addonData, "addon data");
		var addonID = objAddon.prop("id");
		
		validateColAddonElement(objAddon);
		
		addonData = modifyAddonDataBeforeAdd(addonData);
		
		//generate html
		generateAddonHtml(addonData, function(htmlAddon){
			
			var objAddonNew = jQuery(htmlAddon);
			
			objAddon.replaceWith(objAddonNew);
			
			saveAddonElementData(objAddonNew, addonData);
			
			//previous addon element removed
			triggerEvent(t.events.ELEMENT_REMOVED, addonID);
			
		});
		
	}
	
	
	/**
	 * open addon browser
	 */
	function openAddonsBrowser(objElement){
		
		var isNew = true;
		var addonData = null;
		
		var type = getElementType(objElement);
		
		if(type == "addon"){	//edit addon
			
			openAddonSettingsPanel(objElement);
			return(false);
		}
		
		
		g_objBrowser.openAddonsBrowser(addonData, function(newAddonData){
			
			setColEmptyStateLoading(objElement, true);
			
			newAddonData.return_output = g_temp.is_live_view;
				
			g_objAddonConfig.loadNewAddonData(newAddonData, function(addonData){
				
				setColEmptyStateLoading(objElement, false);
				
				addColAddon(objElement, addonData);
				
			});
			
		});
		
	}
	
	
	function ____________________GET_DATA________________(){}
	
	
	/**
	 * get columns data
	 */
	function getGridData_cols(objRow){
		
		var objCols = getCols(objRow);
		var dataCols = [];
		
		//create col data
		jQuery.each(objCols,function(colIndex, col){
			var objCol = jQuery(col);
			
			var dataCol = {};
			dataCol.addon_data = getColAddonsData(objCol, modifyAddonDataBeforeSave);
			
			var colSettings = objCol.data("settings");
			if(colSettings)
				dataCol.settings = colSettings;
			
			var size = getColSize(objCol);
			if(size)
				dataCol.size = size;
			
			dataCols.push(dataCol);
		});
		
		return(dataCols);
	}
	
	
	/**
	 * get row data
	 */
	function getGridData_row(objRow){
		var dataRow = {};
		dataRow.cols = getGridData_cols(objRow);
		
		var rowSettings = objRow.data("settings");
		if(rowSettings)
			dataRow.settings = rowSettings;
		
		return(dataRow);
	}
	
	
	/**
	 * get grid rows
	 */
	function getGridData_rows(){
		var dataRows = [];
		var objRows = getRows();
				
		jQuery.each(objRows, function(index, row){
			var objRow = jQuery(row);
			var dataRow = getGridData_row(objRow);
			
			dataRows.push(dataRow);
			
		});
		
		return(dataRows);
	}
	
	
	/**
	 * get grid data
	 */
	function getGridData(){
		var data = {};
		data.rows = getGridData_rows();
		
		if(g_optionsCustom)
			data.options = g_optionsCustom;
		
		
		return(data);
	}
	
	
	/**
	 * get grid data
	 */
	this.getGridData = function(){
		
		var objData = getGridData();
		
		return(objData);
	};
	
	
	function ____________GRID_SETTINGS______________(){}
	
	
	/**
	 * get grid option
	 */
	function getGridOption(name){
		
		var gridOptions = getCombinedOptions();
		
		var value = g_ucAdmin.getVal(gridOptions, name);
		
		return(value);
	}
	
	
	/**
	 * get combined options
	 */
	function getCombinedOptions(){
		
		if(!g_optionsCustom)
			g_optionsCustom = {};
				
		var objOptions = {};
		jQuery.extend(objOptions, g_options, g_optionsCustom);
		
		return(objOptions);
	}
	
	
	/**
	 * put css based on the options
	 */
	function putGeneratedCss(){
		var br = "\n";
		var tab = "	    ";
		var objOptions = getCombinedOptions();
				
		var css = "";
		
		g_ucAdmin.validateObjProperty(objOptions, ["col_gutter",
		                                           "row_padding_top",
		                                           "row_padding_bottom",
		                                           "row_container_width"
		              ],"grid options");
				
		//row css
		css += g_gridID+" .uc-grid-row{"+br;
			css += tab+"padding-top:"+objOptions.row_padding_top+"px;"+br;
			css += tab+"padding-bottom:"+objOptions.row_padding_bottom+"px;"+br;
		css += "}"+br+br;
		
		
		//row container css
		css += g_gridID+" .uc-grid-row .uc-grid-row-container{"+br;
		
		css += tab+"width:"+g_ucAdmin.normalizeSizeValue(objOptions.row_container_width)+";"+br;
		
		css += "}"+br+br;
				
		//column css
		css += g_gridID+" .uc-grid-row .uc-grid-col{"+br;
		
		//add gutter
		css += tab+"padding-left:"+objOptions.col_gutter+"px;"+br;
		css += tab+"padding-right:"+objOptions.col_gutter+"px;"+br;
		css += "}"+br;
		
		//column addons
		
		var spaceBetweenAddons = g_ucAdmin.getVal(objOptions, "space_between_addons", null);
		if(spaceBetweenAddons){
			spaceBetweenAddons = g_ucAdmin.normalizeSizeValue(spaceBetweenAddons);
			
			var addonsStyle = "margin-top:" + spaceBetweenAddons+";";
			
			var addonsSelector = g_gridID+" .uc-grid-row .uc-grid-col .uc-grid-col-addon + .uc-grid-col-addon";
			css += addonsSelector+"{"+addonsStyle+"}"+br;
		}
		
		
		g_objStyle.html(css);
	}
	
	/**
	 * update grid settings placeholders
	 */
	function updateSettingsPlaceholders(){
		
		var objOptions = getCombinedOptions();
		g_panel.updatePlaceholders("row-settings", objOptions);
		
	}
	
	
	/**
	 * update options from settings dialog
	 */
	function updateOptionsFromGridSettings(){
		
		var objValues = g_panel.getSettingsValues("grid-settings");
		
		//update custom options, skip empty values
		g_optionsCustom = {};
		
		jQuery.each(objValues, function(option, val){
			if(!val || jQuery.trim(val) == "")
				return(true);
			
			//convert to int
			if(typeof val == "string" && jQuery.isNumeric(val))
				val = parseInt(val);
			
			g_optionsCustom[option] = val;
		});
		
		updateSettingsPlaceholders();
	}
	
	
	/**
	 * apply grid options
	 */
	function applyGridSettings(){
		
		updateOptionsFromGridSettings();
		putGeneratedCss();
		updateAllRowsVisual();
		
	}
	
	
	/**
	 * init grid settings related, style, options, dialogs
	 */
	function initGridSettings(){
		
		//init style object
		g_objStyle = g_objWrapper.children("style");
		g_ucAdmin.validateDomElement(g_objStyle, "style tag");
		
		//init options
		g_options = g_objGrid.data("options");
		if(!g_options)
			throw new Error("Should be passed some options!");
		
		
		g_objGrid.removeAttr("data-options");	//remove attribute for not interfere
		
		jQuery("#uc_button_grid_settings").click(function(){
			
			g_panel.toggle("grid-settings");
			
		});
		
	}
	
	
	function ____________EVENTS______________(){}
	
	
	/**
	 * grigger event
	 */
	function triggerEvent(eventName, options){
		
		g_objGrid.trigger(eventName, options);
	
	}
	
	
	/**
	 * on some event
	 */
	function onEvent(eventName, func){
		
		g_objGrid.on(eventName, func);
		
	}
	
	
	/**
	 * on rows updated
	 * happends on add / update / delete / reorder row
	 */
	function onRowsUpdated(event){
		
		updateRowsClasses();
		
	}
	
	
	/**
	 * on add column
	 */
	function onRowColumnsUpdated(event, objRow){
		
		objRow = jQuery(objRow);
		
		updateColsClasses(objRow);
		
		updateColOperationButtons(objRow);
		
		updateRowVisual_buttons(objRow);
	}
	
	
	/**
	 * on col addons updated function
	 * show / hide empty visual if no addons
	 */
	function onColAddonsUpdated(event, objCol, origEvent){
				
		objCol = jQuery(objCol);
		
		var numAddons = getNumColAddons(objCol);
		if(origEvent == "sortchange")
			numAddons--;
		
		if(numAddons == 0)
			setColEmptyStateVisual(objCol, true);
		else
			setColEmptyStateVisual(objCol, false);
		
	}
		
	
	/**
	 * on col or row action icon click
	 */
	function onActionIconClick(){
		
		var objIcon = jQuery(this);
		
		var action = objIcon.data("action");
		var actionType = objIcon.data("actiontype");
		
		if(!action || action == "")
			throw new Error("wrong icon action");
		
		switch(actionType){
			case "grid":
                var objRow = getParentRow(objIcon);
                doGridAction(action, objRow);
			break;
			case "col":
				var objAddon = getParentCol(objIcon);
				doColAction(objAddon, action);
			break;
			case "row":
				var objRow = getParentRow(objIcon);
				doRowAction(action, objRow);
			break;
			case "addon":
				var objAddon = getParentAddonElement(objIcon);
				
				doAddonAction(objAddon, action);
			break;
			default:
				throw new Error("Wrong action type: " + actionType);
			break;
		}
		
	}
	
	/**
	 * init new row events
	 */
	function initNewRowEvents(event, objRow){
		
		jQuery(objRow).sortable({
			items: ".uc-grid-col",
			handle: ".uc-col-icon-move",
			cursor: "move",
			axis: "x",
			update: function(event, ui){
				var objCol = ui.item;
				var objRow = getParentRow(objCol);
				
				triggerEvent(t.events.ROW_COLUMNS_UPDATED, objRow);
				
			}
		});
			
	}
	
	
	/**
	 * on sortable addons change
	 */
	function onSortableAddonsChanged(event, ui){
		
		var objAddon = ui.item;
		var objCol = getParentCol(objAddon);
		
		triggerEvent(t.events.COL_ADDONS_UPDATED, [objCol, event.type]);
	}
	
	/**
	 * on col or row duplicated
	 * modify addons content
	 */
	function onColRowDuplicated(event, objElement){
				
		objElement = jQuery(objElement);
		var objAddons = getElementAddons(objElement);
		
		jQuery(objAddons).each(function(index, objAddon){
			objAddon = jQuery(objAddon);
			triggerEvent(t.events.ADDON_DUPLICATED, objAddon);
		});
	}
	
	
	/**
	 * on panel settings change
	 */
	function onPanelSettingsChange(event, params){
		
		var settingsType = params["object_name"];
		
		switch(settingsType){
			case "grid-settings":
				applyGridSettings(params);
			break;
			case "row-settings":
				applyRowSettings(params);
			break;
			case "col-settings":
				applyColSettings(params);
			break;
			case "addon-container-settings":
				applyAddonContainerSettings(params);
			break;
			case "addon-settings":
				applyAddonSettings(params);
			break;
			default:
				throw new Error("onPanelSettingsChange: Wrong settings type: " + settingsType);
			break;
		}
		
		
	}
	
	
	/**
	 * on panel html settings loaded from ajax
	 * save settings in addon data
	 */
	function onPanelHtmlSettingsLoaded(event, data){
		
		var addonID = data["object_id"];
		
		var objAddon = jQuery("#"+addonID);
		if(objAddon.length == 0)
			return(true);
		
		var htmlSettings = data["html_settings"];
		if(!htmlSettings)
			return(true);
		
		var addonData = getColAddonData(objAddon);
		
		addonData = g_objAddonConfig.setHtmlSettingsInAddonData(addonData, htmlSettings);
		
		saveAddonElementData(objAddon, addonData);
	}
	
	
	function ____________HOVER_EVENTS______________(){}

	
	/**
	 * on panel head mouseover
	 * show borders of relative element
	 */
	function onPanelHeadMouseOver(event, data){
		
		var objectID = data.objectID;
		
		setElementHoverMode(objectID, true);
	}
	
	
	/**
	 * on panel head mouseover
	 * hide borders of relative element
	 */
	function onPanelHeadMouseOut(event, data){
		
		var objectID = data.objectID;
		
		setElementHoverMode(objectID, false);
	}
	
	/**
	 * on panel mouse over
	 * blink with active element
	 */
	function onPanelMouseOver(event, data){
		
		//var objectID = data.objectID;
		//setElementHoverMode(objectID, true, true);
	}
	
	
	/**
	 * set hover mode to the element
	 */
	function setElementHoverMode(elementID, set, isTimeout){
		
		if(typeof elementID == "string"){
			
			var objElement = jQuery("#"+elementID);
			if(objElement.length == 0)
				return(false);
			
		}else
			var objElement = elementID;
		
		
		var type = getElementType(objElement);
		
		switch(type){
			case "row":
			case "column":
			case "addon":
			break;
			default:
				return(false);
			break;
		}
		
		
		if(set == true){
			objElement.addClass("uc-grid-always-hover");
			if(isTimeout == true){
				setTimeout(function(){
					objElement.removeClass("uc-grid-always-hover");
				}, 800);
			}
		}
		else
			objElement.removeClass("uc-grid-always-hover");
		
	}
	
	/**
	 * remove all element hover modes
	 */
	function removeAllElementHoverMode(){
		
		g_objGrid.find("uc-grid-always-hover").removeClass("uc-grid-always-hover");
		
	}
	
	
	/**
	 * on column mouse enter
	 */
	function onColAddonMouseOver(){
		
		var objAddon = jQuery(this);
		
		setColHoverSecondMode(null, objAddon);
		
		unsetRowHoverSecondMode(null, objAddon);
		
		//showAddonOverlay(objAddon, true);
	}

		
	
	/**
	 * on column mouse out
	 */
	function onColAddonMouseOut(){
		
		var objAddon = jQuery(this);
		
		unsetColHoverSecondMode(null, objAddon);
		
		//showAddonOverlay(objAddon, false);
	}
	
	
	/**
	 * on addon duplicated, modify content
	 */
	function onAddonDuplicated(event, objAddonCopy){
		
		objAddonCopy = jQuery(objAddonCopy);
		
		//modify data
		var addonData = getColAddonData(objAddonCopy);
		
		addonData = modifyAddonDataBeforeAdd(addonData);
		saveAddonElementData(objAddonCopy, addonData);
		
		setDuplicatedAddonHtml(objAddonCopy, addonData);
		
	}
	
	
	/**
	 * trigger after new addon added
	 */
	function onAddonAdded(event, data){
		
		var objAddon = data["addon"];
		var isGridInit = data["is_grid_init"];
		if(isGridInit === true)
			return(true);
		
		var addonData = getColAddonData(objAddon);
		var command = g_objAddonConfig.getPanelCommand("add_addon", addonData);
		
		if(!command)
			return(true);
		
		openAddonSettingsPanel(objAddon, command);
				
	}
	
	
	/**
	 * calling after delete or update addon
	 */
	function onElementRemoved(event, elementID){
		
		if(g_temp.is_live_view == true)
			checkRemoveLiveModeIncludes();
		
		if(elementID)
			g_panel.hideIfActive(elementID);
		
	}
	
	
	/**
	 * init the events
	 */
	function initEvents(){
		
		onEvent(t.events.ROW_COLUMNS_UPDATED, onRowColumnsUpdated);
		onEvent(t.events.ROWS_UPDATED, onRowsUpdated);
		onEvent(t.events.ROW_ADDED, initNewRowEvents);
		onEvent(t.events.COL_ADDONS_UPDATED, onColAddonsUpdated);
		onEvent(t.events.ELEMENT_REMOVED, onElementRemoved);
		onEvent(t.events.ADDON_ADDED, onAddonAdded);
		onEvent(t.events.ADDON_DUPLICATED,onAddonDuplicated);
		onEvent(t.events.COL_DUPLICATED, onColRowDuplicated);
		onEvent(t.events.ROW_DUPLICATED, onColRowDuplicated);
		
		g_objGrid.delegate(".uc-grid-action-icon", "click", onActionIconClick);
		
		//init sortable rows
		g_objGrid.sortable({
			handle: ".uc-row-icon-move",
			axis: "y",
			update: function(){
				triggerEvent(t.events.ROWS_UPDATED);
			}
		});	
		
		//init sortable addons
		
		var objGridOuter = g_objGrid.parents(".uc-grid-builder-outer");
		
		objGridOuter.sortable({
			items: ".uc-grid-col-addon",
			handle: ".uc-addon-icon-move",
			cursor: "move",
			axis: "y,x",
	        change: onSortableAddonsChanged,
			update: onSortableAddonsChanged 
		});
		
		
		//hover events
		g_objGrid.delegate(".uc-grid-col .uc-grid-col-addon", "mouseenter", onColAddonMouseOver);
		g_objGrid.delegate(".uc-grid-col .uc-grid-col-addon", "mouseleave", onColAddonMouseOut);

		//g_objGrid.delegate(".uc-grid-col", "mouseenter", unsetColHoverSecondMode);
		//g_objGrid.delegate(".uc-grid-col", "mouseleave", setColHoverSecondMode);
		
				
		g_objGrid.delegate(".uc-grid-row","mouseenter", unsetRowHoverSecondMode);
		g_objGrid.delegate(".uc-grid-row","mouseleave", setRowHoverSecondMode);
        
		g_objGrid.delegate(".uc-grid-col .uc-grid-box-wrapper", "mouseenter", setRowHoverSecondMode);
		g_objGrid.delegate(".uc-grid-col .uc-grid-box-wrapper", "mouseleave", unsetRowHoverSecondMode);
		
		//init panel events
		
		g_panel.onEvent(g_panel.events.SETTINGS_CHANGE, onPanelSettingsChange);
		g_panel.onEvent(g_panel.events.SETTINGS_HTML_LOADED, onPanelHtmlSettingsLoaded);
		g_panel.onEvent(g_panel.events.HEAD_MOUSEOVER, onPanelHeadMouseOver);
		g_panel.onEvent(g_panel.events.HEAD_MOUSEOUT, onPanelHeadMouseOut);
		g_panel.onEvent(g_panel.events.PANEL_MOUSEOVER, onPanelMouseOver);
		g_panel.onEvent(g_panel.events.PANEL_MOUSEOUT, removeAllElementHoverMode);
		
	}
	
	
	/**
	 * init tipsy
	 */
	function initTipsy(){
		
		if(typeof jQuery("body").tipsy != "function")
			return(false);
		
		var tipsyOptions = {
				html:true,
				gravity:"s",
		        delayIn: 1000,
		        selector: ".uc-tip"
		};
		
		g_objGrid.tipsy(tipsyOptions);
		
	}
	
	
	
	
	/**
	 * init side panel
	 */
	function initPanel(){
		
		var objPanel = g_objWrapper.find(".uc-grid-panel");
		if(objPanel.length == 0){
			g_panel = null;
			return(false);
		}
		
		g_panel.init(objPanel);
		
	}
	
	
	function ____________INIT______________(){}
	
	
	/**
	 * init rows
	 */
	function initByData_rows(rows){
		
		jQuery.map(rows, function(row, rowIndex){
			
			//remove me
			//if(rowIndex != 0)
				//return(false);
			
			var objRow = addEmptyRow();
			
			g_ucAdmin.validateObjProperty(row, "cols");
			
			var cols = row.cols;
					
			jQuery.map(cols,function(col){
				
				var objCol = addColumn(objRow);
				var addonsData = col.addon_data;
				
				if(jQuery.isArray(addonsData)){
					
					//add addons
					jQuery.map(addonsData, function(addonData){
						try{
							addColAddon(objCol, addonData, true);
							
						}catch(Error){
							//skip error
							trace(Error);						
						}
						
					});
					
				}else{
							//single - old way
					try{
					if(addonsData)
						addColAddon(objCol, addonsData, true);
												
					}catch(Error){}
					
				}
				
			});	//end add columns
			
			//set custom sizes, update visual
			
			var objCols = getCols(objRow);
			jQuery.each(objCols, function(index, col){
				var objCol = jQuery(col);
				var colData = cols[index];
				var size = g_ucAdmin.getVal(colData, "size");
				if(size)
					setColSize(objCol, size);
				
				var settings = g_ucAdmin.getVal(colData, "settings");
				if(settings)
					updateColSettings(objCol, settings);
				
				//update addons container settings
				
				var objAddons = getColAddons(objCol);
				var addonData = g_ucAdmin.getVal(colData, "addon_data");
				
				jQuery.each(objAddons, function(index, addon){
					var objAddon = jQuery(addon);
					var data = addonData[index];
					var addonOptions = g_ucAdmin.getVal(data, "options");
					
					if(addonOptions)
						updateAddonContainerSettings(objAddon, addonOptions);
					
				});
				
			});
			
			//update row visual
			if(row.hasOwnProperty("settings") && typeof row.settings == "object"){
				updateRowSettings(objRow, row.settings);
			}
			
			
		});
		
	}
	
	
	/**
	 * init options by data
	 */
	function initByData_options(options){
		
		g_optionsCustom = options;
		
		g_panel.setSettingsValues("grid-settings", g_optionsCustom);
		
		updateSettingsPlaceholders();
	}
	
	
	/**
	 * init the builder by data
	 */
	function initByData(initData){
		
		try{
			
			g_ucAdmin.validateObjProperty(initData, "rows");
			
			//init options
			if(initData.hasOwnProperty("options"))
				initByData_options(initData.options);
			
			//init rows
			if(initData.hasOwnProperty("rows"))
				initByData_rows(initData.rows);
			
		}catch(error){
			var errorText = "Error in grid init: "+error+" <br><br>Save disabled, Please move to box view";
			showErrorMessage(errorText);
			
			if(g_objParent)
				g_objParent.hideSaveButton();
			
		}
		
	}
	
	/**
	 * init builder options
	 */
	function initBuilderOptions(){
		
		var builderOptions = g_objGrid.data("builder-options");
		g_temp.indev = builderOptions["indev"];
		
		
		g_objGrid.removeAttr("data-builder-options");	//remove attribute for not interfere
	}
	
	
	/**
	 * init grid
	 */
	this.init = function(gridID, objParent){
		
		g_objGrid = jQuery(gridID);
		if(g_objGrid.length == 0)
			throw new Error("grid object: " + gridID + " not found");
		
		g_gridID = gridID;
		
		//set parent
		if(objParent)
			g_objParent = objParent;
			
		
		g_objWrapper = g_objGrid.parents(".uc-grid-builder-wrapper");
		
		initBuilderOptions();
		
		//init browser
		
		var objBrowserWrapper = jQuery("#uc_addon_browser");
		
		g_ucAdmin.validateDomElement(objBrowserWrapper, "addon browser");
		g_objBrowser.init(objBrowserWrapper);
		
		
		//init live view
		var isLiveView = g_objGrid.data("liveview");
		g_temp.is_live_view = g_ucAdmin.strToBool(isLiveView);
		
		//init panel
		initPanel();
		initEvents();
				
		initGridSettings();
		
		g_objRowStyleContainer = g_objWrapper.children(".uc-grid-row-styles");
		g_objColStyleContainer = g_objWrapper.children(".uc-grid-col-styles");
		
		
		//add the data
		var initData = g_objGrid.data("init");
		if(initData){
			initByData(initData);
			g_objGrid.removeAttr("data-init");   //remove attribute for not interfere
		}
		else
			addRow();

		//put the css by the options
		putGeneratedCss();
		
		//initTipsy();
		
	};
	
	
}