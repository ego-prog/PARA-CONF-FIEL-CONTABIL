/*==========================================================================*/
/* Project Filename:    F:\fielcontabil\documentacao\FIEL Contabil.dez      */
/* Project Name:        Sistema FIEL Contabil                               */
/* Author:              APOENA Software Livre                               */
/* DBMS:                PostgreSQL 7                                        */
/* Copyright:           (CC) Licenciado sob Creative Commons                */
/* Generated on:        19/03/2007 15:56:33                                 */
/*==========================================================================*/

/*==========================================================================*/
/*  Tables                                                                  */
/*==========================================================================*/

CREATE TABLE parametro_cont (
    codigocliente INT2 NOT NULL,
    cliente VARCHAR(70) NOT NULL,
    linha1 VARCHAR(70),
    linha2 VARCHAR(70),
    linha3 VARCHAR(70),
    maximodiaslog INT2 NOT NULL,
    logotipo VARCHAR(70),
    CONSTRAINT PK_parametro_cont PRIMARY KEY (codigocliente)
);

CREATE TABLE log_cont (
    codigocliente INT2,
    data DATE NOT NULL,
    hora CHAR(5) NOT NULL,
    loginusuario VARCHAR(12) NOT NULL,
    numeroip CHAR(15),
    descricao VARCHAR(30),
    complemento VARCHAR(30)
);

CREATE TABLE consulta_cont (
    codigo INT2 NOT NULL,
    codigocliente INT2,
    titulo VARCHAR(70) NOT NULL,
    modulo VARCHAR(70),
    instrucaosql TEXT,
    perfilusuario CHAR(1) NOT NULL,
    CONSTRAINT PK_consulta_cont PRIMARY KEY (codigo)
);

CREATE TABLE usuario_cont (
    codigo INT2 NOT NULL,
    codigocliente INT2,
    nome VARCHAR(40) NOT NULL,
    login VARCHAR(12) NOT NULL,
    senha VARCHAR(12) NOT NULL,
    numeroip VARCHAR(15),
    perfilusuario CHAR(1) NOT NULL,
    CONSTRAINT PK_usuario_cont PRIMARY KEY (codigo)
);

CREATE TABLE empresa_cont (
    codigo INT2 NOT NULL,
    codigocliente INT2,
    razaosocial VARCHAR(40) NOT NULL,
    cnpj VARCHAR(18),
    inscricaoestadual VARCHAR(18),
    inscricaomunicipal VARCHAR(18),
    endereco VARCHAR(40),
    bairro VARCHAR(30),
    cidade VARCHAR(40),
    cep VARCHAR(9),
    uf CHAR(2),
    email VARCHAR(60),
    datainicial DATE NOT NULL,
    datafinal DATE NOT NULL,
    nomecontador VARCHAR(40) NOT NULL,
    registrocontador VARCHAR(20) NOT NULL,
    responsavel VARCHAR(40) NOT NULL,
    cpfresponsavel VARCHAR(20) NOT NULL,
    mascaraplano VARCHAR(14) NOT NULL,
    mascaradoar VARCHAR(10) NOT NULL,
    codigocaixa VARCHAR(40),
    CONSTRAINT PK_empresa_cont PRIMARY KEY (codigo)
);

CREATE TABLE termo_cont (
    codigo INT2 NOT NULL,
    codigoempresa INT2,
    descricao VARCHAR(50) NOT NULL,
    texto TEXT NOT NULL,
    localizacao CHAR(1) NOT NULL,
    CONSTRAINT PK_termo_cont PRIMARY KEY (codigo)
);

CREATE TABLE contacontabil_cont (
    codigoacesso INT2 NOT NULL,
    codigoempresa INT2 NOT NULL,
    dv INT2 NOT NULL,
    codigosintetico CHAR(14) NOT NULL,
    descricao VARCHAR(40) NOT NULL,
    natureza CHAR(1),
    tipo CHAR(1) NOT NULL,
    despesareceita CHAR(1),
    podedevedora CHAR(1),
    podecredora CHAR(1),
    contadoar CHAR(7),
    CONSTRAINT PK_contacontabil_cont PRIMARY KEY (codigoacesso)
);

