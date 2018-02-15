
/**
 * browser object
 */
function UniteCreatorGridPanel(){
	
	var g_objPanel, g_objBody, g_objHead;
	var t = this, g_objPaneGridSettings, g_objButtonHide, g_objGridBuilderOuter;
	var g_objButtonShow, g_objButtonClose, g_objHeaderLink;
	var g_objSettings = {};
	
	
	this.events = {
			SETTINGS_CHANGE: "panel_settings_change",
			SETTINGS_HTML_LOADED: "settings_html_loaded",
			AFTER_OPEN_SETTINGS: "after_open_settings",
			HEAD_MOUSEOVER: "head_mouseover",
			HEAD_MOUSEOUT: "head_mouseout",
			PANEL_MOUSEOUT: "mouse_mouseout",
			PANEL_MOUSEOVER: "mouse_mouseover"
	};
	
	var g_options = {
			allow_undock: false
	};
	
	var g_temp = {
			isInited:false,
			bodyMarginTop:1,
			bodyMarginBottom:0,
			bodyHeight: null,
			headHeight:null,
			bottomHeight:null,
			baseWidth: 250,
			baseTop: 90,
			animation_speed: 500,
			minWidth: 200,
			isDocked: true,
			isHidden: false,
			enableTriggerChange: true,
			command_after_load: null		//run command after load settings
	};
	
	if(!g_ucAdmin)
		var g_ucAdmin = new UniteAdminUC();
	
	/**
	 * validate inited
	 */
	function validateInited(){
		
		g_ucAdmin.validateDomElement(g_objPanel, "panel");
		
	}
	
	/**
	 * validate that pane exists
	 */
	function validatePane(name){
		
		validateInited();
		g_ucAdmin.validateObjProperty(g_objSettings, name, "pane");
		
	}
		
	
	/**
	 * set setting values
	 */
	function setSettingsValues(paneName, values){
		
		var isClear = false;
		if(typeof values == "undefined")
			isClear = true;
		
		validatePane(paneName);
				
		g_temp.enableTriggerChange = false;
		
		if(isClear == true)
			g_objSettings[paneName].clearSettingsInit();
		else
			g_objSettings[paneName].setValues(values);
				
		g_temp.enableTriggerChange = true;
	}
	
	
	/**
	 * external alias
	 */
	this.setSettingsValues = function(paneName, values){
		setSettingsValues(paneName, values);
	};
	
	
	/**
	 * get settings values
	 */
	function getSettingsValues(paneName){
		validatePane(paneName);
		
		var values = g_objSettings[paneName].getSettingsValues();
		
		return(values);
	}
	
	
	/**
	 * external alias
	 */
	this.getSettingsValues = function(paneName){
		return getSettingsValues(paneName);
	};
	
	
	
	/**
	 * check if pane active and has the same id
	 */
	function isExactPaneActive(paneName, objectID){
		
		if(!objectID)
			var objectID = null;
		
		var data = getActivePaneData();
		if(paneName == data.name && objectID == data.objectID)
			return(true);
		
		return(false);
	}
	
	
	/**
	 * get settings and active id datga
	 */
	this.getPaneData = function(paneName){
		
		var objPane = getPaneByName(paneName);
		
		var output = {};
		output.objectID = objPane.data("objectid");
		output.settings = getSettingsValues(paneName);
				
		return(output);
	};
	
	
	/**
	 * get active pane
	 */
	function getActivePaneData(objPane){
		
		if(!objPane)
			var objPane = g_objPanel.find(".uc-grid-panel-pane.uc-current-pane");
		
		g_ucAdmin.validateDomElement(objPane, "current pane");
		
		if(objPane.length != 1)
			throw new Error("There should be only one active pane");
		
		var paneName = objPane.data("name");
		var objectID = objPane.data("objectid");
		if(!objectID)
			objectID = null;
		
		var output = {
				name: paneName,
				objectID: objectID
		};
		
		return(output);
	}
	
	
	/**
	 * get pane by name
	 */
	function getPaneByName(paneName){
		
		var paneClass = ".uc-grid-panel-pane.uc-pane-" + paneName;
		
		var objPane = g_objPanel.find(paneClass);
		g_ucAdmin.validateDomElement(objPane, paneClass);
		 
		return(objPane);
	}
	
	
	/**
	 * get pane settings object
	 */
	function getPaneSettingsObject(objPane){
		var name = objPane.data("name");
		var objSettings = g_objSettings[name];
		if(!objSettings)
			throw new Error("Settings object not found! "+ name);
		
		return(objSettings);
	}
	
	
	/**
	 * switch pane
	 */
	function switchPane(paneName, customTitle, params){
		
		var classCurrentPane = "uc-current-pane";
		
		var objPane = getPaneByName(paneName);
		
		if(objPane.hasClass(classCurrentPane) == false){
			var otherPanes = g_objPanel.find(".uc-grid-panel-pane").not(objPane);
			
			otherPanes.hide().removeClass(classCurrentPane);
			objPane.show().addClass(classCurrentPane);
		}
		
		
		//set header
		var title = objPane.data("title");
		if(customTitle)
			title = customTitle;
		
		g_ucAdmin.validateNotEmpty(title, "pane title");

		var className = "uc-grid-panel-head uc-panetype-"+paneName;
		g_objHead.attr("class", className);
				
		var objTitleText = g_objHead.find(".uc-grid-panel-head-text");
		objTitleText.html(title);
		
		//prepare header link
		
		var editLink = g_ucAdmin.getVal(params, "header_edit_link");
		if(editLink){
			g_objHeaderLink.addClass("uc-link-active");
			g_objHeaderLink.attr("href", editLink);
		}else{
			g_objHeaderLink.removeClass("uc-link-active");
		}
			
		
		return(objPane);
	}
	
		
	
	function _________MOVEMENT_________(){}
	
	/**
	 * hide panel in docked state
	 */
	function hidePanelDocked(){
		
		var width = g_objPanel.width();
		
		var objCss = {};
		objCss["top"] = g_temp.baseTop+"px";
		objCss["left"] = -width+"px";
		
		//just for case
		if(g_objButtonShow)
			g_objButtonShow.hide();
		
		g_objPanel.animate(objCss, g_temp.animation_speed,null,function(){
			
			if(g_objButtonShow)
				g_objButtonShow.toggle("slide");
			
		});	
		
		setBuilderSize(0, true);
	}
	
	
	/**
	 * hide panel undocked state
	 */
	function hidePanelUndocked(){
		
		if(g_objButtonShow)
			g_objButtonShow.hide();
		
		g_objPanel.fadeOut(g_temp.animation_speed,function(){
			
			if(g_objButtonShow)
				g_objButtonShow.toggle("slide");
			
			g_objPanel.hide();
		});
		
	}
	
	
	
	/**
	 * hide panel in side
	 */
	function hidePanel(){
		
		//hide tinymce panel if exists
		jQuery(".mce-floatpanel").hide();
		
		if(g_temp.isDocked == true)
			hidePanelDocked();
		else
			hidePanelUndocked();
		
		g_temp.isHidden = true;
	}
	
	
	
	
	/**
	 * show the panel
	 */
	function showPanel(){
		
		if(g_temp.isHidden == false)
			return(false);
		
		if(g_objPanel.is(":visible") == false){
			g_objPanel.show();
			setPanelSizes();
		}
		
		var width = g_objPanel.width();
				
		//set init position
		var objCss = {};
		objCss["top"] = g_temp.baseTop+"px";
		objCss["left"] = -width+"px";
		g_objPanel.css(objCss);
		
		
		var objCss = {};
		objCss["top"] = g_temp.baseTop+"px";
		objCss["left"] = "0px";
						
		if(g_objButtonShow){
			if(g_objButtonShow.is(":visible"))
				g_objButtonShow.toggle("slide");
		}
		
		g_objPanel.animate(objCss, g_temp.animation_speed);
		
		setBuilderSize(width, true);
		
		g_temp.isHidden = false;
	}
	
	
	
	/**
	 * check is docked or not by position
	 */
	function isDocked(ui){
		
		var bottom = g_objPanel.css("bottom");
		
		if(bottom != "0px" && bottom != "0" && bottom != 0)
			return(false);
		
		if(ui){
			var left = ui.position.left;
			var top = ui.position.top;
		}
		else{
			var pos = g_objPanel.position();
			
			var top = pos.top;
			var left = pos.left;
			
		}
		
		if(left != 0)
			return(false);
		
		if(top != g_temp.baseTop)
			return(false);
		
		return(true);
	}
	
	
	/**
	 * undock the panel
	 */
	function undock(){
		
		g_temp.isDocked = false;
		
		setBuilderSize(0, true);
	}
	
	
	/**
	 * check if docked state changed, if do, change var and run events
	 */
	function handleDockedState(ui){
		
		if(g_temp.isDocked == false)
			return(false);
		
		var docked = isDocked();
		
		if(docked == false)
			undock();
		
	}
	
	/**
	 * set builder size
	 */
	function setBuilderSize(panelWidth, isAnimation){
		
		var objCssBuilder = {"padding-left":panelWidth+"px"};
		
		if(isAnimation)
			g_objGridBuilderOuter.animate(objCssBuilder, g_temp.animation_speed);	
		else
			g_objGridBuilderOuter.css(objCssBuilder);
	}
	
	
	/**
	 * set settings max height
	 */
	function setSettingsSize(objSettings){
		if(!objSettings)
			return(false);
		
		objSettings.setAccordionMaxHeight(g_temp.bodyHeight);
	}
	
	
	/**
	 * set panel max height
	 */
	function setPanelSizes(){
		
		setBodySize();
		
		//set settings size
		jQuery.each(g_objSettings, function(index, objSettings){
			setSettingsSize(objSettings);
		});
		
	}
	
	
	/**
	 * set body size
	 */
	function setBodySize(){
		
		var panelHeight = g_objPanel.height();
		var headHeight = g_temp.headHeight;
		if(headHeight === null)
			headHeight = g_objHead.height();
		
		var bottomHeight = g_temp.bottomHeight;
		if(bottomHeight === null){
			var objBottomPanel = g_objPanel.find(".uc-grid-panel-bottom");
			if(objBottomPanel.length)
				bottomHeight = objBottomPanel.height();
			else
				bottomHeight = 0;
			
			g_temp.bottomHeight = bottomHeight;
		}
		
		
		var bodyHeight = panelHeight - headHeight - g_temp.bodyMarginTop - g_temp.bodyMarginBottom - bottomHeight;
		var bodyPosY = headHeight + g_temp.bodyMarginTop;
		
		//set body height
		var isFirstSet = g_temp.bodyHeight === null;
		
		var bodyCss = {};
		
		if(isFirstSet == true){
			bodyCss["top"] = bodyPosY+"px";
			bodyCss["display"] = "block";
		}
		
		bodyCss["height"] = bodyHeight+"px";
		
		g_objBody.css(bodyCss);
		
		g_temp.bodyHeight = bodyHeight;
		
	}
	
	
	/**
	 * load pane data
	 */
	function loadPaneData(objPane, data){
		
		g_temp.enableTriggerChange = false;
		
		var objLoader = objPane.children(".uc-grid-panel-pane-loader");
		g_ucAdmin.validateDomElement(objLoader, "pane loader");
		
		destroyPane(objPane);
		
		var objContent = objPane.children(".uc-grid-panel-pane-content");
		
		//check for html settings
		var htmlSettings = g_ucAdmin.getVal(data, "html_settings");
		
		if(htmlSettings){
			
			objContent.html(htmlSettings);
			initPaneSettingsObject(objPane);
			
			triggerEvent(t.events.AFTER_OPEN_SETTINGS, objPane);
			
		}else{		//html settings don't found, load settings
			
			
			objLoader.show();
			
			var action = objPane.data("action");
			g_ucAdmin.ajaxRequest(action, data, function(response){
				
				objLoader.hide();
				var htmlSettings = response.html;
				var paneData = getActivePaneData(objPane);
				var eventData = {"object_id":paneData.objectID, "html_settings":htmlSettings};
				
				triggerEvent(t.events.SETTINGS_HTML_LOADED, eventData);
				
				objContent.html(htmlSettings);
				initPaneSettingsObject(objPane);
				
				triggerEvent(t.events.AFTER_OPEN_SETTINGS, objPane);
				
			});
			
		}
		
		g_temp.enableTriggerChange = true;
		
	}
	
	
	/**
	 * set pane data after open
	 */
	function setPaneData(objPane, objValues, paneName){
				
		var paneAction = objPane.data("action");
				
		if(paneAction){
			loadPaneData(objPane, objValues);
		}else{
			
			if(!paneName)
				paneName = objPane.data("name");
			
			setSettingsValues(paneName, objValues);
			
			triggerEvent(t.events.AFTER_OPEN_SETTINGS, objPane);
			
		}
		
	}
	
	
	/**
	 * open the panel
	 */
	this.open = function(paneName, objValues, objectID, customTitle, params){
		
		
		if(params){
			var command = g_ucAdmin.getVal(params, "command");
			if(command)
				g_temp.command_after_load = command;
		}
		
		var objPane = switchPane(paneName, customTitle, params);
		var paneObjectID = objPane.data("objectid");
		
		if(paneObjectID !== objectID)
			setPaneData(objPane, objValues, paneName);
		
		objPane.data("objectid", objectID);
				
		if(g_temp.isHidden == true)
			showPanel();
		
	};
	
	
	/**
	 * toggle
	 */
	this.toggle = function(paneName, objValues, objectID, customTitle, params){
		
		if(g_temp.isHidden == true)
			this.open(paneName, objValues, objectID, customTitle, params);
		else{
			
			var isActive = isExactPaneActive(paneName, objectID);
			
			if(isActive == true)
				hidePanel();
			else
			  this.open(paneName, objValues, objectID, customTitle, params);
		}
	};
	
	/**
	 * hide panel if the pane with id is active
	 */
	this.hideIfActive = function(objectID){
		
		var data = getActivePaneData();
		if(objectID == data.objectID)
			hidePanel();
	};
	
	
	function _____EVENTS_____(){}
	
	
	/**
	 * on setting change
	 */
	function onSettingChange(objectName, params, isInstant){
		
		if(g_temp.enableTriggerChange == false)
			return(true);
		
		if(g_temp.isHidden == true)
			return(false);
		
		if(!params)
			params = {};
		
		params["object_name"] = objectName;
		params["is_instant"] = isInstant;		
		
		//add object ID
		var objPane = getPaneByName(objectName);	
		var data = getActivePaneData(objPane);
		
		params["object_id"] = data["objectID"];
		
		
		triggerEvent(t.events.SETTINGS_CHANGE, params);
	}
	
	
	/**
	 * on resize
	 */
	function onResizableResize(event, ui){
		
		var panelWidth = ui.size.width;
		
		//ui.size.height = ui.originalSize.height;
		
		if(g_temp.isDocked)
			setBuilderSize(panelWidth);
		
		handleDockedState(ui);
	}
	
	
	/**
	 * init settings object events
	 */
	function initEvents_settings(objSettings, paneName){
		
		if(!objSettings)
			return(false);
		
		//change
		objSettings.setEventOnChange(function(event, params){
			
			onSettingChange(paneName, params);
			
		});
		
		//instant change
		objSettings.onEvent(objSettings.events.INSTANT_CHANGE, function(event, params){
			
			onSettingChange(paneName, params, true);
			
		});
		
	}
	
	/**
	 * run on after open settings, check command
	 */
	function onAfterLoadSettings(event, objPane){
				
		if(!g_temp.command_after_load)
			return(true);
		
		objPane = jQuery(objPane);
		var objSettings = getPaneSettingsObject(objPane);
		
		objSettings.runCommand(g_temp.command_after_load);
		
		g_temp.command_after_load = null;
	}
	
	
	/**
	 * init events
	 */
	function initEvents(){
		
		jQuery( window ).resize(setPanelSizes);
		
		
		//html / show buttons
		if(g_objButtonHide)
			g_objButtonHide.click(hidePanel);
		
		if(g_objButtonShow)
			g_objButtonShow.click(showPanel);
		
		if(g_objButtonClose)
			g_objButtonClose.click(hidePanel);
		
		//set resizable
		var optionsResizable = {
				minWidth: g_temp.minWidth,
				resize: onResizableResize
		};
		
		//mouse events
		g_objHead.on("mouseenter",function(){
			triggerEvent(t.events.HEAD_MOUSEOVER);
		});
		
		g_objHead.on("mouseleave",function(){
			triggerEvent(t.events.HEAD_MOUSEOUT);
		});
		
		g_objPanel.on("mouseenter", function(){
			triggerEvent(t.events.PANEL_MOUSEOVER);
		});
		
		g_objPanel.on("mouseleave", function(){
			triggerEvent(t.events.PANEL_MOUSEOUT);
		});
		
		
		if(g_options.allow_undock == false)
			optionsResizable["handles"] = "w,e";
		
		g_objPanel.resizable(optionsResizable);
		
		t.onEvent(t.events.AFTER_OPEN_SETTINGS, onAfterLoadSettings);

	}
	
	
	/**
	 * trigger event
	 */
	function triggerEvent(eventName, params){
		
		if(!params)
			var params = getActivePaneData();
		
		g_objPanel.trigger(eventName, params);
	}
	
	
	/**
	 * on event name
	 */
	this.onEvent = function(eventName, func){
		
		validateInited();		
		
		g_objPanel.on(eventName,func);
	};
	
	
	
	function _____INIT_____(){}
	
	
	/**
	 * destroy pane
	 */
	function destroyPane(objPane){
		
		var name = objPane.data("name");
		
		//destroy settings
		var existingSettings = g_ucAdmin.getVal(g_objSettings, name);
		if(existingSettings){
			existingSettings.destroy();
			g_objSettings[name] = null;
		}
		
		//clear content
		var objContent = objPane.children(".uc-grid-panel-pane-content");
		objContent.html("");
		
	}
	
	
	/**
	 * init all objects
	 */
	function initObjects(objPanel){
		
		g_objPanel = objPanel;
		g_ucAdmin.validateDomElement(g_objPanel, "panel object");
		
		g_objBody = g_objPanel.children(".uc-grid-panel-body");
		g_ucAdmin.validateDomElement(g_objBody, "panel body");
		
		g_objHead = g_objPanel.children(".uc-grid-panel-head");
		g_ucAdmin.validateDomElement(g_objHead, "panel head");
		
		g_objGridBuilderOuter = g_objPanel.siblings(".uc-grid-builder-outer");
		g_ucAdmin.validateDomElement(g_objGridBuilderOuter, "grid builder outer");

		g_objButtonClose = g_objPanel.find(".uc-grid-panel-head-close");
		g_ucAdmin.validateDomElement(g_objButtonClose, "grid builder close");
			
		g_objHeaderLink = g_objHead.find(".uc-grid-panel-head-edit");
		g_ucAdmin.validateDomElement(g_objHeaderLink, "header edit link");
		
		g_objButtonHide = g_objPanel.find(".uc-panel-button-hide");
		if(g_objButtonHide.length)
			g_objButtonHide = null;
		
		g_objButtonShow = g_objPanel.siblings(".uc-grid-panel-show-handle");
		
		if(g_objButtonShow.length)
			g_objButtonShow = null;
	}
	
	
	/**
	 * init some options
	 */
	function initOptions(){
		
		g_temp.isHidden = !g_objPanel.is(":visible");
		
		//init options from data
		
		var objOptions = g_objPanel.data("options");
		g_ucAdmin.validateIsObject(objOptions, "objOptions");
		
		jQuery.extend(g_options, objOptions);
		
	}
	
	
	/**
	 * init pane settings object, after ajax load
	 */
	function initPaneSettingsObject(objPane){
		
		var name = objPane.data("name");
		
		//if existing exists, destroy settings object
		var existingSettings = g_ucAdmin.getVal(g_objSettings, name);
		if(existingSettings){
			trace(existingSettings);
			throw new Error("No settings shoud be before init!");
		}
		
		var objPaneContent = objPane.children(".uc-grid-panel-pane-content");
		var objSettingsWrapper = objPaneContent.children(".unite_settings_wrapper");
		
		if(objSettingsWrapper.length > 1){
			trace(objSettingsWrapper);
			throw new Error("Could be only 1 settings object in pane");
		}
		
		if(objSettingsWrapper.length == 0){
			g_objSettings[name] = null;
			return(false);
		}
		
		
		var objSettings = new UniteSettingsUC();
		objSettings.init(objSettingsWrapper);
		
		//init events
		initEvents_settings(objSettings, name);
		
		//set size
		if(g_temp.isInited == true)
			setSettingsSize(objSettings);
			
		
		g_objSettings[name] = objSettings;
		
	}
	
	
	
	/**
	 * init all panes
	 */
	function initPanes(){
		
		var objPanes = g_objPanel.find(".uc-grid-panel-pane");
		
		jQuery.each(objPanes, function(index, pane){
			var objPane = jQuery(pane);
			initPaneSettingsObject(objPane);
		});
		
	}
	
	/**
	 * update placeholders
	 */
	this.updatePlaceholders = function(paneName, objPlaceholders){
		
		validatePane(paneName);
		
		var objSettings = g_objSettings[paneName];
		
		objSettings.updatePlaceholders(objPlaceholders);
	};
	
	
	/**
	 * init panel
	 */
	this.init = function(objPanel){
		
		initObjects(objPanel);
		
		initOptions();
		
		initPanes();
		
		setPanelSizes();
		
		initEvents();
		
		g_temp.isInited = true;
	};
	
}