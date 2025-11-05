CREATE TABLE setor(
	ID SERIAL NOT NULL,
	NOME varchar(50) NOT NULL,
	primary key(id)
);

CREATE TABLE pergunta(
	ID SERIAL NOT NULL,
	pergunta varchar(100) NOT NULL,
	ativa smallint not null,
	id_setor BIGINT not null,
	PRIMARY KEY (ID)
);

ALTER TABLE pergunta ADD CONSTRAINT "FK_TBPERGUNTA_TBSETOR" FOREIGN KEY (id_setor) REFERENCES setor(id);

CREATE TABLE dispositivo(
	ID SERIAL NOT NULL,
	nome varchar(100) NOT NULL,
	ativa smallint not null,
	id_setor BIGINT not null,
	PRIMARY KEY (ID)
);

ALTER TABLE dispositivo ADD CONSTRAINT "FK_TBDISPOSITIVO_TBSETOR" FOREIGN KEY (id_setor) REFERENCES setor(id);

CREATE TABLE avaliacao(
	ID SERIAL NOT NULL,
	resposta smallint NOT NULL,
	feedback varchar(100),
	datahora timestamp not null,
	id_setor BIGINT not null,
	id_pergunta BIGINT not null,
	id_dispositivo BIGINT not null,
	PRIMARY KEY (ID)
);

ALTER TABLE avaliacao ADD CONSTRAINT "FK_TBAVALIACAO_TBSETOR" FOREIGN KEY (id_setor) REFERENCES setor(id);
ALTER TABLE avaliacao ADD CONSTRAINT "FK_TBAVALIACAO_TBPERGUNTA" FOREIGN KEY (id_pergunta) REFERENCES pergunta(id);
ALTER TABLE avaliacao ADD CONSTRAINT "FK_TBAVALIACAO_TBDISPOSITIVO" FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id);