package com.fdvs.cpb.backendlab.interfaces.notes;

import com.fdvs.cpb.backendlab.interfaces.I_BaseResponse;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 6:35 PM
 * To change this template use File | Settings | File Templates.
 */
public class I_DeleteNoteResponse extends I_BaseResponse  {
    public I_DeleteNoteResponse(String code, String message) {
        super(code,message);
    }
}
