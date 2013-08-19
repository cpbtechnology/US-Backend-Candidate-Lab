package com.fdvs.cpb.backendlab.services.exceptions;

/**
 * Created with IntelliJ IDEA.
 * User: DJ Mamana
 * Date: 17/04/13
 * Time: 22:00
 * To change this template use File | Settings | File Templates.
 */
public class ServiceException extends Exception {
    public ServiceException(String message) {
        super(message);
    }

    public ServiceException(String message, Throwable cause) {
        super(message, cause);
    }

    public ServiceException(Throwable cause) {
        super(cause);
    }

    public ServiceException() {
    }
}
