// English translations

export default {
  admin: {
    generic: {
      application_name: 'Generic boilerplate',
      designed_by: 'Designed by',
      all_rights_reserved: 'Toate drepturile rezervate',
      page_title: 'Titlu pagina admin',
      welcome: 'Bun venit {authUserName}',
      page_description: `
        Aplicatia de panou de bord {applicationName} este o platforma
        bogata in functionalitati si personalizabila care ofera utilizatorilor
        o gama extinsa de capabilitati. Construita cu combinatia Vue.js si TypeScript,
        ofera o interfata vizuala atractiva si intuitiva. Utilizatorii pot modifica
        cu usurinta profilurile lor, inclusiv informatiile personale si preferintele,
        avand totodata control asupra rolurilor si permisiunilor utilizatorilor.
        Aceasta aplicatie ofera utilizatorilor posibilitatea de a crea
        pagini si articole dinamice si captivante, facilitand administrarea facila
        a continutului. In plus, panoul de bord faciliteaza incarcarea convenabila
        a fisierelor media, asigurand integrarea fara probleme a elementelor multimedia.
        Cu instrumentele sale puternice si flexibilitate, aceasta aplicatie servește
        ca o solutie cuprinzatoare pentru gestionarea eficienta si personalizarea eficienta.
      `,
      documentation: {
        first_part: `
          Pentru o intelegere mai cuprinzatoare si pentru informatii detaliate despre
          {applicationName}, recomand consultarea
        `,
        second_part: 'documentatiei',
        third_part:
          'insotitoare, care ofera informatii in profunzime si vizualizari.',
      },
      view_resource: 'Vizualizeaza',
      table: {
        id: 'Id',
        actions: 'Actiuni',
        no_data_label: 'Nu exista inregistrari',
        new_record_label: 'Inregistrare noua',
        default_column_name: 'Eticheta implicita',
      },
      notification_warning_title: 'Atentionare',
      notification_warning_message: 'Operatia nu a putut fi efectuata. Id-ul inregistrarii este invalid: {recordId}',
      view_image_label: 'Vezi imagine',
      ok_label: 'OK',
      cancel_label: 'Anuleaza',
      close_label: 'Inchide',
      save_label: 'Salveaza',
      update_label: 'Modifica',
      delete_label: 'Sterge',
      default_dialog_title: 'Titlu implicit',
      create_dialog_title: 'Creaza inregistrare noua',
      show_dialog_title: 'Afiseaza detalii inregistrare',
      edit_dialog_title: 'Modifica inregistrarea',
      delete_dialog_title: 'Sterge inregistrarea',
      delete_confirmation_message: 'Esti sigur ca vrei sa stergi aceasta inregistrare?',
      advanced_filter_dialog_title: 'Filtrare avansata',
      filter: 'Filtreaza tabelul',
      filter_advanced: 'Filtrare avansata',
      clear_filters: 'Sterge filtrele',
      apply_filters: 'Aplica filtrele',
      notification_info_title: 'Info',
      no_filters_applied: 'Nu exista filtre aplicate pe tabelul {resourceName}',
      no_filters_to_apply: 'Nu exista filtre care sa fie aplicate pe tabelul {resourceName}',
      filters_applied_remove: 'Toate filtrele au fost sterse cu success de pe tabelul {resourceName}',
      notification_success_title: 'Succes',
      filter_results_message: 'In prezent vezi rezultate pentru: ',
    },
    menu: {
      my_account: 'Profil utilizator',
      documentation: 'Documentatie',
      sign_out: 'Deconectare',
    },
    home: {
      title: 'Dashboard',
      description: `
        TEXT HERE
      `,
    },
    management: {
      title: 'Management',
      description: `
        TEXT HERE
      `,
      pages: {
        title: 'Pagini',
        description: `
          TEXT HERE.
        `,
        table: {
          field_1: 'Field 1',
          field_2: 'Field 2',
          field_3: 'Field 3',
        },
      },
      tags: {
        title: 'Etichete',
        description: `
          TEXT HERE.
        `,
      },
      articles: {
        title: 'Articole',
        description: `
          TEXT HERE.
        `,
      },
      media: {
        title: 'Media',
        description: `
          TEXT HERE.
        `,
      },
      comments: {
        title: 'Comentarii',
        description: `
          TEXT HERE.
        `,
      },
    },
    communication: {
      title: 'Comunicare',
      description: `
        TEXT HERE.
      `,
      contact: {
        title: 'Contacteaza-ma',
        description: `
          TEXT HERE.
        `,
        table: {
          full_name: 'Nume si prenume',
          email: 'Adresa email',
          subject: 'Subiect',
        },
      },
      newsletter: {
        title: 'Newsletter si Campanii',
        description: `
          TEXT HERE.
        `,
        table: {
          name: 'Nume campanie',
          valid_from: 'Valabil de la',
          valid_to: 'Valabil de la',
          is_active: 'Este activa?',
        },
      },
    },
    reports: {
      title: 'Rapoarte',
      description: `
        TEXT HERE.
      `,
    },
    documentation: {
      title: 'Documentatie',
      description: `
        TEXT HERE.
      `,
    },
    user_settings: {
      title: 'Setari utilizator',
      description: `
        TEXT HERE.
      `,
      user_profile: {
        title: 'Profil utilizator',
        description: `
          TEXT HERE.
        `,
      },
      users: {
        title: 'Toti utilizatorii',
        description: `
          TEXT HERE.
        `,
        table: {
          full_name: 'Nume si prenume',
          email: 'Adresa email',
          nickname: 'Nickname',
          created_at: 'Data aderarii',
        },
      },
      roles_and_permissions: {
        title: 'Roluri si permisiuni',
        description: `
          TEXT HERE.
        `,
        table: {
          name: 'Nume',
          slug: 'Eticheta'
        },
      },
    },
    application_settings: {
      title: 'Setari aplicatie',
      description: `
        TEXT HERE.
      `,
      general: {
        title: 'General',
        description: `
          TEXT HERE.
        `,
      },
      performance: {
        title: 'Performanta',
        description: `
          TEXT HERE
        `,
      },
      accepted_domains: {
        title: 'Domenii acceptate',
        description: `
          TEXT HERE
        `,
        table: {
          domain: 'Domeniu',
          type: 'Tip'
        },
      },
      notifications: {
        title: 'Notificari',
        description: `
          TEXT HERE.
        `,
      },
      emails: {
        title: 'Email-uri',
        description: `
          TEXT HERE.
        `,
      },
    },
  },
};
