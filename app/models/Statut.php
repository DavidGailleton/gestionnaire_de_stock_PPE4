<?php

namespace ppe4\models;

enum Statut: string
{
    case En_attente = "en_attente";
    case Refuse = "refuse";
    case En_cours_prep = "en_cours_de_preparation";
    case En_cours_livr = "en_cours_de_livraison";
    case Livre = "livre";
    case Facture = "facture";
}