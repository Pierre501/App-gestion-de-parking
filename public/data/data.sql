create database gestion_parking;

use gestion_parking;


create table if not exists utilisateurs(
	id int not null auto_increment,
	nom varchar(100) not null,
	username varchar(255) not null,
	motdepasse varchar(255) not null,
	etat int(1) not null,
	roles int(1) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
)engine=innodb default charset=latin1;
insert into utilisateurs values(null, 'Adminstrateur', 'administrateur@gmail.com', '$2y$10$BNoYQJaHA0MilmM6Rlbi1eXQFJBiblZOPSDquTkeAfbSYrXZrTLCK', 1, 1, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into utilisateurs values(null, 'RAKOTO Jean','rakoto@gmail.com', '$2y$10$NkGUJdqlBxENp3Yjf6eRI.Xaq1fWRMsfv7R1vuLbWFEqycJMB3oZa', 1, 0, '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists portefeuilles(
	id int not null auto_increment,
	utilisateurs_id int not null,
	montant decimal(10,2) not null,
	montantdepense decimal(10,2) not null,
	etat int(1) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(utilisateurs_id) references utilisateurs(id)
)engine=innodb default charset=latin1;
insert into portefeuilles values(null, 1, 0, 0, 1, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into portefeuilles values(null, 2, 0, 0, 1, '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create view viewportefeuille as select utilisateurs_id, sum(montant) as montant, sum(montantdepense) as montantdepense, etat from portefeuilles group by utilisateurs_id, etat;


create view viewportefeuillefinal as select utilisateurs_id, montant, montantdepense, etat, (montant-montantdepense) as solde from viewportefeuille;


create view viewsutilisateur as select
	utilisateurs.id,
	utilisateurs.nom,
	utilisateurs.username,
	utilisateurs.motdepasse,
	viewportefeuillefinal.montant,
	viewportefeuillefinal.etat,
	viewportefeuillefinal.montantdepense,
	viewportefeuillefinal.solde
from utilisateurs join viewportefeuillefinal on utilisateurs.id = viewportefeuillefinal.utilisateurs_id;


create table if not exists historique_portefeuilles(
	id int not null auto_increment,
	portefeuilles_id int not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(portefeuilles_id) references portefeuilles(id)
)engine=innodb default charset=latin1;
insert into historique_portefeuilles values(null, 1, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into historique_portefeuilles values(null, 2, '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists voitures(
	id int not null auto_increment,
	utilisateurs_id int not null,
	model varchar(100) not null,
	marque varchar(100) not null,
	matricule varchar(30) not null,
	types varchar(100) not null,
	etat int not(1) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(utilisateurs_id) references utilisateurs(id)
)engine=innodb default charset=latin1;
insert into voitures values(null, 2, 'Sprinter', 'Mercedes', '1234TBA', 'Legèrs', 0, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into voitures values(null, 3, 'Camion', 'Mercedes', '3456TBA', 'Lourds', 0, '2023-11-10 22:49:00', '2023-11-10 22:49:00');

alter table voitures add etat int(1) default null;

create view viewstatusvoitures as select
	voitures.id,
	voitures.utilisateurs_id,
	voitures.model,
	voitures.marque,
	voitures.matricule,
	voitures.types,
	voitures.created_at,
	voitures.updated_at,
	stationnements.voitures_id
from voitures left join stationnements on voitures.id = stationnements.voitures_id where stationnements.voitures_id is null;


create table if not exists parkings(
	id int not null auto_increment,
	nomparking varchar(50) not null,
	lieuparking varchar(100) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
)engine=innodb default charset=latin1;
insert into parkings values(null, 'Parking ITuniversity', 'Andoharanofotsy', '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists places(
	id int not null auto_increment,
	parkings_id int not null,
	numero char(5) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(parkings_id) references parkings(id)
)engine=innodb default charset=latin1;
insert into places values(null, 1, '01', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '02', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '03', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '04', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '05', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '06', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '07', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '08', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '09', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '10', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '11', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '12', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '13', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '14', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into places values(null, 1, '15', '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists tarifparkings(
	id int not null auto_increment,
	tarif varchar(20) not null,
	dure time not null,
	montant decimal(10,2) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
)engine=innodb default charset=latin1;
insert into tarifparkings values(null, 'Tarif 1', '00:15:00', 1500, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into tarifparkings values(null, 'Tarif 2', '00:30:00', 3500, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into tarifparkings values(null, 'Tarif 3', '01:00:00', 5000, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into tarifparkings values(null, 'Tarif 4', '01:30:00', 7000, '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into tarifparkings values(null, 'Tarif 5', '02:00:00', 9000, '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists parametres(
	id int not null,
	dateparametre date not null,
	heureparametre time not null,
	options varchar(50) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
)engine=innodb default charset=latin1;
insert into parametres values(1, '2022-07-14', '09:00:00', 'Avance', '2023-11-10 22:49:00', '2023-11-10 22:49:00');

create view viewsparametre as select id, dateparametre, options, heureparametre, current_date as dateencours, current_time as heureencours from parametres;



create table if not exists stationnements(
	id int not null auto_increment,
	voitures_id int not null,
	places_id int not null,
	tarifparkings_id int not null,
	parametres_id int not null,
	datedebut date not null,
	heuredebut time not null,
	datefin date not null,
	heurefin time not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(voitures_id) references voitures(id),
	foreign key(places_id) references places(id),
	foreign key(tarifparkings_id) references tarifparkings(id),
	foreign key(parametres_id) references parametres(id)
)engine=innodb default charset=latin1;
insert into stationnements values(null, 1, 1, 1, 1,'2022-07-16', '07:00:00', '2022-07-16', '07:15:00', '2023-11-10 22:49:00', '2023-11-10 22:49:00');
insert into stationnements values(null, 7, 9, 1, 1,'2023-11-18', '10:47:00', '2023-11-18', '12:00:00', '2023-11-10 22:49:00', '2023-11-10 22:49:00');


create table if not exists historique_stationnements(
	id int not null auto_increment,
	voitures_id int not null,
	places_id int not null,
	tarifparkings_id int not null,
	parametres_id int not null,
	datedebut date not null,
	heuredebut time not null,
	datefin date not null,
	heurefin time not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(voitures_id) references voitures(id),
	foreign key(places_id) references places(id),
	foreign key(tarifparkings_id) references tarifparkings(id),
	foreign key(parametres_id) references parametres(id)
)engine=innodb default charset=latin1;



create view viewplacedisponible as select
	places.id,
	places.parkings_id,
	places.numero
from places left join stationnements on places.id = stationnements.places_id where stationnements.places_id is null;


create view viewsstationnement as select
	tarifparkings.tarif,
	tarifparkings.dure,
	tarifparkings.montant,
	stationnements.id,
	stationnements.voitures_id,
	stationnements.places_id,
	stationnements.tarifparkings_id,
	stationnements.parametres_id,
	stationnements.datedebut,
	stationnements.heuredebut,
	stationnements.datefin,
	stationnements.heurefin,
	viewsparametre.dateparametre,
	viewsparametre.heureparametre,
	viewsparametre.options,
	viewsparametre.dateencours,
	viewsparametre.heureencours
from tarifparkings join stationnements on tarifparkings.id = stationnements.tarifparkings_id
join viewsparametre on stationnements.parametres_id = viewsparametre.id;


create view viewsetat as select
	places.parkings_id,
	places.numero,
	viewsstationnement.id,
	viewsstationnement.places_id,
	viewsstationnement.voitures_id,
	viewsstationnement.tarifparkings_id,
	viewsstationnement.dure,
	viewsstationnement.options,
	viewsstationnement.parametres_id,
	viewsstationnement.datedebut,
	viewsstationnement.heuredebut,
	viewsstationnement.datefin,
	viewsstationnement.heurefin,
	viewsstationnement.dateparametre,
	viewsstationnement.heureparametre,
	viewsstationnement.dateencours,
	viewsstationnement.heureencours,
case 
	when viewsstationnement.dateparametre = viewsstationnement.datefin and viewsstationnement.heureparametre >= viewsstationnement.heuredebut and  viewsstationnement.heureparametre <= viewsstationnement.heurefin then "Occupé"
	when (viewsstationnement.dateparametre < viewsstationnement.datefin) and  (viewsstationnement.heureparametre >= viewsstationnement.heurefin or viewsstationnement.heureparametre <= viewsstationnement.heurefin) then "Occupé"
	when viewsstationnement.dateparametre <= viewsstationnement.datefin and viewsstationnement.heureparametre > viewsstationnement.heurefin then "En infraction"
	when viewsstationnement.dateparametre > viewsstationnement.datefin then "En infraction"
	else "Libre"
end as etatparametre,
case 
	when viewsstationnement.dateencours = viewsstationnement.datefin and viewsstationnement.heureencours >= viewsstationnement.heuredebut and  viewsstationnement.heureencours <= viewsstationnement.heurefin then "Occupé"
	when (viewsstationnement.dateencours < viewsstationnement.datefin) and  (viewsstationnement.heureencours >= viewsstationnement.heurefin or viewsstationnement.heureencours <= viewsstationnement.heurefin) then "Occupé"
	when viewsstationnement.dateencours <= viewsstationnement.datefin and viewsstationnement.heureencours > viewsstationnement.heurefin then "En infraction"
	when viewsstationnement.dateencours > viewsstationnement.datefin  then "En infraction"
	else "Libre"
end as etatencours
from places left join viewsstationnement on places.id = viewsstationnement.places_id;

create view viewsetatparking as select
	viewsetat.places_id,
	viewsetat.parkings_id,
	viewsetat.numero,
	viewsetat.id,
	viewsetat.tarifparkings_id,
	viewsetat.voitures_id,
	viewsetat.dure,
	viewsetat.parametres_id,
	viewsetat.datedebut,
	viewsetat.heuredebut,
	viewsetat.datefin,
	viewsetat.heurefin,
	viewsetat.etatparametre,
	viewsetat.etatencours,
	voitures.utilisateurs_id,
	voitures.model,
	voitures.marque,
	voitures.matricule,
	voitures.types
from viewsetat left join voitures on viewsetat.voitures_id = voitures.id;

drop view viewsetatparking;
drop view viewsetat;


create table if not exists voituresortants(
	id int not null auto_increment,
	voitures_id int not null,
	places_id int not null,
	datesortant date not null,
	heuresortant time not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(voitures_id) references voitures(id),
	foreign key(places_id) references places(id)
)engine=innodb default charset=latin1;



create table if not exists amendes(
	id int not null,
	nomamende varchar(30) not null,
	tranche int not null,
	montant decimal(10,2) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id)
)engine=innodb default charset=latin1;
insert into amendes values(1, 'Amende forfaitaire', 30, 1000, '2023-11-10 22:49:00', '2023-11-10 22:49:00');



create table if not exists payements(
	id int not null auto_increment,
	utilisateurs_id int not null,
	tarifparkings_id int not null,
	places_id int not null,
	montant decimal(10,2) not null,
	motif varchar(155) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(utilisateurs_id) references utilisateurs(id),
	foreign key(tarifparkings_id) references tarifparkings(id),
	foreign key(places_id) references places(id)
)engine=innodb default charset=latin1;


create table if not exists dettes(
	id int not null auto_increment,
	voitures_id int not null,
	montant decimal(10,2) not null,
	created_at datetime not null,
	updated_at datetime not null,
	primary key(id),
	foreign key(voitures_id) references voitures(id)
)engine=innodb default charset=latin1;


create view view_dette as select
	count(*) as compteur,
	voitures.utilisateurs_id
from dettes join voitures on dettes.voitures_id = voitures.id;




