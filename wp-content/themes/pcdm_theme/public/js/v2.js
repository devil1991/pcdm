

$(document).ready(() => {
  const wrapper = $('#videoproducts')
  TweenLite.set(wrapper.get(0), { css: {opacity: 0} })
  const videoEl = $('.videoproducts__video')
  const player = plyr.setup(videoEl.get(0))[0];
  $('.videoproducts__shop').on('click', 'a', (e) => {
    e.preventDefault()
    $('body, html').animate({
      scrollTop: $('.videoproducts__grid').offset().top
    }, { duration: 1200 })
  })

  const sr = ScrollReveal();
  player.on('ready', function(event) {
    imagesLoaded(wrapper.get(0), () => {
      TweenLite.to(wrapper.get(0), 0.6, { css: {opacity: 1} })
      sr.reveal('.videoproducts__grid .item');
    })
  })

})
//
