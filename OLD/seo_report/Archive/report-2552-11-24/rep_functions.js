function OpenHelp()
{
	OpenNewWindow(HelpURL,'Help',640,480)
}

function DrawSplitPageJump(expand)
{
	retV = ''
	+	'<tr height="23" bgcolor="FAFAFF" class="blk_Font_11px_Bold">'
	+	'<td colspan="2" align="center">'

	+	'<table border="0"  width="800" >'
	+	'<tr class="blk_Font_11px"><td style="padding-left: 16px;" align="left">Engine:&nbsp;&nbsp;'
	+		'<form name="frmJump1" style="display:inline;">'
	+		'<select name="cboJumpList" class="button" id="cboEngineList">'
	
	var selIndex = 0;
	for(var i=0;i < JumpPages.length;i++)
	{
		var Page = JumpPages[i].split('|');
		var sel = '';
		if(document.location.href.indexOf(Page[0]) > 0)
		{
			sel = ' selected="true" '
			selIndex = i;
		}
		retV +='<option value="' + Page[0] + '" ' + sel + '>' + Page[1] + '</option>'
	}

	retV +=	'</select>'
	+	'&nbsp;<input type="button" name="Go" class="button" value="Go" OnClick="Javascript:if(document.frmJump1.cboEngineList.selectedIndex > -1){document.location.replace(document.frmJump1.cboEngineList[document.frmJump1.cboEngineList.selectedIndex].value);}">'
	+	'</td><td width="100%" align="right" valign="bottom" style="padding-right: 16px;">'

	+	' <a Title="Previous Page" href="Javascript:" OnClick="Javascript:'

	if(selIndex > 0)
	{
		var prevp = JumpPages[selIndex-1].split('|');
		retV += 'document.location = \'' + prevp[0] + '\''
	}

	retV +=	';return false;"><img src="page_l.gif" border="0" width="15" height="15"></a> '

	retV +=	'&nbsp;' + (selIndex +1) + ' of ' + JumpPages.length + '&nbsp;'

	+ ' <a Title="Next Page" href="Javascript://" OnClick="Javascript:'
	if(selIndex < JumpPages.length -1)
	{
		var nextp = JumpPages[selIndex+1].split('|');
		retV += 'document.location = \'' + nextp[0] + '\''
	}

	retV +=	';return false;"><img src="page_r.gif" border="0" width="15" height="15"></a> '

	retV +=	'</form>'
	+	'</td>'
	+	'<td align="right" style="padding-left: 16px;">'

	if(expand == true)
	{
			if(CurPage == 7)
				var selStr = 'Graphs'
			else
				var selStr = 'Nodes'
 			retV += '<img border="0" id="i-AllNodes" align="bottom" title="Collapse All ' + selStr + '" src="maximize2.gif" onclick="javascript:ToggleAllNodes(this, \'' + selStr + '\');">'
	}
	else
		retV += '&nbsp;'

	retV +=	'</td>'
	+	'</tr></table></td></tr>'

	document.write(retV);
}

	function Jump(EList)
	{
		if(EList.selectedIndex == -1)
			return;

		var selVal = EList.options[EList.selectedIndex].value;
		var obj = document.getElementsByName(selVal);

		if(obj.length == 0)
			return;

		var p= obj[0];
		
		var y= p.offsetTop;
		while( (p= p.offsetParent) != null)
		{
			y= y + p.offsetTop;
		}
		scrollTo( 0, y);
	}

	function Jump2D(EList,KList)
	{
		if(EList.selectedIndex == -1 || KList.selectedIndex == -1)
			return;

		var obj = document.getElementsByName(EList.options[EList.selectedIndex].value + '-' + KList.options[KList.selectedIndex].value);
		var p= obj[0];
		
		if(obj.length == 0)
			return;

		var y= p.offsetTop;
		while( (p= p.offsetParent) != null)
		{
			y= y + p.offsetTop;
		}
		scrollTo( 0, y);
	}


	function SetArrow(val)
	{
		var retV = '';
		if(isNumeric(val))
		{

			var t = /\+/g;
			val = val.replace(t,'');

			if (val == 0)	
				retV = val + '&nbsp;<img width="8" height="0" src="equal.gif">' ;
			else if(val > 0)
				retV = val + '&nbsp;<img width="8" height="8" src="up.gif">';
			else
				retV = val + '&nbsp;<img width="8" height="8" src="down.gif">';
		}
		else
		{
			retV = val + '&nbsp;<img height="0" width="8" src="equal.gif">';
		}
		return retV;
	}
	
	
	function isNumeric(n)
	{
		var NumStr = new String(n)
		var regex = /[^0-9\-\+]/
		return !regex.test(NumStr)
	}

	function Draw2DTables(myData, ColSet)
	{
		myData = SplitData(myData)

		for (var i in myData)
		{
			Draw2DTable(myData[i], ColSet)
		}

		if(myData.length == 0)
		{
			retV = ''
			retV += '<table class="reportheader" cellspacing="0" cellpadding="0" align="center" border="0"><tr> '
				+ '<td class="headerleft"></td>'
				+ '<td class="headercenter">No Results Found.</td>'
				if(Suppress == false)
					retV += '<td class="headercenter" width="19"><a href="Javascript:OpenHelp();"><img src="help_card.gif" alt="Help" border="0"></a></td>'

				retV += '<td class="headerright"></td>'
				+ '</tr></table>'

				+ '<table class="reportbody" cellspacing="0" cellpadding="0">'
				+ '<tr bgcolor="#EDEDED"><td>&nbsp;</td></tr></table><BR>'
			document.write(retV)
		}
	}

	function SplitData(myData)
	{
		var retData = new Array();
		for(var i in myData)
		{
		//Find 1st Dim
			var fndfirst = '';
			var fndsecond = '';
			for(var j in retData)
			{			
				if(retData[j][0][0][0] == myData[i][0])
					fndfirst = j
			}
			if (fndfirst == '')
			{
				fndfirst = retData.length
				retData[retData.length] = new Array();
			}
		//Find 2nd Dim
			for(var k in retData[fndfirst])
			{
				if(retData[fndfirst][k][0][1] == myData[i][1])
					fndsecond = k		
			}
			if (fndsecond == '')
			{
				fndsecond = retData[fndfirst].length
				retData[fndfirst][fndsecond] = new Array();
			}
			
		//Add Array
			var obj = retData[fndfirst][fndsecond]
			var fndthird = obj.length
			obj[fndthird] = new Array();
			for(var l in myData[i])
			{
				obj[fndthird][l] = myData[i][l]
			}
		}

		return retData
	}

	function Draw2DTable(myData, ColSet)
	{
		var retV = ''
		

		//Table Header
		retV += '<a name="' + myData[0][0][0] + '"></a>'
		retV += '<table class="reportheader" cellspacing="0" cellpadding="0" align="center" border="0">'
        	+ '<tr> '
		+ '<td class="headerleft"></td>'
		+ '<td class="headercenter">' + myData[0][0][0] + '</td>'

		if(Suppress == false)
			retV += '<td class="headercenter" width="19"><a href="Javascript:OpenHelp();"><img src="help_card.gif" alt="Help" border="0"></a></td>'

		retV += '<td class="headerright"></td>'
		+ '</tr>'
		+ '</table>'
		+ '<table class="reportbody" cellspacing="0" cellpadding="0">'
	
		//Columns Labels
		retV += '<tr bgcolor="#EDEDED"><td width="6"></td>'

		for (var i in ColSet)
		{
			if(i == 0 )
				retV += '<td valign="top" style="padding-left: 16px;" class="engine_Cell_Head" width="' + ColWidths[i] + '">' + ColSet[i] + '</td>'
			else
				retV += '<td valign="top" align="right" style="padding-right: 16px;" class="engine_Cell_Head" width="' + ColWidths[i] + '">' + ColSet[i] + '</td>'
		}
		retV += '<td width="6"></td></tr>'
		

		//Data
		for (var i in myData)
		{
			DivCnt++;
			if (i%2)
				var bgcolor = ' bgcolor="EDEDED" '
			else
				var bgcolor =  'bgcolor="DADADA" '

			for(var k in myData[i])
			{
				for (var j in ColSet)
				{
					if(j == 0 )
					{

						if (k < 1)
						{

							retV += '<tr ' + bgcolor + '><td></td>'

							retV += '<td valign="top" colspan="' + (ColSet.length) + '" ><img src="drillDownSelected.gif" id="i-' + CleanForID(myData[0][0][0] + '-' + myData[i][k][1]) + '" OnClick="Javascript:ToggleLayer(\'' + CleanForID(myData[0][0][0] + '-' + myData[i][k][1]) + '\');" >&nbsp;' 

							if( typeof(Reports[7]) != 'undefined')
							{
								if(CurPage == 2)
									retV += '<a href="Javascript:OpenNewWindow(\'Trend-' + EncodeReportData(myData[i][k][0] + '-' + myData[i][k][1]) + '.png\',\'TrendGraph\',600,270)" Title="View Trend Graph">'
								else if(CurPage == 3)
									retV += '<a href="Javascript:OpenNewWindow(\'Trend-' + EncodeReportData(myData[i][k][1] + '-' + myData[i][k][0]) + '.png\',\'TrendGraph\',600,270)" Title="View Trend Graph">'
							}

							retV += '<b>' + FormatData(myData[i][k][parseInt(j)+1], ColSet[parseInt(j)-1]) + '</b>'

							if( typeof(Reports[7]) != 'undefined' && (CurPage == 2 || CurPage == 3))
								retV += '</a>'
							
							if(CurPage != 8)
							{
								var ext = (myData[i].length == 1)? ' item' : ' items';
								var bpVal;
								if (myData[i][0][3] == 0 || myData[i][0][3] == -1)
									bpVal = ", No page found)"
								else
								{
									// var bpVal = ', Best Position: ' + myData[i][0][3] + ')'
									var TempSmall=31;
									for(var m in myData[i])
									{									
									if (myData[i][m][3] <= eval(TempSmall))										
									  {
										TempSmall = myData[i][m][3];
									  }
									}
									if (TempSmall != 31)
									  bpVal = ', Best Position: ' +  TempSmall  + ')';
									else
									  bpVal = ', Best Position: Not in first 30)';
								}
								if ((bpVal == ', Best Position: Not in first 30)') || (bpVal ==  ', No page found)'))
									retV += '&nbsp;&nbsp;(0' + ext + bpVal
								else									
									retV += '&nbsp;&nbsp;(' + myData[i].length + ext + bpVal
							}
							retV += '</td>'
							retV += '<td ></td></tr>'
						}
					}
					else if(j == 1)
						retV += '<tr ' + bgcolor + ' id="r-' + CleanForID(myData[0][0][0] + '-' + myData[i][k][1]) + '"><td></td><td valign="top" style="padding-left: 32px;" >' + FormatData(myData[i][k][parseInt(j)+1], ColSet[parseInt(j)-1]) + '</td>'
					else
						retV += '<td valign="top" align="right" style="padding-right: 16px;">' + FormatData(myData[i][k][parseInt(j)+1], ColSet[parseInt(j)-1]) + '</td>'
				}
				retV += '<td valign="top" align="right" style="padding-right: 16px;">' + FormatData(myData[i][k][parseInt(j)+2], ColSet[parseInt(j)]) + '</td>'
				retV += '<td width="6"></td></tr>'
				document.write(retV);
				retV = '';
			}

		}

		//End Table
		retV += '</table><BR>'

		document.write(retV);
	
	}

	function EncodeReportData(myVal)
	{

		var t = /\`|\/|\\|\:|\*|\?|\""|\<|\>|\||\'/g;
		myVal = myVal.replace(t,"_");
		return myVal
 	}
	function formatString(strVal)
	{
		document.write(strVal.replace(/,/g, ", " ));
	}

	function formatStringToLength(strVal,numLength)  
	{                                     
		for(var i= 0; i < strVal.length; i+=numLength)
		{       if ((i + numLength)<= strVal.length)
			{
				document.write(strVal.slice(i, i + numLength) + '<BR>');
			}
			else
			{
				document.write(strVal.slice(i, strVal.length) + '<BR>');				
			}
		}       
	}	
	
	function CleanForID(sVal)
	{

		var t = /\'|\"|\<|\>|\:|\=|\/|\;|\.|\s|\?|\#/gi; 

		sVal = sVal.replace(t, ""); 
		return sVal
	}

	function ToggleLayer(glayer)
	{

		var timg = 'i-' + glayer
		var trow = 'r-' + glayer

		for(var i=0;i < document.images.length; i++)
		{
			var obj = document.images[i];
			if(obj.id == timg)
			{
				if(obj.src.indexOf("drillDown.gif") > -1)
					obj.src = "drillDownSelected.gif";
				else if(obj.src.indexOf("drillDownSelected.gif") > -1)				
					obj.src = "drillDown.gif"
				else if(obj.src.indexOf("minimize2.gif") > -1)
					obj.src = "maximize2.gif";
				else if(obj.src.indexOf("maximize2.gif") > -1)
					obj.src = "minimize2.gif";
			}
		}

		var x = document.getElementsByTagName('tr');
		for (var i=0;i<x.length;i++)
		{
			var obj = x[i];
			if(obj.id == trow)
			{
				var style2 = x[i].style;
				style2.display = style2.display == "none"? "":"none";
			}
		}

	}
	
	function SetKeywords(eng,keys)
	{
		if(eng.selectedIndex == -1)
			return;

		var selEng = eng[eng.selectedIndex].value
		var sArray = Jump2[selEng]

		for (var i=(keys.options.length-1); i>=0; i--)
		{ 
			keys.options[i] = null; 
		} 
		for(var i in sArray )
		{
			keys.options[keys.length] = new Option( sArray[i], sArray[i], false, false);
		}
	}
//Jump


	function OpenNewWindow(url,title,width,height)
	{
		window.open(url,title,'scrollbars=yes,resizable=yes,toolbar=no,menubar=no,width=' + width + ',height=' + height);
	}

	function DrawHeader()
	{

		var retV = '';
		retV += '<table border="0" width="820" cellspacing="0" cellpadding="0"><tr height="25">'
		var cnt = 0;
		for(var i in Reports)
		{
			if (menuDisplayCustom ==1)
			{ if ( i==4 || i==5 || i==6 || i== 9 || i== 10 || i==11 || i==12)
			  { 
				// dont display these menu items
				if (i== 12) 
				{
					retV += '<td cellspacing="0" cellpadding="0" class="menu_lc" ></td>'
					+	'<td align="center" cellspacing="0" cellpadding="0" width="' + 60 * 7 +'" class="menu_c" >'
					+	'&nbsp;&nbsp;sdfd</nobr>'
					+	'</td>'
					+	'<td cellspacing="0" cellpadding="0" class="menu_rc" ></td>'
				}
			  } 
			  if(menuItem[i] == 1 ){
				if(CurPage == i)
				{			
					retV += '<td cellspacing="0" cellpadding="0" class="menusel_lc" ></td>'
					+	'<td align="center" cellspacing="0" cellpadding="0" width="' + Reports[i][3] + '" class="menusel_c" >'
					+	'<a href="' + Reports[i][2] + '" title="' + Reports[i][1] + '" cellspacing="0" cellpadding="0" >' + Reports[i][0] + '</a>'
					+	'</td>'
					+	'<td cellspacing="0" cellpadding="0" class="menusel_rc" ></td>'
				}
				else
				{
					retV += '<td cellspacing="0" cellpadding="0" class="menu_lc" ></td>'
					+	'<td align="center" cellspacing="0" cellpadding="0" width="' + Reports[i][3] + '" class="menu_c" >'
					+	'<a href="' + Reports[i][2] + '" title="' + Reports[i][1] + '">' + Reports[i][0] + '</a></nobr>'
					+	'</td>'
					+	'<td cellspacing="0" cellpadding="0" class="menu_rc" ></td>'
				}
				cnt += Reports[i][3] + 12
				}
			}
			else 
			/* */
			{
				if(CurPage == i)
				{			
					retV += '<td cellspacing="0" cellpadding="0" class="menusel_lc" ></td>'
					+	'<td align="center" cellspacing="0" cellpadding="0" width="' + Reports[i][3] + '" class="menusel_c" >'
					+	'<a href="' + Reports[i][2] + '" title="' + Reports[i][1] + '" cellspacing="0" cellpadding="0" >' + Reports[i][0] + '</a>'
					+	'</td>'
					+	'<td cellspacing="0" cellpadding="0" class="menusel_rc" ></td>'
				}
				else
				{
					retV += '<td cellspacing="0" cellpadding="0" class="menu_lc" ></td>'
					+	'<td align="center" cellspacing="0" cellpadding="0" width="' + Reports[i][3] + '" class="menu_c" >'
					+	'<a href="' + Reports[i][2] + '" title="' + Reports[i][1] + '">' + Reports[i][0] + '</a></nobr>'
					+	'</td>'
					+	'<td cellspacing="0" cellpadding="0" class="menu_rc" ></td>'
				}
				cnt += Reports[i][3] + 12
			}
		}
		if((820 - cnt) > 0)
			retV += '<td style="border-bottom: 1px solid #CCCCCC;" width="' + (820 - cnt) + '">&nbsp;</td></tr></table>'

		document.write (retV)

	}

function DrawTitle()
{
	var retV = ''
	retV += '<table bgcolor="FAFAFF" width="820" style="border: 1px solid #CCCCCC;border-top: none;" cellspacing="0" cellpadding="0">'
		+ '<tr height="3" bgcolor="FFFFFF"><td colspan="2"></td></tr>'
		+ '<tr><td colspan="2" height="10" ></td></tr>'
		+ '<tr> '
		+ '<td class="blk_Font_11px_Bold" width="600" style="padding-left: 16px;">' + Reports[CurPage][0] + ' Report for: '

		var Sites = DomainsStr.split(",");
		for (var i = 0; i < Sites.length; i++)
		{
			var site = Sites[i].replace(" ","");
			retV += '<a href="Javascript:OpenNewWindow(\'http://' + site + '\',\'site\',800,600);"><font style="font-weight:bold;font-size:11px;text-decoration : none;color : #E39215;font-family : Arial, Helvetica, sans-serif;">' + site + '</font></a>'

			if (i < Sites.length -1)
				retV += ', ';
		}
	
	retV	+= '</td><td align="right" style="padding-right: 16px;"><font class="blk_Font_11px_Bold">' + DateStr + '</font></td>'
		+ '</tr>'
		+ '<tr><td class="blk_Font_11px" colspan="2" style="padding-left: 16px;padding-right: 16px;">' + Reports[CurPage][1] + '<BR><BR></td>'
		+ '</tr>'
		+ '</table><table><tr><td height="1"></td></tr></table>'
		+ '<table bgcolor="FAFAFF" width="820" style="border: 1px solid #CCCCCC;" cellspacing="0" cellpadding="0">'

	document.write(retV);
}


	function ExpandAllNodes()
	{
		for(var i=0;i < document.images.length; i++)
		{
			var obj = document.images[i];
			if(obj.id.indexOf('i-') == 0)
			{
				if(obj.src.indexOf("drillDown.gif") > -1)					
					obj.src = "drillDownSelected.gif"
				else if(obj.src.indexOf("minimize2.gif") > -1)
					obj.src = "maximize2.gif";
			}
		}

		var x = document.getElementsByTagName('tr');
		for (var i=0;i<x.length;i++)
		{
			var obj = x[i];
			if(obj.id.indexOf('r-') == 0)
			{
				var style2 = x[i].style;
				style2.display = "";				
			}
		}
	}

	function CollapseAllNodes()
	{
		for(var i=0;i < document.images.length; i++)
		{
			var obj = document.images[i];
			if(obj.id.indexOf('i-') == 0)
			{
				if(obj.src.indexOf("drillDownSelected.gif") > -1)					
					obj.src = "drillDown.gif"
				else if(obj.src.indexOf("maximize2.gif") > -1)
					obj.src = "minimize2.gif";
			}
		}

		var x = document.getElementsByTagName('tr');
		for (var i=0;i<x.length;i++)
		{
			var obj = x[i];
			if(obj.id.indexOf('r-') == 0)
			{
				var style2 = x[i].style;
				style2.display = "none";				
			}
		}

	}

	function ToggleAllNodes(myObj, eType)
	{
		if(myObj.src.indexOf("maximize2.gif") > -1)
		{
			CollapseAllNodes();
			myObj.title = 'Expand All ' + eType
		}
		else
		{
			ExpandAllNodes();
			myObj.title = 'Collapse All ' + eType
		}
	}

	function FormatData(myData,ColName)
	{
		//Check against Competitors
		if(typeof(Competitors) != 'undefined')
		{
			for(var i = 0; i < Competitors.length; i++)
			{
				if(Competitors[i] == myData)
					myData = myData + ' *';
			}
		}


		if(ColName == "Change")
		{
			myData = SetArrow(myData);
		}
		else
		{
			var re = new RegExp(/\<a href\=/i);
			if(! myData.match(re))
			{
				var t;
				re = new RegExp(/\http:\/\//i);
				if (myData.match(re))
				{
					var myData2 = ''

					t = /([^ \t\n\r\f\v\/]{10,}?)/g;
					myData2 = myData.replace(t,'$1<WBR>');

					t = /\//g;
					myData2 = myData2.replace(t,"/<wbr>");

					myData = '<a href="Javascript:OpenNewWindow(\'' + myData + '\',\'vis\',800,500);" Title="' + myData + '">' + myData2 + '</a>'
				}
				else
				{
					t = /(\S{8,}?)/g;
					myData = myData.replace(t,'$1<WBR>');
				}
			}
		}

		return myData
	}
var 	menuDisplayCustom=0;
var 	menuItem   = new Array();	