package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.model.auth.User;
import com.fdvs.cpb.backendlab.model.notes.Note;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;
import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.TypedQuery;
import java.util.Date;
import java.util.List;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 5:36 PM
 * To change this template use File | Settings | File Templates.
 */
public class NoteServiceImpl extends BaseService implements NoteService  {

    private static final Log LOG = LogFactory.getLog(NoteServiceImpl.class);

    @Override
    @Transactional(propagation = Propagation.REQUIRED)
    public Note createNote(Long userId, String title, String description) throws ServiceException {

        if (StringUtils.isEmpty(title))
            throw new ServiceException("Title cannot be empty");

        User user = getUserOrDie(userId);

        Note note = new Note(title,description);
        note.setCreated(new Date());
        note.setLastModified(note.getCreated());
        note.setOwner(user);

        entityManager.persist(note);

        return note;
    }

    @Override
    @Transactional(propagation = Propagation.REQUIRED)
    public Note updateNote(Long userId, Long noteId, String title, String description) throws ServiceException {
        if (StringUtils.isEmpty(title))
            throw new ServiceException("Title cannot be empty");

        User user = getUserOrDie(userId);

        Note note = getNoteOrDie(noteId, user);

        note.setTitle(title);
        note.setDescription(description);
        note.setLastModified(new Date());

        return note;
    }

    private Note getNoteOrDie(Long noteId, User user) throws ServiceException {
        Note note = entityManager.find(Note.class,noteId);

        if (note == null){
            LOG.debug("Could not found note " + noteId + " for user " + user.getId());
            throw new ServiceException("Invalid note id");
        }

        if (!note.getOwner().getId().equals(user.getId())){
            LOG.debug("User " + user.getId() + " is not the owner of the note " + noteId);
            throw new ServiceException("Invalid note id");
        }
        return note;
    }

    @Override
    public Note findNote(Long userId, Long noteId) throws ServiceException {
        User user = getUserOrDie(userId);
        Note note = getNoteOrDie(noteId, user);
        return note;

    }

    @Override
    @Transactional(propagation = Propagation.REQUIRED)
    public void deleteNote(Long userId, Long noteId) throws ServiceException {
        User user = getUserOrDie(userId);
        Note note = getNoteOrDie(noteId, user);
        entityManager.remove(note);
    }

    @Override
    public List<Note> listNotes(Long userId, int pageSize, int pageNumber) throws ServiceException {
        User user = getUserOrDie(userId);
        TypedQuery<Note> query = entityManager.createQuery("select n from Note n where n.owner = :owner order by n.id asc", Note.class);
        query.setParameter("owner",user);

        if (pageSize > 0){
            query.setMaxResults(pageSize);

            query.setFirstResult(pageSize*( Math.max(0,pageNumber-1)));
        }

        return query.getResultList();
    }



    private User getUserOrDie(Long userId) throws ServiceException {
        User user = getUserById(userId);
        if (user == null)
            throw new ServiceException("UserId is not valid");
        return user;
    }


}
