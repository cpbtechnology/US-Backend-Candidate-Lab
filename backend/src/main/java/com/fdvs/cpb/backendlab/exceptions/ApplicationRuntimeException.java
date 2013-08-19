package com.fdvs.cpb.backendlab.exceptions;

/**
 * Created with IntelliJ IDEA.
 * User: DJ Mamana
 * Date: 15/05/13
 * Time: 13:00
 * To change this template use File | Settings | File Templates.
 */
public class ApplicationRuntimeException extends RuntimeException {

    public ApplicationRuntimeException() {
    }

    public ApplicationRuntimeException(String message) {
        super(message);
    }

    public ApplicationRuntimeException(String message, Throwable cause) {
        super(message, cause);
    }

    public ApplicationRuntimeException(Throwable cause) {
        super(cause);
    }
}
