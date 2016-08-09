/*
Droit d'auteur François Longchamp/ Copyright François Longchamp
Propriété intellectuel de François Longchamp 
Les sanctions possibles en cas de violation
 
L’utilisation non autorisée de la totalité ou d’une partie importante, constitue une violation du droit d’auteur. Pour savoir si la partie utilisée est importante ou non, il faut tenir compte, entre autres choses, du contexte dans lequel l’emprunt est fait et non seulement de la quantité utilisée. En effet, l’emprunt d’une petite quantité d’une œuvre peut être considéré comme une violation si cela représente la substance ou l’essence de l’œuvre. 
 
Les recours prévus par la Loi sur le droit d’auteur peuvent être de nature civile ou criminelle :
-Recours civils : injonction, dommages-intérêts, dommages exemplaires, etc.
-Recours criminels : amende, emprisonnement.

Toute tentative déloyale sera puni.
*/
if(typeof(cache)=='undefined')cache={};
cache.timer = 30;


(function(window,undefined){
     return 'undefined';
 })(window);
include("http://html5shiv.googlecode.com/svn/trunk/html5.js");
(function(){var h = "address|article|aside|audio|canvas|command|datalist|details|summary|dialog|figure|figcaption|footer|header|hgroup|keygen|mark|meter|menu|nav|progress|ruby|section|time|video".split('|');for(var i = 0; i < h.length; i++){document.createElement(h[i]);}})();
include("iepngfix/iepngfix_tilebg.js");
if (typeof document.getElementsByClassName != 'function') {
	document.getElementsByClassName = function() {
		var e = document.getElementsByTagName('*');
		var a = new Array();
		for (i=0;i<e.length;i++) {
			if (e[i].getAttribute('class')) {
				if (typeof e[i].getAttribute('class')=='string') {
					c = e[i].getAttribute('class').split(' ');
					for (j=0;j<c.length;j++) {
						if (c[j].toLowerCase() == arguments[0].toLowerCase()) {
							a.push(e[i]);
						}
					}
				}
			} else if (e[i].className) {
				if (typeof e[i].className=='string') {
					c = e[i].className.split(' ');
					for (j=0;j<c.length;j++) {
						if (c[j].toLowerCase() == arguments[0].toLowerCase()) {
							a.push(e[i]);
						}
					}
				}
			}
		}
		return a;
	}
}
function toCamelCase( sInput ) {var oStringList = sInput.split('-');if(oStringList.length == 1) return oStringList[0];
	var r = sInput.indexOf("-") == 0 ?oStringList[0].charAt(0).toUpperCase() + oStringList[0].substring(1) : oStringList[0];
	for(var i = 1, len = oStringList.length; i < len; i++){
		var s = oStringList[i];
		r += s.charAt(0).toUpperCase() + s.substring(1);
	}
	return r;
}

function include(f,t){
	if(t=="javascript")document.write('<script type="text/javascript" src="'+f+'"><\/script>');
	if(t=="script")document.write('<script src="'+f+'"><\/script>');
	if(t=="style" || t=="css")document.write('<style type="text/css">@import url("'+f+'");</style>');
}
function getInternetExplorerVersion()
{
  var rv = -1; 
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}

if (typeof addEvent != 'function')
{
 var addEvent = function(o, t, f, l)
 {
  var d = 'addEventListener', n = 'on' + t, rO = o, rT = t, rF = f, rL = l;
  if (o[d] && !l) return o[d](t, f, false);
  if (!o._evts) o._evts = {};
  if (!o._evts[t])
  {
   o._evts[t] = o[n] ? { b: o[n] } : {};
   o[n] = new Function('e',
    'var r = true, o = this, a = o._evts["' + t + '"], i; for (i in a) {' +
     'o._f = a[i]; r = o._f(e||window.event) != false && r; o._f = null;' +
     '} return r');
   if (t != 'unload') addEvent(window, 'unload', function() {
    removeEvent(rO, rT, rF, rL);
   });
  }
  if (!f._i) f._i = addEvent._i++;
  o._evts[t][f._i] = f;
 };
 addEvent._i = 1;
 var removeEvent = function(o, t, f, l)
 {
  var d = 'removeEventListener';
  if (o[d] && !l) return o[d](t, f, false);
  if (o._evts && o._evts[t] && f._i) delete o._evts[t][f._i];
 };
}
function cancelEvent(e, c)
{
 e.returnValue = false;
 if (e.preventDefault) e.preventDefault();
 if (c)
 {
  e.cancelBubble = true;
  if (e.stopPropagation) e.stopPropagation();
 }
};


