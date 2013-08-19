package com.fdvs.cpb.backendlab.interfaces;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 5:49 PM
 * To change this template use File | Settings | File Templates.
 */
public class I_BaseResponse {

    protected String code;
    protected String message;

    public I_BaseResponse() {
    }

    protected I_BaseResponse(String code, String message) {
        this.code = code;
        this.message = message;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
