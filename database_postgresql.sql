--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

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
-- Name: questionreponse; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE questionreponse (
    "idQuestion" integer NOT NULL,
    "idReponse" interval NOT NULL,
    "isCorrect" boolean NOT NULL
);


ALTER TABLE public.questionreponse OWNER TO matthias;

--
-- Name: reponse; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE reponse (
    "idReponse" integer NOT NULL,
    "labelReponse" text NOT NULL
);


ALTER TABLE public.reponse OWNER TO matthias;

--
-- Name: salle; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE salle (
    "idSalle" integer NOT NULL,
    "nomSalle" text NOT NULL,
    "idCategorie" integer NOT NULL,
    "nbQuestions" integer NOT NULL,
    "tempsLimite" integer NOT NULL,
    "isStarted" boolean NOT NULL
);


ALTER TABLE public.salle OWNER TO matthias;

--
-- Name: sallejoueur; Type: TABLE; Schema: public; Owner: matthias; Tablespace: 
--

CREATE TABLE sallejoueur (
    "idSalle" integer NOT NULL,
    "idJoueur" integer NOT NULL,
    "isHost" boolean NOT NULL,
    score integer NOT NULL,
    "tempsLastQuestion" numeric NOT NULL
);


ALTER TABLE public.sallejoueur OWNER TO matthias;

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

