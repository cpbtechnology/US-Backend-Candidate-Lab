package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.interfaces.auth.I_LoginResponse;
import com.fdvs.cpb.backendlab.interfaces.auth.I_UserPassword;
import com.fdvs.cpb.backendlab.model.auth.User;
import com.fdvs.cpb.backendlab.services.exceptions.ServiceException;
import com.fdvs.cpb.backendlab.util.Utils;
import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.TypedQuery;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/7/13
 * Time: 10:25 AM
 */
public class AuthServiceImpl extends BaseService implements AuthService, UserDetailsService {

    private static final Log LOG = LogFactory.getLog(AuthServiceImpl.class);

    @Override
    public I_LoginResponse login(I_UserPassword userPassword) throws ServiceException {

        User user = findUserByUsernameAndPassword(userPassword.getUsername(), userPassword.getPassword());

        I_LoginResponse resp = new I_LoginResponse();
        if (user != null){
            resp.setCodigo("200");
            resp.setMensaje("OK");
            resp.setUserId(user.getId());
        } else {
            resp.setCodigo("500");
            resp.setMensaje("LOGIN INCORRECT");
        }

        return resp;
    }

    private User findUserByUsernameAndPassword(String username, String password) {
        TypedQuery<User> query = entityManager.createQuery("select u from User u where u.username = :username and u.password = :password", User.class);
        query.setParameter("username",username);
        query.setParameter("password",Utils.hashWithMD5(password));
        return Utils.getSingleResultOrNull(query);
    }


    @Transactional(propagation = Propagation.REQUIRED)
    @Override
    public User createAccount(String username, String email, String cleanPassword) throws ServiceException {
        TypedQuery<User> query = entityManager.createQuery("select u from User u where upper(u.username) = :username or upper(u.email) = :email", User.class);
        query.setParameter("username", StringUtils.upperCase(username));
        query.setParameter("email", StringUtils.upperCase(email));

        User user = Utils.getSingleResultOrNull(query);
        if (user != null) {
            if (user.getUsername().toUpperCase().equals(StringUtils.upperCase(username))){
                throw new ServiceException("Username '" + username +"' already exists");
            }
            if (user.getEmail().toUpperCase().equals(StringUtils.upperCase(email))){
                throw new ServiceException("Email '" + email +"' is not available");
            }
        }

        user = new User(username, email, Utils.hashWithMD5(cleanPassword), new Date());

        entityManager.persist(user);

        return user;

    }


    @Override
    @Transactional
    public void changePassword(String username, String currentPassword, String newPassword) throws ServiceException {
        User aUser = findUserByUsernameAndPassword(username, currentPassword);
        if (aUser != null){
            aUser.setPassword(newPassword);
            entityManager.persist(aUser);
        } else {
            throw new ServiceException("Wrong password");
        }
    }


    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {

        try {
            TypedQuery<User> query = entityManager.createQuery("select u from User u where u.username = :username", User.class);
            query.setParameter("username",username);

            User user = query.getSingleResult();

            UserDetails userDetails = null;

            if (user != null){
                Collection<GrantedAuthority> authorities = new ArrayList<GrantedAuthority>();
                authorities.add(new SimpleGrantedAuthority("ROLE_USER"));
                userDetails = new org.springframework.security.core.userdetails.User(user.getUsername(),user.getPassword(),authorities);
            }

            return userDetails;
        } catch (Exception e) {
            LOG.error("Error authenticating user " + username + ", " + e.getMessage(),e);
        }

        return null;

    }
}
