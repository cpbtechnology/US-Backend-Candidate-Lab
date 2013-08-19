package com.fdvs.cpb.backendlab.ws;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.beans.propertyeditors.CustomDateEditor;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.InitBinder;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.context.request.WebRequest;

import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.lang.reflect.UndeclaredThrowableException;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created with IntelliJ IDEA.
 * User: DJ Mamana
 * Date: 15/05/13
 * Time: 12:46
 * To change this template use File | Settings | File Templates.
 */
public class BaseController {

    private static final Log LOG = LogFactory.getLog(BaseController.class);


    protected static final SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss");

    @InitBinder
    public void initBinder(WebDataBinder binder) {
        dateFormat.setLenient(false);
        binder.registerCustomEditor(Date.class, new CustomDateEditor(dateFormat, false));
    }

    @ExceptionHandler(Exception.class)
    public @ResponseBody
    String handleUncaughtException(Exception ex, WebRequest request, HttpServletResponse response) throws IOException {
        if (ex instanceof UndeclaredThrowableException){
            ex = (Exception) ((UndeclaredThrowableException)ex).getUndeclaredThrowable();
        }
        response.sendError(HttpServletResponse.SC_INTERNAL_SERVER_ERROR, ex.getClass().getCanonicalName() + ": " + ex.getMessage());
        LOG.error(ex.getMessage(),ex);
        return null;
    }

}
