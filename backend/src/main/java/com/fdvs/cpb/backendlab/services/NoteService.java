package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.model.notes.Note;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;

import java.util.List;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 5:36 PM
 * To change this template use File | Settings | File Templates.
 */
public interface NoteService {
    Note createNote(Long userId, String title, String description) throws ServiceException;

    Note updateNote(Long userId, Long noteId, String title, String description) throws ServiceException;

    Note findNote(Long userId, Long noteId) throws ServiceException;

    void deleteNote(Long userId, Long noteId) throws ServiceException;

    List<Note> listNotes(Long userId, Integer pageSize, Integer pageNumber) throws ServiceException;
}
