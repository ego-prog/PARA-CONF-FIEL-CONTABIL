## Instalar PHP5 e Apache 2  
```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php5.6 php5.6-mysql php5.6-gd php5.6-mcrypt php5.6-mbstring php5.6-sqlite3 apache2 libapache2-mod-php5.6
```

## Instalar PostgreSQL  
```
sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list' 
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
`sudo apt-get update
sudo apt-get -y install postgresql-10
```

## Comandos PostgreSQL
### Status do PostgreSQL
`sudo systemctl status postgresql`  
### Parar PostgreSQL
`sudo systemctl stop postgresql`  
### Iniciar PostgreSQL
`sudo systemctl start postgresql`  
### Reestart PostgreSql
`sudo systemctl restart postgresql`  
### Verificar versão PostgreSQL
`sudo -u postgres psql -c "SELECT version();"`  
### Logar com usuário postgres
`sudo su – postgres`  
### Sair PostgreSQL
`\q`  
