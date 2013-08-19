package com.fdvs.cpb.backendlab.interfaces.notes;

import com.fdvs.cpb.backendlab.interfaces.I_BaseResponse;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 5:49 PM
 * To change this template use File | Settings | File Templates.
 */
public class I_CreateNoteResponse  extends I_BaseResponse {

    private Long noteId;

    public I_CreateNoteResponse(String code, String message, Long noteId) {
        this.code = code;
        this.message = message;
        this.noteId = noteId;
    }


    public Long getNoteId() {
        return noteId;
    }

    public void setNoteId(Long noteId) {
        this.noteId = noteId;
    }
}
