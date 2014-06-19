package labs.controller;

import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import labs.model.Page;
import labs.model.SearchResult;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.data.redis.core.script.RedisScript;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@RequestMapping(method = RequestMethod.GET, value = "/search")
public class SearchController {

	@Autowired
	private StringRedisTemplate redisTemplate;

	@Autowired
	private RedisScript<Object> script;

	@ResponseBody
	@RequestMapping(consumes = { "application/json", "text/json" })
	public SearchResult getJson(@RequestParam("q") String q) {
		return new SearchResult(q, getSearchResult(q));
	}

	@RequestMapping
	public String getHtml(@RequestParam("q") String q, Model model) {
		model.addAttribute("result", new SearchResult(q, getSearchResult(q)));
		return "search";
	}

	private List<Page> getSearchResult(String q) {
		List<Page> result = new ArrayList<Page>();

		@SuppressWarnings("unchecked")
		ArrayList<String> pageUrls = (ArrayList<String>) redisTemplate.execute(script, null, "labs:pages", q);

		if (pageUrls.size() > 0) {
			Iterator<String> itar = pageUrls.iterator();
			String pageUrl;
			String encodedPageUrl;
			int indexBegin;
			int indexEnd;

			while (itar.hasNext()) {
				pageUrl = (String) itar.next();

				try {
					encodedPageUrl = URLDecoder.decode(pageUrl, "UTF-8");
					indexBegin = encodedPageUrl.lastIndexOf("/");
					indexEnd = encodedPageUrl.lastIndexOf(".html");

					if (indexBegin == -1) {
						indexBegin = 0;
					} else {
						indexBegin = indexBegin + 1;
					}

					if (indexEnd > encodedPageUrl.length()) {
						indexEnd = encodedPageUrl.length() - 1;
					}

					result.add(new Page(pageUrl, encodedPageUrl.substring(indexBegin, indexEnd)));
				} catch (Exception exception) {
					System.out.println(exception);
				}
			}
		}

		return result;
	}
}