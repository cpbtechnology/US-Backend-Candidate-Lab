package com.fdvs.cpb.backendlab.model.auth;

import com.fdvs.cpb.backendlab.model.Identifiable;

import javax.persistence.*;
import java.util.Date;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:27 AM
 */
@Entity
@Table(name = "user")
public class User extends Identifiable {

    @Column(length = 50, nullable = false, unique = true)
    private String username;

    @Column(length = 100, nullable = false, unique = true)
    private String email;

    /**
     * El password debe venir en formato MD5
     */
    @Column(length = 100, nullable = false)
    private String password;

    @Temporal(TemporalType.TIMESTAMP)
    private Date fechaCreacion;

    private boolean admin = false;

    public User() {
    }

    public User(String username, String email, String password, Date fechaCreacion) {
        this.username = username;
        this.password = password;
        this.email = email;
        this.fechaCreacion = fechaCreacion;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Date getFechaCreacion() {
        return fechaCreacion;
    }

    public void setFechaCreacion(Date fechaCreacion) {
        this.fechaCreacion = fechaCreacion;
    }

    public boolean isAdmin() {
        return admin;
    }

    public void setAdmin(boolean admin) {
        this.admin = admin;
    }
}
