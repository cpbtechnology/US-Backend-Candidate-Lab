package com.fdvs.cpb.backendlab.util;

import org.springframework.core.io.ByteArrayResource;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 3/27/13
 * Time: 7:31 PM
 */
public class ByteArrayResourceWithFileName extends ByteArrayResource {
    public ByteArrayResourceWithFileName(byte[] byteArray, String description) {
        super(byteArray, description);
    }

    private ByteArrayResourceWithFileName(byte[] byteArray) {
        super(byteArray);
    }

    @Override
    public String getFilename() {
        return getDescription();
    }
}
