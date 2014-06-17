package labs.config;

import labs.Application;

import org.springframework.boot.builder.SpringApplicationBuilder;
import org.springframework.boot.context.web.SpringBootServletInitializer;

public class Initialize extends SpringBootServletInitializer {
	@Override
	protected SpringApplicationBuilder configure(
			SpringApplicationBuilder application) {
		return application.sources(Application.class);
	}
}