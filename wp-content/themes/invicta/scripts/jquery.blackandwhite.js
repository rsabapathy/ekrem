/**
 *
 * Version: 0.2.7
 * Author:  Gianluca Guarini
 * Contact: gianluca.guarini@gmail.com
 * Website: http://www.gianlucaguarini.com/
 * Twitter: @gianlucaguarini
 *
 * Copyright (c) 2013 Gianluca Guarini
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 **/(function(e){e.fn.extend({BlackAndWhite:function(t){"use strict";var n=this,r={hoverEffect:!0,webworkerPath:!1,responsive:!0,invertHoverEffect:!1,speed:500,onImageReady:null};t=e.extend(r,t);var i=t.hoverEffect,s=t.webworkerPath,o=t.invertHoverEffect,u=t.responsive,a=e.isPlainObject(t.speed)?t.speed.fadeIn:t.speed,f=e.isPlainObject(t.speed)?t.speed.fadeOut:t.speed,l=document.all&&!window.opera&&window.XMLHttpRequest?!0:!1,c=" -webkit- -moz- -o- -ms- ".split(" "),h={},p=function(e){if(h[e]||h[e]==="")return h[e]+e;var t=document.createElement("div"),n=["","Moz","Webkit","O","ms","Khtml"];for(var r in n)if(typeof t.style[n[r]+e]!="undefined"){h[e]=n[r];return n[r]+e}return e.toLowerCase()},d=function(){var e=document.createElement("div");e.style.cssText=c.join("filter:blur(2px); ");return!!e.style.length&&(document.documentMode===undefined||document.documentMode>9)}(),v=!!document.createElement("canvas").getContext,m=e(window),g=function(){return typeof Worker!="undefined"?!0:!1}(),y=p("Filter"),b=[],w=g&&s?new Worker(s+"BnWWorker.js"):!1,E=function(t){e(t.currentTarget).find(".BWfade").stop(!0,!0)[o?"fadeOut":"fadeIn"](f)},S=function(t){e(t.currentTarget).find(".BWfade").stop(!0,!0)[o?"fadeIn":"fadeOut"](a)},x=function(e){typeof t.onImageReady=="function"&&t.onImageReady(e)},T=function(){if(!b.length)return;w.postMessage(b[0].imageData);w.onmessage=function(e){b[0].ctx.putImageData(e.data,0,0);x(b[0].img);b.splice(0,1);T()}},N=function(e,t,n,r){var i=t.getContext("2d"),s=e,o=0,u;i.drawImage(e,0,0,n,r);var a=i.getImageData(0,0,n,r),f=a.data,l=f.length;if(w)b.push({imageData:a,ctx:i,img:e});else{for(;o<l;o+=4){u=f[o]*.3+f[o+1]*.59+f[o+2]*.11;f[o]=f[o+1]=f[o+2]=u}i.putImageData(a,0,0);x(e)}},C=function(t,n){var r=t[0],i=r.src,s=t.width(),u=t.height(),a={position:"absolute",top:0,left:0,display:o?"none":"block"};if(v&&!d){var f=r.width,l=r.height;e('<canvas class="BWfade" width="'+f+'" height="'+l+'"></canvas>').prependTo(n);var c=n.find("canvas");c.css(a);N(r,c[0],f,l)}else{a[p("Filter")]="grayscale(100%)";e("<img src="+i+' width="'+s+'" height="'+u+'" class="BWFilter BWfade" /> ').prependTo(n);e(".BWFilter").css(e.extend(a,{filter:"progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)"}));x(r)}};this.init=function(t){n.each(function(t,n){var r=e(n),i=r.find("img");i.width()?C(i,r):i.on("load",function(){C(i,r)})});w&&T();if(i){n.on("mouseleave",E);n.on("mouseenter",S)}u&&m.on("resize orientationchange",n.resizeImages)};this.resizeImages=function(){n.each(function(t,n){var r=e(n).find("img:not(.BWFilter)"),i=l?e(r).prop("width"):e(r).width(),s=l?e(r).prop("height"):e(r).height();e(this).find(".BWFilter, canvas").css({width:i,height:s})})};return this.init(t)}})})(jQuery);