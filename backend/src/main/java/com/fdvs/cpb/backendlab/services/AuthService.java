package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.interfaces.auth.I_LoginResponse;
import com.fdvs.cpb.backendlab.interfaces.auth.I_UserPassword;
import com.fdvs.cpb.backendlab.model.auth.User;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:25 AM
 */
public interface AuthService {

    I_LoginResponse login(I_UserPassword userPassword) throws ServiceException;

    User createAccount(String username, String email, String cleanPassword) throws ServiceException;

    void changePassword(String username, String currentPassword, String newPassword) throws ServiceException;
}
