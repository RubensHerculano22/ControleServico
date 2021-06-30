CREATE TABLE Categoria(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  nome VARCHAR NOT NULL, 
  id_pai INT NOT NULL, 
  icon VARCHAR);


CREATE TABLE Colores(
  id INTEGER PRIMARY KEY AUTOINCREMENT, 
  color1 VARCHAR, 
  color2 VARCHAR, 
  color3 VARCHAR, 
  color4 VARCHAR, 
  color5 VARCHAR);


CREATE TABLE ContrataServico (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  id_orcamento INTEGER NOT NULL, 
  status INT, 
  id_usuario INTEGER NOT NULL, 
  data_servico DATE, 
  hora_servico VARCHAR, 
  descricao VARCHAR(1500), 
  endereco VARCHAR(300), 
  orcamento VARCHAR, 
  ativo TINYINT, 
  data_alteracao DATETIME);


CREATE TABLE ControleVisualizacao(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  id_servico INT, 
  id_usuario INT, 
  data_acesso DATETIME);


CREATE TABLE Enderecos (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  cep VARCHAR NOT NULL, 
  endereco VARCHAR NOT NULL, 
  bairro VARCHAR NOT NULL, 
  numero INT NOT NULL, 
  cidade VARCHAR NOT NULL, 
  estado INT NOT NULL, 
  complemento VARCHAR, 
  id_usuario INT NOT NULL);


CREATE TABLE EsqueciSenha (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  id_usuario INTEGER, 
  ativo INTEGER, 
  codigo VARCHAR NOT NULL, 
  data_solicitacao DATETIME, 
  data_troca DATETIME);


CREATE TABLE Estados(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  nome VARCHAR NOT NULL, 
  sigla VARCHAR NOT NULL);


CREATE TABLE Favoritos(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  data_inclusao DATETIME NOT NULL, 
  ativo TINYINT NOT NULL, 
  id_servico INT NOT NULL, 
  id_usuario INT NOT NULL);


CREATE TABLE Feedback(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  quantidade_estrelas INT NOT NULL, 
  titulo INT NOT NULL, 
  descricao BLOB, 
  data_inclusao DATETIME, 
  id_orcamento INT NOT NULL);


CREATE TABLE Horario (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  titulo VARCHAR);


CREATE TABLE "HorarioServico"(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  id_servico INT, 
  texto VARCHAR, 
  dia_semana INT);


CREATE TABLE Imagens (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  img BLOB, 
  ativo TINYINT NOT NULL, 
  principal TINYINT NOT NULL, 
  nome VARCHAR(150), 
  tipo_imagem VARCHAR(45), 
  data_insercao DATETIME, 
  id_servico INT NOT NULL);


CREATE TABLE ListaHorario(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  horario VARCHAR);


CREATE TABLE Orcamento (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  id_servico INT, 
  id_usuario INT);


CREATE TABLE OrcamentoStatus (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  nome VARCHAR);


CREATE TABLE "PagamentoServico"(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  id_tipo_pagamento INT NOT NULL, 
  id_servico INT NOT NULL, vezes int, juros int);


CREATE TABLE Perguntas (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  pergunta VARCHAR(1200) NOT NULL, 
  resposta VARCHAR(1200), 
  data_inclusao DATETIME NOT NULL, 
  data_resposta DATETIME, 
  id_servico INT NOT NULL, 
  id_usuario INT NOT NULL, 
  id_usuario_servico INT NOT NULL);


CREATE TABLE Servico (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  nome VARCHAR(200) NOT NULL, 
  ativo TINYINT NOT NULL, 
  descricao_curta VARCHAR(610), 
  descricao BLOB, 
  data_inclusao DATETIME NOT NULL, 
  data_atualizacao DATETIME, 
  id_tipo_servico TINYINT NOT NULL, 
  id_categoria INT NOT NULL, 
  valor FLOAT, 
  cep VARCHAR, 
  estado INTEGER, 
  cidade INTEGER, 
  bairro VARCHAR, 
  endereco VARCHAR, 
  numero INT, 
  complemento VARCHAR, 
  quantidade_disponivel INT, 
  caucao FLOAT, 
  id_usuario INTEGER);


CREATE TABLE TipoPagamento(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  nome VARCHAR(75) NOT NULL, 
  forma_pagamento VARCHAR NOT NULL);


CREATE TABLE TipoServico(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
  nome VARCHAR(50) NOT NULL);


