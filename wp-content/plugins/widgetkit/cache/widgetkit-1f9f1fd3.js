jQuery(function(a){a("#accordion").delegate("a.action.delete","click",function(c){c.preventDefault();if(confirm("Are you Sure?")){var d=a(this);a.post(widgetkitajax+"&task=delete_accordion",{id:a(this).attr("data-id")},function(b){b&&b.id?d.parents("tr:first").fadeOut(function(){a(this).remove()}):alert("Delete action failed.")},"json")}})});
jQuery(function(a){var b=a("#gallery form");a('input[type="submit"]',b).bind("click",function(d){d.preventDefault();var c=a(this);c.attr("disabled",!0).parent().addClass("saving");a.post(b.attr("action"),b.serialize(),function(){c.attr("disabled",!1).parent().removeClass("saving")})});a("#gallery").delegate("a.action.delete","click",function(b){b.preventDefault();if(confirm("Are you Sure?")){var c=a(this);a.post(widgetkitajax+"&task=delete_gallery",{id:a(this).attr("data-id")},function(b){b&&b.id?c.parents("tr:first").fadeOut(function(){a(this).remove()}):alert("Delete action failed.")},"json")}})});
jQuery(function(a){var b=a("#lightbox form");a('input[type="submit"]',b).bind("click",function(c){c.preventDefault();var d=a(this);d.attr("disabled",!0).parent().addClass("saving");a.post(b.attr("action"),b.serialize(),function(){d.attr("disabled",!1).parent().removeClass("saving")})});var c=a("#lightbox div.howtouse").hide();a("#lightbox a.howtouse").bind("click",function(){c.slideToggle()})});
jQuery(function(a){a("#map").delegate("a.action.delete","click",function(c){c.preventDefault();if(confirm("Are you Sure?")){var d=a(this);a.post(widgetkitajax+"&task=delete_map",{id:a(this).attr("data-id")},function(b){b&&b.id?d.parents("tr:first").fadeOut(function(){a(this).remove()}):alert("Delete action failed.")},"json")}})});
jQuery(function(a){var b=a("#mediaplayer form");a('input[type="submit"]',b).bind("click",function(c){c.preventDefault();var d=a(this);d.attr("disabled",!0).parent().addClass("saving");a.post(b.attr("action"),b.serialize(),function(){d.attr("disabled",!1).parent().removeClass("saving")})});var c=a("#mediaplayer div.howtouse").hide();a("#mediaplayer a.howtouse").bind("click",function(){c.slideToggle()})});
jQuery(function(a){a("#slideset").delegate("a.action.delete","click",function(c){c.preventDefault();if(confirm("Are you Sure?")){var d=a(this);a.post(widgetkitajax+"&task=delete_slideset",{id:a(this).attr("data-id")},function(b){b&&b.id?d.parents("tr:first").fadeOut(function(){a(this).remove()}):alert("Delete action failed.")},"json")}})});
jQuery(function(a){a("#slideshow").delegate("a.action.delete","click",function(c){c.preventDefault();if(confirm("Are you Sure?")){var d=a(this);a.post(widgetkitajax+"&task=delete_slideshow",{id:a(this).attr("data-id")},function(b){b&&b.id?d.parents("tr:first").fadeOut(function(){a(this).remove()}):alert("Delete action failed.")},"json")}})});
jQuery(function(a){var b=a("#spotlight form");a('input[type="submit"]',b).bind("click",function(c){c.preventDefault();var d=a(this);d.attr("disabled",!0).parent().addClass("saving");a.post(b.attr("action"),b.serialize(),function(){d.attr("disabled",!1).parent().removeClass("saving")})});var c=a("#spotlight div.howtouse").hide();a("#spotlight a.howtouse").bind("click",function(){c.slideToggle()})});
(function(g,f){var a={};f.$widgetkit={lazyloaders:{},load:function(b){a[b]||(a[b]=g.getScript(b));return a[b]},lazyload:function(a){a=a||document;g("[data-widgetkit]",a).each(function(){var a=g(this),b=a.data("widgetkit"),c=a.data("options")||{};!a.data("wk-loaded")&&$widgetkit.lazyloaders[b]&&($widgetkit.lazyloaders[b](a,c),a.data("wk-loaded",!0))})}};g(function(){$widgetkit.lazyload()});for(var b=document.createElement("div"),c=b.style,b=!1,d=["-webkit-","-moz-","-o-","-ms-","-khtml-"],e=["Webkit","Moz","O","ms","Khtml"],j="",h=0;h<e.length;h++)if(""===c[e[h]+"Transition"]){b=e[h]+"Transition";j=d[h];break}$widgetkit.prefix=j;c=$widgetkit;b=(d=b)&&"WebKitCSSMatrix"in window&&"m11"in new WebKitCSSMatrix&&!navigator.userAgent.match(/Chrome/i);e=document.createElement("canvas");e=!(!e.getContext||!e.getContext("2d"));c.support={transition:d,css3d:b,canvas:e};$widgetkit.css3=function(a){a=a||{};a.transition&&(a[j+"transition"]=a.transition);a.transform&&(a[j+"transform"]=a.transform);a["transform-origin"]&&(a[j+"transform-origin"]=a["transform-origin"]);return a};if(!(b=g.browser))c=navigator.userAgent,c=c.toLowerCase(),b={},c=/(chrome)[ \/]([\w.]+)/.exec(c)||/(webkit)[ \/]([\w.]+)/.exec(c)||/(opera)(?:.*version)?[ \/]([\w.]+)/.exec(c)||/(msie) ([\w.]+)/.exec(c)||0>c.indexOf("compatible")&&/(mozilla)(?:.*? rv:([\w.]+))?/.exec(c)||[],b[c[1]]=!0,b.version=c[2]||"0";g.browser=b;b=null})(jQuery,window);(function(g){var f;a:{try{f=parseInt(navigator.appVersion.match(/MSIE (\d\.\d)/)[1],10);break a}catch(a){}f=!1}f&&9>f&&(g(document).ready(function(){g("body").addClass("wk-ie wk-ie"+f)}),g.each("abbr article aside audio canvas details figcaption figure footer header hgroup mark meter nav output progress section summary time video".split(" "),function(){document.createElement(this)}))})(jQuery);(function(g,f){f.$widgetkit.trans={__data:{},addDic:function(a){g.extend(this.__data,a)},add:function(a,b){this.__data[a]=b},get:function(a){if(!this.__data[a])return a;var b=1==arguments.length?[]:Array.prototype.slice.call(arguments,1);return this.printf(String(this.__data[a]),b)},printf:function(a,b){if(!b)return a;var c="",d=a.split("%s");if(1==d.length)return a;for(var e=0;e<b.length;e++)d[e].lastIndexOf("%")==d[e].length-1&&e!=b.length-1&&(d[e]+="s"+d.splice(e+1,1)[0]),c+=d[e]+b[e];return c+
d[d.length-1]}}})(jQuery,window);(function(g){g.easing.jswing=g.easing.swing;g.extend(g.easing,{def:"easeOutQuad",swing:function(f,a,b,c,d){return g.easing[g.easing.def](f,a,b,c,d)},easeInQuad:function(f,a,b,c,d){return c*(a/=d)*a+b},easeOutQuad:function(f,a,b,c,d){return-c*(a/=d)*(a-2)+b},easeInOutQuad:function(f,a,b,c,d){return 1>(a/=d/2)?c/2*a*a+b:-c/2*(--a*(a-2)-1)+b},easeInCubic:function(f,a,b,c,d){return c*(a/=d)*a*a+b},easeOutCubic:function(f,a,b,c,d){return c*((a=a/d-1)*a*a+1)+b},easeInOutCubic:function(f,a,b,c,d){return 1>(a/=d/2)?c/2*a*a*a+b:c/2*((a-=2)*a*a+2)+b},easeInQuart:function(f,a,b,c,d){return c*(a/=d)*a*a*a+b},easeOutQuart:function(f,a,b,c,d){return-c*((a=a/d-1)*a*a*a-1)+b},easeInOutQuart:function(f,a,b,c,d){return 1>(a/=d/2)?c/2*a*a*a*a+b:-c/2*((a-=2)*a*a*a-2)+b},easeInQuint:function(f,a,b,c,d){return c*(a/=d)*a*a*a*a+b},easeOutQuint:function(f,a,b,c,d){return c*((a=a/d-1)*a*a*a*a+1)+b},easeInOutQuint:function(f,a,b,c,d){return 1>(a/=d/2)?c/2*a*a*a*a*a+b:c/2*((a-=2)*a*a*a*a+2)+b},easeInSine:function(f,a,b,c,d){return-c*Math.cos(a/d*(Math.PI/2))+c+b},easeOutSine:function(f,a,b,c,d){return c*Math.sin(a/d*(Math.PI/2))+b},easeInOutSine:function(f,a,b,c,d){return-c/2*(Math.cos(Math.PI*a/d)-1)+b},easeInExpo:function(f,a,b,c,d){return 0==a?b:c*Math.pow(2,10*(a/d-1))+b},easeOutExpo:function(f,a,b,c,d){return a==d?b+c:c*(-Math.pow(2,-10*a/d)+1)+b},easeInOutExpo:function(f,a,b,c,d){return 0==a?b:a==d?b+c:1>(a/=d/2)?c/2*Math.pow(2,10*(a-1))+b:c/2*(-Math.pow(2,-10*--a)+2)+b},easeInCirc:function(f,a,b,c,d){return-c*(Math.sqrt(1-(a/=d)*a)-1)+b},easeOutCirc:function(f,a,b,c,d){return c*Math.sqrt(1-(a=a/d-1)*a)+b},easeInOutCirc:function(f,a,b,c,d){return 1>(a/=d/2)?-c/2*(Math.sqrt(1-a*a)-1)+b:c/2*(Math.sqrt(1-(a-=2)*a)+1)+b},easeInElastic:function(f,a,b,c,d){f=1.70158;var e=0,g=c;if(0==a)return b;if(1==(a/=d))return b+c;e||(e=0.3*d);g<Math.abs(c)?(g=c,f=e/4):f=e/(2*Math.PI)*Math.asin(c/g);return-(g*Math.pow(2,10*(a-=1))*Math.sin((a*d-f)*2*Math.PI/e))+b},easeOutElastic:function(f,a,b,c,d){f=1.70158;var e=0,g=c;if(0==a)return b;if(1==(a/=d))return b+c;e||(e=0.3*d);g<Math.abs(c)?(g=c,f=e/4):f=e/(2*Math.PI)*Math.asin(c/g);return g*Math.pow(2,-10*a)*Math.sin((a*d-f)*2*Math.PI/e)+c+b},easeInOutElastic:function(f,a,b,c,d){f=1.70158;var e=0,g=c;if(0==a)return b;if(2==(a/=d/2))return b+c;e||(e=d*0.3*1.5);g<Math.abs(c)?(g=c,f=e/4):f=e/(2*Math.PI)*Math.asin(c/g);return 1>a?-0.5*g*Math.pow(2,10*(a-=1))*Math.sin((a*d-f)*2*Math.PI/e)+b:0.5*g*Math.pow(2,-10*(a-=1))*Math.sin((a*d-f)*2*Math.PI/e)+c+b},easeInBack:function(f,a,b,c,d,e){void 0==e&&(e=1.70158);return c*(a/=d)*a*((e+1)*a-e)+b},easeOutBack:function(f,a,b,c,d,e){void 0==e&&(e=1.70158);return c*((a=a/d-1)*a*((e+1)*a+e)+1)+b},easeInOutBack:function(f,a,b,c,d,e){void 0==e&&(e=1.70158);return 1>(a/=d/2)?c/2*a*a*(((e*=1.525)+1)*a-e)+b:c/2*((a-=2)*a*(((e*=1.525)+1)*a+e)+2)+b},easeInBounce:function(f,a,b,c,d){return c-g.easing.easeOutBounce(f,d-a,0,c,d)+b},easeOutBounce:function(f,a,b,c,d){return(a/=d)<1/2.75?c*7.5625*a*a+b:a<2/2.75?c*(7.5625*(a-=1.5/2.75)*a+0.75)+
b:a<2.5/2.75?c*(7.5625*(a-=2.25/2.75)*a+0.9375)+b:c*(7.5625*(a-=2.625/2.75)*a+0.984375)+b},easeInOutBounce:function(f,a,b,c,d){return a<d/2?0.5*g.easing.easeInBounce(f,2*a,0,c,d)+b:0.5*g.easing.easeOutBounce(f,2*a-d,0,c,d)+0.5*c+b}})})(jQuery);(function(g){function f(a){var c=a||window.event,d=[].slice.call(arguments,1),e=0,f=0,h=0;a=g.event.fix(c);a.type="mousewheel";a.wheelDelta&&(e=a.wheelDelta/120);a.detail&&(e=-a.detail/3);h=e;void 0!==c.axis&&c.axis===c.HORIZONTAL_AXIS&&(h=0,f=-1*e);void 0!==c.wheelDeltaY&&(h=c.wheelDeltaY/120);void 0!==c.wheelDeltaX&&(f=-1*c.wheelDeltaX/120);d.unshift(a,e,f,h);return g.event.handle.apply(this,d)}var a=["DOMMouseScroll","mousewheel"];g.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var b=a.length;b;)this.addEventListener(a[--b],f,!1);else this.onmousewheel=f},teardown:function(){if(this.removeEventListener)for(var b=a.length;b;)this.removeEventListener(a[--b],f,!1);else this.onmousewheel=null}};g.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);(function(g){var f=g.support;var a=document.createElement("INPUT");a.type="file";if(a="files"in a)a=new XMLHttpRequest,a=!(!a||!("upload"in a&&"onprogress"in a.upload))&&!!window.FormData;f.ajaxupload=a;g.support.ajaxupload&&g.event.props.push("dataTransfer");g.fn.uploadOnDrag=function(a){return!g.support.ajaxupload?this:this.each(function(){var c=g(this),b=g.extend({action:"",single:!1,method:"POST",params:{},loadstart:function(){},load:function(){},loadend:function(){},progress:function(){},complete:function(){},allcomplete:function(){},readystatechange:function(){}},a);c.on("drop",function(a){function c(a,b){for(var d=new FormData,e=new XMLHttpRequest,f=0,h;h=a[f];f++)d.append("files[]",h);for(var l in b.params)d.append(l,b.params[l]);e.upload.addEventListener("progress",function(a){b.progress(100*(a.loaded/a.total),a)},!1);e.addEventListener("loadstart",function(a){b.loadstart(a)},!1);e.addEventListener("load",function(a){b.load(a)},!1);e.addEventListener("loadend",function(a){b.loadend(a)},!1);e.addEventListener("error",function(a){b.error(a)},!1);e.addEventListener("abort",function(a){b.abort(a)},!1);e.open(b.method,b.action,!0);e.onreadystatechange=function(){b.readystatechange(e);if(4==e.readyState){var a=e.responseText;if("json"==b.type)try{a=g.parseJSON(a)}catch(c){a=!1}b.complete(a,e)}};e.send(d)}a.stopPropagation();a.preventDefault();var d=a.dataTransfer.files;if(b.single){var f=a.dataTransfer.files.length,e=0,j=b.complete;b.complete=function(a,g){e+=1;j(a,g);e<f?c([d[e]],b):b.allcomplete()};c([d[0]],b)}else c(d,b)}).on("dragover",function(a){a.stopPropagation();a.preventDefault()})})};g.fn.ajaxform=function(a){return!g.support.ajaxupload?this:this.each(function(){var b=g(this),c=g.extend({action:b.attr("action"),method:b.attr("method"),loadstart:function(){},load:function(){},loadend:function(){},progress:function(){},complete:function(){},readystatechange:function(){}},a);b.on("submit",function(a){a.preventDefault();a=new FormData(this);var b=new XMLHttpRequest;a.append("formdata","1");b.upload.addEventListener("progress",function(a){c.progress(100*(a.loaded/a.total),a)},!1);b.addEventListener("loadstart",function(a){c.loadstart(a)},!1);b.addEventListener("load",function(a){c.load(a)},!1);b.addEventListener("loadend",function(a){c.loadend(a)},!1);b.addEventListener("error",function(a){c.error(a)},!1);b.addEventListener("abort",function(a){c.abort(a)},!1);b.open(c.method,c.action,!0);b.onreadystatechange=function(){c.readystatechange(b);if(4==b.readyState){var a=b.responseText;if("json"==c.type)try{a=g.parseJSON(a)}catch(d){a=!1}c.complete(a,b)}};b.send(a)})})};if(!g.event.special.debouncedresize){var b=g.event,c,d;c=b.special.debouncedresize={setup:function(){g(this).on("resize",c.handler)},teardown:function(){g(this).off("resize",c.handler)},handler:function(a,f){var g=this,m=arguments,k=function(){a.type="debouncedresize";b.dispatch.apply(g,m)};d&&clearTimeout(d);f?k():d=setTimeout(k,c.threshold)},threshold:150}}})(jQuery);
(function(b,f,g){function d(h){e.innerHTML='&shy;<style media="'+h+'"> #mq-test-1 { width: 42px; }</style>';a.insertBefore(j,m);l=42==e.offsetWidth;a.removeChild(j);return l}function k(h){var a=d(h.media);if(h._listeners&&h.matches!=a){h.matches=a;for(var a=0,c=h._listeners.length;a<c;a++)h._listeners[a](h)}}function c(a,c,d){var b;return function(){var f=this,g=arguments,e=d&&!b;clearTimeout(b);b=setTimeout(function(){b=null;d||a.apply(f,g)},c);e&&a.apply(f,g)}}if(!f.matchMedia||b.userAgent.match(/(iPhone|iPod|iPad)/i)){var l,a=g.documentElement,m=a.firstElementChild||a.firstChild,j=g.createElement("body"),e=g.createElement("div");e.id="mq-test-1";e.style.cssText="position:absolute;top:-100em";j.style.background="none";j.appendChild(e);f.matchMedia=function(a){var b,e=[];b={matches:d(a),media:a,_listeners:e,addListener:function(a){"function"===typeof a&&e.push(a)},removeListener:function(a){for(var b=0,c=e.length;b<c;b++)e[b]===a&&delete e[b]}};f.addEventListener&&f.addEventListener("resize",c(function(){k(b)},150),!1);g.addEventListener&&g.addEventListener("orientationchange",function(){k(b)},!1);return b}}})(navigator,window,document);(function(b,f,g){if(!b.onMediaQuery){var d={},k=f.matchMedia&&f.matchMedia("only all").matches;b(g).ready(function(){for(var c in d)b(d[c]).trigger("init"),d[c].matches&&b(d[c]).trigger("valid")});b(f).bind("load",function(){for(var c in d)d[c].matches&&b(d[c]).trigger("valid")});b.onMediaQuery=function(c,g){var a=c&&d[c];a||(a=d[c]=f.matchMedia(c),a.supported=k,a.addListener(function(){b(a).trigger(a.matches?"valid":"invalid")}));b(a).bind(g);return a}}})(jQuery,window,document);
jQuery(function(a){a("#tabs").tabs().prev().append('<li class="version">'+a("#tabs").data("wkversion")+"</li>");a("#widgetkit").delegate(".box .deletable","click",function(){a(this).parent().trigger("delete",[a(this)])});a("input:text").placeholder()});jQuery("body").bind("afterPreWpautop",function(a,b){b.data=b.unfiltered.replace(/caption\]\[caption/g,"caption] [caption").replace(/<object[\s\S]+?<\/object>/g,function(a){return a.replace(/[\r\n]+/g," ")})}).bind("afterWpautop",function(a,b){b.data=b.unfiltered});(function(a){var b={get:function(a){return window.sessionStorage?sessionStorage.getItem(a):null},set:function(a,b){window.sessionStorage&&sessionStorage.setItem(a,b)}};a.fn.tabs=function(){return this.each(function(){var g=a(this).addClass("content").wrap('<div class="tabs-box" />').before('<ul class="nav" />'),e=a(this).prev("ul.nav");g.children("li").each(function(){e.append("<li><a>"+a(this).hide().attr("data-name")+"</a></li>")});e.children("li").bind("click",function(c){c.preventDefault();var c=a("li",e).removeClass("active").index(a(this).addClass("active").get(0)),h=g.children("li").hide();a(h[c]).show();b.set("widgetkit-tab",c)});var f=parseInt(b.get("widgetkit-tab"));a(!isNaN(f)?e.children("li").get(f):e.children("li:first")).trigger("click")})}})(jQuery);(function(a){var b=function(){};a.extend(b.prototype,{name:"finder",initialize:function(b,e){function f(h){h.preventDefault();var d=a(this).closest("li",b);d.length||(d=b);d.hasClass(c.options.open)?d.removeClass(c.options.open).children("ul").slideUp():(d.addClass(c.options.loading),a.post(c.options.url,{path:d.data("path")},function(b){d.removeClass(c.options.loading).addClass(c.options.open);b.length&&(d.children().remove("ul"),d.append("<ul>").children("ul").hide(),a.each(b,function(b,c){d.children("ul").append(a('<li><a href="#">'+
c.name+"</a></li>").addClass(c.type).data("path",c.path))}),d.find("ul a").bind("click",f),d.children("ul").slideDown())},"json"))}var c=this;this.options=a.extend({url:"",path:"",open:"open",loading:"loading"},e);b.data("path",this.options.path).bind("retrieve:finder",f).trigger("retrieve:finder")}});a.fn[b.prototype.name]=function(){var g=arguments,e=g[0]?g[0]:null;return this.each(function(){var f=a(this);if(b.prototype[e]&&f.data(b.prototype.name)&&"initialize"!=e)f.data(b.prototype.name)[e].apply(f.data(b.prototype.name),Array.prototype.slice.call(g,1));else if(!e||a.isPlainObject(e)){var c=new b;b.prototype.initialize&&c.initialize.apply(c,a.merge([f],g));f.data(b.prototype.name,c)}else a.error("Method "+e+" does not exist on jQuery."+b.name)})}})(jQuery);(function(a){function b(b){var d={},c=/^jQuery\d+$/;a.each(b.attributes,function(a,b){b.specified&&!c.test(b.name)&&(d[b.name]=b.value)});return d}function g(){var b=a(this);b.val()===b.attr("placeholder")&&b.hasClass("placeholder")&&(b.data("placeholder-password")?b.hide().next().show().focus():b.val("").removeClass("placeholder"))}function e(){var c,d=a(this);if(""===d.val()||d.val()===d.attr("placeholder")){if(d.is(":password")){if(!d.data("placeholder-textinput")){try{c=d.clone().attr({type:"text"})}catch(e){c=a("<input>").attr(a.extend(b(d[0]),{type:"text"}))}c.removeAttr("name").data("placeholder-password",!0).bind("focus.placeholder",g);d.data("placeholder-textinput",c).before(c)}d=d.hide().prev().show()}d.addClass("placeholder").val(d.attr("placeholder"))}else d.removeClass("placeholder")}var f="placeholder"in document.createElement("input"),c="placeholder"in document.createElement("textarea");a.fn.placeholder=f&&c?function(){return this}:function(){return this.filter((f?"textarea":":input")+"[placeholder]").bind("focus.placeholder",g).bind("blur.placeholder",e).trigger("blur.placeholder").end()};a(function(){a("form").bind("submit.placeholder",function(){var b=a(".placeholder",this).each(g);setTimeout(function(){b.each(e)},10)})});a(window).bind("unload.placeholder",function(){a(".placeholder").val("")})})(jQuery);(function(a){var b=a(window),g=a(document),e=!1,f=!1,c=null,h=null;a.modalwin=function(d){e&&a.modalwin.close();"object"===typeof d?(d=a(d),d.parent().length&&(this.persist=d,this.persist.data("modal-persist-parent",d.parent()))):d="string"===typeof d||"number"===typeof d?a("<div></div>").html(d):a("<div></div>").html("Modalwin Error: Unsupported data type: "+typeof d);c=a('<div class="modalwin"><div class="inner"></div><div class="btnclose"></div>');c.find(".inner:first").append(d);c.css({position:"fixed","z-index":101}).find(".btnclose").click(a.modalwin.close);h=a('<div class="modal-overlay"></div>').css({position:"absolute",left:0,top:0,width:g.width(),height:g.height(),"z-index":100}).bind("click",a.modalwin.close);a("body").append(h).append(c.hide());c.show().css({left:b.width()/2-c.width()/2,top:b.height()/2-c.height()/2}).fadeIn();e=!0};a.modalwin.close=function(){e&&(f&&(f.appendTo(this.persist.data("modal-persist-parent")),f=!1),c.remove(),h.remove(),h=c=null,e=!1)};b.bind("resize",function(){e&&(c.css({left:b.width()/2-c.width()/2,top:b.height()/2-c.height()/2}),h.css({width:g.width(),height:g.height()}))})})(jQuery);
var widgetkitajax="http://96.30.11.60/~dorseyco/wp-admin/admin-ajax.php?action=widgetkit&ajax=1";