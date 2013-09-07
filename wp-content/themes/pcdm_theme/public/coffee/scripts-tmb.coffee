$ ->
  
  posts_prev = 0

  contentCheck = =>

    posts = $ 'section.content .post'
    posts_length = posts.length
  
    if posts_length isnt posts_prev

      for i in [0...posts_length]
    
        post = $ posts[i]

        unless post.hasClass 'js-checked'
    
          # remove tags #small, #medium, #large
          tags = post.find '>.hover .tags >li >a'
          for j in [0...tags.length]
            tag = $ tags[j]
            text = tag.text().substring 1
            if text is 'small' or text is 'medium' or text is 'large' then tag.remove()
      
          # text vertically centered
          hover = post.find '>.hover'
          aux = hover.find '>.wrap-text >.aux-text'
          pos = .5 * (hover.height() - aux.height())
          aux.css {top: "#{pos}px"}

          # outside the loop..
          unless pos < 0 then post.addClass 'js-checked'

      posts_prev = posts_length

    setTimeout contentCheck, 1000
  
  $(window).load contentCheck

