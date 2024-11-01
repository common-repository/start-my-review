(function(root,factory){if(typeof module==="object"&&module.exports){require("./toastify.css");module.exports=factory();}else{root.Toastify=factory();}})(this,function(global){var Toastify=function(options){return new Toastify.lib.init(options);},version="1.2.2";Toastify.lib=Toastify.prototype={toastify:version,constructor:Toastify,init:function(options){if(!options){options={};}this.options={};this.options.text=options.text||"Hi there!";this.options.duration=options.duration||3000;this.options.selector=options.selector;this.options.callback=options.callback||function(){};this.options.destination=options.destination;this.options.newWindow=options.newWindow||false;this.options.close=options.close||false;this.options.gravity=options.gravity=="bottom"?"toastify-bottom":"toastify-top";this.options.positionLeft=options.positionLeft||false;this.options.backgroundColor=options.backgroundColor;this.options.avatar=options.avatar||"";this.options.className=options.className||"";return this;},buildToast:function(){if(!this.options){throw"Toastify is not initialized";}var divElement=document.createElement("div");divElement.className="toastify on "+this.options.className;if(this.options.positionLeft===true){divElement.className+=" toastify-left";}else{divElement.className+=" toastify-right";}divElement.className+=" "+this.options.gravity;if(this.options.backgroundColor){divElement.style.background=this.options.backgroundColor;}divElement.innerHTML=this.options.text;if(this.options.avatar!==""){var avatarElement=document.createElement("img");avatarElement.src=this.options.avatar;avatarElement.className="toastify-avatar";if(this.options.positionLeft===true){divElement.appendChild(avatarElement);}else{divElement.insertAdjacentElement("beforeend",avatarElement);}}if(this.options.close===true){var closeElement=document.createElement("span");closeElement.innerHTML="&#10006;";closeElement.className="toast-close";closeElement.addEventListener("click",function(event){event.stopPropagation();this.removeElement(event.target.parentElement);window.clearTimeout(event.target.parentElement.timeOutValue);}.bind(this));var width=window.innerWidth>0?window.innerWidth:screen.width;if(this.options.positionLeft===true&&width>360){divElement.insertAdjacentElement("afterbegin",closeElement);}else{divElement.appendChild(closeElement);}}if(typeof this.options.destination!=="undefined"){divElement.addEventListener("click",function(event){event.stopPropagation();if(this.options.newWindow===true){window.open(this.options.destination,"_blank");}else{window.location=this.options.destination;}}.bind(this));}return divElement;},showToast:function(){var toastElement=this.buildToast();var rootElement;if(typeof this.options.selector==="undefined"){rootElement=document.body;}else{rootElement=document.getElementById(this.options.selector);}if(!rootElement){throw"Root element is not defined";}rootElement.insertBefore(toastElement,rootElement.firstChild);Toastify.reposition();toastElement.timeOutValue=window.setTimeout(function(){this.removeElement(toastElement);}.bind(this),this.options.duration);return this;},removeElement:function(toastElement){toastElement.className=toastElement.className.replace(" on","");window.setTimeout(function(){toastElement.parentNode.removeChild(toastElement);this.options.callback.call(toastElement);Toastify.reposition();}.bind(this),400);},};Toastify.reposition=function(){var topLeftOffsetSize={top:15,bottom:15,};var topRightOffsetSize={top:15,bottom:15,};var offsetSize={top:15,bottom:15,};var allToasts=document.getElementsByClassName("toastify");var classUsed;for(var i=0;i<allToasts.length;i++){if(containsClass(allToasts[i],"toastify-top")===true){classUsed="toastify-top";}else{classUsed="toastify-bottom";}var height=allToasts[i].offsetHeight;classUsed=classUsed.substr(9,classUsed.length-1)
var offset=15;var width=window.innerWidth>0?window.innerWidth:screen.width;if(width<=360){allToasts[i].style[classUsed]=offsetSize[classUsed]+"px";offsetSize[classUsed]+=height+offset;}else{if(containsClass(allToasts[i],"toastify-left")===true){allToasts[i].style[classUsed]=topLeftOffsetSize[classUsed]+"px";topLeftOffsetSize[classUsed]+=height+offset;}else{allToasts[i].style[classUsed]=topRightOffsetSize[classUsed]+"px";topRightOffsetSize[classUsed]+=height+offset;}}}return this;};function containsClass(elem,yourClass){if(!elem||typeof yourClass!=="string"){return false;}else if(elem.className&&elem.className.trim().split(/\s+/gi).indexOf(yourClass)>-1){return true;}else{return false;}}Toastify.lib.init.prototype=Toastify.lib;return Toastify;});