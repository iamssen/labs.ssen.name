package labs.model;

public class Page {
	private String url;
	private String title;
	
	public Page(String url, String title) {
		this.url = url;
		this.title = title;
	}
	
	public String getUrl() {
		return url;
	}
	
	public String getTitle() {
		return title;
	}
}