CREATE TABLE contadoar_cont (
    codigoempresa INT2,
    codigodoar CHAR(7) NOT NULL,
    descricao VARCHAR(40) NOT NULL,
    CONSTRAINT PK_contadoar_cont PRIMARY KEY (codigodoar)
);

CREATE TABLE historicopadrao_cont (
    codigo INT2 NOT NULL,
    codigoempresa INT2,
    historico VARCHAR(40) NOT NULL,
    CONSTRAINT PK_historicopadrao_cont PRIMARY KEY (codigo)
);

CREATE TABLE orcamento_cont (
    codigoacesso INT2 NOT NULL,
    ano INT2 NOT NULL,
    previsto01 FLOAT8 NOT NULL,
    previsto02 FLOAT8,
    previsto03 FLOAT8,
    previsto04 FLOAT8,
    previsto05 FLOAT8,
    previsto06 FLOAT8,
    previsto07 FLOAT8,
    previsto08 FLOAT8,
    previsto09 FLOAT8,
    previsto10 FLOAT8,
    previsto11 FLOAT8,
    previsto12 FLOAT8,
    CONSTRAINT PK_orcamento_cont PRIMARY KEY (codigoacesso, ano)
);

CREATE TABLE cablancamento_cont (
    codigoempresa INT2,
    codigo INT8 NOT NULL,
    data DATE NOT NULL,
    datadigitacao DATE NOT NULL,
    horadigitacao VARCHAR(8) NOT NULL,
    loginoperador VARCHAR(12) NOT NULL,
    dataliberacao DATE,
    horaliberacao VARCHAR(8),
    loginsupervisor VARCHAR(12),
    aberto CHAR(1) NOT NULL,
    contabilizado VARCHAR(1) NOT NULL,
    PRIMARY KEY (codigo)
);

CREATE TABLE itemlancamento_cont (
    codigo INT8 NOT NULL,
    codigolancamento INT8,
    codigoacesso INT2,
    historico TEXT,
    valor NUMERIC(15,2) NOT NULL,
    debitocredito CHAR(1) NOT NULL,
    codigozeramento INT8,
    codigocentrocusto INT2,
    nomeimagem VARCHAR(60),
    PRIMARY KEY (codigo)
);

CREATE TABLE nota_cont (
    codigo INT2 NOT NULL,
    codigoempresa INT2,
    notaexplicativa TEXT NOT NULL,
    PRIMARY KEY (codigo)
);

CREATE TABLE zeramento_cont (
    codigo INT8 NOT NULL,
    codigoempresa INT2,
    contrapartida INT2 NOT NULL,
    grupo1 INT8,
    grupo2 INT8,
    grupo3 INT8,
    grupo4 INT8,
    grupo5 INT8,
    PRIMARY KEY (codigo)
);

CREATE TABLE centrocusto_cont (
    codigo INT2 NOT NULL,
    codigoempresa INT2,
    sigla CHARACTER(10) NOT NULL,
    descricao VARCHAR(40) NOT NULL,
    PRIMARY KEY (codigo)
);

CREATE TABLE usuarioempresa_cont (
    codigo INT2 NOT NULL,
    codigousuario INT2,
    codigoempresa INT2,
    PRIMARY KEY (codigo)
);

/*==========================================================================*/
/*  Foreign Keys                                                            */
/*==========================================================================*/

ALTER TABLE log_cont
    ADD CONSTRAINT parametro_cont_log_cont FOREIGN KEY (codigocliente) REFERENCES parametro_cont (codigocliente);

ALTER TABLE consulta_cont
    ADD CONSTRAINT parametro_cont_consulta_cont FOREIGN KEY (codigocliente) REFERENCES parametro_cont (codigocliente);

