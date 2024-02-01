// This is just an example,
// so you can safely delete all default props below

export default {
  admin: {
    generic: {
      search_the_application: 'Rechercher l\'application',
      search_button_label: 'Rechercher',
      notification_tooltip: 'Gérer vos notifications',
      contrast_tooltip: 'Changer le mode de thème',
      language_tooltip: 'Changer la langue',
      english_language: 'Anglais',
      french_language: 'Français',
      romanian_language: 'Roumain',
      welcome_message: 'Bienvenue, {username}',
      welcome_tooltip: 'Cliquez ici pour les paramètres',
      profile_label: 'Profil',
      notifications_label: 'Notifications',
      theme_mode_label: 'Mode de thème',
      logout_label: 'Déconnexion',
      table_no_data_label: 'Pas d\'enregistrements disponibles',
      default_title: 'Titre par défaut',
      default_page_description: `
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
        Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
        Qui consequatur quidem itaque et ullam, non velit unde quo
        inventore adipisci tempora, voluptas sunt dolore vitae iure,
        quos eligendi. Corporis id adipisci aliquam cum officia impedit
        repudiandae, numquam, dicta earum, cupiditate consequuntur?
      `,
      create_record_label: 'Ajouter un nouvel enregistrement',
      create_record_tooltip: 'Cliquez ici pour ajouter un nouvel enregistrement',
      resource_settings_tooltip: 'Cliquez ici pour configurer le tableau',
      quick_show_record_label: 'Afficher rapidement l\'enregistrement',
      quick_show_record_tooltip: 'Cliquez ici pour afficher rapidement l\'enregistrement',
      quick_edit_record_label: 'Édition rapide de l\'enregistrement',
      quick_edit_record_tooltip: 'Cliquez ici pour éditer rapidement l\'enregistrement',
      delete_record_label: 'Supprimer l\'enregistrement',
      delete_record_tooltip: 'Cliquez ici pour supprimer l\'enregistrement',
      advanced_filters_record_label: 'Filtres avancés',
      advanced_filters_record_tooltip: 'Cliquez ici pour filtrer les enregistrements',
      default_label: 'Boîte de dialogue générique',
      default_tooltip: 'Cliquez ici pour voir une boîte de dialogue générique',
      close_label: 'Fermer',
      cancel_label: 'Annuler',
      save_label: 'Enregistrer',
      quick_edit_label: 'Édition rapide',
      edit_label: 'Modifier',
      delete_label: 'Supprimer',
      apply_filters_label: 'Appliquer les filtres',
      ok_label: 'OK',
      options_label: 'Plus d\'options',
      options_label_tooltip: 'Cliquez ici pour plus d\'options (filtre, téléchargement, téléversement et plus encore)',
      configure_resource: 'Configuration des ressources',
      configure_resource_tooltip: 'Cliquez ici pour configurer la ressource',
      download_record_label: 'Télécharger les enregistrements',
      upload_record_label: 'Téléverser les enregistrements',
      actions_label: 'Actions',
      actions_label_tooltip: 'Cliquez ici pour les actions (afficher, éditer, supprimer et plus)',
      content_stats: 'Statistiques du contenu',
      stats_record_label: 'Statistiques',
      go_to_show: 'Aller à la page de détails',
      go_to_edit: 'Aller à la page d\'édition',
      delete_confirmation_message: 'Êtes-vous sûr de vouloir supprimer cet enregistrement ? Les enregistrements supprimés peuvent être restaurés depuis Plus d\'options > Restaurer les enregistrements !',
      restore_record_label: 'Restaurer les enregistrements',
      restore_confirmation_message: 'Êtes-vous sûr de vouloir restaurer ces enregistrements ?',
      no_records_to_restore: 'Il n\'y a aucun enregistrement disponible à restaurer!',
      no_records_available: 'Aucun enregistrement disponible à afficher!',
      no_data_model: `
        Le modèle {nonExistingModel} n'existe pas.
        Veuillez configurer la ressource.
        Si le problème persiste, vous pouvez contacter l'administrateur.
      `,
      input: {
        search_the_resource: 'Rechercher la ressource',
      },
      update_profile_label: 'Mettre à jour le profil',
      update_profile_label_tooltip: 'Cliquez ici pour mettre à jour votre profil',
      deactivate_account: 'Désactiver le compte',
      deactivate_account_tooltip: 'Cliquez ici pour désactiver votre compte',
    },
    home: {
      title: 'Dashboard',
      page_description: `
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
        Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
        Qui consequatur quidem itaque et ullam, non velit unde quo
        inventore adipisci tempora, voluptas sunt dolore vitae iure,
        quos eligendi. Corporis id adipisci aliquam cum officia impedit
        repudiandae, numquam, dicta earum, cupiditate consequuntur?
      `,
      statistic_contact_messages: 'Messages de contact',
      statistic_newsletter_campaigns: 'Campagnes de newsletter',
      statistic_newsletter_subscribers: 'Abonnés à la newsletter',
      statistic_reviews: 'Avis',
      statistic_articles: 'Vues d\'articles',
      statistic_storage: 'Stockage',
      statistic_appreciations: 'J\'aime — Je n\'aime pas — Note',
      statistic_comments: 'Commentaires',
    },
    management: {
      title: 'Gestion',
      contents: {
        title: 'Contenu',
        show_title: 'Montrer le contenu',
        create_title: 'Créer du contenu',
        edit_title: 'Modifier le contenu',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des contenus.
          Il joue un rôle crucial dans la configuration des contenus de l'application (pages et articles de blog).
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration d'enregistrements, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
        data_model: {},
      },
      tags: {
        title: 'Étiquettes',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des balises de contenu.
          Il joue un rôle crucial dans la configuration des balises de contenu de l'application.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration d'enregistrements, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      media: {
        title: 'Médias',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des médias de contenu.
          Il joue un rôle crucial dans la configuration des supports de contenu de l'application.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration d'enregistrements, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      comments: {
        title: 'Commentaires',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des commentaires de blog.
          Il joue un rôle crucial dans la configuration des commentaires du blog de l'application.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration d'enregistrements, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      appreciations: {
        title: 'Appréciations',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des appréciations des blogs.
          Il joue un rôle crucial dans la configuration des appréciations du blog de l'application (j'aime, je n'aime pas et les avis).
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration d'enregistrements, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      }
    },
    communication: {
      title: 'Communication',
      contact: {
        title: 'Contact',
        page_description: `
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
          Qui consequatur quidem itaque et ullam, non velit unde quo
          inventore adipisci tempora, voluptas sunt dolore vitae iure,
          quos eligendi. Corporis id adipisci aliquam cum officia impedit
          repudiandae, numquam, dicta earum, cupiditate consequuntur?
        `,
      },
      newsletter: {
        title: 'Bulletin d\'information',
        page_description: `
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
          Qui consequatur quidem itaque et ullam, non velit unde quo
          inventore adipisci tempora, voluptas sunt dolore vitae iure,
          quos eligendi. Corporis id adipisci aliquam cum officia impedit
          repudiandae, numquam, dicta earum, cupiditate consequuntur?
        `,
      },
      review: {
        title: 'Critique',
        page_description: `
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
          Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
          Qui consequatur quidem itaque et ullam, non velit unde quo
          inventore adipisci tempora, voluptas sunt dolore vitae iure,
          quos eligendi. Corporis id adipisci aliquam cum officia impedit
          repudiandae, numquam, dicta earum, cupiditate consequuntur?
        `,
      }
    },
    documentation: {
      title: 'Documentation',
      page_description: `
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
        Iste rem est voluptatem obcaecati maiores, sit quibusdam ad.
        Qui consequatur quidem itaque et ullam, non velit unde quo
        inventore adipisci tempora, voluptas sunt dolore vitae iure,
        quos eligendi. Corporis id adipisci aliquam cum officia impedit
        repudiandae, numquam, dicta earum, cupiditate consequuntur?
      `,
    },
    settings: {
      title: 'Paramètres',
      users: {
        title: 'Utilisateurs',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des utilisateurs.
          Il joue un rôle crucial dans l'enregistrement de nouveaux utilisateurs, l'attribution d'autorisations aux utilisateurs et bien d'autres encore.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
        profile: {
          title: 'Profil utilisateur',
          page_description: `
            Cette ressource alimente une page d'administration dédiée à la gestion du profil utilisateur.
            Il joue un rôle crucial dans la gestion du profil utilisateur (nom, coordonnées, pseudo et bien d'autres).
          `,
        },
      },
      roles: {
        title: 'Rôles et permissions',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des rôles et des autorisations des utilisateurs.
          Il joue un rôle crucial dans la configuration des rôles et des autorisations des utilisateurs pour accéder à différentes ressources.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      general: {
        title: 'Paramètres généraux',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des paramètres généraux.
          Il joue un rôle crucial dans la configuration du titre et du slogan du site, la définition de la langue par défaut,
          définissez le fuseau horaire, le crédit de pied de page, le nombre d'articles de blog, le format de date et bien d'autres.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      accepted_domains: {
        title: 'Domaines acceptés',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des domaines acceptés.
          Il joue un rôle crucial en garantissant la validité des adresses e-mail avant
          les utilisateurs s'abonnent, commentent ou soumettent des messages via le formulaire de contact.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      notifications: {
        title: 'Notifications et modèles',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des notifications et des modèles.
          Il joue un rôle crucial dans la configuration des notifications (email et/ou SMS) pour divers événements.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
      configuration: {
        resources: {
          title: 'Ressources de configuration',
          show_title: 'Afficher les ressources de configuration',
          create_title: 'Créer des ressources de configuration',
          edit_title: 'Modifier les ressources de configuration',
          page_description: `
            Cette ressource alimente une page d'administration dédiée à la gestion de la configuration des ressources.
            Il joue un rôle crucial dans la configuration des colonnes, des entrées pour la création, le filtrage et
            mise à jour. Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
            suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
            et des informations statistiques.
          `,
        },
      },
      resource: {
        title: 'Ressources',
        page_description: `
          Cette ressource alimente une page d'administration dédiée à la gestion des menus et des API.
          Il joue un rôle crucial dans la configuration du menu de l'application et des API de repos.
          Le composant présente des fonctionnalités essentielles telles que la création, l'édition,
          suppression et restauration des enregistrements de domaine, ainsi que des options de filtrage avancées
          et des informations statistiques.
        `,
      },
    }
  }
};
