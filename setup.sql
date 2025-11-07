CREATE TABLE setor(
	ID SERIAL NOT NULL,
	NOME varchar(50) NOT NULL,
	primary key(id)
);

CREATE TABLE pergunta(
	ID SERIAL NOT NULL,
	id_setor BIGINT not null,
	pergunta varchar(100) NOT NULL,
	ativa smallint not null,
	PRIMARY KEY (ID, id_setor)
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
	feedback varchar(100),
	datahora timestamp not null,
	id_setor BIGINT not null,
	id_dispositivo BIGINT not null,
	PRIMARY KEY (ID)
);

ALTER TABLE avaliacao ADD CONSTRAINT "FK_TBAVALIACAO_TBSETOR" FOREIGN KEY (id_setor) REFERENCES setor(id);
ALTER TABLE avaliacao ADD CONSTRAINT "FK_TBAVALIACAO_TBDISPOSITIVO" FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id);

CREATE TABLE respostas (
	sequencia SERIAL NOT NULL,
	id_avaliacao BIGINT NOT NULL,
	resposta smallint NOT NULL,
	id_pergunta BIGINT NOT null,
	PRIMARY KEY (sequencia, id_avaliacao)
);

ALTER TABLE respostas ADD CONSTRAINT "FK_TBRESPOSTA_TBAVALIACAO" FOREIGN KEY (id_avaliacao) REFERENCES avaliacao(ID);
ALTER TABLE respostas ADD CONSTRAINT "FK_TBRESPOSTA_TBPERGUNTA" FOREIGN KEY (id_pergunta) REFERENCES pergunta(ID);


INSERT INTO setor (nome) VALUES 
('Atendimento Acadêmico / Secretaria'),
('Corpo Docente / Professores'),
('Limpeza e Conservação'),
('Infraestrutura e Tecnologia'),
('Coordenação e Gestão Institucional');

INSERT INTO pergunta (pergunta, ativa, id_setor) VALUES
('O atendimento foi prestado com cordialidade e respeito?', 1, 1),
('O(a) atendente demonstrou conhecimento sobre os procedimentos acadêmicos?', 1, 1),
('O tempo de espera para ser atendido foi satisfatório?', 1, 1),
('As informações fornecidas foram claras e precisas?', 1, 1),
('Você sentiu que sua solicitação foi resolvida adequadamente?', 1, 1),
('O atendimento foi ágil e eficiente?', 1, 1),
('O(a) atendente se mostrou disposto(a) a ajudar?', 1, 1),
('A comunicação entre a secretaria e os estudantes é eficaz?', 1, 1),
('Você se sente bem acolhido(a) ao procurar este setor?', 1, 1),
('Como avalia sua satisfação geral com o atendimento acadêmico?', 1, 1);

INSERT INTO pergunta (pergunta, ativa, id_setor) VALUES
('Os professores demonstram domínio sobre o conteúdo ministrado?', 1, 2),
('As aulas são bem organizadas e didáticas?', 1, 2),
('O professor estimula a participação e o pensamento crítico dos alunos?', 1, 2),
('O feedback sobre atividades e avaliações é claro e construtivo?', 1, 2),
('O professor demonstra respeito e ética no relacionamento com os alunos?', 1, 2),
('O conteúdo das disciplinas é atualizado e relevante?', 1, 2),
('O professor cumpre horários e prazos de forma adequada?', 1, 2),
('As metodologias utilizadas favorecem o aprendizado?', 1, 2),
('Você se sente motivado(a) nas aulas ministradas pelos professores?', 1, 2),
('Como avalia sua satisfação geral com o corpo docente?', 1, 2);

INSERT INTO pergunta (pergunta, ativa, id_setor) VALUES
('As salas de aula estão limpas e bem cuidadas?', 1, 3),
('Os banheiros estão em boas condições de higiene?', 1, 3),
('As áreas comuns estão limpas e organizadas?', 1, 3),
('O lixo é recolhido com frequência adequada?', 1, 3),
('Há odores desagradáveis em alguma área do campus?', 1, 3),
('O serviço de limpeza é realizado de forma eficiente?', 1, 3),
('Os ambientes estão organizados e agradáveis?', 1, 3),
('A equipe de limpeza demonstra atenção e comprometimento?', 1, 3),
('Você considera o campus um ambiente limpo e confortável?', 1, 3),
('Qual é sua satisfação geral com a limpeza e conservação da universidade?', 1, 3);

INSERT INTO pergunta (pergunta, ativa, id_setor) VALUES
('As salas de aula e laboratórios possuem boa iluminação e ventilação?', 1, 4),
('Os equipamentos (computadores, projetores, etc.) estão em bom estado de uso?', 1, 4),
('O acesso à internet (Wi-Fi) é satisfatório e estável?', 1, 4),
('As instalações elétricas e hidráulicas funcionam adequadamente?', 1, 4),
('Os espaços físicos (salas, auditórios, biblioteca) são confortáveis?', 1, 4),
('A manutenção dos equipamentos é feita com frequência adequada?', 1, 4),
('O ambiente oferece segurança e acessibilidade?', 1, 4),
('A sinalização dentro do campus é clara e útil?', 1, 4),
('Você considera a infraestrutura adequada para as atividades acadêmicas?', 1, 4),
('Como avalia sua satisfação geral com a infraestrutura da universidade?', 1, 4);

INSERT INTO pergunta (pergunta, ativa, id_setor) VALUES
('A coordenação do curso está disponível para atender os alunos?', 1, 5),
('As informações institucionais são comunicadas com clareza?', 1, 5),
('As decisões da gestão são transparentes e coerentes?', 1, 5),
('Você sente que a universidade se preocupa com o bem-estar dos estudantes?', 1, 5),
('A coordenação responde às solicitações dentro de um prazo adequado?', 1, 5),
('Há canais eficazes de comunicação entre alunos e coordenação?', 1, 5),
('A instituição demonstra comprometimento com a qualidade do ensino?', 1, 5),
('As políticas da universidade são aplicadas de forma justa?', 1, 5),
('Você se sente ouvido(a) pela administração da universidade?', 1, 5),
('Qual é sua satisfação geral com a coordenação e gestão da instituição?', 1, 5);


INSERT into dispositivo (nome, ativa, id_setor) VALUES ('teste', 1, 1);