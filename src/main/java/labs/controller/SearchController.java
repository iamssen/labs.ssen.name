package labs.controller;

import labs.model.SearchResult;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@RequestMapping(method = RequestMethod.GET, value = "/search/{q}")
public class SearchController {

	@ResponseBody
	@RequestMapping(consumes = { "application/json", "text/json" })
	public SearchResult getJson(@PathVariable String q) {
		return new SearchResult(q, "Search Result Body");
	}

	@RequestMapping
	public String getHtml(@PathVariable String q, Model model) {
		model.addAttribute("result", new SearchResult(q, "Search Result Body"));
		return "search";
	}
}