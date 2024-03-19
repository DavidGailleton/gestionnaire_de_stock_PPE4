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


