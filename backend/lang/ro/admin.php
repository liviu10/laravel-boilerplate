<?php

return [
    'navbar' => [
        'home' => 'Acasa',
        'sections' => [
            'title' => 'Sectiuni Website',
            'contact_page' => 'Mesaje contact',
        ],
        'profile' => 'Contul meu',
        'users' => 'Utilizatori',
        'roles' => 'Roluri',
        'logout' => 'Iesire',
        'view_website' => 'Vezi website'
    ],
    'home' => [
        'page_title' => 'Panou de bord',
        'logged_in_message' => 'Acum esti autentificat in panoul de administrare al :appName\'s.',
        'app_short_description' => 'Acesta este un kit de start pentru aplicatii web laravel.',
        'app_description' => '<a href=":laravelUrl">:laravelUrlName</a> cu <a href=":bootstrapUrl">:bootstrapUrlName</a> au fost folosite pentru sistemul de autentificare.',
        'account_section' => [
            'title' => 'Contul meu',
            'description' => 'Modifica informatiile profilului (nume, nickname, adresa de email si parola)'
        ],
        'users_section' => [
            'title' => 'Utilizatori & Tipuri roluri',
            'description' => 'Modificati numele si atribuiti utilizatorilor diferitelor tipuri de roluri (webmaster, administrator, contabil, vanzari, client)'
        ]
    ],
    'general' => [
        'id_column_label' => 'ID',
        'actions_column_label' => 'Actiuni',
        'clear_filter_label' => 'Sterge filtrul',
        'apply_filter_label' => 'Aplica filtrul',
        'save_new_record_label' => 'Salvare',
        'choose_an_option_label' => '--Te rog alege o optiune--',
        'filter_button_label' => 'Filtreaza tabelul',
        'is_active_column_label' => 'Este activ?',
        'close_button_label' => 'Inchide',
        'update_button_label' => 'Modifica',
        'created_at_label' => 'Creat la',
        'updated_at_label' => 'Modificat la',
        'yes_label' => 'Da',
        'no_label' => 'Nu',
        'privacy_policy_column_label' => 'Politica de confidentialitate',
        'error_message_fetch' => 'A aparut o eroare la preluarea inregistrarilor! Va rugam sa incercati din nou si daca problema persista contactati administratorul!',
        'success_message' => 'Inregistrarea a fost actualizata cu succes!',
        'error_message_update' => 'A aparut o eroare la actualizarea inregistrarii! Va rugam sa incercati din nou si daca problema persista contactati administratorul!',
        'error_message_delete' => 'A aparut o eroare la stergerea inregistrarii! Va rugam sa incercati din nou si daca problema persista contactati administratorul!',
        'search_results_label' => 'Rezultatele cautarii',
        'modal_show_details_title' => 'Detalii inregistrare',
        'modal_update_details_title' => 'Modificare inregistrare',
        'welcome_message' => 'Bun venit, :userName',
        'view_more_button_label' => 'Vezi mai multe',
        'add_new_button_label' => 'Inregistrare noua'
    ],
    'contact' => [
        'page_title' => 'Mesaje contacteaza-ma',
        'contact_details_column_label' => 'Detalii mesaje contacteaza-ma',
        'message_column_label' => 'Mesaj',
        'full_name_column_label' => 'Nume si prenume',
        'contact_subject_column_label' => 'Subiect',
        'phone_number_column_label' => 'Numar de telefon',
        'email_column_label' => 'Email',
        'reply_message_label' => 'Raspunde mesaj',
        'reply_message_title' => 'Raspunde la mesaj',
        'reply_button_label' => 'Raspunde'
    ],
    'profile' => [
        'page_title' => 'Profil',
        'contact_details' => 'Detalii contact',
        'full_name_label' => 'Nume si prenume',
        'first_name_label' => 'Nume',
        'last_name_label' => 'Prenume',
        'profile_picture_label' => 'Poza de profil',
        'view_image_label' => 'Vezi imagine',
        'email_details' => 'Detalii email',
        'nickname_label' => 'Nickname',
        'email_address_label' => 'Adresa email',
        'password_details' => 'Detalii parola',
        'password_label' => 'Parola',
        'password_confirmation_label' => 'Confirmare parola'
    ],
    'users' => [
        'page_title' => 'Toti utilizatorii',
        'full_name_column_label' => 'Nume si prenume',
        'email_column_label' => 'Email',
        'email_and_nickname_column_label' => 'Adresa email & Nickname',
        'nickname_column_label' => 'Nickname',
        'role_column_label' => 'Rol',
        'first_name_column_label' => 'Nume',
        'last_name_column_label' => 'Prenume',
        'nickname_column_label' => 'Nickname',
        'user_role_label' => 'rol utilizator',
        'email_verified_at_column_label' => 'Email verificat la',
        'choose_user_role_type_label' => 'Alegeti tipul rolului utilizatorului'
    ],
    'user_roles' => [
        'page_title' => 'Roluri utilizatori',
        'name_and_description_column_label' => 'Nume & Descriere',
        'user_role_name_column_label' => 'Nume',
        'user_role_description_column_label' => 'Descriere'
    ],
    'settings' => [
        'page_title' => 'Setari'
    ],
];
