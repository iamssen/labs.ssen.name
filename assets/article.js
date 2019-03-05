$(document).ready(function () {
	// fix markdown
	$('#article-content table').addClass('table table-striped table-bordered')

	$('#article-content img').click(function (event) {
		if ($(this).parent().prop('tagName').toLowerCase() !== "a") {
			var args = {href: $(this).attr('src')}

			if ($(this).attr('alt')) {
				args['title'] = $(this).attr('alt')
			}

			$.fancybox.open(args)
		}
	})

	$('#article-content img').load(function() {
		if ($(this).width() > 250) {
			$(this).addClass('center')
		}
	})
})