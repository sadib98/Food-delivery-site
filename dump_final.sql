--
-- PostgreSQL database dump
--

-- Dumped from database version 11.6
-- Dumped by pg_dump version 11.6

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: carte; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carte (
    idcarte integer NOT NULL,
    nomcarte character varying(250)
);


ALTER TABLE public.carte OWNER TO postgres;

--
-- Name: Carte_idcarte_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Carte_idcarte_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Carte_idcarte_seq" OWNER TO postgres;

--
-- Name: Carte_idcarte_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Carte_idcarte_seq" OWNED BY public.carte.idcarte;


SET default_with_oids = false;

--
-- Name: client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client (
    nom character varying(250) NOT NULL,
    prenom character varying(250) NOT NULL,
    mail character varying(250) NOT NULL,
    telephone integer NOT NULL,
    numcb integer NOT NULL,
    adresse character varying(250) NOT NULL,
    codepostal integer NOT NULL,
    pointsfidelite integer NOT NULL,
    idcli integer NOT NULL,
    mot_de_passe character varying NOT NULL
);


ALTER TABLE public.client OWNER TO postgres;

--
-- Name: client_idcli_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.client_idcli_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.client_idcli_seq OWNER TO postgres;

--
-- Name: client_idcli_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.client_idcli_seq OWNED BY public.client.idcli;


--
-- Name: commande; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commande (
    date_a timestamp without time zone NOT NULL,
    etat character varying(250) NOT NULL,
    numcom integer NOT NULL,
    idres integer NOT NULL,
    idcli integer NOT NULL,
    idliv integer
);


ALTER TABLE public.commande OWNER TO postgres;

--
-- Name: commande_numcom_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.commande_numcom_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.commande_numcom_seq OWNER TO postgres;

--
-- Name: commande_numcom_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.commande_numcom_seq OWNED BY public.commande.numcom;


--
-- Name: commenter; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commenter (
    idcli integer NOT NULL,
    idres integer NOT NULL,
    note integer NOT NULL,
    commentaire character varying(250) NOT NULL,
    CONSTRAINT "note<0" CHECK ((note >= 0)),
    CONSTRAINT "note>5" CHECK ((note <= 5))
);


ALTER TABLE public.commenter OWNER TO postgres;

--
-- Name: contenir; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.contenir (
    numcommande integer NOT NULL,
    idplat integer NOT NULL,
    quantite integer NOT NULL
);


ALTER TABLE public.contenir OWNER TO postgres;

--
-- Name: decriverspecialite; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.decriverspecialite (
    idres integer NOT NULL,
    motclef character varying(250) NOT NULL
);


ALTER TABLE public.decriverspecialite OWNER TO postgres;

--
-- Name: fermeexcep; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fermeexcep (
    raison character varying(250) NOT NULL
);


ALTER TABLE public.fermeexcep OWNER TO postgres;

--
-- Name: fermer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fermer (
    idres integer NOT NULL,
    raison character varying(250) NOT NULL,
    date timestamp without time zone NOT NULL
);


ALTER TABLE public.fermer OWNER TO postgres;

--
-- Name: livreur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.livreur (
    nom character varying(250) NOT NULL,
    prenom character varying(250) NOT NULL,
    telephone integer NOT NULL,
    adresse character varying(250) NOT NULL,
    mot_de_passe character varying(250) NOT NULL,
    etat character varying(250) NOT NULL,
    matricule integer NOT NULL
);


ALTER TABLE public.livreur OWNER TO postgres;

--
-- Name: livreur_idliv_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.livreur_idliv_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.livreur_idliv_seq OWNER TO postgres;

--
-- Name: livreur_idliv_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.livreur_idliv_seq OWNED BY public.livreur.matricule;


--
-- Name: parrainer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parrainer (
    idcli integer NOT NULL,
    idparrain integer NOT NULL
);


ALTER TABLE public.parrainer OWNER TO postgres;

