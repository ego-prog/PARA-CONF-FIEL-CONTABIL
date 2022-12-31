/*==========================================================================*/
/* Project Name:        Sistema FIEL Contabil                               */
/* Author:              APOENA Software Livre                               */
/* DBMS:                PostgreSQL 7                                        */
/* Copyright:           (CC) Licenciado sob Creative Commons                */
/* Generated on:        19/03/2007 15:40                                    */
/*==========================================================================*/
/*   O script altera o tipo de dado de itemlancamento_cont.valor de float8  */
/* para numeric(15,2), resolvendo um problema de arredondamento de números. */
/*==========================================================================*/

/* Cria um campo temporário para valor */
alter table itemlancamento_cont add column valor_novo numeric(15,2);

/* Alimenta o campo */
update itemlancamento_cont set valor_novo = valor;

/* Elimina o campo antigo */
alter table itemlancamento_cont drop column valor;

/* Renomeia a coluna criada */
alter table itemlancamento_cont rename column valor_novo to valor;

/* Transforma o campo em NOT NULL   */
alter table itemlancamento_cont alter column valor set not null;


/*   FIM das Atualizações necessárias */

