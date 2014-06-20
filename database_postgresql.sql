--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: categorie; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE categorie (
    "idCategorie" integer NOT NULL,
    "labelCategorie" text NOT NULL
);


ALTER TABLE public.categorie OWNER TO matthias;

--
-- Name: joueur; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE joueur (
    "idJoueur" integer NOT NULL,
    login text NOT NULL,
    password text NOT NULL,
    email text NOT NULL,
    "nbQuestionsCorrectes" integer DEFAULT 0 NOT NULL,
    "nbQuestionsRepondus" integer DEFAULT 0 NOT NULL,
    "nbTotalPoints" integer DEFAULT 0 NOT NULL,
    status boolean DEFAULT false NOT NULL,
    "isConnect" boolean DEFAULT false NOT NULL
);


ALTER TABLE public.joueur OWNER TO matthias;

--
-- Name: log; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE log (
    log text NOT NULL
);


ALTER TABLE public.log OWNER TO matthias;

--
-- Name: question; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE question (
    "idQuestion" integer NOT NULL,
    "labelQuestion" text NOT NULL,
    "idCategorie" integer NOT NULL,
    "isValidated" boolean DEFAULT false NOT NULL
);


ALTER TABLE public.question OWNER TO matthias;

--
-- Data for Name: categorie; Type: TABLE DATA; Schema: public; Owner: matthias
--

INSERT INTO categorie VALUES (1, 'Toutes');
INSERT INTO categorie VALUES (2, 'Astronomie');
INSERT INTO categorie VALUES (3, 'Cinéma');
INSERT INTO categorie VALUES (4, 'Géographie');
INSERT INTO categorie VALUES (5, 'Histoire');
INSERT INTO categorie VALUES (6, 'Jeux');
INSERT INTO categorie VALUES (7, 'Sport');
INSERT INTO categorie VALUES (8, 'Série');


--
-- Data for Name: joueur; Type: TABLE DATA; Schema: public; Owner: matthias
--

INSERT INTO joueur VALUES (1, 'Fabien', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'fabien.lassie@gmail.com', 0, 0, 0, true, false);
INSERT INTO joueur VALUES (2, 'Faouzi', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'faouzi.gazzah@gmail.com', 0, 0, 0, true, false);
INSERT INTO joueur VALUES (3, 'Julien', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'dealmeida.julien@gmail.com', 0, 0, 0, true, false);
INSERT INTO joueur VALUES (4, 'Matthias', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'matthias.ballarini@gmail.com', 0, 0, 0, true, false);
INSERT INTO joueur VALUES (5, 'Thomas', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'tomavron94@gmail.com', 0, 0, 0, true, false);


--
-- Data for Name: log; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Data for Name: question; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Name: categorie_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY categorie
    ADD CONSTRAINT categorie_pkey PRIMARY KEY ("idCategorie");


--
-- Name: joueur_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY joueur
    ADD CONSTRAINT joueur_pkey PRIMARY KEY ("idJoueur");


--
-- Name: question_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY question
    ADD CONSTRAINT question_pkey PRIMARY KEY ("idQuestion");


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