--
-- Name: plat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.plat (
    nomplat character varying(250) NOT NULL,
    prix real NOT NULL,
    description character varying(250) NOT NULL,
    idplat integer NOT NULL,
    imagemenu character varying(250)
);


ALTER TABLE public.plat OWNER TO postgres;

--
-- Name: plat_idplat_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.plat_idplat_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.plat_idplat_seq OWNER TO postgres;

--
-- Name: plat_idplat_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.plat_idplat_seq OWNED BY public.plat.idplat;


--
-- Name: proposer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proposer (
    idplat integer NOT NULL,
    idcarte integer NOT NULL
);


ALTER TABLE public.proposer OWNER TO postgres;

--
-- Name: restaurant; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.restaurant (
    nom character varying(250) NOT NULL,
    adresse character varying(250) NOT NULL,
    codepostal integer NOT NULL,
    houvert time without time zone NOT NULL,
    hferme time without time zone NOT NULL,
    prixlivraison real NOT NULL,
    idres integer NOT NULL,
    idcarte integer,
    image character varying(250)
);


ALTER TABLE public.restaurant OWNER TO postgres;

--
-- Name: restaurant_idres_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.restaurant_idres_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.restaurant_idres_seq OWNER TO postgres;

--
-- Name: restaurant_idres_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.restaurant_idres_seq OWNED BY public.restaurant.idres;


--
-- Name: specialite; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.specialite (
    motclef character varying(250) NOT NULL
);


ALTER TABLE public.specialite OWNER TO postgres;

--
-- Name: travailler; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.travailler (
    matricule integer NOT NULL,
    codepostal integer NOT NULL
);


ALTER TABLE public.travailler OWNER TO postgres;

--
-- Name: ville; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ville (
    codepostal integer NOT NULL,
    nom character varying(250) NOT NULL,
    pays character varying(250)
);


ALTER TABLE public.ville OWNER TO postgres;

--
-- Name: carte idcarte; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carte ALTER COLUMN idcarte SET DEFAULT nextval('public."Carte_idcarte_seq"'::regclass);


--
-- Name: client idcli; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client ALTER COLUMN idcli SET DEFAULT nextval('public.client_idcli_seq'::regclass);


--
-- Name: commande numcom; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commande ALTER COLUMN numcom SET DEFAULT nextval('public.commande_numcom_seq'::regclass);


--
-- Name: livreur matricule; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.livreur ALTER COLUMN matricule SET DEFAULT nextval('public.livreur_idliv_seq'::regclass);


--
-- Name: plat idplat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plat ALTER COLUMN idplat SET DEFAULT nextval('public.plat_idplat_seq'::regclass);


--
-- Name: restaurant idres; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.restaurant ALTER COLUMN idres SET DEFAULT nextval('public.restaurant_idres_seq'::regclass);


--
-- Data for Name: carte; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.carte VALUES (1, 'KFC carte');
INSERT INTO public.carte VALUES (2, 'McDonald''s carte');
INSERT INTO public.carte VALUES (3, 'Burger King carte');
INSERT INTO public.carte VALUES (4, 'Tacos carte');
INSERT INTO public.carte VALUES (5, 'Cezam Carte');


--
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.client VALUES ('Abi Hanna Daher', 'Alexy', 'aabihann@etud.u-pem.fr', 123456789, 123456789, '4 rue Welter', 93330, 0, 2, 'alexy1234');
INSERT INTO public.client VALUES ('HAMITOUCHE', 'Bilel', 'bhamitou@etud.u-pem.fr', 123456789, 123456789, '4 rue boifdf', 93330, 0, 4, 'bilel123');
INSERT INTO public.client VALUES ('SAN', 'Nishan', 'san@etud.u-pem.fr', 87897897, 98789, '2 Rue albert', 94600, 0, 7, 'san123');
INSERT INTO public.client VALUES ('kdsuhf', 'kjdsf', 'sadib@enjoy.com', 8797, 7867, '5hsqbnd qksbd', 94600, 0, 8, 'sadib123');
INSERT INTO public.client VALUES ('Sadib', 'Alexy', 'sadib.alexy@enjoy.com', 6060606, 9090909, '2 avenue France', 93330, 0, 9, 'sadibalexy123');
INSERT INTO public.client VALUES ('AHAMMAD', 'Sadib', 'sahammad@etud.u-pem.fr', 12345678, 12345678, '2 rue brbrb', 77420, 10, 5, 'sadib123');


