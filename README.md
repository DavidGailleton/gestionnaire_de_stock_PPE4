<style>
img{
display: flex;
width: 30em;
align-items: center;
}
*{
text-align: justify;
}
</style>

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

![xampp_download.png](public/img/README/xampp_download.png)

Une fois téléchargé, lancer l'executable.

Il est possible qu'une fenêtre vous prévienne que votre anti virus est actif. N'y prêtez pas attention et cliquez sur oui :

![xampp_antivirus_alert.png](public/img/README/xampp_antivirus_alert.png)

En suite, faite suivant plusieurs fois :

![xampp_installer_1.png](public/img/README/xampp_installer_1.png)

![xampp_installer_2.png](public/img/README/xampp_installer_2.png)

Vérifié bien que dans le champ ***Select a folder***, le chemin soit `C:\xampp`

![xampp_installer_3.png](public/img/README/xampp_installer_3.png)

![xampp_installer_4.png](public/img/README/xampp_installer_4.png)

![xampp_installer_5.png](public/img/README/xampp_installer_5.png)

Si le programme d'installation vous propose de redémarrer votre poste, redémarrez-le.

### Installation du projet

Une fois XAMPP installé, nous pouvons ajouter le projet en local.

Pour commencer, il faut télécharger le projet depuis [le dépot Github](https://github.com/DavidGailleton/gestionnaire_de_stock_PPE4) :

![github_download.png](public/img/README/github_download.png)

Une fois téléchargé, extraire le dossier précédemment téléchargé dans le dossier `C:\xampp\htdocs`.

**Attention, l'extracteur vous proposera surement de l'éxtraire dans le dossier `C:\xampp\htdocs\ppe4`. Bien penser à corriger** :

![project_extract_1.png](public/img/README/project_extract_1.png)

![project_extract_2.png](public/img/README/project_extract_2.png)

### Base de données MariaDB

Pour mettre la base de données en place, il faut en premier temps démarrer **Apache** et **MySQL** depuis XAMPP :

![xampp_start_mysql_apache.png](public/img/README/xampp_start_mysql_apache.png)

Il est maintenant possible d'accéder à PHP My Admin pour accéder aux bases de données depuis le navigateur web avec l'addresse [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

Pour créer la base de données, il faut en premier temps cliquer sur *Nouvelle base de données* (**1.**), puis donner un nom à la base de données, dans notre cas `ppe4` (**2.**), puis cliquer sur *Créer* (**3.**) :

![phpmyadmin_create_database.png](public/img/README/phpmyadmin_create_database.png)

Nous allons en suite importer la base de données du projet.

Cette base des données est disponible à la racine du projet. L'importation est simplifié par l'interface phpmyadmin :

![import_sql_1.png](public/img/README/import_sql_1.png)

![import_sql_2.png](public/img/README/import_sql_2.png)

![import_sql_3.png](public/img/README/import_sql_3.png)

Si tout s'est déroulé comme prévu, la base de données devrait se présenter comme ceci :

![db_view.png](public/img/README/db_view.png)

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

![Page de connexion](public/img/README/login_card.png)

Lors de la soumission du formulaire, le programme PHP va vérifier plusieurs choses :

- En premier temps, il va simplement vérifier si l'utilisateur existe.
- En suite, il va vérifier si le compte n'est pas bloqué (valeurs booleen *compte_desactive_uti* dans la table **Utilisateur**).
- Pour finir, il va vérifier si le mot de passe entré est valide avec [BCrypt](#bcrypt).

Si toutes ses conditions sont valides, le programme vérifiera si le mot de passe doit être modifié (ce qui arrive lors de la première connexion ou si un administrateur a réinitialisé le mot de passe).

#### Nouveau mot de passe

Si un nouveau mot de passe doit être mis en place, l'utilisateur sera redirigé sur le formulaire suivant :

![nouveau_mot_de_passe.png](public/img/README/nouveau_mot_de_passe.png)

Pour valider le changement de mot de passe, plusieurs conditions doivent être remplies :

- Minimum 8 caractères
- Minimum 1 majuscule 
- Minimum 1 minuscule
- Minimum 1 caractère spécial
- Minimum 1 chiffre

Si le code JS présent dans la page n'a pas été modifié, l'utilisateur devrait être prévenu si l'une de ces conditions n'est pas respécté (Le JavaScript permet seulement de prévenir l'utilisateur, si la requète est quand meme envoyé, le code php revérifiera et refusera la modification du mot de passe).

### Espace Utilisateur

![dashboard_utilisateur_gestionnaire.png](public/img/README/dashboard_utilisateur_gestionnaire.png)

L'espace utilisateur du site permet aux laboratoires d'éfféctuer des commandes qui devront être, par la suite, validé.

#### Choix des produits

L'espace de commandes de médicaments et de matériels fonctionnent exactement de la même manière, la seule différence est la façon dont sont affichés les produits.

Cette page est composée de 3 éléments :
- La liste des produits
- La barre de recherche
- Le choix de page

##### Liste des produits

La liste des produits est affiché par des composants :

![product_card.png](public/img/README/product_card.png)

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

![page_select.png](public/img/README/page_select.png)

#### Panier

La page du panier présente la liste des produits ajoutés, ainsi qu'un bouton permettant de confirmer la commande :

![liste_produit_panier.png](public/img/README/liste_produit_panier.png)

Il est possible de supprimer un produit de panier, ainsi que de modifier sa quantité.

Lors du changement de quantité un script JS est éxécuté permettant d'éfféctuer une requete à chaque changement :

```js
document.getElementById("formulaire_'.$i.'").addEventListener("input", function(){
        let form = document.getElementById("formulaire_'.$i.'");
        let formData = new FormData(form);
        fetch("index.php?action=modifier_qte_produit_panier", {
            method: "POST",
            body: formData
        })
    });
```

```sql
UPDATE panier 
SET qte = :qte 
WHERE id_uti = :id_utilisateur AND id_pro = :id_produit;
```

A la confirmation de la commande, L'application va en premier temps créer une commande via la requète suivante :

```sql
INSERT INTO commande (commande.date_com, commande.mouvement_com, commande.id_uti_Utilisateur, commande.statut_com) 
VALUES (NOW(), :mouvement, :id_utilisateur, :statut);
```

Puis dans un second temps, créer pour chaque élément du panier une ligne dans la table ligne_commande :

```php
foreach ($produits as $produit) {
            $ligne_commande->inserer_ligne_commande(
                $id_commande,
                $produit["id"],
                $produit["qte"],
            );
        }
```

```sql
INSERT INTO ligne_commande (id_com, id_pro, qte) 
VALUES (:id_commande, :id_produit, :qte);
```

Enfin, pour finir, vider le panier de l'utilisateur :

```sql
DELETE 
FROM panier 
WHERE id_uti = :id_utilisateur
```

#### Vos commandes

Il est possible d'accéder aux commandes faites au préalable via le menu déroulant disponible en cliquant sur l'icône profile :

![profile_icone_header.png](public/img/README/profile_icone_header.png)

Cette page présente l'ensemble des commandes faites par l'utilisateur :

![vos_commande.png](public/img/README/vos_commande.png)

En sélectionnant une, vous accédez aux informations de la commande : 

![lignes_commandes_vos_commande.png](public/img/README/lignes_commandes_vos_commande.png)

### Espace Validateur

L'espace validateur permet de valider les commandes faites par les utilisateurs.

On accède aux commandes en attente de validation en cliquant sur l'un des raccourcis proposés :

![vue_validateur.png](public/img/README/vue_validateur.png)

Vous pouvez en suite sélectionner une commande à valider :

![commandes_a_valider.png](public/img/README/commandes_a_valider.png)

Sur cette commande, vous pouvez seulement valider ou refuser la commande :

![commande_vue_validateur.png](public/img/README/commande_vue_validateur.png)

#### Valider commande

Si la commande est validé, 2 requètes sont éxécuté.

La première permet de modifier le statut de la commande :

```sql
UPDATE commande 
SET commande.date_val_com = NOW(), commande.id_uti_validateur = :id_validateur, commande.statut_com = :statut 
WHERE commande.id_com = :id_commande;
```

La seconde permet de réduire le nombre de produits disponible en stock :

```sql
UPDATE produits
SET qte_stock_pro = produits.qte_stock_pro - :quantite
WHERE id_pro = :id;
```

#### refuser commande

Si la commande est refusé, seulement le statut sera modifié :

```sql
UPDATE commande 
SET commande.date_val_com = NOW(), commande.id_uti_validateur = :id_validateur, commande.statut_com = :statut 
WHERE commande.id_com = :id_commande;
```

### Espace Administrateur

![dashboard_admin.png](public/img/README/dashboard_admin.png)

Le compte administrateur permet seulement de gérer les compte utilisateur.

Il est possible de :
- Créer un compte
- Modifier un compte
- Désactiver un compte
- Supprimer un compte
- Modifier le mot de passe

#### Création d'un utilisateur

![creation_utilisateur.png](public/img/README/creation_utilisateur.png)

L'espace de création de compte présente plusieurs champs.

##### Email

L'email de l'utilisateur est l'identifiant de connexion de ce dernier. L'email doit être unique parmi tous les comptes non archivés.

##### Prenom et Nom de famille

Le prénom et le non de famille est seulement présent à titre indicatif.

##### Mot de passe temporaire

Le mot de passe mis en place par l'administrateur devra obligatoirement être modifié à la première connexion de l'utilisateur.

##### Role

Les role affiché dans la liste sont importé depuis [la table Role](#role) de la base de donnée.

##### Soumission du formulaire

Lors de la soumission du formulaire la fonction suivante sera exécuté :

```php
public function creer_utilisateur(
        string $mot_de_passe,
        string $email,
        string $prenom,
        string $nom,
        string $libelle_role
    ): bool {
        require_once ROOT . "app/models/Role.php";
        $role_model = new Role();
        $role = $role_model->selectionner_role_par_libelle($libelle_role);
        $id_role = $role_model->selectionner_id_role($role);

        require_once ROOT . "app/controllers/Bcrypt.php";
        $bcrypt = new Bcrypt();
        $mot_de_passe_crypte = $bcrypt->crypter_mot_de_passe($mot_de_passe);

        require_once ROOT . "app/models/Utilisateur.php";
        $utilisateur_model = new Utilisateur();
        $result = $utilisateur_model->creer_utilisateur(
            $mot_de_passe_crypte,
            $email,
            $prenom,
            $nom,
            $id_role
        );

        if (!$result){
            echo '<script>alert("Une erreur s\'est produit")</script>';
        }
        return $result;
    }
```

```sql
# Requete exécuté avec la fonction creer_utilisateur()
INSERT INTO utilisateur (email_uti, password_uti, nom_uti, prenom_uti, id_rol) 
VALUES (:email, :mot_de_passe, :nom, :prenom, :id_role);
```

#### Gestion des utilisateurs

Sur la page de gestion des utilisateurs, en séléctionnant un compte, vous arriverez sur cette page :

![modification_utilisateur.png](public/img/README/modification_utilisateur.png)

##### Modification

Pour modifier les informations du compte, il faut simplement modifier les différents champs que l'on souhaite modifier pour cliquer sur le bouton `Modifier l'utilisateur`.

Lors de la soumission du formulaire, la requete SQL suivante est exécuté :

```sql
UPDATE utilisateur 
SET email_uti = :email, prenom_uti = :prenom, nom_uti = :nom, id_rol = :id_role 
WHERE id_uti = :id_utilisateur 
AND est_archive_uti = false;
```

##### Reinitialiser mot de passe

En cliquant sur le bouton *Reinitialiser mot de passe*, une pop up va s'afficher vous demandant d'entrer un mot de passe temporaire :

![reset_password.png](public/img/README/reset_password.png)

Une fois soumis, le mot de passe sera encrypté, puis modifier sur [la table Utilisateur](#utilisateur). 
A la prochaine connexion, l'utilisateur sera forcé à modifier le mot de passe temporaire mis en place.

##### Désactiver l'utilisateur

Il est également possible de désactiver l'utilisateur. 

La désactivation va simplement changer la valeur booléenne `compte_desactivé_uti` de la table Utilisateur, ce qui l'empêchera de se connecter.

##### Suppression de l'utilisateur

En cliquant sur le bouton *Supprimer utilisateur*, un pop up demandera une seconde confirmation de suppression afin d'éviter toutes erreurs :

![confirmation_suppression.png](public/img/README/confirmation_suppression.png)

> Etant donnée que la clé primaire de l'utilisateur peut être liée à d'autres tables, ce dernier n'est pas réellement supprimé de la table utilisateur, mais archivé via la valeur booléenne `est_archive_uti`. L'intégralité de requête `SELECT` faite vers la table **utilisateur** filtre les utilisateurs archivés.

### Gestionnaire de stock

La vue du gestionnaire de stockage est exactement la même que l'utilisateur.

La différence vient du fait que lors de la [confirmation d'une commande](#panier), le paramètre de la fonction appelé sont différentes :

```php
public function confirmer_la_commande_gestionnaire(
        array $produits,
        int $id_utilisateur,
    ): void {
        require_once ROOT . "app/models/Commande.php";
        require_once ROOT . "app/models/Ligne_commande.php";
        require_once ROOT . "app/models/Produit.php";
        $commande = new Commande();
        $produit_model = new Produit();
        $id_commande = $commande->inserer_commande(
            $id_utilisateur,
            // false pour une commande entrante
            false,
            // statut de la commande
            "en_cours_de_preparation",
        );

        $ligne_commande = new \ppe4\models\Ligne_commande();
        foreach ($produits as $produit) {
            $ligne_commande->inserer_ligne_commande(
                $id_commande,
                $produit["id"],
                $produit["qte"],
            );
            $produit_model->augmenter_quantite($produit["id"], $produit["qte"]);
        }

        require_once ROOT . "app/models/Panier.php";
        $panier = new \ppe4\models\Panier();
        $panier->vider_le_panier($id_utilisateur);
    }
```

Dans ce cas-là, la commande n'a pas besoin d'être validé par un validateur.

## Conclusion