package com.fdvs.cpb.backendlab.exceptions;

public class ConversionException extends RuntimeException {

	private static final long serialVersionUID = -6051433301898423730L;

	public ConversionException() {
		super();
	}

	public ConversionException(String message, Throwable cause) {
		super(message, cause);
	}

	public ConversionException(String message) {
		super(message);
	}

	public ConversionException(Throwable cause) {
		super(cause);
	}

}
