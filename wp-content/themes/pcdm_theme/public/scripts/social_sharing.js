// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.SocialSharing = (function() {
    function SocialSharing(ref) {
      this.ref = ref;
      this.setButton = __bind(this.setButton, this);
      this.onSharingDataUpdated = __bind(this.onSharingDataUpdated, this);
      this.meta_title = ($("meta[property='og:title']")).attr('content');
      this.meta_image = ($("meta[property='og:image']")).attr('content');
      this.meta_description = ($("meta[property='og:description']")).attr('content');
      this.loc = window.location.href.replace('#', '');
      this.checkButtons();
      event_emitter.addListener('UPDATE_SHARING_DATA', this.onSharingDataUpdated);
    }

    SocialSharing.prototype.onSharingDataUpdated = function(id, obj) {
      if (id === this.ref.attr('id')) {
        this.meta_title = obj.title;
        this.meta_image = obj.image;
        this.meta_description = obj.description;
        this.loc = obj.url;
        return this.checkButtons();
      }
    };

    SocialSharing.prototype.checkButtons = function() {
      var email_body, email_btn, email_subject, email_url, facebook_btn, facebook_url, gplus_btn, gplus_url, pinterest_btn, pinterest_url, tumblr_btn, tumblr_caption, tumblr_click_thru, tumblr_source, tumblr_url, twitter_btn, twitter_url, weibo_btn, weibo_url;
      facebook_btn = this.ref.find('.facebook a');
      if (facebook_btn.length === 1) {
        facebook_url = encodeURI("http://www.facebook.com/sharer.php?u=" + this.loc);
        this.setButton(facebook_btn, facebook_url);
      }
      twitter_btn = this.ref.find('.twitter a');
      if (twitter_btn.length === 1) {
        twitter_url = encodeURI("http://twitter.com/share?text=" + this.meta_title + "&url=" + this.loc);
        this.setButton(twitter_btn, twitter_url);
      }
      gplus_btn = this.ref.find('.gp a');
      if (gplus_btn.length === 1) {
        gplus_url = encodeURI("https://plus.google.com/share?url=" + this.loc);
        this.setButton(gplus_btn, gplus_url);
      }
      pinterest_btn = this.ref.find('.pinterest a');
      if (pinterest_btn.length === 1) {
        pinterest_url = encodeURI("http://pinterest.com/pin/create/button?url=" + this.loc + "&media=" + this.meta_image + "&description=" + this.meta_description);
        this.setButton(pinterest_btn, pinterest_url);
      }
      tumblr_btn = this.ref.find('.tumblr a');
      if (tumblr_btn.length === 1) {
        tumblr_source = encodeURIComponent(this.meta_image);
        tumblr_caption = encodeURIComponent(this.meta_description);
        tumblr_click_thru = encodeURIComponent(this.loc);
        tumblr_url = "http://www.tumblr.com/share/photo?source=" + tumblr_source + "&caption=" + tumblr_caption + "&click_thru=" + tumblr_click_thru;
        this.setButton(tumblr_btn, tumblr_url);
      }
      weibo_btn = this.ref.find('.weibo a');
      if (weibo_btn.length === 1) {
        weibo_url = encodeURI("http://service.weibo.com/share/share.php?url=" + this.loc + "&title=" + this.meta_title + "&pic=" + this.meta_image);
        this.setButton(weibo_btn, weibo_url);
      }
      email_btn = this.ref.find('.email a');
      if (email_btn.length === 1) {
        email_subject = email_btn.attr('data-subject');
        email_body = email_btn.attr('data-body');
        email_url = encodeURI("mailto:?subject=" + email_subject + "&body=" + email_body + this.loc);
        return this.setButton(email_btn, email_url, true);
      }
    };

    SocialSharing.prototype.setButton = function(btn, url, is_email) {
      if (is_email == null) {
        is_email = false;
      }
      btn.attr('href', url);
      if (!is_email) {
        return btn.bind('click', (function(e) {
          e.preventDefault();
          return window.open($(e.currentTarget).attr('href'), 'Share', 'toolbar=0,status=0,width=900,height=500');
        }));
      }
    };

    return SocialSharing;

  })();

}).call(this);
