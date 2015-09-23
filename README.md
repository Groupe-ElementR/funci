# Une plateforme de calcul et de visualisation d'indicateurs fonctionnels 
**Compute and Display Functionnal Indicators**


## Objectif de l'application  
Les organisations, les chercheurs et les praticiens travaillent principalement sur des données « statiques »
qui caractérisent des unités spatiales. Dans ce cadre, chaque valeur décrit une unité spatiale
indépendamment de son contexte et des infrastructures qui la traversent. Les indicateurs fonctionnels aident
à considérer chaque unité spatiale dans son contexte territorial.  
Func-i est un outil qui répond à un double objectif :  
1. offrir une plateforme de calcul et de visualisation d'indicateurs fonctionnels ;  
2. proposer un outil générique que d’autres utilisateurs peuvent s’approprier et développer sur leurs
propres données.  

## Principe
Les modèles d’interaction spatiale sont utilisés pour décrire, expliquer ou prévoir les interactions entre les
lieux. On distingue deux grandes familles de modèles : l’interaction peut être saisie à travers des flux entre
les lieux (flux de personnes, de marchandises, de richesse, d’information, etc.) ; l’interaction peut aussi être
saisie à travers l’influence exercée par un lieu sur tous les autres (aire de marché d’un commerce, aire
d’influence d’une ville, etc.). C'est ce second type de modèle qui est mobilisé dans la plateforme Func-i. Plus
précisément, le potentiel, concept développé par le physicien John Q. Stewart , permet de mesurer les
stocks (quantités brutes de population, de travailleurs, de production) situés autour d'un lieu selon une
distance donnée (exprimée en temps de transport ou simplement à vol d’oiseau).
Selon ce principe, les indicateurs fonctionnels permettent :  
1. de rendre les cartes plus intelligibles en simplifiant la représentation des phénomènes spatiaux (figure 1);  
2. d’enrichir l’information en considérant simultanément les problématiques d’accessibilité et les
caractéristiques régionales.  

## Description
La plateforme se compose de trois principaux onglets. Le premier (**maps**), permet de visualiser sur une
carte, le potentiel ou l’accessibilité d’une série d’indicateurs statistiques (e.g. population, agriculteurs,
ouvriers, ...) . Dans le menu, les fonctions d’interactions sont paramétrables. Il est possible d’y faire varier la
portée et la nature de l’interaction elle-même (distance à vol d’oiseau, temps de transport par la route,
etc...). La modification de ces paramètres permet alors de construire des représentations cartographiques
plus ou moins simplifiées. Sous le menu, un texte d’explication est généré donnant une clef de lecture
concernant la carte affichée à l’écran. Sous la carte sont listées les 10 unités territoriales les plus
accessibles selon les paramètres choisis par l’utilisateur. Deux boutons permettent d’exporter les données et
la carte dans différents formats (csv, svg, png, jpg, pdf).  
![figure1](img/fig1.png)  
Si la cartographie de répartition du nombre d’ouvriers à l’échelle des communes d’Ile-de-France ne donne
pas immédiatement une image intelligible et mémorisable , l’enrichissement de la donnée par l’accessibilité
permet aussitôt d’en dégager les grandes structures spatiales. Ainsi, sur la figure 1, Paris et la petite
couronne sont naturellement mis en exergue. Mais, la carte d’accessibilité permet ici également de visualiser
de façon très nette d’autres pôles urbains secondaires où se concentrent des populations ouvrières :
Trappes, Goussainville, Mantes-la-Jolie, Evry, Meaux, Melun, les Mureaux, Cergy, ...  

L’onglet **graphs** permet de comparer les unités territoriales entre-elles pour un indicateur donné que
l’utilisateur peut changer à tout moment. Enfin, l’onglet **Help** décrit les éléments méthodologiques.

## Contexte de développement
L’application a été réalisée dans un premier temps dans le cadre du projet européen [ESPON FIT](http://fit.espon.eu/). Dans un second temps, dans une démarche de reproductibilité et d’ouverture du code,
l’outil a été rendu générique pour permettre son utilisation par d’autres utilisateurs sur d’autres espaces
géographiques avec d’autres données. 
La cartographie des CSP en Île-de-France est donc un
exemple d’utilisation parmi d’autres : la plateforme Func-i est une plateforme applicable à tout jeu de
données spatialisées.

## Technologies mobilisées
Func-i s’appuie sur deux environnements techniques différents. Tout d’abord, les indicateurs d’accessibilité
sont calculés en « backoffice » grâce au langage R et au package SpatialPosition (sur le [CRAN](https://cran.r-project.org/web/packages/SpatialPosition/) et sur [GitHub](Groupe-ElementR/SpatialPosition
)) . Ceci permet de générer
en bloc tous les fichiers utilisés par l’application. L’interface du site, les cartes et les graphiques sont quant à
eux générés dynamiquement via les langages usuels mis en œuvre dans le développement web (PHP,
HTML5, CSS, JavaScript). Deux librairies JavaScript sont également utilisées : Highcharts et JQuery. Du
fait de ces choix technique, l’application est portable, elle ne nécessite pas de base de données.