$.fn.flplay = function () {
	return this.each(function () {
		var preview = $(this).attr('preview')
			, src = $(this).attr('src')
			, width = $(this).attr('width')
			, height = $(this).attr('height')
			, text = $(this).html()
			, template = []

		template.push('<div class="flplay" flsrc="{{flsrc}}" style="width: {{width}}px; height: {{height}}px;">')
		template.push('  <img class="flplay-screen" src="{{preview}}" width="{{width}}" height="{{height}}"/>')
		template.push('  <div class="flplay-play">')
		template.push('    <svg width="93px" height="55px" viewBox="0 0 93 55" version="1.1" xmlns="http://www.w3.org/2000/svg" onclick="__flplay(event)">')
		template.push('      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">')
		template.push('        <g>')
		template.push('          <rect x="0" y="0" width="92.8164062" height="54.2888414" rx="7"></rect>')
		template.push('          <path d="M37,41.0200472 L37,13 L61.4145264,27.0100236 L37,41.0200472 Z" fill="#FFFFFF"></path>')
		template.push('        </g>')
		template.push('      </g>')
		template.push('    </svg>')
		template.push('    <p>{{text}}</p>')
		template.push('  </div>')
		template.push('</div>')

		$(this).replaceWith(S(template.join('')).template({ preview: preview, flsrc: src, width: width, height: height, text: text }).s)
	})
}

$(document).ready(function () {
	$('flplay').flplay()
})

function __flplay(event) {
	var svg = $(event.currentTarget)
		, flplay = svg.parent().parent()
		, img = flplay.find('> img')
		, width = img.attr('width')
		, height = img.attr('height')
		, src = flplay.attr('flsrc')

	if (width && height && src) {
		flplay.flash({swf: src, width: width, height: height})
	}
}