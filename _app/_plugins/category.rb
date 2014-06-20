require 'pp'
		
module Jekyll

	class CategoryGenerator < Generator
		safe true

		def generate(site)
			root = Hash.new()

			site.pages.each do |page|
				if page.data['title'] == 'Test'
					puts '[category.rb]'
					puts page.data['title']
					puts page.data['date']
					puts page.data['primary']
					puts '[/category.rb]'
				end

				if not page.data['categories'].nil?
					current = root
					page.data['categories'].each do |category|
						if current[category].nil?
							current[category] = Hash.new()
						end
						current = current[category]
					end
					current[page.data['title']] = page
				end
			end

			str = '<ul>'
			str += node_to_string(root, '')
			str += '</ul>'

			site.data['page_tree_hash'] = root
			site.data['page_tree'] = str
		end

		def node_to_string(hash, parent_category_id)
			str = ''
			hash = hash.sort_by { |key, value| key }
			hash.each do |key, value|
				if value.is_a?(Hash)
					current_category_id = "#{parent_category_id}/#{key}"
					str += "<li class='tree-node tree-node-open' branche-id='#{current_category_id}'><a>#{key}</a><ul>"
					str += node_to_string(value, current_category_id)
					str += '</ul></li>'
				else
					url = value['url']
					primary = value.data['primary']
					str += "<li class='tree-leaf' primary-id='#{primary}'><a href='#{url}'>#{key}</a></li>"
				end
			end
			str
		end
	end
end