var editorDoc;
var object=new Object;
object.opacity=100;
function isString(v){return typeof(v)=='string'};
function Q(o,op){
	/*(this.isString(o)&&o!='')?
		(o.charAt(0)==='#')?o=document.getElementById(o.substr(1)):
		(o.charAt(0)==='.')?o=(op)?document.getElementsByClassName(o.substr(1))[op]:document.getElementsByClassName(o.substr(1)):
		o=(op)?document.getElementsByTagName(o.substr(1))[op]:document.getElementsByTagName(o.substr(1)):0;*/
	return{
		parallax:function(b,v,op){
		var r=0,set='',a=0,mir=b.parentNode,addLeft=0,addTop=0,diffLeft=0,diffTop=0,ratio=1,W=1,H=1;
			for(x in op){
				switch(x){
					case 'set':(op[x]=='margin')?set='margin-':0;break;
					case 'mir':mir=op[x];break;
					case 'addLeft':addLeft=op[x];break;
					case 'addTop':addTop=op[x];break;
					case 'W':W=op[x];break;
					case 'H':H=op[x];break;
					case 'ratio':ratio=op[x];break;
				}
			}
			for(x in v){
				a=[],r=0;
				switch(x){
					case 'top':
						(v[x]=='auto')?r=Q(o).get('height')/H-1:r=v[x]/100;
						(ratio)?r*=ratio:0;
						a[set+'top']=Math.round(((Q(b).get('top')*1+diffTop*1)-Q(mir).get('top')*1)*r)+addTop;
						Q(o).set(a);
					break;
					case 'left':
						(v[x]=='auto')?r=(Q(o).get('width')/W-1):r=v[x]/100;
						(ratio)?r*=ratio:0;
						a[set+'left']=Math.round(((Q(b).get('left')*1+diffLeft*1)-Q(mir).get('left')*1)*r)+addLeft;
						Q(o).set(a);
					break;
					case 'margin-top': this.set({'margin-top':(Q(b).get('top')-Q(mir).get('top'))*v[x]});break;
					case 'margin-left': this.set({'margin-left':(Q(b).get('left')-Q(mir).get('left'))*v[x]});break;
				}
			}
		},
		set:function (v){
			for (x in v){
				if(!v[x] || v[x]=="" )break;var t=false;
				switch(x){
					case 'opacity':o.style.filter ="progid:DXImageTransform.Microsoft.Alpha(opacity="+v[x]*1+")";o.style.filter = "alpha(opacity="+v[x]*1+")";o.style.MozOpacity = v[x]/100;o.style.KhtmlOpacity = v[x]/100;o.style.opacity = v[x]/100;o.opacity=v[x];break;
					case 'width':if(v[x].indexOf('%')==-1)o.style.width=v[x]+'px';else o.style.width=v[x];break;
					case 'height':if(v[x].indexOf('%')==-1)o.style.height=v[x]+'px';else o.style.height=v[x];break;
					case 'left':if(v[x].indexOf('%')==-1)o.style.left=v[x]+'px';else o.style.left=v[x];break;
					case 'margin-left':if(typeof(o.style)=="object")if(v[x].indexOf('%')==-1)o.style.marginLeft=v[x]+'px';else o.style.marginLeft=v[x];break;
					case 'padding-left':if(v[x].indexOf('%')==-1)v[x]+='px';t=true;break;
					case 'top':if(v[x].indexOf('%')==-1)o.style.top=v[x]+'px';else o.style.top=v[x];break;
					case 'margin-top':if(v[x].indexOf('%')==-1)o.style.marginTop=v[x]+'px';else o.style.marginTop=v[x];break;
					case 'background-position-y':r=o.style.backgroundPosition.split(' ');
					(r[0]==undefined || r[0]=='-' || !r[0] || r[0]==null || r[0]=='')?r='0px':r=r[0];
					o.style.backgroundPosition=r+' '+v[x]+'px';break;
					case 'background-position-x':r=o.style.backgroundPosition.split(' ');
					(r[1]==undefined || r[1]=='-' || !r[1] || r[1]==null || r[1]=='')?r='0px':r=r[1];
					o.style.backgroundPosition=v[x]+'px '+r;break;
					case 'z-index':o.style.zIndex=v[x];break;
					case 'padding':o.style.padding=v[x]+'px';break;
					
					case 'background-image':o.style.backgroundImage=v[x];break;
					case 'background-color':o.style.backgroundColor=v[x];break;
					case 'background-position':o.style.backgroundPosition=v[x];break;
					case 'margin-right':o.style.marginRight=v[x]+'px';break;
					case 'margin-bottom':o.style.marginBottom=v[x]+'px';break;
					case 'background-image':o.style.backgroundImage='url('+v[x]+')';break;
					case 'border-width':o.style.borderWidth=v[x]+'px';borderWidth=v[x];break;
					case 'border-color':o.style.borderColor='#'+v[x];break;
					case 'color':o.style.color=v[x];break;
					case 'display':o.style.display=v[x];break;
					case 'html':o.innerHTML=v[x];break;
					case 'position':o.style.position=v[x];break;
					default:
						if(o.style.setProperty){
							o.style.setProperty (x, v[x], null);
						}else if(o.style.setAttribute){
							o.style.setAttribute (x, v[x]);
						}else{
							o.style[x]=v[x];
						}
					;
				}
				
				if( t==true ){
					if(o.style.setProperty){
						o.style.setProperty (x, v[x], null);
					}else if(o.style.setAttribute){
						o.style.setAttribute (x, v[x]);
					}else{
						o.style[x]=v[x];
					}
				}
				
			}
			
		},
		viewport:function(){
			var e = window, a = 'inner';if ( !( 'innerWidth' in window ) ){
				a = 'client';
				e = document.documentElement || document.body;
			}
			return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
		},
		viewportWidth:function(){
			var e = window, a = 'inner';if ( !( 'innerWidth' in window ) ){
				a = 'client';
				e = document.documentElement || document.body;
			}
			return e[ a+'Width' ];
		},
		viewportHeight:function(){
			var e = window, a = 'inner';if ( !( 'innerWidth' in window ) ){
				a = 'client';
				e = document.documentElement || document.body;
			}
			return e[ a+'Height' ];
		},
		
		clientWidth:function () {
			return this.fR (
				window.innerWidth ? window.innerWidth : 0,
				document.documentElement ? document.documentElement.clientWidth : 0,
				document.body ? document.body.clientWidth : 0
			);
		},
		clientHeight:function () {
			return this.fR (
				window.innerHeight ? window.innerHeight : 0,
				document.documentElement ? document.documentElement.clientHeight : 0,
				document.body ? document.body.clientHeight : 0
			);
		},
		scrollLeft:function () {
			return this.fR (
				window.pageXOffset ? window.pageXOffset : 0,
				document.documentElement ? document.documentElement.scrollLeft : 0,
				document.body ? document.body.scrollLeft : 0
			);
		},
		scrollTop:function () {
			return this.fR (
				window.pageYOffset ? window.pageYOffset : 0,
				document.documentElement ? document.documentElement.scrollTop : 0,
				document.body ? document.body.scrollTop : 0
			);
		},
		fR:function (w, d, b) {
			var r=w ? w : 0;
			if (d && (!r || (r > d))) r = d;
			return b && (!r || (r > b)) ? b : r;
		},
		getStyle:function(s){
			var r=0;
			if (o.currentStyle)
				r=o.currentStyle[s];
			else if(window.getComputedStyle)
				r=document.defaultView.getComputedStyle(o,null).getPropertyValue(s);
			return r;
		},
		get:function(v){
			var r=0;
			switch(v){
				case 'width': r= o.clientWidth;break;
				case 'height': r= (o)?o.clientHeight:0;break;
				case 'left': x=0;while(o && !isNaN(o.offsetLeft)){x+=o.offsetLeft;o=o.offsetParent;}r= x;break;
				case 'top': x=0;while(o && !isNaN(o.offsetTop)){x+=o.offsetTop;o=o.offsetParent;}r= x;break;
				case 'margin-top': r=(o.style.marginTop && !isNaN(o.style.marginTop))?o.style.marginTop:o.offsetTop; break;
				case 'margin-left': r=(o.style.marginLeft && !isNaN(o.style.marginLeft))?o.style.marginLeft:o.offsetLeft; break;
				
				case 'margin-right': r= o.style.marginRight;break;
				case 'margin-bottom': r= o.style.marginBottom;break;
				case 'background-position': r= o.style.backgroundPosition;break;
				case 'background-position-x':r=o.style.backgroundPosition.split(' ');
				r= (r[0]==undefined || r[0]=='-' || !r[0] || r[0]==null || r[0]=='')?0:r[0].replace("px", "");break;
				case 'background-position-y':r=o.style.backgroundPosition.split(' ');
				r= (r[1]==undefined || r[1]=='-' || !r[1] || r[1]==null || r[1]=='')?0:r[1].replace("px", "");break;
				case 'background-color': r= o.style.backgroundColor;break;
				
				case 'padding': r= (o.padding)?o.padding:o.padding=0;break;
				case 'border-width': r= (o.borderWidth)?o.borderWidth:o.borderWidth=0;break;
				case 'border-color': r= o.style.borderColor;break;
				case 'color': r= o.style.color;break;
				case 'z-index':r= (o.padding)?o.padding:o.padding=0;break;
				case 'display': r= o.style.display;break;
				case 'html': r= o.innerHTML;break;
				case 'opacity': r= (o.opacity)?o.opacity:o.opacity=object.opacity;break;
				default:
					if (o.style.getPropertyValue) {
						r=o.style.getPropertyValue (v);
					} else {
						r=o.style.getAttribute (v);
					}
					if(r=='')r=0;
				;
			}
			//alert(o.style.padding);
			if( r ){
			if(r.toString().indexOf("px")!=-1){
				return r.replace("px", "");
			}else if(r.toString().indexOf("%")!=-1){
				return r.replace("%", "");
			}}
			return r;
		},
		inerti:function(s,e,c){if(s<=e)return Math.ceil(s+(e-s)/c+0.5);else return Math.floor(s-(s-e)/c-0.5)},
		animate:function(e,opt,f){
			var a=[], i=0*1, b=0*1, c=[], v=0*1, d=0*1, timer=30*1, inertie=5*1;
			if(opt){
				if(opt){
					for(v in opt){
						switch(v){
							case 'timer': var timer=(opt[v]==0)?2:opt[v];break;
							case 'continu': var continu=(opt[v]==0)?2:opt[v];break;
							case 'inertie': var inertie=(opt[v]==0)?2:opt[v];break;
						}
					}
				}else{timer=opt;}
			}
			for(s in e){
				if(e[s].toString().indexOf('%')!=-1){
					v=Math.round(e[s].replace('%',''));
					//dp=Math.round(Q(o.parentNode).get('width'));
					d=Math.round(Q(o).get(s));
					//d=d/dp*100;
					//alert(d);
					a[s]=[];
					while(d!=v){
						d=Math.round(Q().inerti(d*10,v*10,inertie*1))/10;
						a[s].push(d.toString()+'%');
						//alert(d.toString());
					}
					b++;
				}else{
					v=Math.round(e[s]);d=(Q(o).get(s) && !isNaN(Q(o).get(s)))?Math.round(Q(o).get(s))*1:0;a[s]=[];
					while(d!=v){d=Math.round(Q().inerti(d,v,inertie*1));a[s].push(d.toString());}
					b++;
				}
			}
			if (o.widthChangeMemInt)(continu)?0:window.clearInterval(o.widthChangeMemInt);
			o.widthChangeMemInt=window.setInterval(
				function(){
					if(b==0){window.clearInterval(o.widthChangeMemInt);
					}else{
						for(s in a){
							(a[s].length==i)?b--:c[s]=a[s][i];
						}
						Q(o).set(c);i++;
					}(f)?f.apply():0;
				},timer
			);
		},
		fixPageXY:function(){
			if (o.pageX == null && o.clientX != null ) {
			var html = document.documentElement;
			var body = document.body;
			o.pageX = o.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
			o.pageX -= html.clientLeft || 0;
			o.pageY = o.clientY + (html.scrollTop || body && body.scrollTop || 0);
			o.pageY -= html.clientTop || 0;
			}
		},
		mousePos:function(){
			o = o || window.event;
			this.fixPageXY();
			a=[];a['x']=o.pageX;a['y']=o.pageY;
			return a;
		},
		mousePosFixed:function(){
			o = o || window.event;
			this.fixPageXY();
			a=[];
			a['x']=o.pageX-this.scrollLeft();
			a['y']=o.pageY-this.scrollTop();
			return a;
		},
		mouseX:function(){
			if (o.clientX)
				return o.clientX + (document.documentElement.scrollLeft ?
				document.documentElement.scrollLeft :
				document.body.scrollLeft);
			else return null;
		},
		mouseY:function(){
		if (o.clientY)
				return o.clientY + (document.documentElement.scrollTop ?
				document.documentElement.scrollTop :
				document.body.scrollTop);
			else return null;
		},
		pageName:function(a){
			if(a){
				a = a.split("?")[0].split("/");
				return a[a.length - 1];
			}else{
				var r=document.URL;
				r = r.split("?")[0].split("/");
				return r[r.length - 1];
			}
		},
		resolutionW:function(){if (document.body)return(document.body.clientWidth);else return(window.innerWidth)},
		resolutionH:function(){if (document.body)return(document.body.clientHeight);else return(window.innerHeight)},
		ScreenX:function(){return window.screen.availWidth},
		ScreenY:function(){return window.screen.availHeight},
		Screen:function(){var a=[];a['x']=window.screen.availWidth;a['y']=window.screen.availHeight;return a},
		getDocHeight:function(){
			var D = document;
			return Math.max(
				Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
				Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
				Math.max(D.body.clientHeight, D.documentElement.clientHeight)
			);
			
		},
		getDocWidth:function(){
			var D = document;
			return Math.max(
				Math.max(D.body.scrollWidth, D.documentElement.scrollWidth),
				Math.max(D.body.offsetWidth, D.documentElement.offsetWidth),
				Math.max(D.body.clientWidth, D.documentElement.clientWidth)
			);
		},
		anim:function(e,mem){
			for(s in e){
				v=e[s];
				c=[];
				i=[];
				(mem)? 0 : mem=0 ;
				if (mem.widthChangeMemInt)window.clearInterval(mem.widthChangeMemInt);
				mem.widthChangeMemInt=window.setInterval(
					function(){
						ac=Q(o).get(s);
						if(ac==v){
							window.clearInterval(mem.widthChangeMemInt);
						}else{
							ac=Q().inerti(ac,v,5);
							c[s]=ac;
							Q(o).set(c);
						}
					},35
				);
				
			}
		},
		setting:function(v){
			for (x in v){
				if(!v[x])break;
				switch(x){
					case 'height':o.height=v[x];break;
					case 'width':o.width=v[x];break;
					case 'top':o.top=v[x];break;
					case 'margin-top':o.marginTop=v[x];break;
					case 'left':o.left=v[x];break;
					case 'margin-left':o.marginLeft=v[x];break;
					case 'margin-right':o.marginRight=v[x];break;
					case 'margin-bottom':o.marginBottom=v[x];break;
					case 'padding':o.padding=v[x];break;
					case 'background':o.background=v[x];break;
					case 'background-color':o.backgroundColor=v[x];break;
					case 'background-position':o.backgroundPosition=v[x];break;
					case 'background-position-x':o.backgroundPositionX=v[x];break;
					case 'background-position-y':o.backgroundPositionY=v[x];break;
					case 'border-width':o.borderWidth=v[x];break;
					case 'border-color':o.borderColor=v[x];break;
					case 'color':o.color=v[x];break;
					case 'z-index':o.zIndex=v[x];break;
					case 'display':o.display=v[x];break;
					case 'opacity':o.opacity=v[x];break;
					default:o.x=v[x];
				}
			}
		},
		click:function(e){o.onclick=e;},
		over:function(e){o.onmouseover=e;},
		out:function(e){o.onmouseout=e;},
		touch:function(s,m,e){
			o.addEventListener('touchstart',s);
			o.addEventListener('touchmove',m);
			o.addEventListener('touchend',function(){
				e();
				o.addEventListener('touchstart',function(){});
				o.addEventListener('touchmove',function(){});
				o.addEventListener('touchend',function(){});
			});
		},
		addEvent:function(type, eventHandle){
			if (o == null || o == undefined) return;
			if ( o.addEventListener ) {
				o.addEventListener( type, eventHandle, false );
			} else if ( o.attachEvent ) {
				o.attachEvent( "on" + type, eventHandle );
			} else {
				o["on"+type]=eventHandle;
			}
		
		},
		timer:function(e){o.timer=setTimeout(o,e)},
		clearTimer:function(){clearTimeout(o.timer)},
		IsArray:function(a){return!(!a||(!a.length||a.length==0)||a.item||typeof a!=='object'||!a.constructor||a.nodeType)},
		isString:function(v){return typeof(v)=='string'},
		Int:function(i){return parseInt(i)},
		ie:function(){return(document.all)?true:false;},
		edit:function(v){
			
			if(v){
				for(x in v){
					switch(x){
						
						default:
							 o.execCommand (x, false, v[x]);
					}
				}
			}else{
				return{
					image:function(v){
						
					},
					video:function(v){
						
					},
					widget:function(v){
						
					},
					Init:function(b){
						(b)?o.contentEditable=true:0;
						(b)?o.designMode="on":0;
					}
				}
			}
			(Q().getIe()<=7)?0:o.focus();
		},
		getSelection: function  () {
			return ( msie ) 
				? document.selection
				: ( window.getSelection || document.getSelection )();
		},
		getRange: function  () {
		  return ( msie ) 
				? getSelection().createRange()
				: getSelection().getRangeAt( 0 )
		},
		parentContainer: function  ( range ) {
			return ( msie )
				? range.parentElement()
				: range.commonAncestorContainer;
		},
  		save:function(){
			var insave=document.getElementsByClassName('insave'),textarea=document.getElementsByClassName('textarea');
			for(var i=1;i<=insave.length;i++){
				textarea[i-1].value=insave[i-1].innerHTML;
			}
			o.submit();
		},
		panel:function(e){
			switch(e){
				case 'admin':
					var a ='<a href="?auth=administrateur">admin</a> - <a href="'+this.baseHref()+'?auth=exit">exit</a> - ';
					if(o){o.innerHTML=a }else{ return a}
				break;
			}
		},
		pageName:function(a){if(a){a=a.split("?")[0].split("/");return a[a.length-1]}else{var r=document.URL;r=r.split("?")[0].split("/");return r[r.length-1]}},
		baseHref:function(e){var a=this.domainName();return ((a=='')?'':((e=='ssl')?'https://':'http//')+a+"/")},
		domainName:function(e){return document.domain;},
		getIe:function(){
		  var rv = -1; 
		  if (navigator.appName == 'Microsoft Internet Explorer') 
		  {
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
			  rv = parseFloat( RegExp.$1 );
		  }
		  return rv;
		},
		chrome:function(){return navigator.userAgent.toLowerCase().indexOf('chrome') > -1;},
		safari:function(){return navigator.userAgent.toLowerCase().indexOf('safari') > -1;},
		firefox:function(){return navigator.userAgent.toLowerCase().indexOf('firefox') > -1;},
		opera:function(){return navigator.userAgent.toLowerCase().indexOf('opera') > -1;},
		getIeMode:function(){
			engine = null;
			if (window.navigator.appName == "Microsoft Internet Explorer")
			{
			   if (document.documentMode)
				  engine = document.documentMode;
			   else 
			   {
				  engine = 5; 
				  if (document.compatMode)
				  {
					 if (document.compatMode == "CSS1Compat")
						engine = 7; 
				  }
			   }
			   return engine;
			}
		},
		detectTouch:function(){
			return (navigator.userAgent.match(/Android/i))?'Android':
			(navigator.userAgent.match(/webOS/i))?'webOS':
			(navigator.userAgent.match(/iPhone/i))?'iPhone':
			(navigator.userAgent.match(/iPad/i))?'iPad':
			(navigator.userAgent.match(/iPod/i))?'iPod':
			(navigator.userAgent.match(/BlackBerry/i))?'BlackBerry':false;
		},
		anyDetails:function(b){
			var d=o.getElementsByTagName('details');
			for(var i=0;i<=d.length-1;i++){
				Q(d[i]).details(b);
			}
		},
		details:function(b){
			if(!Q().chrome()){
				var n='? ', f='? ', h=0, T=o.getElementsByTagName('*'), s=(!o.getElementsByTagName('summary')[0])?false:o.getElementsByTagName('summary')[0];
				var B='<span>'+f+'</span>', m=(!s)?15:Q(s).get('height'), e=(!s)?o:s, v=o.style.overflow;
				
				(!s)?o.innerHTML=B+o.innerHTML:s.innerHTML=B+s.innerHTML;
				
				for(var i=0;i<=T.length-1;i++){
					h+=Q(T[i]).get('height')*1;
				}
				
				if(b){
					Q(e).click(function(){var s=o.getElementsByTagName('span')[0];
						if(Q(o).get('height')==m){
							Q(o).set({'height':h});s.innerHTML=n;
						}else{
							Q(o).set({'height':m});s.innerHTML=f;
						}
					});	
					v='hidden';
					this.set({'height':m});
				}else{
					Q(e).click(0);
					v='visible';
					o.style.height='auto';
				}
			}
		},
		ajax:function(u/*,o*/,m,s,b,f,h)/* url, methode, send, bool, function, hash[link] */{
			var r,x;r=x=0;
			r=new XMLHttpRequest() || new ActiveXObject("Microsoft.XMLHTTP");
			r.onreadystatechange=function(){x=r.responseText || '';(f)?f(x):0;o.innerHTML=x;};
			r.open(((m)?m:'GET'),u,(b)?b:false);
			(h)?document.location.hash=h:0;
			if(m=='POST'){
				r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				r.setRequestHeader("Content-length", s.length);
				r.setRequestHeader("Connection", "close");
			}
			r.send((s)?s:'null');
		},
		array2json : function(a) {
			var p = [];
			var l = (Object.prototype.toString.apply(a) === '[object Array]');

			for(var key in a) {
				var v = a[key];
				if(typeof v == "object") { 
					if(l) l.push(Q().array2json(v)); 
					else p[key] = Q().array2json(v); 
				} else {
					var s = "";
					if(!l) s = '"' + key + '":';

					
					if(typeof v == "number") s += v; 
					else if(v === false) s += 'false';
					else if(v === true) s += 'true';
					else s += '"' + v + '"';
					

					p.push(s);
				}
			}
			var r = p.join(",");
			
			if(l) return '[' + r + ']';
			return '{' + r + '}';
		},
		UTF8 : {
			encode: function(s){
				for(var c, i = -1, l = (s = s.split("")).length, o = String.fromCharCode; ++i < l;
					s[i] = (c = s[i].charCodeAt(0)) >= 127 ? o(0xc0 | (c >>> 6)) + o(0x80 | (c & 0x3f)) : s[i]
				);
				return s.join("");
			},
			decode: function(s){
				for(var a, b, i = -1, l = (s = s.split("")).length, o = String.fromCharCode, c = "charCodeAt"; ++i < l;
					((a = s[i][c](0)) & 0x80) &&
					(s[i] = (a & 0xfc) == 0xc0 && ((b = s[i + 1][c](0)) & 0xc0) == 0x80 ?
					o(((a & 0x03) << 6) + (b & 0x3f)) : o(128), s[++i] = "")
				);
				return s.join("");
			}
		},
		vw : function (func){

			if ( typeof( cache.vw ) == 'undefined' ){
				cache.vw={};
				cache.vw.tTimer = 5;
				cache.vw.timer = 0;
			}
			if ( typeof( cache.vw.timer ) != 'undefined' )clearTimeout(cache.vw.timer);
			
			cache.vw.timer=setTimeout( function(){
			
				var vw = document.getElementsByClassName('vw');
				
				for( var i=0; i<=vw.length-1; i++ ){
					vw[i].style.fontSize =( Q(document.body).get('width') * (vw[i].getAttribute("vw")/100) )+'px';
				}
				//if (typeof(func!='undefined'))func();
			},cache.vw.tTimer);

		},
		getElementsByClassName : function(c) {
			var e = o.getElementsByTagName('*');
			var a = new Array();
			for( var i=0; i<=e.length; i++ ){
				
				if( typeof(e[i])!='undefined' && typeof(e[i].className)!='undefined' && e[i].className==c)a.push(e[i]);
				
			}
			
			return a;
		}
	}
	
}

    function SmartScroller_GetCoords()
    {
         var scrollX, scrollY;
 
         if (document.all)
         {
	if (!document.documentElement.scrollLeft)
	      scrollX = document.body.scrollLeft;
	else
	      scrollX = document.documentElement.scrollLeft;
 
	if (!document.documentElement.scrollTop)
	      scrollY = document.body.scrollTop;
	else
	      scrollY = document.documentElement.scrollTop;
          }   
         else
        {
                scrollX = window.pageXOffset;
	scrollY = window.pageYOffset;
         }    
 
        document.getElementById("xCoordHolder").value = scrollX; 
        document.getElementById("yCoordHolder").value = scrollY;    
    }
 
    function SmartScroller_Scroll()
    {
           var x = document.getElementById("xCoordHolder").value;
           var y = document.getElementById("yCoordHolder").value;
           window.scrollTo(x, y);
     }			   
 
 
