package labs.controller;

import java.util.List;

import labs.model.Page;
import labs.model.SearchResult;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@RequestMapping(method = RequestMethod.GET, value = "/search")
public class SearchController {

	@ResponseBody
	@RequestMapping(consumes = { "application/json", "text/json" })
	public SearchResult getJson(@RequestParam("q") String q) {
		return new SearchResult(q, getSearchResult());
	}

	@RequestMapping
	public String getHtml(@RequestParam("q") String q, Model model) {
		model.addAttribute("result", new SearchResult(q, getSearchResult()));
		return "search";
	}

	private List<Page> getSearchResult() {
		return null;
		// List<Page> result = new ArrayList<Page>();
		// result.add(new Page("/docs/1", "Title1"));
		// result.add(new Page("/docs/2", "Title2"));
		// result.add(new Page("/docs/2", "Title3"));
		// result.add(new Page("/docs/2", "Title4"));
		// return result;
	}
}