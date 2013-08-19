package com.fdvs.cpb.backendlab.util;

import com.fdvs.cpb.backendlab.exceptions.ConversionException;
import org.apache.commons.io.IOUtils;

import java.io.*;
import java.sql.Blob;
import java.sql.SQLException;

/**
 * Esta clase facilita la conversion de Archivos a blob y viceversa
 *
 * @author M. Simone, D. Garcia
 */
public class FileToBlobConverter {
	
	/**
	 * Convierte el archivo pasado a un blob persistible
	 * @param file Archivo fuente
	 * @return El blob creado
	 * @throws ConversionException Si se produce un error en el proceso (generalmente IO)
	 */
//	public static Blob convert(File file) throws ConversionException {
//		try {
//			Blob blob = Hibernate.createBlob(new FileInputStream(file));
//			return blob;
//		} catch (FileNotFoundException e) {
//			throw new ConversionException("Couldn't find file",e);
//		} catch (IOException e) {
//			throw new ConversionException("Couldn't read from file",e);
//		}
//	}

	/**
	 * Crea un archivo temporal a partir de un blob
	 * @param blob Blob fuente de los bytes a escribir en el archivo
	 * @return El archivo temporal creado
	 * @throws ConversionException Si se produce un error interno durante la conversion. Puede ser IO, de acceso a la base, etc
	 */
	public static File convert(Blob blob) throws ConversionException{
		File tempFile;
		try {
			tempFile = File.createTempFile("blobfile_", ".tmp");
            tempFile.deleteOnExit();
		}
		catch (IOException e) {
			throw new ConversionException("Couldn't create tmp file for converting blob",e);
		}
		FileOutputStream destinationStream;
		try {
			destinationStream = new FileOutputStream(tempFile);
		}
		catch (FileNotFoundException e) {
			throw new ConversionException("Coldn't find tmp file["+tempFile+"] create for conversion",e);
		}
		
		InputStream sourceBytes;
		try {
			sourceBytes = blob.getBinaryStream();
		}
		catch (SQLException e) {
			throw new ConversionException("Error accessing Blob from DB",e);
		}
		try {
			IOUtils.copy(sourceBytes, destinationStream);
			destinationStream.flush();
			destinationStream.close();
		}
		catch (IOException e) {
			throw new ConversionException("IO error copying creating tmp fil from blob", e);
		}
		return tempFile;
	}
}
