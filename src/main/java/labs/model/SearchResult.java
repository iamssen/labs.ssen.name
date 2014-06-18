package labs.model;

import java.util.List;

public class SearchResult {
	private final String query;
	private final List<Page> pages;

	public SearchResult(String query, List<Page> pages) {
		this.query = query;
		this.pages = pages;
	}

	public String getQuery() {
		return query;
	}

	public List<Page> getPages() {
		return pages;
	}
	
	public Boolean getHasPages() {
		return pages != null && pages.size() > 0;
	}
}