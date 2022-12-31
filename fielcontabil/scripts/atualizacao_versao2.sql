/*==========================================================================*/
/* Project Name:        Sistema FIEL Contabil                               */
/* Author:              APOENA Software Livre                               */
/* DBMS:                PostgreSQL 7                                        */
/* Copyright:           (CC) Licenciado sob Creative Commons                */
/* Generated on:        21/03/05 14:10:20                                   */
/*==========================================================================*/
/*   O script cria as novas tabelas e realiza alteracoes nas tabelas do     */
/* FIEL Contabil para permitir o controle por centro de custos e outros     */
/* recursos disponibilizados a partir da versao 2 do sistema.               */
/*==========================================================================*/

CREATE TABLE centrocusto_cont (
    codigo INT2 NOT NULL,
    codigoempresa INT2,
    sigla CHARACTER(10) NOT NULL,
    descricao VARCHAR(40) NOT NULL,
    PRIMARY KEY (codigo)
);

CREATE TABLE usuarioempresa_cont (
    codigo INT2 NOT NULL,
    codigousuario INT4,
    codigoempresa INT4,
    PRIMARY KEY (codigo)
);

/*========================================================*/
/*       Cria o �ndice para evitar codigo de usu�rio e    */
/*  c�digo da empresa duplicados em usuarioempresa_cont   */
/*========================================================*/

CREATE UNIQUE INDEX IDX_usuarioempresa_cont ON usuarioempresa_cont (codigousuario, codigoempresa);

/*==========================================================================*/
/*  Foreign Keys                                                            */
/*==========================================================================*/

ALTER TABLE centrocusto_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE usuarioempresa_cont
    ADD FOREIGN KEY (codigousuario) REFERENCES usuario_cont (codigo);

ALTER TABLE usuarioempresa_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

/*==========================================================================*/
/*  Indexes                                                                 */
/*==========================================================================*/

/*==========================================================================*/
/*  Sequences                                                               */
/*==========================================================================*/
CREATE SEQUENCE centrocusto_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000
    START 1
    ;

CREATE SEQUENCE usuarioempresa_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000
    START 1
    ;

/*==========================================================================*/
/*  Alteracoes de Tabelas existentes (novos atributos)                      */
/*==========================================================================*/
ALTER TABLE itemlancamento_cont ADD COLUMN nomeimagem varchar(60);
ALTER TABLE itemlancamento_cont ADD COLUMN codigocentrocusto int2;
COMMENT ON COLUMN itemlancamento_cont.nomeimage IS 'Nome da Imagem Anexada';
COMMENT ON COLUMN itemlancamento_cont.codigocentrocusto IS 'C�digo do Centro de Custo (opcional)';

/*==========================================================================*/
/*  Comments                                                                */
/*==========================================================================*/

COMMENT ON TABLE centrocusto_cont IS 'Tabela de Centros de Custo';
COMMENT ON TABLE usuarioempresa_cont IS 'C�digo da Empresa';
COMMENT ON COLUMN centrocusto_cont.codigo IS 'C�digo do Centro de Custo';
COMMENT ON COLUMN centrocusto_cont.codigoempresa IS 'C�digo da Empresa';
COMMENT ON COLUMN centrocusto_cont.sigla IS 'Sigla do Centro de Custo';
COMMENT ON COLUMN centrocusto_cont.descricao IS 'Descri��o do Centro de Custo';
COMMENT ON COLUMN usuarioempresa_cont.codigo IS 'C�digo';
COMMENT ON COLUMN usuarioempresa_cont.codigousuario IS 'C�digo do usu�rio';
COMMENT ON SEQUENCE centrocusto_pk IS 'Sequence para Centros de Custo ';
COMMENT ON SEQUENCE usuarioempresa_pk IS 'Sequence para Acessos de usu�rios a empresa ';
