package com.fdvs.cpb.backendlab.mail;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.velocity.app.VelocityEngine;
import org.apache.velocity.exception.VelocityException;
import org.springframework.core.io.Resource;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.JavaMailSenderImpl;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.ui.velocity.VelocityEngineUtils;

import javax.mail.MessagingException;
import javax.mail.internet.MimeMessage;
import java.io.UnsupportedEncodingException;
import java.util.Map;

/**
 * @author Mariano Stampella
 * @author Mariano Simone Date: 15/08/2007
 */
public class VelocityMailSender {

    private static final Log logger = LogFactory.getLog(VelocityMailSender.class);

    private JavaMailSender mailSender;
    private VelocityEngine velocityEngine;

    private String from;
    private String replyTo;
    private String[] to;
    private String[] bcc;
    private String[] cc;
    private String fromName;

    /**
     * Encoding a utilizar en los MIME Message
     */
    private String encoding;

    /**
     * Si TRUE, las direcciones son validadas con la RFC822
     */
    private boolean validateAddresses = true;

    public boolean isValidateAddresses() {
        return validateAddresses;
    }

    public void setValidateAddresses(boolean validateAddresses) {
        this.validateAddresses = validateAddresses;
    }

    private void handleAddresses(MimeMessageHelper helper) {
        helper.setValidateAddresses(this.validateAddresses);
        try {
            if (getTo() != null)
                helper.setTo(getTo());
            if (getFrom() != null)
                helper.setFrom(getFrom());
            if (getFrom() != null && getFromName() != null)
                helper.setFrom(getFrom(), getFromName());
            if (getReplyTo() != null)
                helper.setReplyTo(getReplyTo());
            if (getBcc() != null)
                helper.setBcc(getBcc());
            if (getCc() != null)
                helper.setCc(getCc());
        } catch (MessagingException e) {
            String message = "From, To, Bcc and/or Cc addresses not set properly";
            logger.error(message);
            throw new RuntimeException(message);
        } catch (UnsupportedEncodingException e) {
            throw new RuntimeException(e.getMessage(),e);
        }
    }

    public void sendMail(Map<String, Object> model, String subject,
                         String template) throws MessagingException, VelocityException {
        if (logger.isDebugEnabled()) {
            logger.debug("Sending mail. Template: [" + template
                    + "] Subject: [" + subject + "]");
        }

        final String text = VelocityEngineUtils.mergeTemplateIntoString(
                velocityEngine, template, model);
        final MimeMessage message = this.mailSender.createMimeMessage();
        final MimeMessageHelper helper = new MimeMessageHelper(message, true, encoding);

        handleAddresses(helper);

        helper.setSubject(subject);
        helper.setText(text, true);

        // Seteos para ver en consola la transaccion con el servidor de mail
        if (logger.isDebugEnabled()) {
            ((JavaMailSenderImpl)mailSender).getSession().setDebug(true);
            ((JavaMailSenderImpl)mailSender).getSession().setDebugOut(System.out);
        }
        mailSender.send(message);
    }

    public void sendMail(Map<String, Object> model,
                         Map<String, Resource> resources, String subject, String template)
            throws MessagingException, VelocityException {
        if (logger.isDebugEnabled()) {
            logger.debug("Sending mail. Template: [" + template
                    + "] Subject: [" + subject + "]");
        }

        final String text = VelocityEngineUtils.mergeTemplateIntoString(
                velocityEngine, template, model);
        final MimeMessage message = mailSender.createMimeMessage();
        final MimeMessageHelper helper = new MimeMessageHelper(message, true, encoding);

        handleAddresses(helper);

        helper.setSubject(subject);
        helper.setText(text, true);

        for (String key : resources.keySet()) {
            helper.addAttachment(key, resources.get(key));
        }

        mailSender.send(message);
    }

    /**
     * Crea el texto del mail a partir de un template de velocity, mergeando
     * este template con el mapa del modelo
     *
     * @param model
     * @param template
     * @return
     * @throws VelocityException
     */
    public String createVelocityMailBody(Map<String, Object> model,
                                         String template) throws VelocityException {

        final String body = VelocityEngineUtils.mergeTemplateIntoString(
                velocityEngine, template, model);
        return body;
    }

    /**
     * Envia un mail a partir de los datos básicos preparados previmante (no
     * hace nada con velocity, considera todo ya preparado)
     *
     * @param subject
     * @param mailTo
     * @param mailBody
     */
    public void sendMail(String subject, String mailTo, String mailBody)
            throws MessagingException {
        final MimeMessage message = mailSender.createMimeMessage();
        final MimeMessageHelper helper = new MimeMessageHelper(message, true, encoding);

        handleAddresses(helper);

        helper.setSubject(subject);
        helper.setText(mailBody, true);

        mailSender.send(message);
    }

    public void setMailSender(JavaMailSender mailSender) {
        this.mailSender = mailSender;
    }

    public void setVelocityEngine(VelocityEngine velocityEngine) {
        this.velocityEngine = velocityEngine;
    }

    public String getFrom() {
        return from;
    }

    public void setFrom(String from) {
        this.from = from;
    }

    public String getReplyTo() {
        return replyTo;
    }

    public void setReplyTo(String replyTo) {
        this.replyTo = replyTo;
    }

    public String[] getTo() {
        return to;
    }

    public void setTo(String to) {
        this.to = new String[] { to };
    }

    public void setTo(String[] to) {
        this.to = to;
    }

    public String[] getBcc() {
        return bcc;
    }

    public void setBcc(String bcc) {
        this.bcc = new String[] { bcc };
    }

    public void setBcc(String[] bcc) {
        this.bcc = bcc;
    }

    public String[] getCc() {
        return cc;
    }

    public void setCc(String cc) {
        this.cc = new String[] { cc };
    }

    public void setCc(String[] cc) {
        this.cc = cc;
    }

    public void setFrom(String from, String name) {
        this.from = from;
        this.fromName = name;
    }

    public String getFromName() {
        return fromName;
    }

    public String getEncoding() {
        return encoding;
    }

    public void setEncoding(String encoding) {
        this.encoding = encoding;
    }

    public void setFromName(String fromName) {
        this.fromName = fromName;
    }
}
