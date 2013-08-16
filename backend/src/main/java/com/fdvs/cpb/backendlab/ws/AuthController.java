package com.fdvs.cpb.backendlab.ws;

import com.fdvs.cpb.backendlab.interfaces.auth.I_LoginResponse;
import com.fdvs.cpb.backendlab.interfaces.auth.I_UserPassword;
import com.fdvs.cpb.backendlab.model.auth.User;
import com.fdvs.cpb.backendlab.services.AuthService;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.context.request.WebRequest;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:10 AM
 */
@Controller
@RequestMapping(value = "/auth")
public class AuthController {

    private static final Log LOG = LogFactory.getLog(AuthController.class);

    @Resource(name = "authService")
    private AuthService authService;

    public void setAuthService(AuthService authService) {
        this.authService = authService;
    }

    @ExceptionHandler(Exception.class)
    public @ResponseBody String handleUncaughtException(Exception ex, WebRequest request, HttpServletResponse response) throws IOException {
        response.sendError(HttpServletResponse.SC_INTERNAL_SERVER_ERROR, ex.getMessage());
        LOG.error(ex.getMessage(),ex);
        return null;
    }

    @RequestMapping( value = "/login", method = RequestMethod.POST )
    @ResponseBody
    public I_LoginResponse login(@RequestParam String username, @RequestParam String password) throws ServiceException {
        I_LoginResponse resp = authService.login(new I_UserPassword(username,password));
        return resp;
    }

    @RequestMapping( value = "/createAccount", method = RequestMethod.POST )
    @ResponseBody
    public I_LoginResponse login(@RequestParam("username") String username, @RequestParam("email") String email, @RequestParam("password") String password) throws ServiceException {
        User user = authService.createAccount(username, email, password);
        I_LoginResponse resp = null;
        if (user != null){
            resp = new I_LoginResponse("OK","Account created",user.getId());
        } else {
            resp = new I_LoginResponse("ERROR","Could not create account",0l);
        }
        return resp;
    }


}
