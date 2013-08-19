package com.fdvs.cpb.backendlab.util;

import com.fdvs.cpb.backendlab.exceptions.ApplicationRuntimeException;
import org.apache.commons.io.IOUtils;
import org.apache.commons.lang.StringUtils;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.map.ObjectWriter;

import javax.persistence.NoResultException;
import javax.persistence.TypedQuery;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

/**
 * User: Juan Manuel Alvarez (juan.alvarez@fdvsolutions.com)
 * Date: 5/3/13
 * Time: 2:42 PM
 */
public class Utils {

    private static final Log LOG = LogFactory.getLog(Utils.class);

    /**
     * Dada una query, devuelve el unico valor espera o null si no hay ninguno.
     * Tira excepcion si hay mas de un resultado
     * @param query
     * @param <T>
     * @return
     */
    static public <T> T getSingleResultOrNull(TypedQuery<T> query){
        T ret = null;
        try {
            ret = query.getSingleResult();
        } catch (NoResultException ex){ }

        return ret;
    }

    static final SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy");
    static final SimpleDateFormat dateTimeFormat = new SimpleDateFormat("dd/MM/yyyy HH:mm");

    /**
     * @param date
     * @return string con la forma "dd/MM/yyyy"
     */
    static public String formatDateForUI(Date date){
        if (date == null)
            return null;

        return dateFormat.format(date);
    }

    /**
     *
     * @param date
     * @return String con la forma "dd/MM/yyyy HH:mm"
     */
    static public String formatDateTimeForUI(Date date){
        if (date == null)
            return null;

        return dateTimeFormat.format(date);
    }

    public static String hashWithMD5(String string)  {
        try {

            MessageDigest md = null;
            md = MessageDigest.getInstance("MD5");
            md.update(string.getBytes());

            byte byteData[] = md.digest();

            //convert the byte to hex format method 1
            StringBuffer sb = new StringBuffer();
            for (int i = 0; i < byteData.length; i++) {
                sb.append(Integer.toString((byteData[i] & 0xff) + 0x100, 16).substring(1));
            }

            return sb.toString();

        } catch (NoSuchAlgorithmException e) {
            LOG.error("Error creando hash md5: " + e.getMessage(), e);
        }
        return null;
    }


    private static ObjectMapper mapper = new ObjectMapper();
    public static String toJSON(Object obj)  {
        String json = null;
        try {
            json = mapper.writeValueAsString(obj);
        } catch (IOException e) {
            throw new ApplicationRuntimeException("Error crando json: " + e.getMessage(),e);
        }
//        LOG.debug("ToJSON para " + obj.getClass().getName() + ": " + json.toString());
        return json;
    }

    public static String toJSONPretty(Object obj){
        String json = null;
        try {
            ObjectWriter writer = mapper.defaultPrettyPrintingWriter();
            json = writer.writeValueAsString(obj);
        } catch (IOException e) {
            throw new ApplicationRuntimeException("Error crando json: " + e.getMessage(),e);
        }
//        LOG.debug("ToJSON para " + obj.getClass().getName()+ ":\n" + json.toString());
        return json;
    }

    public static <T> T fromJSON(String json, Class<T> clazz) {
        ObjectMapper mapper = new ObjectMapper();
        T ret= null;
        try {
            ret = mapper.readValue(json,clazz);
        } catch (IOException e) {
            throw new ApplicationRuntimeException("Error deseralizando JSON a una instancia de " + clazz.getName() + ", " + e.getMessage(),e);
        }
        return ret;
    }

    public static byte[] getBytesDeUnFile(File file) throws IOException {
        byte[] contenido = new byte[(int) file.length()];
        IOUtils.readFully(new FileInputStream(file), contenido);
        return contenido;
    }

    /**
     * Devuelve un String con caracteres seguros para un nombre de archivo. Reemplaza caracteres inseguros con "_"
     * @param str
     * @return
     */
    public static String getSecureCharactersForFilename(String str) {
        if (StringUtils.isBlank(str))
            return "";
        return str.replaceAll("[^a-zA-Z0-9.-]", "_");
    }

    public static String vigenere_cipher(String plaintext, String key, boolean encrypt) {

        String alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@1234567890"; // including some special chars
        final int alphabetSize = alphabet.length();
        final int textSize = plaintext.length();
        final int keySize = key.length();
        final StringBuilder encryptedText = new StringBuilder(textSize);

        for (int i = 0; i < textSize; i++) {
            final char plainChar = plaintext.charAt(i); // get the current character to be shifted
            final char keyChar = key.charAt(i % keySize); // use key again if the end is reached
            final int plainPos = alphabet.indexOf(plainChar); // plain character's position in alphabet string
            if (plainPos == -1) { // if character not in alphabet just append unshifted one to the result text
                encryptedText.append(plainChar);
            }
            else { // if character is in alphabet shift it and append the new character to the result text
                final int keyPos = alphabet.indexOf(keyChar); // key character's position in alphabet string
                if (encrypt) { // encrypt the input text
                    encryptedText.append(alphabet.charAt((plainPos+keyPos) % alphabetSize));
                }
                else { // decrypt the input text
                    int shiftedPos = plainPos-keyPos;
                    if (shiftedPos < 0) { // negative numbers cannot be handled with modulo
                        shiftedPos += alphabetSize;
                    }
                    encryptedText.append(alphabet.charAt(shiftedPos));
                }
            }
        }

        return encryptedText.toString();

    }


    public static void setTimeToZero(Calendar cal) {
        cal.set(Calendar.HOUR,0);
        cal.set(Calendar.MINUTE,0);
        cal.set(Calendar.SECOND,0);
        cal.set(Calendar.MILLISECOND,0);
    }
}