ALTER TABLE usuario_cont
    ADD CONSTRAINT parametro_cont_usuario_cont FOREIGN KEY (codigocliente) REFERENCES parametro_cont (codigocliente);

ALTER TABLE empresa_cont
    ADD CONSTRAINT parametro_cont_empresa_cont FOREIGN KEY (codigocliente) REFERENCES parametro_cont (codigocliente);

ALTER TABLE termo_cont
    ADD CONSTRAINT termo_cont_empresa_cont FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE contacontabil_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE contadoar_cont
    ADD CONSTRAINT planodoar_cont_empresa_cont FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE historicopadrao_cont
    ADD CONSTRAINT histpadrao_cont_empresa FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE orcamento_cont
    ADD FOREIGN KEY (codigoacesso) REFERENCES contacontabil_cont (codigoacesso);

ALTER TABLE cablancamento_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE itemlancamento_cont
    ADD FOREIGN KEY (codigolancamento) REFERENCES cablancamento_cont (codigo);

ALTER TABLE itemlancamento_cont
    ADD FOREIGN KEY (codigoacesso) REFERENCES contacontabil_cont (codigoacesso);

ALTER TABLE nota_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE zeramento_cont
    ADD FOREIGN KEY (contrapartida) REFERENCES contacontabil_cont (codigoacesso);

ALTER TABLE zeramento_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE centrocusto_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

ALTER TABLE usuarioempresa_cont
    ADD FOREIGN KEY (codigousuario) REFERENCES usuario_cont (codigo);

ALTER TABLE usuarioempresa_cont
    ADD FOREIGN KEY (codigoempresa) REFERENCES empresa_cont (codigo);

/*==========================================================================*/
/*  Indexes                                                                 */
/*==========================================================================*/

CREATE UNIQUE INDEX IDX_parametro_cont_1 ON parametro_cont (codigocliente);

CREATE INDEX IDX_log_cont_1 ON log_cont (codigocliente);

CREATE INDEX IDX_consulta_cont_1 ON consulta_cont (codigocliente);

CREATE INDEX IDX_usuario_cont_1 ON usuario_cont (codigocliente);

CREATE UNIQUE INDEX IDX_usuario_cont_2 ON usuario_cont (codigo);

CREATE INDEX IDX_empresa_cont_1 ON empresa_cont (codigocliente);

CREATE UNIQUE INDEX IDX_empresa_cont_2 ON empresa_cont (codigo);

CREATE INDEX IDX_termo_cont_1 ON termo_cont (codigoempresa);

CREATE INDEX IDX_contacontabil_cont_1 ON contacontabil_cont (codigoempresa);

CREATE UNIQUE INDEX IDX_contacontabil_cont_2 ON contacontabil_cont (codigoacesso);

CREATE INDEX IDX_contadoar_cont_1 ON contadoar_cont (codigoempresa);

CREATE INDEX IDX_historicopadrao_cont_1 ON historicopadrao_cont (codigoempresa);

CREATE INDEX IDX_orcamento_cont_1 ON orcamento_cont (codigoacesso);

CREATE UNIQUE INDEX IDX_cablancamento_cont_1 ON cablancamento_cont (codigo);

CREATE INDEX IDX_cablancamento_cont_2 ON cablancamento_cont (codigoempresa);

CREATE INDEX IDX_itemlancamento_cont_1 ON itemlancamento_cont (codigolancamento);

CREATE INDEX IDX_itemlancamento_cont_2 ON itemlancamento_cont (codigoacesso);

CREATE INDEX IDX_nota_cont_1 ON nota_cont (codigoempresa);

CREATE INDEX IDX_zeramento_cont_1 ON zeramento_cont (contrapartida);

CREATE INDEX IDX_zeramento_cont_2 ON zeramento_cont (codigoempresa);

CREATE INDEX IDX_centrocusto_cont_1 ON centrocusto_cont (codigoempresa);

CREATE INDEX IDX_usuarioempresa_cont_1 ON usuarioempresa_cont (codigousuario);

