class window.CookieManager

  constructor: () ->

  getCookie: (name) =>

    value = ''

    #console.log 'cookie -> ', document.cookie
    if document.cookie.length > 0

      search = "#{name}="
      offset = document.cookie.indexOf search

      if offset isnt -1
        offset += search.length
        end = document.cookie.indexOf ';', offset
        if end is -1 then end = document.cookie.length
        value = unescape(document.cookie.substring offset, end)

    return value

  setCookie: (name, value, exp_months, domain) =>

      exp_date = new Date()
      exp_date.setMonth(exp_date.getMonth() + exp_months)
      document.cookie = "#{name}=#{escape value};expires=#{exp_date}"
      #document.cookie = "#{name}=#{escape value};expires=#{exp_date};domain=#{domain};path=/"
      #console.log 'cookie -> ', document.cookie