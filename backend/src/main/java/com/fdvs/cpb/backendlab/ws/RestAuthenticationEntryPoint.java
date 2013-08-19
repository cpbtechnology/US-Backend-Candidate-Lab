package com.fdvs.cpb.backendlab.ws;

import org.springframework.security.core.AuthenticationException;
import org.springframework.security.web.AuthenticationEntryPoint;
import org.springframework.stereotype.Component;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

/**
 * Esta clase se invoca cuando al querer acceder a un recurso protegido por la seguridad y no estamos logueados. Lo que
 * haria normalmente es redireccionarnos a el formualrio de auth. Sin embargo en un sistema RESTFULL esto no tiene sentido
 * por lo que directamente devolvemos el codigo de HTTP NO AUTORIZADO (401)
 *
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 3/20/13
 * Time: 8:26 PM
 */
@Component( "restAuthenticationEntryPoint" )
public class RestAuthenticationEntryPoint implements AuthenticationEntryPoint {
    @Override
    public void commence(HttpServletRequest httpServletRequest, HttpServletResponse httpServletResponse, AuthenticationException e) throws IOException, ServletException {
        httpServletResponse.sendError( HttpServletResponse.SC_UNAUTHORIZED, "Unauthorized" );

    }
}