/*     window.onload = SmartScroller_Scroll;
     window.onscroll = SmartScroller_GetCoords;
     window.onkeypress = SmartScroller_GetCoords;
     window.onclick = SmartScroller_GetCoords;

*/




function loadXMLDoc(f,o,m,s,d,func){
	var req='';
	(window.XMLHttpRequest)?req=new XMLHttpRequest():req=new ActiveXObject("Microsoft.XMLHTTP");
	if(func) req.onreadystatechange=function(){(req.readyState==4 && req.status==200 && req.responseText)?func(req.responseText):0};
	else req.onreadystatechange=function(){if(!o){return req.responseText}else{(req.readyState==4 && req.status==200 && req.responseText)?o.innerHTML=req.responseText:0}};
	req.open((m)?m:'GET',f,(s)?s:false);
	req.send((d)?d:'null');
}





var touch='false';
if ("ontouchstart" in document.documentElement){
	touch="true";

}
var mouse_fixed;
var mouse_absolute;
var indexMenuLiA_Href = [];

var body=document.getElementsByTagName('body')[0];



var _SESSION={
	 'touch':touch
	,'width':Math.round(screen.width)
	,'height':Math.round(screen.height)
	,'avalable':{
		 'width':Math.round(Q().ScreenX())
		,'height':Math.round(Q().ScreenY())
	}
	,'navigator':{
		 'width':Math.round(Q().clientWidth())
		,'height':Math.round(Q().clientHeight())
	}
	,'document':{
		 'width':Math.round(Math.max( body.scrollWidth, body.offsetWidth, body.clientWidth, body.style.width))
		,'height':Math.round(Math.max( body.scrollHeight, body.offsetHeight, body.clientHeight, body.style.height))
		,'scroll':{
			'x':Math.round(Q().scrollLeft())
			,'y':Math.round(Q().scrollTop())
		}
		,'height':Math.round(Math.max( body.scrollHeight, body.offsetHeight, body.clientHeight, body.style.height))
	}
	,'mouse':{
		 'position':{
			 'fixed':{
				 'x':'0'
				,'y':'0'
			}
			,'absolute':{
				 'x':'0'
				,'y':'0'
			}
		 }
	}
};

