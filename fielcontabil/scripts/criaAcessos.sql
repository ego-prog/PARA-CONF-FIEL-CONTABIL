/*==========================================================================*/
/* Este script deve ser executado SOMENTE para converter os arquivos do     */
/* FIEL Contabil da Versao 1 para a Versao 2.                               */
/* Este script cria uma funcao para inserir o produto cartesiano na tabela  */
/* usuarioempresa_cont.                                                     */
/* Inicialmente, todos os usuarios terao acesso a todas as empresas (por    */
/* forca da conversao). Depois, o usuario tera que acertar os acessos via   */
/* sistema.                                                                 */
/*==========================================================================*/

create function insereAcesso( int, int) returns void as
   'insert into usuarioempresa_cont values (nextval(\'usuarioempresa_pk\'), $1, $2)' language 'SQL';

/*==========================================================================*/
/*                    Preenche a tabela empresausuario_cont                 */
/*==========================================================================*/

select usuario.codigo,empresa.codigo,insereAcesso( usuario.codigo, empresa.codigo) as resultado
    from usuario_cont usuario, empresa_cont empresa;

/*==========================================================================*/
/*  Ja que nao precisaremos mais da function, excluiremos ela por seguranca */
/*==========================================================================*/

drop function insereAcesso(int,int);

