package labs;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.builder.SpringApplicationBuilder;
import org.springframework.boot.context.web.SpringBootServletInitializer;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.context.annotation.Bean;
import org.springframework.boot.context.embedded.ServletContextInitializer;
import org.springframework.web.filter.CharacterEncodingFilter;
import javax.servlet.ServletContext;
import org.springframework.http.converter.StringHttpMessageConverter;
import org.springframework.http.MediaType;
import java.util.ArrayList;
import java.util.List;
import java.nio.charset.Charset;

@Configuration
@ComponentScan
@EnableAutoConfiguration
public class Application {
    @Bean
    public CharacterEncodingFilter characterEncodingFilter() {
        final CharacterEncodingFilter characterEncodingFilter = new CharacterEncodingFilter();
        characterEncodingFilter.setEncoding("UTF-8");
        characterEncodingFilter.setForceEncoding(false);
        return characterEncodingFilter;
    }

    @Bean
    public StringHttpMessageConverter stringHttpMessageConverter() {
        final StringHttpMessageConverter stringHttpMessageConverter = new StringHttpMessageConverter(Charset.forName("UTF-8"));
        List<MediaType> mediaTypes = new ArrayList<MediaType>();
        mediaTypes.add(MediaType.TEXT_HTML);
        stringHttpMessageConverter.setSupportedMediaTypes(mediaTypes);
        return stringHttpMessageConverter;
    }

    public static void main(String[] args) {
        SpringApplication.run(Application.class, args);
    }
}