
-- Cria a primeira empresa (necessario para poder logar no sistema
-- -----------------------------------------------------------------
insert into parametro_cont (codigocliente,cliente,linha1,linha2,linha3,maximodiaslog)
       values (nextval('parametro_cont_pk'),'Nome da Empresa Usuária','Sistema de Contabilidade via Internet','www.apoenasoftwarelivre.com.br/fielcontabil','Liberte-se do Software Proprietário',60);


-- Cria o usuario 'admin', com senha 'admin'
-- ----------------------------------------
insert into usuario_cont (codigo,codigocliente, nome, login, senha, numeroip, perfilusuario)
       values (nextval('usuario_cont_pk'),1,'Administrador do Sistema','admin','admin','10.1.1.1','A');
