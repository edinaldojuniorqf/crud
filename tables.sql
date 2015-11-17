CREATE TABLE funcionario
(
  id bigserial NOT NULL,
  nome character varying(255) NOT NULL,
  salario real DEFAULT 0,
  CONSTRAINT funcionario_pkey PRIMARY KEY (id)
);

CREATE TABLE necessidadesespeciais
(
  id bigserial NOT NULL,
  nome character varying(255) NOT NULL,
  CONSTRAINT necessidadesespeciais_pkey PRIMARY KEY (id)
);

CREATE TABLE funcionario_necessidadesespeciais
(
  id bigserial NOT NULL,
  funcionario_id bigint NOT NULL,
  necessidadeespecial_id bigint,
  data_cadastro timestamp without time zone,
  CONSTRAINT funcionario_necessidadesespeciais_pkey PRIMARY KEY (id),
  CONSTRAINT funcionario_necessidadesespeciais_funcionario_id_fkey FOREIGN KEY (funcionario_id)
      REFERENCES funcionario (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT funcionario_necessidadesespeciais_necessidadeespecial_id_fkey FOREIGN KEY (necessidadeespecial_id)
      REFERENCES necessidadesespeciais (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);
