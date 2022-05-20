## Compréhension

Ce que j'ai compris:

 * Un pensionnaire se fait inscrire par l'administrateur, ainsi que son/ses chevaux
 * Ensuite il doit, lors de cette inscription, souscrire à une pension (disponnible [ici](https://www.ecuriesdepersevere.com/travail-du-cheval-et-enseignement))
 * Cette pension lui laisse accès à des [installations](https://www.ecuriesdepersevere.com/installations) spécifiques à celle-ci et des prestations (et je crois bien que ces prestations n'apparaitront pas sur l'appli)
 * En plus de ça, hors des pensions, le pensionnaire peut prendre rendez-vous avec un professionnel de santé équine lors de ses visites et, si j'ai bien compris, ces prestations-là ne sont pas inclues dans les pensions donc il doit les payer
 * Les visites sont programmés par les "administrateurs" à une date dans une fourchette horaire, et étant donné que le temps moyen des rendez-vous est précisé lors de la programmation de la visite, il faudra calculer le max de rdv pour une visite dans sa fourchette horaire
 * Les soins prodigués doivent etre traçables, d'où l'association 0,n de batard dans le MCD (visits_booking)

Pour le moment le seul truc sur lequel je bug c'est que si une installation n'est pas comprise dans une pension, faut-il la faire payer lors de la réservation ?

## Le MCD

J'ai fait un premier jet du MCD, relis bien la doc et essaye de trouver des bails à rajouter. Il manque des colonnes notamment sur les installations (facilities) pour gérer l'utilisation max par jour / semaine (j'ai pas trop bien compris ce point-là)

C'est le fichier en .loo tu peux l'ouvrir avec [Looping](https://www.looping-mcd.fr/), c'est un executable t'as rien à installer

## Initialisation

J'ai initialisé le projet avec un template Vue TS donc ça sert à rien de mettre des routes web dans Laravel (routes/web.php) tout sera redirigé vers Vue.
Donc si tu veux test tes endpoints soit tu fais une vue de test dans vue (ressources/js) et tu mets tes routes dans l'index du fichier router, soit postman tu coco.
Si t'as des questions ou des remarques hésite pas à envoyer un message.

Pour les maquettes j'ai terminé la partie client, je vais essayer de taffer sur la partie admin demain entre 16h et 20h.
SI tu veux jetter un coup d'oeil c'est [ici](https://whimsical.com/uf-louis-3vVuL1TdFxH8rcnzLPtVbV), le mot de passe c'est "suceunzob123".

Bensouer