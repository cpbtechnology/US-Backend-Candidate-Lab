package com.fdvs.cpb.backendlab.model.notes;

import com.fdvs.cpb.backendlab.model.Identifiable;
import com.fdvs.cpb.backendlab.model.auth.User;

import javax.persistence.*;
import java.util.Date;

/**
 * Created with IntelliJ IDEA.
 * User: mamana
 * Date: 16/8/13
 * Time: 2:51 PM
 * To change this template use File | Settings | File Templates.
 */
@Entity
@Table(name = "note")
public class Note extends Identifiable {

    @ManyToOne
    private User owner;

    @Column(name = "title", nullable = false, length = 255)
    private String title;

    @Lob
    @Basic(fetch=FetchType.LAZY)
    private String description;

    @Temporal(TemporalType.TIMESTAMP)
    private Date created;

    @Temporal(TemporalType.TIMESTAMP)
    private Date lastModified;

    public Note(String title, String description) {
        this.title = title;
        this.description = description;
    }

    public Note() {
    }


    public User getOwner() {
        return owner;
    }

    public void setOwner(User owner) {
        this.owner = owner;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Date getCreated() {
        return created;
    }

    public void setCreated(Date created) {
        this.created = created;
    }

    public Date getLastModified() {
        return lastModified;
    }

    public void setLastModified(Date lastModified) {
        this.lastModified = lastModified;
    }
}