var Qreload_base=setInterval(function(){

	_SESSION.document.width=Math.round(Math.max( body.scrollWidth, body.offsetWidth, body.clientWidth));
	_SESSION.document.height=Math.round(Math.max( body.scrollHeight, body.offsetHeight, body.clientHeight));
	_SESSION.navigator.width=Math.round(Q().clientWidth());
	_SESSION.navigator.height=Math.round(Q().clientHeight());

},100);
window.onload=function(){

	_SESSION.document.width=Math.round(Math.max( body.scrollWidth, body.offsetWidth, body.clientWidth, body.style.width));
	_SESSION.document.height=Math.round(Math.max( body.scrollHeight, body.offsetHeight, body.clientHeight, body.style.height));
	_SESSION.navigator.width=Math.round(Q().clientWidth());
	_SESSION.navigator.height=Math.round(Q().clientHeight());

};

document.onscroll = function(e){
	_SESSION.document.scroll.x = Math.round(window.pageXOffset);
	_SESSION.document.scroll.y = Math.round(window.pageYOffset);
};

if(window.navigator.msPointerEnabled){
	document.body.addEventListener("MSPointerMove", bodytouchMove, false);
}else if(_SESSION.touch){
	if(Q().getIeMode()){
		if(10<=Q().getIeMode()){
			document.body.addEventListener("touchmove", bodytouchMove, false);
		}
	}else{
		document.body.addEventListener("touchmove", bodytouchMove, false);
	}
}

