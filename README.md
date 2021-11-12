# Projet-plongée

Indication:
Pour lancer React
cd Front dans un terminale sous le dossier projet 
npm start
Pour lancer le reste:
Lancer Xamp
Dans l'invite de commande aller dans le dossier projet puis api puis 
symfony server:start

URLs:

API:

récupération de toute les données pour organisation dans un tableau
http://127.0.0.1:8000/api/all/look

récupération des profondeurs pour organisation dans un tableau
http://127.0.0.1:8000/api/profondeur/look

recherche d'une profondeur dans une table particulière
http://127.0.0.1:8000/api/profondeur/search?search=...&id=...

recherche d'un temps dans une profondeur particulière
http://127.0.0.1:8000/api/temps/search?search=...&id=...

BACK:

Profondeur:

CREATE
http://127.0.0.1:8000/back/profondeur/new
READ
http://127.0.0.1:8000/back/profondeur
UPDATE
http://127.0.0.1:8000/back/profondeur/edit/{id}
DELETE
http://127.0.0.1:8000/back/profondeur/delete/{id}

Temps:

CREATE
http://127.0.0.1:8000/back/temps/new
READ
http://127.0.0.1:8000/back/temps
UPDATE
http://127.0.0.1:8000/back/temps/edit/{id}
DELETE
http://127.0.0.1:8000/back/temps/delete/{id}

TablePlongee:
CREATE
http://127.0.0.1:8000/back/table_plongee/new
READ
http://127.0.0.1:8000/back/table_plongee
UPDATE
http://127.0.0.1:8000/back/table_plongee/edit/{id}
DELETE
http://127.0.0.1:8000/back/table_plongee/delete/{id}