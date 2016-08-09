/*
Droit d'auteur
Les sanctions possibles en cas de violation
 
L’utilisation non autorisée de la totalité ou d’une partie importante, constitue une violation du droit d’auteur. Pour savoir si la partie utilisée est importante ou non, il faut tenir compte, entre autres choses, du contexte dans lequel l’emprunt est fait et non seulement de la quantité utilisée. En effet, l’emprunt d’une petite quantité d’une œuvre peut être considéré comme une violation si cela représente la substance ou l’essence de l’œuvre. 
 
Les recours prévus par la Loi sur le droit d’auteur peuvent être de nature civile ou criminelle :
-Recours civils : injonction, dommages-intérêts, dommages exemplaires, etc.
-Recours criminels : amende, emprisonnement.

Toute tentative déloyale sera puni.
*/
if (typeof document.getElementsByClassName != 'function') {
	document.getElementsByClassName = function() {
		var elms = document.getElementsByTagName('*');
		var ei = new Array();
		for (i=0;i<elms.length;i++) {
			if (elms[i].getAttribute('class')) {
				if (typeof elms[i].getAttribute('class')=='string') {
					ecl = elms[i].getAttribute('class').split(' ');
					for (j=0;j<ecl.length;j++) {
						if (ecl[j].toLowerCase() == arguments[0].toLowerCase()) {
							ei.push(elms[i]);
						}
					}
				}
			} else if (elms[i].className) {
				if (typeof elms[i].className=='string') {
					ecl = elms[i].className.split(' ');
					for (j=0;j<ecl.length;j++) {
						if (ecl[j].toLowerCase() == arguments[0].toLowerCase()) {
							ei.push(elms[i]);
						}
					}
				}
			}
		}
		return ei;
	}
}



function _(o) {
	d=document;
	if(o.charAt(0)=="#"){r=d.getElementById(o.slice(1));}
	else if(o.charAt(0)=="."){r=d.getElementsByClassName(o.slice(1))[0];}
	else{r=o;}
	return r;
}

