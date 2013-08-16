package com.fdvs.cpb.backendlab.util;

import com.fdvs.cpb.backendlab.interfaces.notes.I_Note;
import com.fdvs.cpb.backendlab.model.notes.Note;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 6:24 PM
 * To change this template use File | Settings | File Templates.
 */
public class IUtils {
    public static I_Note toI_Note(Note note) {
        I_Note iNote = new I_Note();

        iNote.setCreated(note.getCreated());
        iNote.setLastModified(note.getLastModified());
        iNote.setTitle(note.getTitle());
        iNote.setDescription(note.getDescription());
        iNote.setId(note.getId());
        iNote.setOwnerId(note.getOwner().getId());

        return iNote;
    }
}
