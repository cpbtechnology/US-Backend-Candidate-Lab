package com.fdvs.cpb.backendlab.services;

import com.fdvs.cpb.backendlab.Constants;
import org.apache.commons.io.IOUtils;
import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import javax.persistence.PersistenceContext;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.List;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 3/25/13
 * Time: 8:58 PM
 */
public class InitialDataServiceImpl implements InitialDataService {

    private static final Log LOG = LogFactory.getLog(InitialDataServiceImpl.class);
    
//    private BaseDao baseDao;

    @PersistenceContext
    EntityManager entityManager;


    JdbcTemplate jdbcTemplate;

    public void setEntityManager(EntityManager entityManager) {
        this.entityManager = entityManager;
    }

    public void setJdbcTemplate(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    @Transactional(propagation = Propagation.REQUIRES_NEW)
    public void verificarDatosIniciales() throws Exception {

        EntityManagerFactory factory = Persistence.createEntityManagerFactory(Constants.PERSISTENT_UNIT);
        entityManager = factory.createEntityManager();
        entityManager.getTransaction().begin();

        //Put here what you want to initialize

        entityManager.getTransaction().commit();

    }

    private void persistAll(List entities) {
        for (Object entity : entities) {
            entityManager.persist(entity);
        }
    }


    private boolean emptyTable(String entityName) {
        return 0 == (Long)entityManager.createQuery("select count(p) from " + entityName + " p").getSingleResult();

    }


    protected void processSqlFile(JdbcTemplate template, String filePathToProcess) throws IOException {
        LOG.info("Procesando el archivo: " + filePathToProcess);
        InputStreamReader is = new InputStreamReader(this.getClass().getResourceAsStream(filePathToProcess));

        @SuppressWarnings("unchecked")
        List<String> lines = IOUtils.readLines(is);

        try {
            is.close();
        }
        catch (IOException e) {
            e.printStackTrace();
        }

        StringBuilder sql = new StringBuilder();
        for (String line : lines) {

            sql.append(line);

            if (!line.endsWith(";") || StringUtils.isEmpty(line)) {
                continue;
            }

            String sql_ = sql.toString().trim().substring(0, sql.length() - 1);
            LOG.info("ejecutando SQL: " + sql_);

            boolean isDrop = sql_.toLowerCase().startsWith("drop ");

            if (!StringUtils.isEmpty(sql_)) {

                try {
                    template.update(sql_);
                }
                catch (DataAccessException e) {
                    if (!isDrop) {
                        throw e;
                    }
                    else {
                        LOG.warn("Error en sentencia: " + sql_ + "\n" + e.getMessage());
                    }
                }
                finally {

                }
            }
            sql = new StringBuilder();
        }

    }
}
