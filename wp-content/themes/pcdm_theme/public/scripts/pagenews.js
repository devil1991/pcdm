(function(){$(function(){var e,a,n,t,r,s,c,l,o,i,u,f,d;return a=$("#news-grid"),n=$("#mc-email").closest("form"),t=$("#mc-email"),e=n.find(".label-error"),i=$("html").attr("lang"),c=$(".overlay.registration"),l="it","en-US"!==i&&(l="en"),o=function(){return"en-US"===i?"//paulacademartori.us2.list-manage.com/subscribe/post-json?u=fc8967c84ef3cb8620ee8f94b&id=1c44c3f947":"//paulacademartori.us2.list-manage.com/subscribe/post-json?u=fc8967c84ef3cb8620ee8f94b&id=0329e0ad2e"},u=function(a){return"success"===a.result?(c.find(".feedback p").html(a.msg),c.find("form").hide(),c.find(".description").eq(1).hide(),c.find(".feedback").css("display","block"),d()):(e.css("display","block"),a.msg=a.msg.replace("0 - ",""),e.html(a.msg))},f=function(){return $(".wrap-overlay").velocity("fadeIn",900),c.velocity({opacity:[1,0],translateY:[0,50]},{display:"block"})},n.on("submit",function(e){return console.log(t.val())}),r=function(){return $(".wrap-overlay").velocity("fadeOut",900),d(),c.velocity({opacity:0,translateY:50},{display:"none"})},$(".subscribe").on("click",function(e){var a;return a=$(e.currentTarget),e.preventDefault(),f()}),$(".wrap-overlay").on("click",function(e){var a;return a=$(e.target),a.hasClass("overlay")&&e.stopPropagation(),a.hasClass("wrap-overlay")||a.hasClass("close-newsletter")?r():void 0}),n.ajaxChimp({url:o(),language:l,callback:u},s=monster.get("paulanl"),1!==parseInt(s)?f():void 0,d=function(){return monster.set("paulanl",1,40)})})}).call(this);