function Q(o){
	return{
		set:function (s,v){
			var px="px";
			var m=o.style;
			if(IsArray(o)==true)for(var i=0;i<=o.length; i++){Q.set(o[i],s,v);}
			else if(IsArray(s)==true)for(var i=0;i<=s.length; i++){Q.set(o,s[i],v);}
			else v=Int(v);
			if(s=="height"){m.height=v+px;}
			else if(s=="width")sm.width=v+px;
			else if(s=="margin-top")m.marginTop=v+px;
			else if(s=="margin-left"){m.marginLeft=v+px;}
			else if(s=="margin-right")m.marginRight=v+px;
			else if(s=="margin-bottom")m.marginBottom=v+px;
			else if(s=="background")m.background=v;/*Syntax = background: color position size repeat origin clip attachment image;*/
			else if(s=="background-color")m.backgroundColor="#"+v;
			else if(s=="background-position")m.backgroundPosition=v;/*Syntax = xpos ypos (px ou %)*/
			else if(s=="opacity"){
			m.filter ="progid:DXImageTransform.Microsoft.Alpha(opacity="+v+")";
			m.filter = "alpha(opacity="+v+")";
			m.MozOpacity = v/100;
			m.KhtmlOpacity = v/100;
			m.opacity = v/100;
			}else if(s=="z-index")m.zIndex=v;
			else if(s=="html")o.innerHTML=v;
		},
		get:function(s){
			var r;
			if(s=="height")r=o.style.height;
			else if(s=="width")r=o.style.width;
			else if(s=="margin-top")r=o.style.marginTop;
			else if(s=="margin-right")r=o.style.marginRight;
			else if(s=="margin-bottom")r=o.style.marginBottom;
			else if(s=="margin-left")r=o.style.marginLeft;
			else if(s=="background")r=o.style.background;
			else if(s=="background-color")r=o.style.backgroundColor;
			else if(s=="background-position")r=o.style.backgroundPosition;
			else if(s=="opacity")r=o.style.opacity*100;
			else if(s=="z-index")r=o.style.zIndex=v;
			else if(s=="html")r=o.innerHTML=v;
			r=r.replace("px","");
			return r.replace("#","");
		},
		width:function(){return o.clientWidth;},
		height:function(){return o.clientHeight;},
		left:function(){return o.clientLeft;},
		top:function(){return o.clientTop;},
		resolutionW:function(){if (document.body)return document.body.clientWidth;else return window.innerWidth},
		resolutionH:function(){if (document.body)return document.body.clientHeight;else return window.innerHeight},
		objetH:function(){if (document.body)return o.clientHeight},
		getOffset:function(){
			var x=0,y=0;
			return {
				top:function(){
				
					while(o && !isNaN(o.offsetTop)){
						y+=o.offsetTop;
						o=o.offsetParent;
					}return y;
					
				},
				left:function(){
					while(o && !isNaN(o.offsetLeft)){
						x+=o.offsetLeft;
						o=o.offsetParent;
					}return x;
				}
			}
		},
		_filter:function(w,d,b){var n=w?w:0;if (d&&(!n||(n>d)))n=d;return b&&(!n||(n>b))?b:n;},
		objetW:function () {
			return Q._filter (
				window.innerWidth ? o.innerWidth : 0,
				document.documentElement ? o.clientWidth : 0,
				document.body ? o.clientWidth : 0
			);
		},
		objetH:function() {
			return Q._filter (
				window.innerHeight ? o.innerHeight : 0,
				document.documentElement ? o.clientHeight : 0,
				document.body ? o.clientHeight : 0
			);
		},
		_clientWidth:function () {
			return Q._filter (
				window.innerWidth ? window.innerWidth : 0,
				document.documentElement ? document.documentElement.clientWidth : 0,
				document.body ? document.body.clientWidth : 0
			);
		},
		_clientHeight:function() {
			return Q._filter (
				window.innerHeight ? window.innerHeight : 0,
				document.documentElement ? document.documentElement.clientHeight : 0,
				document.body ? document.body.clientHeight : 0
			);
		},
		_scrollLeft:function() {
			r= Q._filter (
				window.pageXOffset ? window.pageXOffset : 0,
				document.documentElement ? document.documentElement.scrollLeft : 0,
				document.body ? document.body.scrollLeft : 0
			);return r;
		},
		_scrollTop:function() {
			return Q._filter (
				window.pageYOffset ? window.pageYOffset : 0,
				document.documentElement ? document.documentElement.scrollTop : 0,
				document.body ? document.body.scrollTop : 0
			);
		},
		parallax:function(objet,mir,ratioZ,r){
			//object//
			//mir//==interieur object
			//ratioZ//z
			//r//ration
			//alert(((Q.getOffset(objet).left()-Q._clientWidth()/2)/Q._clientWidth()/2)*100);
			//alert(((/Q._clientWidth()/2)*(r+ratioZ)*100-(Q.get(mir,"width")-)/2)+"px");/
			//(
			
			//alert(((Q.getOffset(objet).left()-Q._clientWidth()/2)/(Q._clientWidth()/2)) * Q.get(mir,"width")/Q.get(objet,"width"));
			//mir.style.marginLeft=(((Q.getOffset(objet).left()-Q._clientWidth()/2)/Q._clientWidth()/2)*(r+ratioZ)*100-(Q.get(mir,"width")-Q.get(objet,"width"))/2)+"px";
			
			//getOffset
		}
	}
}
/*
ready: function(f) {
		// If the DOM is already ready
		if ( jQuery.isReady )
			// Execute the function immediately
			f.apply( document );
			
		// Otherwise, remember the function for later

*/
function Int(i){return parseInt(i)}
function IsArray(a){return!(!a||(!a.length||a.length==0)||a.item||typeof a!=='object'||!a.constructor||a.nodeType)}
function inerti(s,e,c){if(s<=e)return Math.ceil(s+(e-s)/c+0.5);else return Math.floor(s-(s-e)/c-0.5)}
function resolutionW(){if (document.body)return(document.body.clientWidth);else return(window.innerWidth)}
function resolutionH(){if (document.body)return(document.body.clientHeight);else return(window.innerHeight)}
var larg, haut, scrollleft, scrolltop;if (document.body){larg=(document.body.clientWidth);haut=(document.body.clientHeight);scrollleft=(document.body.scrollLeft);scrolltop=(document.body.scrollTop);}else{larg=(window.innerWidth);haut=(window.innerHeight);scrollleft=(window.scrollLeft);scrolltop=(window.scrollTop);}
function set_objet_style(o,s,v){
	var px="px";
	if(IsArray(o)==true)
		for(var i=0;i<=o.length; i++){
			objet_style(o[i],s,v);
		}
	else if(IsArray(s)==true)
		for(var i=0;i<=s.length; i++){
			objet_style(o,s[i],v);
		}
	else v=Int(v);
	if(s=="height")o.style.height=v+px;
	else if(s=="width")o.style.width=v+px;
	else if(s=="margin-top")o.style.marginTop=v+px;
	else if(s=="margin-left")o.style.marginLeft=v+px;
	else if(s=="margin-right")o.style.marginRight=v+px;
	else if(s=="margin-bottom")o.style.marginBottom=v+px;
	else if(s=="background")o.style.background=v;/*Syntax = background: color position size repeat origin clip attachment image;*/
	else if(s=="background-color")o.style.backgroundColor="#"+v;
	else if(s=="background-position")o.style.backgroundPosition=v;/*Syntax = xpos(px ou %) ypos(px ou %)*/
	else if(s=="opacity"){
		o.style.filter ="progid:DXImageTransform.Microsoft.Alpha(opacity="+v+")";
		o.style.filter = "alpha(opacity="+v+")";
		o.style.MozOpacity = v/100;
		o.style.KhtmlOpacity = v/100;
		o.style.opacity = v/100;
	}
	else if(s=="z-index")o.style.zIndex=v;
	else if(s=="html")o.innerHTML=v;
}
function get_objet_style(o,s){
	var r;
	if(s=="height")r=o.style.height;
	else if(s=="width")r=o.style.width;
	else if(s=="margin-top")r=o.style.marginTop;
	else if(s=="margin-right")r=o.style.marginRight;
	else if(s=="margin-bottom")r=o.style.marginBottom;
	else if(s=="margin-left")r=o.style.marginLeft;
	else if(s=="background")r=o.style.background;
	else if(s=="background-color")r=o.style.backgroundColor;
	else if(s=="background-position")r=o.style.backgroundPosition;
	else if(s=="opacity")r=o.style.opacity*100;
	else if(s=="z-index")r=o.style.zIndex=v;
	else if(s=="html")r=o.innerHTML=v;
	r=r.replace("px","");
	return r.replace("#","");
}
function anim(o,s,v){
	if (o.widthChangeMemInt)window.clearInterval(o.widthChangeMemInt);
	o.widthChangeMemInt = window.setInterval(
		function(){
			ac=get_objet_style(o,s);
			if(ac!=v){
				ac=inerti(ac*100,v*100,10)/100;
				set_objet_style(o,s,ac);
			}else window.clearInterval(o.widthChangeMemInt);
		},30
	);
}
function include(f,t){
	if(t=="javascript")document.write('<script type="text/javascript" src="'+f+'"><\/script>');
	if(t=="script")document.write('<script src="'+f+'"><\/script>');
}
/*non-exclusif*/
include("http://html5shiv.googlecode.com/svn/trunk/html5.js");
document.createElement("header");
document.createElement("footer");
document.createElement("section");
document.createElement("nav");
document.createElement("menu");
document.createElement("aside");
document.createElement("figure");
document.createElement("figcaption");
/*fin-du non-exclusif*/
include("js/sliderCirle3d.js","script");


function setStyle(objId, style, value) {
  document.getElementById(objId).style[style] = value;
}

/*
function getStyle(el, style) {
  if(!document.getElementById) return;
 
   var value = el.style[toCamelCase(style)];
 
  if(!value)
    if(document.defaultView)
      value = document.defaultView.
         getComputedStyle(el, "").getPropertyValue(style);
   
    else if(el.currentStyle)
      value = el.currentStyle[toCamelCase(style)];
  
   return value;
}
function toCamelCase( sInput ) {
  var oStringList = sInput.split('-');
  if(oStringList.length == 1)  
    return oStringList[0];
  var ret = sInput.indexOf("-") == 0 ?
      oStringList[0].charAt(0).toUpperCase() + oStringList[0].substring(1) : oStringList[0];
  for(var i = 1, len = oStringList.length; i < len; i++){
    var s = oStringList[i];
    ret += s.charAt(0).toUpperCase() + s.substring(1)
  }
  return ret;
}

*/



