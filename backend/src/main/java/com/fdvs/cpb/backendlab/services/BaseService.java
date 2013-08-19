package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.model.auth.User;

import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/3/13
 * Time: 5:03 PM
 */
public class BaseService {

    @PersistenceContext()
    protected EntityManager entityManager;


    public void setEntityManager(EntityManager entityManager) {
        this.entityManager = entityManager;
    }


    public User getUserById(Long userId) {
        return entityManager.find(User.class,userId);
    }



}
