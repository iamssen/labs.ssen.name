require 'pp'

module Jekyll

	class TagIndexPage < Page
		def initialize(site, base, dir, tags)
			@site = site
			@base = base
			@dir = dir
			@name = 'index.html'

			self.process(@name)
			self.read_yaml(File.join(base, '_layouts'), 'tag-index.html')
			self.data['tags'] = tags # hash.array
			self.data['title'] = 'Hello Tags'
		end
	end

	class TagPageGenerator < Generator
		safe true

		def generate(site)
			site.data['page_tags'] = Hash.new()
			tags = site.data['page_tags']

			site.pages.each do |page|
				if not page.data['tags'].nil?
					page.data['tags'].each do |tag|
						if tags[tag].nil?
							tags[tag] = Array.new()
						end

						tags[tag].push(page)
					end
				end
			end

			site.pages << TagIndexPage.new(site, site.source, 'tags', site.data['page_tags'])
		end
	end

	class TagSize < Liquid::Tag
		def initialize(tag_name, text, tokens)
			super
			@text = text
		end

		def render(context)
			content = Liquid::Template.parse(@text).render context
			"#{content}"
		end
	end

end

Liquid::Template.register_tag('tag_size', Jekyll::TagSize)