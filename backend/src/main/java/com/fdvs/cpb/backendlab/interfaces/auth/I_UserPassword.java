package com.fdvs.cpb.backendlab.interfaces.auth;

import java.io.Serializable;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:07 AM
 */
public class I_UserPassword implements Serializable {

    private String username;
    private String password;

    public I_UserPassword() {
    }

    public I_UserPassword(String username, String password) {
        this.username = username;
        this.password = password;
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
}