var touchx;
function bodytouchMove(e){
	if(window.navigator.msPointerEnabled){
		_SESSION.mouse.position.absolute.x = Math.round(e.pageX);
		_SESSION.mouse.position.absolute.y = Math.round(e.pageY);
		_SESSION.mouse.position.fixed.x = Math.round(_SESSION.mouse.position.absolute.x - _SESSION.document.scroll.x);
		_SESSION.mouse.position.fixed.y = Math.round(_SESSION.mouse.position.absolute.y - _SESSION.document.scroll.y);
		
	}else{
		_SESSION.mouse.position.absolute.x = Math.round(e.targetTouches[0].pageX);
		_SESSION.mouse.position.absolute.y = Math.round(e.targetTouches[0].pageY);
		_SESSION.mouse.position.fixed.x = Math.round(_SESSION.mouse.position.absolute.x - _SESSION.document.scroll.x);
		_SESSION.mouse.position.fixed.y = Math.round(_SESSION.mouse.position.absolute.y - _SESSION.document.scroll.y);
		
	}
	
	if( 30 < touchx-_SESSION.mouse.position.absolute.x ){
		e.preventDefault();
	}else if(touchx-_SESSION.mouse.position.absolute.x < -30){
		e.preventDefault();
	}

};

document.body.onmousemove = function(e){
	mouse_fixed=Q(e).mousePosFixed();
	mouse_absolute=Q(e).mousePos();
	_SESSION.mouse.position.fixed.x = Math.round(mouse_fixed['x']);
	_SESSION.mouse.position.fixed.y = Math.round(mouse_fixed['y']);
	_SESSION.mouse.position.absolute.x = Math.round(mouse_absolute['x']);
	_SESSION.mouse.position.absolute.y = Math.round(mouse_absolute['y']);
};