--
-- Data for Name: commande; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.commande VALUES ('2019-12-13 11:21:57', 'Livré', 11, 2, 2, NULL);
INSERT INTO public.commande VALUES ('2019-12-13 10:41:11', 'Livré', 9, 3, 2, NULL);
INSERT INTO public.commande VALUES ('2019-12-03 00:00:00', 'Livré', 4, 2, 2, 1);
INSERT INTO public.commande VALUES ('2019-12-13 10:43:28', 'Livré', 10, 3, 2, 1);
INSERT INTO public.commande VALUES ('2019-12-13 11:26:45', 'Livré', 12, 1, 5, 1);
INSERT INTO public.commande VALUES ('2019-12-13 15:58:18', 'Livré', 15, 3, 2, 1);
INSERT INTO public.commande VALUES ('2019-12-13 23:03:40', 'Livré', 18, 3, 2, 1);
INSERT INTO public.commande VALUES ('2019-12-13 23:05:26', 'Livré', 19, 3, 2, 1);
INSERT INTO public.commande VALUES ('2019-12-14 11:08:10', 'Livré', 20, 1, 5, 1);
INSERT INTO public.commande VALUES ('2019-12-14 11:09:05', 'Livré', 21, 1, 5, 1);
INSERT INTO public.commande VALUES ('2019-12-14 11:09:55', 'Livré', 22, 1, 5, 1);
INSERT INTO public.commande VALUES ('2019-12-14 17:08:45', 'Livré', 23, 5, 5, 1);
INSERT INTO public.commande VALUES ('2019-12-14 20:41:25', 'en attente', 24, 3, 2, NULL);
INSERT INTO public.commande VALUES ('2019-12-15 16:00:17', 'Livré', 25, 2, 2, 5);
INSERT INTO public.commande VALUES ('2019-12-16 11:21:19', 'Livré', 26, 3, 9, 5);


--
-- Data for Name: commenter; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.commenter VALUES (2, 2, 5, 'Tres bon wings.');
INSERT INTO public.commenter VALUES (2, 3, 2, 'Boff');
INSERT INTO public.commenter VALUES (5, 1, 5, 'très bon');
INSERT INTO public.commenter VALUES (9, 3, 3, 'C''est bon .');


--
-- Data for Name: contenir; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.contenir VALUES (4, 1, 1);
INSERT INTO public.contenir VALUES (9, 3, 4);
INSERT INTO public.contenir VALUES (10, 3, 2);
INSERT INTO public.contenir VALUES (10, 4, 1);
INSERT INTO public.contenir VALUES (11, 1, 2);
INSERT INTO public.contenir VALUES (12, 2, 1);
INSERT INTO public.contenir VALUES (15, 3, 4);
INSERT INTO public.contenir VALUES (15, 4, 2);
INSERT INTO public.contenir VALUES (18, 3, 2);
INSERT INTO public.contenir VALUES (18, 4, 1);
INSERT INTO public.contenir VALUES (19, 3, 2);
INSERT INTO public.contenir VALUES (19, 4, 2);
INSERT INTO public.contenir VALUES (20, 2, 3);
INSERT INTO public.contenir VALUES (21, 2, 3);
INSERT INTO public.contenir VALUES (22, 2, 4);
INSERT INTO public.contenir VALUES (23, 1, 2);
INSERT INTO public.contenir VALUES (24, 3, 2);
INSERT INTO public.contenir VALUES (24, 4, 1);
INSERT INTO public.contenir VALUES (25, 1, 2);
INSERT INTO public.contenir VALUES (26, 3, 2);
INSERT INTO public.contenir VALUES (26, 4, 1);


