<?php

/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wordpressFlorian');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'mHG1uYjXkzjy+bFEQ%qjW->GX$:.k~>&b 2G[Sa|wg&Rwl7}lk8H7;I#hli%hPz<');
define('SECURE_AUTH_KEY',  '>c@+ym-]t-_{[ytOw8)zX5FZMuqqFSHhulbZdDBe.T?Dn@pj9.eL{ovy2lu.1mEz');
define('LOGGED_IN_KEY',    '(pYm*,:RcZXk*W;q+SLd!~MbuQ9(g-iN^B)RI0}AtFr&UxUv]D|dOMw7_qzAbj.2');
define('NONCE_KEY',        'qQ9W+PRjTp>24__-+t4/H2[F5z|)%[<Hkb[ 6~h#S$t,q^::#E_E=_?MM!Yml:3&');
define('AUTH_SALT',        '=t`Kg^T*cQT+:MF9;[}7EJ$@vhJ@V[6I@#) uP7EK>+Ra8]PGDy5{&|HhRyS^Id$');
define('SECURE_AUTH_SALT', 'F0IP?dHa=JBRZ`,x`/jLWJ$nYhnBY}pBp|##mV-|ymIOuMcREmI5hkP6:Z$3/])S');
define('LOGGED_IN_SALT',   '.tanE=Ga)UBu1bp(%O E7mC% &8z;+&&U9t)VwjP)8kmkwY2lJO:RB2oHvOM6)vA');
define('NONCE_SALT',       'tFCWPME!r$I3m^BCJ6?wR{0:vPzs4xb-U;?Jm:0=]eoc@bczN;vS/4W)bU3nGGh*');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if (!defined('ABSPATH'))
  define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');

ini_set('display_errors', true);
error_reporting(E_ALL);