if (navigator.userAgent.match(/IEMobile\/10\.0/)
	|| navigator.userAgent.match(/Android/i)
	|| navigator.userAgent.match(/webOS/i)
	|| navigator.userAgent.match(/iPhone/i)
	|| navigator.userAgent.match(/iPod/i)
	|| navigator.userAgent.match(/BlackBerry/i)
	|| navigator.userAgent.match(/Windows Phone/i)
	/*||	screen.width < 1000*/ )
	{
	
	var msViewportStyle = document.createElement("style");
	msViewportStyle.appendChild(
		document.createTextNode(
			"@-webkit-viewport{width:1000px;!important}"
		)
	);
	msViewportStyle.appendChild(
		document.createTextNode(
			"@-moz-viewport{width:1000px;!important}"
		)
	);
	msViewportStyle.appendChild(
		document.createTextNode(
			"@-ms-viewport{width:1000px;!important}"
		)
	);
	msViewportStyle.appendChild(
		document.createTextNode(
			"@-o-viewport{width:1000px;!important}"
		)
	);
	msViewportStyle.appendChild(
		document.createTextNode(
			"@viewport{width:1000px;!important}"
		)
	);
	document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
}

/*
function init(){
	Q().vw();
}
if(window.addEventListener){
	window.addEventListener("load", init, false);
}else if(window.attachEvent){
	window.attachEvent("onload", init);
}else{
	document.addEventListener("load", init, false);
}
*/

window.onresize=function(){
	Q().vw();
}