--
-- Data for Name: decriverspecialite; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.decriverspecialite VALUES (2, 'burger');
INSERT INTO public.decriverspecialite VALUES (2, 'poulet');
INSERT INTO public.decriverspecialite VALUES (1, 'burger');
INSERT INTO public.decriverspecialite VALUES (3, 'burger');
INSERT INTO public.decriverspecialite VALUES (1, 'fast food');
INSERT INTO public.decriverspecialite VALUES (2, 'fast food');
INSERT INTO public.decriverspecialite VALUES (3, 'fast food');


--
-- Data for Name: fermeexcep; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.fermeexcep VALUES ('Noel 2019');
INSERT INTO public.fermeexcep VALUES ('Nouvel an 2020');


--
-- Data for Name: fermer; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.fermer VALUES (2, 'Noel 2019', '2019-12-24 00:00:00');
INSERT INTO public.fermer VALUES (1, 'Noel 2019', '2019-12-25 00:00:00');


--
-- Data for Name: livreur; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.livreur VALUES ('Aoun', 'Georges', 234567891, '52 rue de Dr Vaillant', 'georges123', 'en attente', 2);
INSERT INTO public.livreur VALUES ('Hello ', 'sqjd', 89797, '5 qsdjk', 'hello123', 'en attente', 3);
INSERT INTO public.livreur VALUES ('Samaha', 'Joey', 987654321, '8 rue Welter', '1234', 'en attente', 1);
INSERT INTO public.livreur VALUES ('shdbn', 'jkbndsha', 79866, '2 dsjfln dsfu', 'hahaha', 'inactif', 4);
INSERT INTO public.livreur VALUES ('Nabil', 'Fekir', 909098, '2 rue de gerland ', 'demo1234', 'en attente', 5);


--
-- Data for Name: parrainer; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.parrainer VALUES (2, 5);
INSERT INTO public.parrainer VALUES (4, 2);
INSERT INTO public.parrainer VALUES (7, 9);


--
-- Data for Name: plat; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.plat VALUES ('Big Mac', 8.39999962, '1 sandwich,1 accompagnement,1 boisson', 2, 'bigmac.jpg');
INSERT INTO public.plat VALUES ('Menu - 16 wings', 17.9500008, '16 Hot Wings + 2 accompagnements + 2 boissons au choix', 1, '16wings.jpg');
INSERT INTO public.plat VALUES ('Le Cantal', 9.39999962, 'Deux viandes de bœuf grillées à la flamme et tous les ingrédients du WHOPPER®', 3, 'cantal.jpg');
INSERT INTO public.plat VALUES ('Le Grill', 9.39999962, 'Une viande de bœuf, du cheddar affiné et un pain brioché moelleux.', 4, 'grill.jpeg');
INSERT INTO public.plat VALUES ('Tacos XL', 9, 'Double tortilla + triple dose de viande au choix', 5, 'tacosxl.jpeg');
INSERT INTO public.plat VALUES ('Kebab', 6.5, 'pain au choix, emincé de kebab, servi avec frites et boisson', 6, 'kebab.jpg');
INSERT INTO public.plat VALUES ('Pavé de Saumon', 16, 'Pavé de saumon et sauce citronnée, servis avec pain, garniture.', 7, 'saumon.jpeg');


--
-- Data for Name: proposer; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.proposer VALUES (1, 1);
INSERT INTO public.proposer VALUES (2, 2);
INSERT INTO public.proposer VALUES (3, 3);
INSERT INTO public.proposer VALUES (4, 3);
INSERT INTO public.proposer VALUES (5, 4);
INSERT INTO public.proposer VALUES (6, 5);
INSERT INTO public.proposer VALUES (7, 5);


