package com.fdvs.cpb.backendlab.interfaces.notes;

import com.fdvs.cpb.backendlab.interfaces.I_BaseResponse;

import java.util.Date;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 5:49 PM
 * To change this template use File | Settings | File Templates.
 */
public class I_UpdateNoteResponse extends I_BaseResponse {

    private Long noteId;
    private Date date;

    public I_UpdateNoteResponse(String code, String message, Long noteId, Date date) {
        this.code = code;
        this.message = message;
        this.noteId = noteId;
        this.date = date;
    }



    public Long getNoteId() {
        return noteId;
    }

    public void setNoteId(Long noteId) {
        this.noteId = noteId;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }
}
