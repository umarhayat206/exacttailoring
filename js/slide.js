/*
Copyright (c) 2007, Datography! Inc. All rights reserved.
version: 1.0.0.1
*/

//-- System    
tpagemanager = function () {
    //this._dragobject = null;
    this._slider = null;
    this.mousemove = function (evnt) {  
        if (!evnt) evnt = window.event;
        if (this._slider) {
	    	x = this._slider.startOffsetX + evnt.screenX; // Horizontal mouse position relative to allowed slider positions
    	    y = this._slider.startOffsetY + evnt.screenY; // Horizontal mouse position relative to allowed slider positions
    	    if (x < this._slider.min)
    	        x = 0
    	    else if (x > this._slider.max)
    	        x = this._slider.max;
    	        
    	    x = Math.round(x / this._slider.slider.step) * this._slider.slider.step;
    	     
  	        y = 0;	
    	    this.elementleft(this._slider, x);
    	    if (this._slider.slider.doonchange)
    	        this._slider.slider.doonchange();
        }   
    }        
    this.mouseup = function () {
        if (this._slider) {
            this._slider = null;
            document.onmousemove = null;
            document.onmouseup = null;
        }            
    }
    this.elementleft = function (ele, pos) {
        if (!ele.posleft) ele.posleft = 0;
        if (pos) {
            ele.style.left = pos+'px';
            ele.posleft = pos;
        }
        return ele.posleft;
    }
    this.elementtop = function (ele, pos) {
        if (!ele.postop) ele.postop = 0;
        if (pos) {
            ele.style.top = pos+'px';
            ele.postop = pos;
        }
        return ele.postop;
    }   
    this.slide = function (evnt) {
    	if (!evnt) evnt = window.event;
        this._slider = (evnt.target) ? evnt.target : evnt.srcElement;
        this._slider.startOffsetX = this.elementleft(this._slider) - evnt.screenX; 
        this._slider.startOffsetY = this.elementtop(this._slider) - evnt.screenY;
        document.onmousemove = function (e) { pagemanager.mousemove(e); };
        document.onmouseup = function (e) { pagemanager.mouseup(e); };
    }
}
pagemanager = new tpagemanager();


//-- Control    
var tslider_orienation = {
    horizontal:0,
    verticle:1
};

tslider = function (ele, dualslider) {
    this._div = ele;
    this._pointers = new Array();
    this.orientation = tslider_orienation.horizontal;
    this.dualslider = dualslider;
    this.min = 0;
    this.max = 100;
    this.step = 1;
    //-- Private
    this._addpointer = function (pos) {
        //var p = document.createElement('<div class="slider_point" onmousedown="pagemanager.slide();"></div>');
        // try statement for mozilla fix not supporting < or > in the createElement string - DPJS 01 Feb 2008
        try {
            var p = document.createElement('<div>');
        } catch(e) {
            var p = document.createElement('div');
        }
        p.className = 'slider_point';
        this._div.appendChild(p);
        pagemanager.elementleft(p, pos);
        p.onmousedown = function (e) { pagemanager.slide(e); };
        this._pointers[this._pointers.length] = p; 
        p.min = this.min;           
        p.max = this.max;
        p.slider = this;
    }
    this._settext = function () {
        if (this.textcontrol) {
            var text = '';
            if (this.minvalue == this.maxvalue)
                text = this.displayvalues[this.minvalue];
            else
            if ((this.minvalue == 0)&&(this.maxvalue == this.values.length-1))
                text = 'no limit'
            else
            if (this.minvalue == 0)
                text = 'up to ' + this.displayvalues[this.maxvalue];
            else
            if (this.maxvalue == this.values.length-1)
                text = this.displayvalues[this.minvalue];
            else
                text = this.displayvalues[this.minvalue] + ' - ' + this.displayvalues[this.maxvalue];
            this.textcontrol.innerHTML = text;
        }    
    }
    this.doonchange = function () {
        if (this.dualslider) {
            this._pointers[1].min = this._pointers[0].posleft + 12;
            this._pointers[0].max = this._pointers[1].posleft - 12;
            this.minvalue = this.value = Math.round(this._pointers[0].posleft / (this.max / (this.values.length-1)));
            this.maxvalue = Math.round(this._pointers[1].posleft / (this.max / (this.values.length-1)));
        } else {
            this.value = Math.round(this._pointers[0].posleft / (this.max / (this.values.length-1)));
            this.minvalue = this.maxvalue = this.value;
        }
        this._settext();
        if (this.onchange) {
            this.onchange();
        }
    }
    this.IndexOf = function (value) {
        for (i=0; i<this.values.length; i++) {
            if (this.values[i] == value) 
                return i;
        }
        return -1;
    }
    //-- Public
    this.init = function (from, to) {
        var frompos = 0;
        var topos = this.max;
        if (from) {
            i = this.IndexOf(from);
            if (i > -1) 
                frompos = Math.round(i * (this.max / this.values.length));
        }                        
        if (to) {
            i = this.IndexOf(to);
            if (i > -1) 
                topos = Math.round((i + 1) * (this.max / this.values.length));
        }                                
        this._addpointer(frompos);
        if (dualslider) {
            this._addpointer(topos);
        }   
        this.doonchange();         
    }
} 

