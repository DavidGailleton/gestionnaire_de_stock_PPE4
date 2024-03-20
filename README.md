## Contexte

### Description du laboratoire GSB

#### Le secteur d'activité

L’industrie pharmaceutique est un secteur très lucratif dans lequel le mouvement de fusion acquisition est très fort. Les regroupements de laboratoires ces dernières années ont donné naissance à des entités gigantesques au sein desquelles le travail est longtemps resté organisé selon les anciennes structures.

De divers déboires récents autour de médicaments ou molécules ayant entraîné des complications médicales ont fait s'élever des voix contre une partie de l'activité des laboratoires : la visite médicale, réputée être le lieu d' arrangements entre l'industrie et les praticiens, et tout du moins un terrain d'influence opaque.

#### L'entreprise

Le laboratoire Galaxy Swiss Bourdin (GSB) est issu de la fusion entre le géant américain Galaxy (spécialisé dans le secteur des maladies virales dont le SIDA et les hépatites) et le conglomérat européen Swiss Bourdin (travaillant sur des médicaments plus conventionnels), lui même déjà union de trois petits laboratoires . En 2009, les deux géants pharmaceutiques ont uni leurs forces pour créer un leader de ce secteur industriel. L'entité Galaxy Swiss Bourdin Europe a établi son siège administratif à Paris.

Le siège social de la multinationale est situé à Philadelphie, Pennsylvanie, aux EtatsUnis.

La France a été choisie comme témoin pour l'amélioration du suivi de l'activité de visite

### L'application mis en place

L'application présentée dans ce compte rendu permet de gérer la chaine d'approvisionnement des différents laboratoires de l'entreprise GSB.

Elle permet aux différents laboratoires de commander des médicaments ou du matériel.

## Mise en place

### Prérequis

#### XAMPP

XAMPP permet de mettre en place facilement un environnement Apache et un base de données MySQL ou MariaDB.

Pour l'installation il faut se diriger sur [la page de téléchargement de XAMPP](https://www.apachefriends.org/fr/download.html)

Une fois sur la page, téléchargé la version **PHP 8.2.12** :

![xampp_download.png](public%2Fimg%2FREADME%2Fxampp_download.png)

Une fois téléchargé, lancer l'executable.

Il est possible qu'une fenêtre vous prévienne que votre anti virus est actif. N'y prêtez pas attention et cliquez sur oui :

![xampp_antivirus_alert.png](public%2Fimg%2FREADME%2Fxampp_antivirus_alert.png)

En suite, faite suivant plusieurs fois :

![xampp_installer_1.png](public%2Fimg%2FREADME%2Fxampp_installer_1.png)

![xampp_installer_2.png](public%2Fimg%2FREADME%2Fxampp_installer_2.png)

Vérifié bien que dans le champ ***Select a folder***, le chemin soit `C:\xampp`

![xampp_installer_3.png](public%2Fimg%2FREADME%2Fxampp_installer_3.png)

![xampp_installer_4.png](public%2Fimg%2FREADME%2Fxampp_installer_4.png)

![xampp_installer_5.png](public%2Fimg%2FREADME%2Fxampp_installer_5.png)

Si le programme d'installation vous propose de redémarrer votre poste, redémarrez-le.

### Installation du projet

Une fois XAMPP installé, nous pouvons ajouter le projet en local.

