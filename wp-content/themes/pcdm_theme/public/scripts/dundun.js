(function(){var t=function(t,e){return function(){return t.apply(e,arguments)}};window.console||(window.console={log:function(t){}}),window.RotationGallery=function(){function e(e){this.ref=e,this.setListners=t(this.setListners,this),this.images=this.ref.find("img"),this.frontImage=null,this.backImage=null,this.renderImages=null,this.detectors=null,this.detector=null,this.last=null,this.skrollr=null,this.init()}return e.prototype.init=function(){return(new WOW).init(),Modernizr.touch||(this.skrollr=skrollr.init()),this.setUpGallery(),this.renderListners(),this.setListners()},e.prototype.setListners=function(){var t,e;return e=parseInt(this.detector.length/2),t=this.detector.length-1,$(".scrolldown").on("click",function(t){return $("body,html").animate({scrollTop:$(".dundun__intro").offset().top},900,"swing")}),Modernizr.touch?(this.detectors.on("touchmove",function(t){return function(e){var n,i,r,s,o,a,l,h,d,c;for(i=e.originalEvent.targetTouches[0].pageX,h=t.detector,d=[],a=0,l=h.length;l>a;a++)n=h[a],o=$(n),c=o.width(),s=o.offset().left,r=s+c,d.push(i>=s&&r>=i?t.show(o.index()):void 0);return d}}(this)),this.detectors.on("touchend",function(t){return function(e){return t.showFront()}}(this))):(this.detectors.on("mousemove",".rotation-gallery__listner",function(n){return function(i){var r;switch(r=$(i.currentTarget),r.index()){case e:n.showFront();break;case 0:n.showBack();break;case t:n.showBack();break;default:return n.show(r.index())}}}(this)),this.detectors.on("mouseleave",function(t){return function(e){return t.showFront(!0)}}(this)))},e.prototype.showFront=function(t){var e,n,i,r,s,o;return null==t&&(t=!1),t===!1?(this.backImage.hide(),this.frontImage.hide(),this.renderImages.hide(),this.frontImage.get(0).style.display="block"):(s=parseInt(this.detector.length/2),r=-1,i=this.last,n=$(this.last).index()-s,r=$(this.last).index()-s>0?-1:1,o=s-($(this.last).index()+2),0>o&&(o=this.renderImages.length-Math.abs(o)),e=setInterval(function(t){return function(){return o!==s?(t.renderImages.hide(),t.renderImages.eq(o).length?(t.renderImages.eq(o).get(0).style.display="block",o+=r):o=s):(t.backImage.hide(),t.frontImage.hide(),t.renderImages.hide(),t.frontImage.get(0).style.display="block",clearInterval(e))}}(this),25))},e.prototype.showBack=function(){return this.backImage.hide(),this.frontImage.hide(),this.renderImages.hide(),this.backImage.get(0).style.display="block"},e.prototype.show=function(t){return this.renderImages.eq(t).length?(this.renderImages.hide(),this.backImage.hide(),this.frontImage.hide(),this.last=this.renderImages.eq(t),this.renderImages.eq(t).get(0).style.display="block"):void 0},e.prototype.setUpGallery=function(){var t,e,n,i,r,s,o,a;for(n=null,e=null,s=this.images,i=0,r=s.length;r>i;i++)switch(t=s[i],t.getAttribute("alt")){case"front-image":t.setAttribute("class","rotation-gallery-image--front front-image"),t.style.display="block",n=$(t);break;case"back-image":t.setAttribute("class","rotation-gallery-image--back back-image"),t.style.display="none",e=$(t);break;default:t.setAttribute("class","rotation-gallery-image"),t.style.display="none"}return a=n.clone(),o=e.clone(),n.empty(),e.empty(),this.images.parent().append(e),this.images.parent().prepend(n),this.renderImages=this.ref.find(".rotation-gallery-image"),this.frontImage=this.ref.find(".rotation-gallery-image--front"),this.backImage=this.ref.find(".rotation-gallery-image--back")},e.prototype.renderListners=function(){var t,e,n,i,r,s;for(r=100/(this.images.length-2),s=$('<div class="rotation-gallery__listners" />'),t=e=0,n=this.images.length-2;n>=0?n>e:e>n;t=n>=0?++e:--e)i=$('<div class="rotation-gallery__listner" />').css({height:"100%",width:""+r+"%","float":"left"}),s.append(i),s.css({position:"absolute",left:0,top:0,height:"100%",width:"100%"});return this.ref.append(s),this.detectors=this.ref.find(".rotation-gallery__listners"),this.detector=this.ref.find(".rotation-gallery__listner")},e}(),$(function(){var t,e,n,i,r,s,o,a,l;if(s=$(window),n=$(document),e=$("body"),r=$("#preloader"),r.addClass("loading"),s.on("load",function(t){}),window.rotationgalleryObj=[],t=$(".js-rotating-gallary"),t.length){for(l=[],o=0,a=t.length;a>o;o++)i=t[o],l.push(window.rotationgalleryObj.push(new RotationGallery($(i))));return l}})}).call(this);