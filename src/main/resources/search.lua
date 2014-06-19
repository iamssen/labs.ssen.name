-- script parameter 
local NS = ARGV[1]
local query = string.lower(ARGV[2])

-- variables
local matchedPageUrls = {}
local pageUrls = redis.call("hkeys", NS)
local numPages = table.getn(pageUrls)

-- loop variables
local matchedBegin
local matchedEnd

local pageUrl
local pageContent

local i
local keyword

local matched

-- loop
for i = 1, numPages, 1 do
	pageUrl = pageUrls[i]
	pageContent = redis.call("hget", NS, pageUrl)
	
	matched = true
	
	for keyword in string.gmatch(query, "[^%s]+") do
		matchedBegin, matchedEnd = string.find(pageContent, keyword)
		
		if matchedBegin == nil or matchedBegin == -1 then
			matched = false
			break
		end
	end
	
	if matched then
		table.insert(matchedPageUrls, pageUrl)
	end
end

return matchedPageUrls