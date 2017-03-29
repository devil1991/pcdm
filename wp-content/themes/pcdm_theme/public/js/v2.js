

$(document).ready(() => {
  const wrapper = $('#videoproducts')
  TweenLite.set(wrapper.get(0), { css: {opacity: 0} })
  const videoEl = $('.videoproducts__video')
  const cover = $('.videoproducts__videoCover')
  window.onYouTubeIframeAPIReady = () => {
    const player = new YT.Player('player', {
      playsinline: 0,
      rel: 0,
      showinfo: 0
    })
    cover.one('click', () => {
      player.playVideo()
      TweenLite.to(cover.get(0), 1, {
        css: {
          opacity: 0
        },
        onComplete: () => {
          cover.hide()
        }
      })
    })
  }
  // const player = plyr.setup(videoEl.get(0))[0];
  $('.videoproducts__shop').on('click', 'a', (e) => {
    e.preventDefault()
    $('body, html').animate({
      scrollTop: $('.videoproducts__grid').offset().top
    }, { duration: 1200 })
  })

  const sr = ScrollReveal();
  // player.on('ready', function(event) {
  // })
  $.getScript('https://www.youtube.com/iframe_api', () => {
    imagesLoaded(wrapper.get(0), () => {
      TweenLite.to(wrapper.get(0), 0.6, { css: {opacity: 1} })
      sr.reveal('.videoproducts__grid .item');
    })
  })

  if (Modernizr.touch) {
    const items = wrapper.find('.item')
    items.each((index, el) => {
      const anchors = $(el).find('a')
      anchors.each((index, _el) => {
        const anchor = $(_el)
        anchor.swipe({
          click: (event, target) => {
            if (anchor.hasClass('hovered')) {
              window.open(anchor.attr('href'),'_blank')
            }
            anchor.toggleClass('hovered')
            if (anchor.hasClass('hovered')) {
              setTimeout(()=> anchor.toggleClass('hovered'), 2000)
            }
          }
        })
      })
      anchors.find('.hover').addClass('touch-item')
    })
  }

})
//
