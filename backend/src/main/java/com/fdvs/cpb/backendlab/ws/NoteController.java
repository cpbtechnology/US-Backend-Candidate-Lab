package com.fdvs.cpb.backendlab.ws;


import com.fdvs.cpb.backendlab.interfaces.notes.I_CreateNoteResponse;
import com.fdvs.cpb.backendlab.interfaces.notes.I_DeleteNoteResponse;
import com.fdvs.cpb.backendlab.interfaces.notes.I_Note;
import com.fdvs.cpb.backendlab.interfaces.notes.I_UpdateNoteResponse;
import com.fdvs.cpb.backendlab.model.notes.Note;
import com.fdvs.cpb.backendlab.services.NoteService;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;
import com.fdvs.cpb.backendlab.util.IUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

import javax.annotation.Resource;
import java.util.ArrayList;
import java.util.List;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 3/20/13
 * Time: 5:02 PM
 */
@Controller
@RequestMapping(value = "/notes")
public class NoteController extends BaseController {

    Log LOG = LogFactory.getLog(NoteController.class);

    @Resource(name = "noteService")
    NoteService noteService;

    public void setNoteService(NoteService noteService) {
        this.noteService = noteService;
    }

    /**
     * Creates a new note. Title is mandatory.
     *
     * @param userId
     * @param title
     * @param description
     * @return
     * @throws ServiceException
     */
    @RequestMapping( value = "/{userId}/add", method = RequestMethod.POST )
    @ResponseBody
    public I_CreateNoteResponse addNote(@PathVariable Long userId,
                                        @RequestParam String title,
                                        @RequestParam String description) throws ServiceException {
        Note note = noteService.createNote(userId,title,description);
        return new I_CreateNoteResponse("OK","Note created",note.getId());
    }

    /**
     * Updates an existing note.
      * @param userId
     * @param noteId
     * @param title
     * @param description
     * @return
     * @throws ServiceException
     */
    @RequestMapping( value = "/{userId}/note/{noteId}/update", method = RequestMethod.POST )
    @ResponseBody
    public I_UpdateNoteResponse updateNote(@PathVariable Long userId,
                                           @PathVariable Long noteId,
                                           @RequestParam String title,
                                           @RequestParam String description) throws ServiceException {
        Note note = noteService.updateNote(userId, noteId, title, description);
        return new I_UpdateNoteResponse("OK","Note updated",note.getId(),note.getLastModified());
    }

    /**
     * Delelete a note by its id.
     *
     * @param userId
     * @param noteId
     * @return
     * @throws ServiceException
     */
    @RequestMapping( value = "/{userId}/note/{noteId}/delete", method = RequestMethod.POST )
    @ResponseBody
    public I_DeleteNoteResponse getTodosLosClientes(@PathVariable Long userId, @PathVariable Long noteId) throws ServiceException {
        noteService.deleteNote(userId, noteId);
        return new I_DeleteNoteResponse("OK","Note deleted");
    }

    /**
     * Returns a specific note.
     *
     * @param userId
     * @param noteId
     * @return
     * @throws ServiceException
     */
    @RequestMapping( value = "/{userId}/note/{noteId}/get", method = RequestMethod.GET )
    @ResponseBody
    public I_Note getNote(@PathVariable Long userId, @PathVariable Long noteId) throws ServiceException {
        Note note = noteService.findNote(userId, noteId);

        I_Note iNote = IUtils.toI_Note(note);

        return iNote;
    }

    /**
     * Returns the user notes. It cant be paginated through request parameters pageSize and pageNumber
     *
     * @param userId
     * @param pageSize
     * @param pageNumber
     * @return
     * @throws ServiceException
     */
    @RequestMapping( value = "/{userId}/list", method = RequestMethod.GET )
    @ResponseBody
    public List<I_Note> listNotes(@PathVariable Long userId,
                                  @RequestParam(required = false) Integer pageSize,
                                  @RequestParam(required = false) Integer pageNumber)
            throws ServiceException {
        List<Note> notes = noteService.listNotes(userId, pageSize,pageNumber);

        List<I_Note> i_notes = new ArrayList<I_Note>();
        for (Note note : notes) {
            i_notes.add(IUtils.toI_Note(note));
        }

        return i_notes;
    }







}
