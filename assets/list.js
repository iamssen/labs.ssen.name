$(document).ready(function () {
	var cookiePrefix = 'branche-opened-'

	var cookieConfig = {
		path: '/',
		expires: 1
	}

	// initialize tree menu
	$('#list-pages-tree li.tree-node').each(function () {
		var node = $(this)
			, disclosuer = $(this).find('> a')
			, branche = $(this).find('> ul')
			, opened
			, id

		id = node.attr('branche-id')
		opened = $.cookie(cookiePrefix + id)

		// open / close by cookie data
		if (opened) {
			if (opened == 'n' && node.hasClass('tree-node-open')) {
				node.removeClass('tree-node-open')
			} else if (opened == 'y' && !node.hasClass('tree-node-open')) {
				node.addClass('tree-node-open')
			}
		}

		// click open / close handler
		disclosuer.click(function (event) {
			event.preventDefault()
			event.stopPropagation()
			event.stopImmediatePropagation()

			var opened = node.hasClass('tree-node-open')
			var id = node.attr('branche-id')

			if (opened) {
				node.removeClass('tree-node-open')
				$.cookie(cookiePrefix + id, 'n', cookieConfig)
			} else {
				node.addClass('tree-node-open')
				$.cookie(cookiePrefix + id, 'y', cookieConfig)
			}
		})
	})

	// open current page and parents
	var primary = $('#list-pages-tree').attr('page-primary-id').toString()

	if (primary != '') {
		var leafs = $('#list-pages-tree li.tree-leaf[primary-id="' + primary + '"]')

		if (leafs.length > 0) {
			leafs.addClass('highlighted')

			leafs.each(function () {
				var c = $(this).parent()
				var f = 30

				while (--f >= 0) {
					if (c.hasClass('tree-node')) {
						if (!c.hasClass('tree-node-open')) {
							c.addClass('tree-node-open')
						}
					}
					c = c.parent()

					if (c[0].tagName != 'ul' && c[0].tagName != 'li') {
						break
					}
				}
			})
		}
	}
})