CREATE INDEX IDX_usuarioempresa_cont_2 ON usuarioempresa_cont (codigoempresa);

/*==========================================================================*/
/*  Sequences                                                               */
/*==========================================================================*/

CREATE SEQUENCE cablancamento_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE consulta_cont_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE contacontabil_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE contadoar_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE empresa_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE historicopadrao_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE itemlancamento_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE nota_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE parametro_cont_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE termo_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE usuario_cont_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE zeramento_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE centrocusto_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

CREATE SEQUENCE usuarioempresa_pk
    INCREMENT 1
    MINVALUE 0
    MAXVALUE 100000000
    START 1
    ;

/*==========================================================================*/
/*  Views                                                                   */
/*==========================================================================*/

/*==========================================================================*/
/*  Procedures                                                              */
/*==========================================================================*/

/*==========================================================================*/
/*  Triggers                                                                */
/*==========================================================================*/

/*==========================================================================*/
/*  Comments                                                                */
/*==========================================================================*/

COMMENT ON TABLE parametro_cont IS 'Tabela de Parâmetros do Sistema';
COMMENT ON TABLE log_cont IS 'Tabela de LOG do Sistema';
COMMENT ON TABLE consulta_cont IS 'Tabela de Consultas/Relatórios Personalizados';
COMMENT ON TABLE usuario_cont IS 'Tabela de Usuários do Sistema';
COMMENT ON TABLE empresa_cont IS 'Tabela de Empresas Usuárias do Sistema';
COMMENT ON TABLE termo_cont IS 'Tabela de Termos de Abertura/Encerramento';
COMMENT ON TABLE contacontabil_cont IS 'Tabela de Plano de Contas';
COMMENT ON TABLE contadoar_cont IS 'Tabela do Plano de Contas DOAR';
COMMENT ON TABLE historicopadrao_cont IS 'Tabela de Históricos Padrões';
COMMENT ON TABLE orcamento_cont IS 'Tabela de Orçamento Anual';
COMMENT ON TABLE cablancamento_cont IS 'Tabela de Cabecalhos dos Lancamentos';
COMMENT ON TABLE itemlancamento_cont IS 'Tabela de Itens de Lancamentos';
COMMENT ON TABLE nota_cont IS 'Tabela de Notas Explicativas';
COMMENT ON TABLE zeramento_cont IS 'Tabela de Parametros para zeramento de contas de resultados';
COMMENT ON TABLE centrocusto_cont IS 'Tabela de Centros de Custo';
COMMENT ON TABLE usuarioempresa_cont IS 'Código da Empresa';
COMMENT ON COLUMN parametro_cont.codigocliente IS 'Código do Cliente do Sistema';
COMMENT ON COLUMN parametro_cont.cliente IS 'Nome da Empresa Cliente do Sistema';
COMMENT ON COLUMN parametro_cont.linha1 IS 'Linha 1 do cabeçalho de relatórios';
COMMENT ON COLUMN parametro_cont.linha2 IS 'Linha 2 do cabeçalho de relatórios';
COMMENT ON COLUMN parametro_cont.linha3 IS 'Linha 3 do cabeçalho de relatórios';
COMMENT ON COLUMN parametro_cont.maximodiaslog IS 'Número máximo de dias a manter no LOG do sistema';
COMMENT ON COLUMN parametro_cont.logotipo IS 'Endereco do Logotipo a ser utilizado';
COMMENT ON COLUMN log_cont.data IS 'Data da Transação';
COMMENT ON COLUMN log_cont.hora IS 'Horário da Transação';
COMMENT ON COLUMN log_cont.loginusuario IS 'Login do Usuário';
COMMENT ON COLUMN log_cont.numeroip IS 'Número IP de origem';
COMMENT ON COLUMN log_cont.descricao IS 'Descrição da Transação';
COMMENT ON COLUMN log_cont.complemento IS 'Complemento da descrição';
COMMENT ON COLUMN consulta_cont.codigo IS 'Código';
COMMENT ON COLUMN consulta_cont.titulo IS 'Título da Consulta';
COMMENT ON COLUMN consulta_cont.modulo IS 'Nome do módulo PHP';
COMMENT ON COLUMN consulta_cont.instrucaosql IS 'Instrução SQL';
COMMENT ON COLUMN consulta_cont.perfilusuario IS 'Perfil (A=Admin.,S=Superv.,O=Oper.)';
COMMENT ON COLUMN usuario_cont.codigo IS 'Código';
COMMENT ON COLUMN usuario_cont.nome IS 'Nome completo';
COMMENT ON COLUMN usuario_cont.login IS 'Login de Acesso';
COMMENT ON COLUMN usuario_cont.senha IS 'Senha de Acesso';
COMMENT ON COLUMN usuario_cont.numeroip IS 'Número IP no último acesso';
COMMENT ON COLUMN usuario_cont.perfilusuario IS 'Perfil (A=Admin.,S=Superv.,O=Operador)';
COMMENT ON COLUMN empresa_cont.codigo IS 'Código';
COMMENT ON COLUMN empresa_cont.razaosocial IS 'Razão Social da Empresa';
COMMENT ON COLUMN empresa_cont.cnpj IS 'Número do CNPJ';
COMMENT ON COLUMN empresa_cont.inscricaoestadual IS 'Inscrição Estadual';
COMMENT ON COLUMN empresa_cont.inscricaomunicipal IS 'Inscrição Municipal';
COMMENT ON COLUMN empresa_cont.endereco IS 'Endereço';
COMMENT ON COLUMN empresa_cont.bairro IS 'Bairro';
COMMENT ON COLUMN empresa_cont.cidade IS 'Cidade';
COMMENT ON COLUMN empresa_cont.cep IS 'C.E.P.';
COMMENT ON COLUMN empresa_cont.uf IS 'Unidade da Federação';
COMMENT ON COLUMN empresa_cont.email IS 'e-mail para notificações';
COMMENT ON COLUMN empresa_cont.datainicial IS 'Data Inicial do periodo de lançamentos contábeis';
COMMENT ON COLUMN empresa_cont.datafinal IS 'Data final do periodo de lançamentos contábeis';
COMMENT ON COLUMN empresa_cont.nomecontador IS 'Nome do(a) contador(a)';
COMMENT ON COLUMN empresa_cont.registrocontador IS 'Registro do Contador (CRC-XX 999.999)';
COMMENT ON COLUMN empresa_cont.responsavel IS 'Nome do Responsavel pela Empresa';
COMMENT ON COLUMN empresa_cont.cpfresponsavel IS 'CPF do Responsavel pela Empresa';
COMMENT ON COLUMN empresa_cont.mascaraplano IS 'Mascara do Plano de Contas';
COMMENT ON COLUMN empresa_cont.codigocaixa IS 'Codigo da Conta Caixa';
COMMENT ON COLUMN termo_cont.codigo IS 'Código';
COMMENT ON COLUMN termo_cont.codigoempresa IS 'Código da Empresa';
COMMENT ON COLUMN termo_cont.descricao IS 'Descrição do Termo';
COMMENT ON COLUMN termo_cont.texto IS 'Texto do Termo de Abertura/Encerramento';
COMMENT ON COLUMN termo_cont.localizacao IS 'Flag: Local do Termo (I=Início, F=Final)';
COMMENT ON COLUMN contacontabil_cont.codigoacesso IS 'Código de Acesso da Conta';
COMMENT ON COLUMN contacontabil_cont.codigoempresa IS 'Codigo da Empresa';
COMMENT ON COLUMN contacontabil_cont.codigosintetico IS 'Código sintético da conta (9.9.99.99.9999)';
COMMENT ON COLUMN contacontabil_cont.descricao IS 'Descrição da Conta';
COMMENT ON COLUMN contacontabil_cont.natureza IS 'Natureza (D=Devedora, C=Credora)';
COMMENT ON COLUMN contacontabil_cont.tipo IS 'Tipo (A=Analítica, S=Sintética)';
COMMENT ON COLUMN contacontabil_cont.despesareceita IS 'Flag: (D=Despesa, R=Receita, branco=outras)';
COMMENT ON COLUMN contacontabil_cont.podedevedora IS 'Flag: Pode ficar devedora ? (S/N)';
COMMENT ON COLUMN contacontabil_cont.podecredora IS 'Flag: Pode ficar credora (S/N)';
COMMENT ON COLUMN contacontabil_cont.contadoar IS 'Código da Conta DOAR (opcional)';
COMMENT ON COLUMN contadoar_cont.codigodoar IS 'Código do Plano DOAR (9.9.999)';
COMMENT ON COLUMN contadoar_cont.descricao IS 'Descrição da Conta no DOAR';
COMMENT ON COLUMN historicopadrao_cont.codigo IS 'Código';
COMMENT ON COLUMN historicopadrao_cont.codigoempresa IS 'Código da Empresa';
COMMENT ON COLUMN historicopadrao_cont.historico IS 'Histórico Padrão';
COMMENT ON COLUMN orcamento_cont.ano IS 'Ano (c/4 dígitos)';
COMMENT ON COLUMN orcamento_cont.previsto01 IS 'Valor Previsto em Janeiro';
COMMENT ON COLUMN orcamento_cont.previsto02 IS 'Previsto em Fevereiro';
COMMENT ON COLUMN orcamento_cont.previsto03 IS 'Valor Previsto em Marco';
COMMENT ON COLUMN orcamento_cont.previsto04 IS 'Valor Previsto em Abril';
COMMENT ON COLUMN orcamento_cont.previsto05 IS 'Valor Previsto em Maio';
COMMENT ON COLUMN orcamento_cont.previsto06 IS 'Valor Previsto em Junho';
COMMENT ON COLUMN orcamento_cont.previsto07 IS 'Valor Previsto em Julho';
COMMENT ON COLUMN orcamento_cont.previsto08 IS 'Valor Previsto em Agosto';
COMMENT ON COLUMN orcamento_cont.previsto09 IS 'Valor Previsto em Setembro';
COMMENT ON COLUMN orcamento_cont.previsto10 IS 'Valor Previsto em Outubro';
COMMENT ON COLUMN orcamento_cont.previsto11 IS 'Valor Previsto em Novembro';
COMMENT ON COLUMN orcamento_cont.previsto12 IS 'Valor Previsto em Dezembro';
COMMENT ON COLUMN cablancamento_cont.codigoempresa IS 'Codigo da Empresa';
COMMENT ON COLUMN cablancamento_cont.codigo IS 'Codigo do lancamento';
COMMENT ON COLUMN cablancamento_cont.data IS 'Data do Lancamento';
COMMENT ON COLUMN cablancamento_cont.datadigitacao IS 'Data de Digitacao do Lancamento';
COMMENT ON COLUMN cablancamento_cont.horadigitacao IS 'Horario de Digitacao do Lancamento';
COMMENT ON COLUMN cablancamento_cont.loginoperador IS 'Login do Operador que digitou';
COMMENT ON COLUMN cablancamento_cont.dataliberacao IS 'Data de Liberacao';
COMMENT ON COLUMN cablancamento_cont.horaliberacao IS 'Horario de Liberacao';
COMMENT ON COLUMN cablancamento_cont.loginsupervisor IS 'Login do Supervisor que liberou o lancamento';
COMMENT ON COLUMN cablancamento_cont.aberto IS 'Lancamento Aberto (S/N) ?';
COMMENT ON COLUMN cablancamento_cont.contabilizado IS 'Lancamento Contabilizado (S/N) ?';
COMMENT ON COLUMN itemlancamento_cont.codigo IS 'Codigo do Item de Lancamento';
COMMENT ON COLUMN itemlancamento_cont.codigolancamento IS 'Codigo do Lancamento';
COMMENT ON COLUMN itemlancamento_cont.codigoacesso IS 'Codigo da Conta Contabil';
COMMENT ON COLUMN itemlancamento_cont.historico IS 'Historico';
COMMENT ON COLUMN itemlancamento_cont.valor IS 'Valor do Lancamento';
COMMENT ON COLUMN itemlancamento_cont.debitocredito IS 'Debito/Credito (D/C) ?';
COMMENT ON COLUMN itemlancamento_cont.codigozeramento IS 'Codigo do Zeramento (opcional)';
COMMENT ON COLUMN itemlancamento_cont.codigocentrocusto IS 'Código do Centro de Custo (opcional)';
COMMENT ON COLUMN itemlancamento_cont.nomeimagem IS 'Nome da Imagem arquivada';
COMMENT ON COLUMN nota_cont.codigo IS 'Codigo';
COMMENT ON COLUMN nota_cont.codigoempresa IS 'Codigo da Empresa';
COMMENT ON COLUMN nota_cont.notaexplicativa IS 'Texto da Nota Explicativa';
COMMENT ON COLUMN zeramento_cont.codigo IS 'Codigo';
COMMENT ON COLUMN zeramento_cont.codigoempresa IS 'Codigo da Empresa';
COMMENT ON COLUMN zeramento_cont.contrapartida IS 'Codigo da conta de contrapartida';
COMMENT ON COLUMN zeramento_cont.grupo1 IS 'Grupo a Zerar';
COMMENT ON COLUMN zeramento_cont.grupo2 IS 'Grupo a Zerar';
COMMENT ON COLUMN zeramento_cont.grupo3 IS 'Grupo a Zerar';
COMMENT ON COLUMN zeramento_cont.grupo4 IS 'Grupo a Zerar';
COMMENT ON COLUMN zeramento_cont.grupo5 IS 'Grupo a Zerar';
COMMENT ON COLUMN centrocusto_cont.codigo IS 'Código do Centro de Custo';
COMMENT ON COLUMN centrocusto_cont.codigoempresa IS 'Código da Empresa';
COMMENT ON COLUMN centrocusto_cont.sigla IS 'Sigla do Centro de Custo';
COMMENT ON COLUMN centrocusto_cont.descricao IS 'Descrição do Centro de Custo';
COMMENT ON COLUMN usuarioempresa_cont.codigo IS 'Código';
COMMENT ON COLUMN usuarioempresa_cont.codigousuario IS 'Código do usuário';
COMMENT ON SEQUENCE cablancamento_pk IS 'Sequence para cablancamento_cont';
COMMENT ON SEQUENCE consulta_cont_pk IS 'Sequence para consulta_cont';
COMMENT ON SEQUENCE contacontabil_pk IS 'Sequence para contacontabil_cont';
COMMENT ON SEQUENCE contadoar_pk IS 'Sequence para contadoar_cont;';
COMMENT ON SEQUENCE empresa_pk IS 'Sequence para empresa_cont';
COMMENT ON SEQUENCE historicopadrao_pk IS 'Sequence para historicopadrao_cont';
COMMENT ON SEQUENCE itemlancamento_pk IS 'Sequence para itemlancamento_cont';
COMMENT ON SEQUENCE nota_pk IS 'Sequence para nota_cont';
COMMENT ON SEQUENCE parametro_cont_pk IS 'Sequence para parametro_cont';
COMMENT ON SEQUENCE termo_pk IS 'Sequence para termo_cont';
COMMENT ON SEQUENCE usuario_cont_pk IS 'Sequence para usuario_cont';
COMMENT ON SEQUENCE zeramento_pk IS 'Sequence para zeramento_cont';
COMMENT ON SEQUENCE centrocusto_pk IS 'Sequence para Centros de Custo';
COMMENT ON SEQUENCE usuarioempresa_pk IS 'Sequence para Acessos de usuários a empresa';
