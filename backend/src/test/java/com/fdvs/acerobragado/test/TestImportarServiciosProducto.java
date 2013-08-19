package com.fdvs.acerobragado.test;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.test.context.ContextConfiguration;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

/**
 * User: Rodrigo Ocampos (rodrigo.ocampos@fdvsolutions.com)
 * Date: 17/05/13
 * Time: 11:37
 */
@RunWith(SpringJUnit4ClassRunner.class)
@ContextConfiguration(locations = {"classpath:/applicationContext.xml"})
public class TestImportarServiciosProducto {

    private static final Log LOG = LogFactory.getLog(TestImportarServiciosProducto.class);



    @Test
    public void testEnvioExcelTermometro() throws Exception {



    }

}