--
-- Data for Name: restaurant; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.restaurant VALUES ('McDonald''s', '2 Boulevard de Champy Nesles', 77420, '09:00:00', '01:00:00', 3, 1, 2, 'mcdonalds.png');
INSERT INTO public.restaurant VALUES ('KFC', '2 Boulevard du Maréchal Foch', 93330, '08:00:00', '24:00:00', 3.5, 2, 1, 'kfc.jpg');
INSERT INTO public.restaurant VALUES ('KFC', '2 rue logne', 77420, '09:00:00', '23:00:00', 5, 5, 1, 'kfc.jpg');
INSERT INTO public.restaurant VALUES ('Burger King', '2 Boulevard du Maréchal Foch', 93330, '11:00:00', '24:00:00', 2, 3, 3, 'burgerking.png');
INSERT INTO public.restaurant VALUES ('Otacos', 'Avenue de la France libre', 94000, '11:00:00', '23:00:00', 5, 6, 4, 'otacos.jpg');
INSERT INTO public.restaurant VALUES ('Cezam', '5 Avenue Jean Jaurès', 94600, '11:00:00', '00:00:00', 3.5, 7, 5, 'cezam.png');


--
-- Data for Name: specialite; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.specialite VALUES ('burger');
INSERT INTO public.specialite VALUES ('poulet');
INSERT INTO public.specialite VALUES ('fast food');


--
-- Data for Name: travailler; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.travailler VALUES (3, 94600);
INSERT INTO public.travailler VALUES (1, 93330);
INSERT INTO public.travailler VALUES (1, 77420);
INSERT INTO public.travailler VALUES (5, 93330);
INSERT INTO public.travailler VALUES (5, 77420);
INSERT INTO public.travailler VALUES (5, 94600);


--
-- Data for Name: ville; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.ville VALUES (93330, 'Neuilly-sur-Marne', 'France');
INSERT INTO public.ville VALUES (77420, 'Champs-sur-Marne', 'France');
INSERT INTO public.ville VALUES (94600, 'Choisy-Le-Roi', 'France');
INSERT INTO public.ville VALUES (94000, 'Créteil', 'France');


--
-- Name: Carte_idcarte_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Carte_idcarte_seq"', 5, true);


--
-- Name: client_idcli_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.client_idcli_seq', 9, true);


--
-- Name: commande_numcom_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.commande_numcom_seq', 26, true);


--
-- Name: livreur_idliv_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.livreur_idliv_seq', 5, true);


--
-- Name: plat_idplat_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.plat_idplat_seq', 7, true);


--
-- Name: restaurant_idres_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.restaurant_idres_seq', 7, true);


--
-- Name: carte Carte_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carte
    ADD CONSTRAINT "Carte_pkey" PRIMARY KEY (idcarte);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (idcli);


--
-- Name: commande commande_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_pkey PRIMARY KEY (numcom);


--
-- Name: commenter commenter_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commenter
    ADD CONSTRAINT commenter_pkey PRIMARY KEY (idcli, idres);


--
-- Name: contenir contenir_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_pkey PRIMARY KEY (numcommande, idplat);


--
-- Name: decriverspecialite decriverspecialite_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.decriverspecialite
    ADD CONSTRAINT decriverspecialite_pkey PRIMARY KEY (idres, motclef);


--
-- Name: fermeexcep fermeexcep_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fermeexcep
    ADD CONSTRAINT fermeexcep_pkey PRIMARY KEY (raison);


--
-- Name: fermer fermer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fermer
    ADD CONSTRAINT fermer_pkey PRIMARY KEY (idres, raison, date);


--
-- Name: livreur livreur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.livreur
    ADD CONSTRAINT livreur_pkey PRIMARY KEY (matricule);


--
-- Name: parrainer parrainer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parrainer
    ADD CONSTRAINT parrainer_pkey PRIMARY KEY (idcli, idparrain);


--
-- Name: plat plat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.plat
    ADD CONSTRAINT plat_pkey PRIMARY KEY (idplat);


--
-- Name: proposer proposer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_pkey PRIMARY KEY (idplat, idcarte);


--
-- Name: restaurant restaurant_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.restaurant
    ADD CONSTRAINT restaurant_pkey PRIMARY KEY (idres);


--
-- Name: specialite specialite_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.specialite
    ADD CONSTRAINT specialite_pkey PRIMARY KEY (motclef);


