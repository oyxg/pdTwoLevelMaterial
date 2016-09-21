rem *******************************Code Start*****************************
@echo off

set "userName=root"
set "password=abc112233"
set "dbName=xintongsparepartsnew"
set "Ymd=%date:~,4%%date:~5,2%%date:~8,2%"
C:\MySQL\bin\mysqldump --opt -u %userName% --password=%password% %dbName% > D:\db_backup\%dbName%_%Ymd%.sql
@echo on
rem *******************************Code End*****************************