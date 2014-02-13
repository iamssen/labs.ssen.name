---
layout: layout

styles:
- '/assets/nav.css'
- '/assets/search.css'
- '/assets/list.css'
- '/assets/copyright.css'

scripts:
- '/assets/list.js'

includes:
  nav: 'nav.html'
  search: 'search.html'
  list: 'list.html'
  copyright: 'copyright.html'
---

{% include nav.html %}
{% include search.html %}
{% include list.html %}
{% include copyright.html %}