Pour commencer, il faut télécharger le projet depuis [le dépot Github](https://github.com/DavidGailleton/gestionnaire_de_stock_PPE4) :

![github_download.png](public%2Fimg%2FREADME%2Fgithub_download.png)

Une fois téléchargé, extraire le dossier précédemment téléchargé dans le dossier `C:\xampp\htdocs`.

**Attention, l'extracteur vous proposera surement de l'éxtraire dans le dossier `C:\xampp\htdocs\ppe4`. Bien penser à corriger** :

![project_extract_1.png](public%2Fimg%2FREADME%2Fproject_extract_1.png)

![project_extract_2.png](public%2Fimg%2FREADME%2Fproject_extract_2.png)

### Base de données MariaDB

Pour mettre la base de données en place, il faut en premier temps démarrer **Apache** et **MySQL** depuis XAMPP :

![xampp_start_mysql_apache.png](public%2Fimg%2FREADME%2Fxampp_start_mysql_apache.png)

Il est maintenant possible d'accéder à PHP My Admin pour accéder aux bases de données depuis le navigateur web avec l'addresse [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

Pour créer la base de données, il faut en premier temps cliquer sur *Nouvelle base de données* (**1.**), puis donner un nom à la base de données, dans notre cas `ppe4` (**2.**), puis cliquer sur *Créer* (**3.**) :

![phpmyadmin_create_database.png](public%2Fimg%2FREADME%2Fphpmyadmin_create_database.png)

Nous allons en suite importer la base de données du projet.

Cette base des données est disponible à la racine du projet. L'importation est simplifié par l'interface phpmyadmin :

![import_sql_1.png](public%2Fimg%2FREADME%2Fimport_sql_1.png)

![import_sql_2.png](public%2Fimg%2FREADME%2Fimport_sql_2.png)

![import_sql_3.png](public%2Fimg%2FREADME%2Fimport_sql_3.png)

Si tout s'est déroulé comme prévu, la base de données devrait se présenter comme ceci :

![db_view.png](public%2Fimg%2FREADME%2Fdb_view.png)

## Base de données

![MCD](public/img/README/mcd.png)

Le MCD si dessus représentent les différentes tables de la base de données.

### Tables et évolutions

#### Role

La table Role permet simplement d'affécter un role à un utilisateur.

Les roles ne sont pas un ENUM contenue dans la table Utilisateur, mais une table aparentière. Cette façon de faire permet une évolutivité de l'application web.
Il serait possible par la suite, par exemple, de lier la table role a la table Produits afin de limiter l'accès de certains produits à certain role, ou encore d'ajouter une clé étrangère role dans la table role pour créer un role Père.

#### Utilisateur

La table utilisateur permet simplement de contenir toutes les informations des utilisateurs.

Elle doit obligatoirement posséder un rôle. Les informations d'adresse ne sont actuellement pas utilisé dans l'application web, mais on pourrait ajouter une adresse automatiquement, par exemple avec une synchronisation d'un Active Directory.
Elle pourrait en suite automatiser l'adresse de destination d'une commande.

#### Produits

La table Produits est une base aux différents produits utilisés, elle contient seulement les informations communes à tous les produits.

Pour l'instant seulement la table Médicaments et Matériels ont été mis en place, mais cette fléxibilité permet d'ajouter d'autres catégories de produits plus facilement, en limitant les effets de bords sur les autres catégories de produits.

##### Médicaments

Tous les médicaments présents dans cette table ont été ajouté depuis la [Base de données publique des médicaments](https://base-donnees-publique.medicaments.gouv.fr/telechargement.php).

##### Matériels

La table Matériels est vide, car les informations nécessaires sont déja présents dans la table [Produits](#produits).

#### Panier

La table Panier, comme son nom l'indique, contient les différents produits ajoutés par les utilisateurs avec une valeur quantité pour chaque produit ajoutés.

#### Commande

La table Commande contient toutes les informations des commandes.

La valeur booléenne `mouvement_com`, correspond au mouvement de la commande, `false` correspond à une commande en direction des stocks, `true` à une sortie de stock en direction d'un laboratoire.

Les produits contenus dans une autre table nommée Ligne_commande

##### Ligne commande

Les données contenues dans la table ligne_commande sont similaires à la table [Panier](#panier). Elle associe un produit à une commande, en ajoutant une quantité aux produits.

## Le projet

### Sécurité

La sécurité est une partie extremement important dans n'importe quelles applications, mais encore plus dans le secteur médical.

#### BCrypt

Pour encrypter les mots de passe dans la base de données, j'ai choisi d'utiliser l'algorithme de BCrypt. BCrypt permet d'encrypter un mot de passe dans une chaine de caractère unique et indéchiffrable.
Unique, car même avec le même mot de passe, la clé sera différente.

En PHP, on utilise une methode nommé `password_hash()` :

```php
/**
     * Crypt le mot de passe mis en paramètre puis retourne son hash
     *
     * @param string $mot_de_passe
     * @return string
     */
    public function crypter_mot_de_passe(string $mot_de_passe): string
    {
        return password_hash($mot_de_passe, PASSWORD_BCRYPT, ["cost" => 13]);
    }
```

La seul manière de vérifier si un mot de passe est correct est de le comparer avec la version cryptée. En php, on utilise la méthode `password_verify()` :

```php
/**
     * Vérifie si le mot de passe mis en paramètre est le bon mot de passe, retourne true si c'est le cas, false sinon
     *
     * @param string $email
     * @param string $mot_de_passe
     * @return bool
     */
    public function verifier_mot_de_passe(
        string $email,
        string $mot_de_passe
    ): bool {
        require_once ROOT . "app/models/Utilisateur.php";
        $utilisateur = new Utilisateur();

        $mot_de_passe_importe = $utilisateur->selectionner_mot_de_passe($email);

        return password_verify($mot_de_passe, $mot_de_passe_importe);
    }
```

L'algorithme permet donc de protéger les utilisateurs en cas de fuite de la base de données ou du code source.

#### JWT (JSON Web Token)

JSON Web Token permet d'inscrire un token JSON sur la session de l'utilisateur, dans le stockage local, ou mieux, dans le cookie du navigateur.

Le token JWT est composé de 3 parties, le **header** (en tête), le **payload** et la **signature**.

##### Header

Le header contient les informations du token permettant de l'identifier en tant que token JWT.

```json
{
  "alg": "HS256",
  "typ": "JWT"
}
```

##### Payload

Le payload permet de contenir toutes les informations que l'on souhaite enregistrer sur le navigateur de l'utilisateur.
Dans notre cas, nous allons enregistrer son **id**, son **email**, son **role**, sa date d'emission et sa date d'expiration.

```json
{
  "user_id": "9",
  "user_email": "utilisateur@gmail.com",
  "user_role": "utilisateur",
  "iat": 1710779138,
  "exp": 1710793538
}
```

##### Signature

La partie la plus importante du JWT est la signature. Elle permet d'assurer l'authenticité du token via une clé privé qui ne doit absolument pas être diffusée.

La signature est un hash généré via un algorithme de hashage choisie préalablement. Pour créer ce hash nous allons concaténé le header et le payload puis la hasher avec la clé secrète que nous aurons au préalable encodé en [base 64](https://fr.wikipedia.org/wiki/Base64).

Dans notre cas, l'alogithme de hashage utilisé est le [SHA256](https://docs.devolutions.net/fr/kb/general-knowledge-base/what-is-sha-256/) :

```php
// Encodage en base 64 des éléments de la signature
$base_64_header = base64_encode(json_encode(JWT_HEADER));
$base_64_payload = base64_encode(json_encode($payload));
$secret = base64_encode(JWT_SECRET);
        
//generation de la signature
$signature = hash_hmac(
    "sha256",
    $base_64_header . "." . $base_64_payload, $secret
    true,
);
```

Une fois le tout généré, nous allons concaténer le header, le payload et la signature en les séparant par un point ce qui donnera :
```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```

#### Injection SQL

Pour éviter le risque d'injection, PDO a introduit les [Requète préparé](https://www.php.net/manual/en/security.database.sql-injection.php#security.database.avoiding) via la fonction `prepare()`.

```php
public function get_one()
    {
        $sql = "GET * FROM :table WHERE :id_table = :id";
        // préparation de la requète
        $query = $this->pdo->prepare($sql);
        $query->execute(
            ["table" => $this->table],
            ["id_table" => "id_" . $this->table[0 - 2]],
            ["id" => $this->id],
        );
    }
```

### Page de connexion

La page de connexion présente un formulaire ou rentrer son email et son mot de passe :

![Page de connexion](public%2Fimg%2FREADME%2Flogin_card.png)

Lors de la soumission du formulaire, le programme PHP va vérifier plusieurs choses :

- En premier temps, il va simplement vérifier si l'utilisateur existe.
- En suite, il va vérifier si le compte n'est pas bloqué (valeurs booleen *compte_desactive_uti* dans la table **Utilisateur**).
- Pour finir, il va vérifier si le mot de passe entré est valide avec [BCrypt](#bcrypt).

Si toutes ses conditions sont valides, le programme vérifiera si le mot de passe doit être modifié (ce qui arrive lors de la première connexion ou si un administrateur a réinitialisé le mot de passe).

#### Nouveau mot de passe

Si un nouveau mot de passe doit être mis en place, l'utilisateur sera redirigé sur le formulaire suivant :

![nouveau_mot_de_passe.png](public%2Fimg%2FREADME%2Fnouveau_mot_de_passe.png)

Pour valider le changement de mot de passe, plusieurs conditions doivent être remplies :

- Minimum 8 caractères
- Minimum 1 majuscule 
- Minimum 1 minuscule
- Minimum 1 caractère spécial
- Minimum 1 chiffre

Si le code JS présent dans la page n'a pas été modifié, l'utilisateur devrait être prévenu si l'une de ces conditions n'est pas respécté (Le JavaScript permet seulement de prévenir l'utilisateur, si la requète est quand meme envoyé, le code php revérifiera et refusera la modification du mot de passe).

### Espace Utilisateur

![dashboard_utilisateur_gestionnaire.png](public%2Fimg%2FREADME%2Fdashboard_utilisateur_gestionnaire.png)

L'espace utilisateur du site permet aux laboratoires d'éfféctuer des commandes qui devront être, par la suite, validé.

#### Choix des produits

L'espace de commandes de médicaments et de matériels fonctionnent exactement de la même manière, la seule différence est la façon dont sont affichés les produits.

Cette page est composée de 3 éléments :
- La liste des produits
- La barre de recherche
- Le choix de page

##### Liste des produits

La liste des produits est affiché par des composants :

![product_card.png](public%2Fimg%2FREADME%2Fproduct_card.png)

En ajoutant un produit au panier, l'application va ajouter l'ajouter à la table [panier](#panier) via la requête suivante :

```sql
INSERT INTO panier (id_uti, id_pro, qte) 
VALUES (:id_utilisateur, :id_produit, :quantite);
```

##### Barre de recherche

Lors de la soumission d'une recherche, la requête éxécuté ajoutera une variable `LIKE` :

```sql
SELECT produits.id_pro AS id, libelle_pro AS libelle, description_pro AS description, qte_stock_pro AS quantite_stock, forme_med AS forme, cis_med AS cis 
FROM medicaments 
INNER JOIN produits on medicaments.id_pro = produits.id_pro 
WHERE produits.libelle_pro 
LIKE :recherche                                                                                                                                                                                                                                        
LIMIT :offset , 25;
```

##### Choix de page

Pour éviter de faire planter la page (la base de données des médicaments contient 15767 lignes), la liste des produits est limité à 25 par page.

Pour choisir une page, une barre disponible en bas de page est disponible :

![page_select.png](public%2Fimg%2FREADME%2Fpage_select.png)

