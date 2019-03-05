function moveto(id) {
	var topoffset = 30
	var speed = 500
	var destination = $('#' + id).offset().top - topoffset
	$('html:not(:animated),body:not(:animated)').animate({ scrollTop: destination }, speed)
}

function validateSearchParameters(form) {
	var q = form.q.value.replace(/(^\s*)|(\s*$)/, '')

	if (q == "") {
		alert('Please input your search keyword.')
		return false
	}

	return true
}