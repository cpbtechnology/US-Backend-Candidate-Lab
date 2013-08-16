package com.fdvs.cpb.backendlab;

import org.springframework.beans.BeansException;
import org.springframework.context.ApplicationContext;
import org.springframework.context.ApplicationContextAware;
import org.springframework.web.context.support.WebApplicationContextUtils;

import javax.servlet.ServletContext;
import java.util.Properties;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 3/19/13
 * Time: 2:53 PM
 */
public class SpringHelper implements ApplicationContextAware {

    private ApplicationContext context;

    static final SpringHelper instance = new SpringHelper();

    private SpringHelper(){}

    static public SpringHelper getInstance(){
        return instance;
    }

    static public void init (ServletContext servletContext) {
        /*ServletContext servletContext =
                ((WebApplicationContext) application.getContext())
                .getHttpSession().getServletContext();*/
        instance.context = WebApplicationContextUtils.getRequiredWebApplicationContext(servletContext);
    }

    static public String getPropery(String property){
        Properties properties = (Properties) getBean("properties");
        if (properties != null){
            if(properties.containsKey(property))
                return properties.getProperty(property);
        }

        return null;
    }


    static public Object getBean(final String beanRef) {
        if (instance.context == null){
            throw new RuntimeException("SpringHelper no fue correctametne inicializado");
        }
        return instance.context.getBean(beanRef);
    }


    @Override
    public void setApplicationContext(ApplicationContext applicationContext) throws BeansException {
        this.context = applicationContext;
    }
}