CREATE TABLE Usuario (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
  nome VARCHAR NOT NULL, 
  sobrenome VARCHAR NOT NULL, 
  cpf VARCHAR(11) NOT NULL, 
  data_nascimento DATE NOT NULL, 
  telefone VARCHAR(10), 
  celular VARCHAR(11), 
  cep VARCHAR, 
  endereco VARCHAR, 
  bairro VARCHAR, 
  numero INT, 
  cidade VARCHAR, 
  estado INT, 
  complemento VARCHAR, 
  email VARCHAR(180) NOT NULL, 
  senha VARCHAR(32) NOT NULL, 
  data_insercao DATE, 
  data_criacao DATETIME, 
  ativar_conta INTEGER DEFAULT 0, 
  data_ativacao DATETIME);





  Arrumado


  CREATE TABLE Categoria(
  id INTEGER PRIMARY KEY NOT NULL, 
  nome VARCHAR(70) NOT NULL, 
  id_pai INT NOT NULL, 
  icon VARCHAR(100));


CREATE TABLE Colores(
  id INTEGER PRIMARY KEY, 
  color1 VARCHAR(20), 
  color2 VARCHAR(20), 
  color3 VARCHAR(20), 
  color4 VARCHAR(20), 
  color5 VARCHAR(20));


CREATE TABLE ContrataServico (
  id INTEGER NOT NULL PRIMARY KEY, 
  id_orcamento INTEGER NOT NULL, 
  status INT, 
  id_usuario INTEGER NOT NULL, 
  data_servico DATE, 
  hora_servico VARCHAR(20), 
  descricao VARCHAR(1500), 
  endereco VARCHAR(300), 
  orcamento VARCHAR(20), 
  ativo TINYINT, 
  data_alteracao DATETIME);


CREATE TABLE ControleVisualizacao(
  id INTEGER PRIMARY KEY NOT NULL, 
  id_servico INT, 
  id_usuario INT, 
  data_acesso DATETIME);


CREATE TABLE Enderecos (
  id INTEGER NOT NULL PRIMARY KEY, 
  cep VARCHAR(20) NOT NULL, 
  endereco VARCHAR(150) NOT NULL, 
  bairro VARCHAR(150) NOT NULL, 
  numero INT NOT NULL, 
  cidade VARCHAR(150) NOT NULL, 
  estado INT NOT NULL, 
  complemento VARCHAR(150), 
  id_usuario INT NOT NULL);


CREATE TABLE EsqueciSenha (
  id INTEGER NOT NULL PRIMARY KEY, 
  id_usuario INTEGER, 
  ativo INTEGER, 
  codigo VARCHAR(20) NOT NULL, 
  data_solicitacao DATETIME, 
  data_troca DATETIME);


CREATE TABLE Estados(
  id INTEGER PRIMARY KEY NOT NULL, 
  nome VARCHAR(100) NOT NULL, 
  sigla VARCHAR(20) NOT NULL);


CREATE TABLE Favoritos(
  id INTEGER PRIMARY KEY NOT NULL, 
  data_inclusao DATETIME NOT NULL, 
  ativo TINYINT NOT NULL, 
  id_servico INT NOT NULL, 
  id_usuario INT NOT NULL);


CREATE TABLE Feedback(
  id INTEGER PRIMARY KEY NOT NULL, 
  quantidade_estrelas INT NOT NULL, 
  titulo INT NOT NULL, 
  descricao BLOB, 
  data_inclusao DATETIME, 
  id_orcamento INT NOT NULL);


CREATE TABLE Horario (
  id INTEGER NOT NULL PRIMARY KEY, 
  titulo VARCHAR(20));

  CREATE TABLE HorarioServico(
  id INTEGER PRIMARY KEY NOT NULL, 
  id_servico INT, 
  texto VARCHAR(40), 
  dia_semana INT);


CREATE TABLE Imagens (
  id INTEGER NOT NULL PRIMARY KEY, 
  img BLOB, 
  ativo TINYINT NOT NULL, 
  principal TINYINT NOT NULL, 
  nome VARCHAR(150), 
  tipo_imagem VARCHAR(45), 
  data_insercao DATETIME, 
  id_servico INT NOT NULL);


CREATE TABLE ListaHorario(
  id INTEGER PRIMARY KEY NOT NULL, 
  horario VARCHAR(20));


CREATE TABLE Orcamento (
  id INTEGER NOT NULL PRIMARY KEY, 
  id_servico INT, 
  id_usuario INT);


CREATE TABLE OrcamentoStatus (
  id INTEGER NOT NULL PRIMARY KEY, 
  nome VARCHAR(60));