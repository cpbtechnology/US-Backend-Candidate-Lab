echo logpath=%~d0%~p0log\mongodb.log >"%~d0%~p0mongodb-service-config.user"
echo dbpath=%~d0%~p0data >>"%~d0%~p0mongodb-service-config.user"
"%~d0%~p0bin\mongod.exe" --config "%~d0%~p0mongodb-service-config.user" --reinstall
net start MongoDB

