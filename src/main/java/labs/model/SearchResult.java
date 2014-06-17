package labs.model;

public class SearchResult {
	private final String query;
	private final String result;

	public SearchResult(String query, String result) {
		this.query = query;
		this.result = result;
	}

	public String getQuery() {
		return query;
	}

	public String getResult() {
		return result;
	}
}