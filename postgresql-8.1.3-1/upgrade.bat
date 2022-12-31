@echo off
cls
echo This file will upgrade your PostgreSQL installation.
echo.
echo You must have PostgreSQL 8.1.x installed from the official 
echo MSI installation to use this upgrade path.
echo.
echo If the PostgreSQL server or any client applications are running,
echo a reboot will be required once the upgrade is completed.
echo.
echo.
echo Press Ctrl-C to abort the upgrade or
pause

REM Parameters described:
REM  /i postgresql-8.1-int.msi - pick MSI file to install. All properties
REM                              will be read from existing installation.
REM  REINSTALLMODE=vamus       - reinstall all files, regardless of version.
REM                              This makes sure documentation and other
REM                              non-versioned files are updated.
REM  REINSTALL=ALL             - Reinstall all features that were previously
REM                              installed with the new version.
msiexec /i postgresql-8.1-int.msi REINSTALLMODE=vamus REINSTALL=ALL /qr
