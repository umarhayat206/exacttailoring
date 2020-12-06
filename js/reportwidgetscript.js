window._reportwidget_gaSSDSLoadForChrome =function(win) {

	  if (win._gat==null){
	      var gaJsHost = (("https:" == win.document.location.protocol) ? "https://ssl." : "http://www.");
		  
		  var s = win.document.createElement('script');
		  s.setAttribute("id","gareportscript");
		  s.id = "gareportscript";
		  s.src = gaJsHost + 'google-analytics.com/ga.js';
		  s.type = 'text/javascript';  
		  var headElem = win.document.getElementsByTagName('head')[0];
		  headElem.appendChild(s);
	  }
	  else
	  {
	  }
};


window._reportwidget_sendGATEventImplForChrome=function (win,category, action, optional_label, optional_value,count,GA_ACCOUNT){
	
	var isError=false;
	try {
		
		var _tempTracker = win._gat._getTracker(GA_ACCOUNT);

		if(_tempTracker) {
			_tempTracker._setVar(category);
			pageGlog("now page");
			_tempTracker._trackPageview(category);
			_tempTracker._setCustomVar(1, "AffId", category, 3);
			_tempTracker._setCustomVar(2, "distribution", "coupish", 3);

			
			optional_value = parseInt(optional_value);
			pageGlog("now event");
			var eventResult = _tempTracker._trackEvent(category, action, optional_label, optional_value);

		

			if((""+eventResult)!=="true")
			{
				isError=true;
			};
			
	
		}
	
	} catch (err) {		
		pageGlog(err);
		isError=true;
		
	}
	
	if(isError)
	{
		pageGlog("sending reportactivechromefailed...");
		window.postMessage({ type: "reportactivechromefailed" }, "*");

	}
	else
	{
		pageGlog("sending reportactivechromesuccess...");
		window.postMessage({ type: "reportactivechromesuccess" }, "*");

	}
};

window._reportwidget_sendGATEventForChrome =function(win,category, action, optional_label, optional_value,gaaccount){

	var count =0;
	setTimeout(function(){window._reportwidget_sendGATEventImplForChrome(win,category, action, optional_label, optional_value,count,gaaccount);}, 3000);
	
};



var onExtMessage = function(event) 
{
	
	if(!event){return;}
	var data=null;
	
	
	var rawData = ""+ event.data;
	if( rawData.indexOf("YUFAthismessagecomesfromextYUFA") >= 0)
	{
		pageGlog("message from ext");
	}
	
	
	if(event.data )
	{
		try{
			data = window.JSON.parse(event.data);
		}catch(e){}
		
	}else{return;}
	
	
	if (data && (data.type == "gaSSDSLoadForChrome")) {
		
		try{
			pageGlog("gaSSDSLoadForChrome received in page");
			window._reportwidget_gaSSDSLoadForChrome(window);
		}catch(e){}
	}
	
	if (data && (data.type == "sendGATEventForChrome")) {
			pageGlog("sendGATEventForChrome received in page");

			var dataObj;
			dataObj = data.dataObj;
			pageGlog("dataObj:");
			pageGlog(dataObj);

			if(dataObj)
			{
				window._reportwidget_sendGATEventForChrome(window, dataObj.category, dataObj.action, dataObj.optional_label, dataObj.optional_value,dataObj.gaaccount);
			}
			else
			{
				pageGlog("data for event is invalid");
			}
			
			
		
	 }
	
};

if (!window.addEventListener) {
	window.attachEvent("onmessage", onExtMessage);
}
else {
	window.addEventListener("message", onExtMessage, false,true);
}

pageGlog("sending reportwidgetready");
window.postMessage("reportwidgetready", "*");

	