INSERT INTO question VALUES (2, 'Qui a gagné Rolland Garros, catégorie homme, en 2009 ?', 7, true);
INSERT INTO question VALUES (3, 'Combien de ligue des champions compte le S.L.Benfica ?', 7, true);
INSERT INTO question VALUES (4, 'A quel âge est décédé le pilote de Formule 1, Ayrton Senna ?', 7, true);
INSERT INTO question VALUES (5, 'Combien de courses a disputé Alain Prost ?', 7, true);
INSERT INTO question VALUES (6, 'Quel joueur a obtenu le Ballon d''or en 2008 ?', 7, true);
INSERT INTO question VALUES (7, 'Quelle est la date de sortie du film "E.T." ?', 3, true);
INSERT INTO question VALUES (8, 'Qui a réalisé le film "Indiana Jones : Les Aventuriers de l''arche perdue" ?', 3, true);
INSERT INTO question VALUES (9, 'Quel acteur a été le plus récompensé pour l''Oscar du meilleur acteur ?', 3, true);
INSERT INTO question VALUES (10, 'Qui a reçu le prix du César du meilleur acteur en 2011 ?', 3, true);
INSERT INTO question VALUES (11, 'En quelle année Coluche a-t-il reçu le prix du César du meilleur acteur ?', 3, true);
INSERT INTO question VALUES (12, 'Quel est le métier principal de Walter White, dans la série "Breaking bad" ?', 8, true);
INSERT INTO question VALUES (13, 'Quel est le nom de l''hopital de la série "Dr House" ?', 8, true);
INSERT INTO question VALUES (14, 'Quel est le nom de la prison dans la série "Prison Break" ?', 8, true);
INSERT INTO question VALUES (15, 'Comment est surnommé le personnage "Daenerys Targaryen", dans la série "Games of Thrones" ?', 8, true);
INSERT INTO question VALUES (16, 'Quel personnage de la série "the Walking dead" ne fait pas parti de la BD ?', 8, true);
INSERT INTO question VALUES (17, 'Qui est le premier président de la République française ?', 5, true);
INSERT INTO question VALUES (18, 'Quel est le nom du premier homme a avoir fait le tour du Monde ?', 5, true);
INSERT INTO question VALUES (19, 'Qui a été le premier roi de France ?', 5, true);
INSERT INTO question VALUES (20, 'En quel année Louis XIV est-il mort ?', 5, true);
INSERT INTO question VALUES (21, 'Quel navigateur a découvert le Brésil ?', 5, true);
INSERT INTO question VALUES (22, 'Quelle est la capital du Brésil ?', 4, true);
INSERT INTO question VALUES (23, 'Quelle est la capital du Bénin ?', 4, true);
INSERT INTO question VALUES (24, 'Dans quel pays le fleuve du "Douro" prend-t-il source ?', 4, true);
INSERT INTO question VALUES (25, 'Quel est l''océan le plus vaste du globe terrestre ?', 4, true);
INSERT INTO question VALUES (26, 'Dans quel pays se situe le Kilimandjaro ?', 4, true);
INSERT INTO question VALUES (27, 'Qui est le créateur de Mario ?', 6, true);
INSERT INTO question VALUES (28, 'Qui est le créateur de Kirby ?', 6, true);
INSERT INTO question VALUES (29, 'En quel année est sortie le titre "Sonic the Hedgehog" ?', 6, true);
INSERT INTO question VALUES (30, 'Quelle est la nationalité du créateur de Tetris ?', 6, true);
INSERT INTO question VALUES (31, 'Qui est le créateur de "Metal Gear Solid" ?', 6, true);
INSERT INTO question VALUES (32, 'Quel est la planète la plus proche du Soleil ?', 2, true);
INSERT INTO question VALUES (33, 'Quel est la planète la plus proche de la Terre ?', 2, true);
INSERT INTO question VALUES (34, 'A quelle distance se situe la Lune par rapport à la Terre ?', 2, true);
INSERT INTO question VALUES (35, 'En quelle année a été lancé le programme  "Apollo" ?', 2, true);
INSERT INTO question VALUES (36, 'Quel est le nom de la première navette spatiale ?', 2, true);
INSERT INTO question VALUES (37, 'Combien de coupe du Monde compte l''équipe de France de football ?', 7, true);
INSERT INTO question VALUES (38, 'Quel est le sportif possèdant le plus de titre en Jeux Olympiques ?', 7, true);
INSERT INTO question VALUES (39, 'Quel est l''année des premiers Jeux paralympiques ?', 7, true);
INSERT INTO question VALUES (40, 'En quel année ont eu lieu les Jeux paralympiques de Barcelone ?', 7, true);
INSERT INTO question VALUES (41, 'De combien est le record du monde de 100 m détenu par Usain Bolt ?', 7, true);
INSERT INTO question VALUES (42, 'En quelle année est sortie en salle le film "Retour vers le futur" ?', 3, true);
INSERT INTO question VALUES (43, 'En quelle année est sortie le film "Bad boy"', 3, true);
INSERT INTO question VALUES (44, 'En quelle année, l''acteur Will Smith débute sa carrière dans le cinéma ?', 3, true);
INSERT INTO question VALUES (45, 'Combien le film "Intouchables" a-t-il comptabilisé d''entrées en France ?', 3, true);
INSERT INTO question VALUES (46, 'Quel est le film le plus vu de l''histoire ?', 3, true);
INSERT INTO question VALUES (47, 'En quelle année s''est arrêté la série "Heroes" ?', 8, true);
INSERT INTO question VALUES (48, 'Quel est le pouvoir du personnage "Hiro Nakamura" dans la série "Heroes" ?', 8, true);
INSERT INTO question VALUES (49, 'Dans quelle série a joué l''acteur "Bryan Cranston" ?', 8, true);
INSERT INTO question VALUES (50, 'Combien compte d''épisode la série "Sliders" ?', 8, true);
INSERT INTO question VALUES (51, 'Quelle chaine américaine diffuse la série "Dr House" ?', 8, true);


--
-- Data for Name: questionreponse; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Data for Name: reponse; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Data for Name: salle; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Data for Name: sallejoueur; Type: TABLE DATA; Schema: public; Owner: matthias
--



--
-- Name: question reponse_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY questionreponse
    ADD CONSTRAINT "question reponse_pkey" PRIMARY KEY ("idQuestion", "idReponse");


--
-- Name: reponse_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY reponse
    ADD CONSTRAINT reponse_pkey PRIMARY KEY ("idReponse");


--
-- Name: salle_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY salle
    ADD CONSTRAINT salle_pkey PRIMARY KEY ("idSalle");


--
-- Name: sallejoueur_pkey; Type: CONSTRAINT; Schema: public; Owner: matthias; Tablespace: 
--

ALTER TABLE ONLY sallejoueur
    ADD CONSTRAINT sallejoueur_pkey PRIMARY KEY ("idSalle", "idJoueur");


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