--
-- Name: travailler travailler_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.travailler
    ADD CONSTRAINT travailler_pkey PRIMARY KEY (matricule, codepostal);


--
-- Name: ville ville_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ville
    ADD CONSTRAINT ville_pkey PRIMARY KEY (codepostal);


--
-- Name: client client_codepostal_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_codepostal_fkey FOREIGN KEY (codepostal) REFERENCES public.ville(codepostal) ON UPDATE CASCADE;


--
-- Name: commande commande_idcli_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_idcli_fkey FOREIGN KEY (idcli) REFERENCES public.client(idcli) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: commande commande_idliv_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_idliv_fkey FOREIGN KEY (idliv) REFERENCES public.livreur(matricule) ON UPDATE CASCADE;


--
-- Name: commande commande_idres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commande
    ADD CONSTRAINT commande_idres_fkey FOREIGN KEY (idres) REFERENCES public.restaurant(idres) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: commenter commenter_idcli_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commenter
    ADD CONSTRAINT commenter_idcli_fkey FOREIGN KEY (idcli) REFERENCES public.client(idcli) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: commenter commenter_idres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commenter
    ADD CONSTRAINT commenter_idres_fkey FOREIGN KEY (idres) REFERENCES public.restaurant(idres) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: contenir contenir_idplat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_idplat_fkey FOREIGN KEY (idplat) REFERENCES public.plat(idplat) ON UPDATE CASCADE;


--
-- Name: contenir contenir_numcommande_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.contenir
    ADD CONSTRAINT contenir_numcommande_fkey FOREIGN KEY (numcommande) REFERENCES public.commande(numcom) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: decriverspecialite decriverspecialite_idres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.decriverspecialite
    ADD CONSTRAINT decriverspecialite_idres_fkey FOREIGN KEY (idres) REFERENCES public.restaurant(idres) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: decriverspecialite decriverspecialite_motclef_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.decriverspecialite
    ADD CONSTRAINT decriverspecialite_motclef_fkey FOREIGN KEY (motclef) REFERENCES public.specialite(motclef) ON UPDATE CASCADE;


--
-- Name: fermer fermer_idres_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fermer
    ADD CONSTRAINT fermer_idres_fkey FOREIGN KEY (idres) REFERENCES public.restaurant(idres) ON UPDATE CASCADE;


--
-- Name: fermer fermer_raison_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fermer
    ADD CONSTRAINT fermer_raison_fkey FOREIGN KEY (raison) REFERENCES public.fermeexcep(raison) ON UPDATE CASCADE;


--
-- Name: parrainer parrainer_idcli_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parrainer
    ADD CONSTRAINT parrainer_idcli_fkey FOREIGN KEY (idcli) REFERENCES public.client(idcli) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: parrainer parrainer_idparrain_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parrainer
    ADD CONSTRAINT parrainer_idparrain_fkey FOREIGN KEY (idparrain) REFERENCES public.client(idcli) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: proposer proposer_idcarte_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_idcarte_fkey FOREIGN KEY (idcarte) REFERENCES public.carte(idcarte) ON UPDATE CASCADE;


--
-- Name: proposer proposer_idplat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proposer
    ADD CONSTRAINT proposer_idplat_fkey FOREIGN KEY (idplat) REFERENCES public.plat(idplat) ON UPDATE CASCADE;


--
-- Name: restaurant restaurant_idcarte_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.restaurant
    ADD CONSTRAINT restaurant_idcarte_fkey FOREIGN KEY (idcarte) REFERENCES public.carte(idcarte);


--
-- Name: travailler travailler_codepostal_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.travailler
    ADD CONSTRAINT travailler_codepostal_fkey FOREIGN KEY (codepostal) REFERENCES public.ville(codepostal) ON UPDATE CASCADE;


--
-- Name: travailler travailler_matricule_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.travailler
    ADD CONSTRAINT travailler_matricule_fkey FOREIGN KEY (matricule) REFERENCES public.livreur(matricule) ON UPDATE CASCADE;


--
-- PostgreSQL database dump complete
--

