package com.fdvs.cpb.backendlab.interfaces.auth;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:08 AM
 */
public class I_LoginResponse {

    private String codigo;
    private String mensaje;
    private Long userId;

    public I_LoginResponse() {
    }

    public I_LoginResponse(String codigo, String mensaje, Long userId) {
        this.codigo = codigo;
        this.mensaje = mensaje;
        this.userId = userId;
    }

    public String getCodigo() {
        return codigo;
    }

    public void setCodigo(String codigo) {
        this.codigo = codigo;
    }

    public String getMensaje() {
        return mensaje;
    }

    public void setMensaje(String mensaje) {
        this.mensaje = mensaje;
    }

    public Long getUserId() {
        return userId;
    }

    public void setUserId(Long userId) {
        this.userId = userId;
    }
}
