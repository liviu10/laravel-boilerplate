<?php

return [
    'navbar' => [
        'home' => 'Home',
        'sections' => [
            'title' => 'Website Sections',
            'contact_page' => 'Contact messages',
        ],
        'profile' => 'My Account',
        'users' => 'Users',
        'roles' => 'Roles',
        'logout' => 'Logout',
        'view_website' => 'View website'
    ],
    'home' => [
        'page_title' => 'Dashboard',
        'logged_in_message' => 'You are now logged in to :appName\'s administration panel.',
        'app_short_description' => 'This is a laravel web application starter kit.',
        'app_description' => '<a href=":laravelUrl">:laravelUrlName</a> with <a href=":bootstrapUrl">:bootstrapUrlName</a> was used as the authentication system.',
        'account_section' => [
            'title' => 'My account',
            'description' => 'Modify your profile information (name, nickname, email address and password)'
        ],
        'users_section' => [
            'title' => 'Users & Roles Types',
            'description' => 'Modify the name and assign users to different role types (webmaster, administrator, accountant, sales, client)'
        ]
    ],
    'general' => [
        'id_column_label' => 'ID',
        'actions_column_label' => 'Actions',
        'clear_filter_label' => 'Clear filter',
        'apply_filter_label' => 'Apply filter',
        'save_new_record_label' => 'Save',
        'choose_an_option_label' => '--Please choose an option--',
        'filter_button_label' => 'Filter table',
        'is_active_column_label' => 'Is active?',
        'close_button_label' => 'Close',
        'update_button_label' => 'Update',
        'created_at_label' => 'Created at',
        'updated_at_label' => 'Updated at',
        'yes_label' => 'Yes',
        'no_label' => 'No',
        'privacy_policy_column_label' => 'Privacy policy',
        'error_message_fetch' => 'There was an error when fetching the records! Please try again and if the problem persist contact the administrator!',
        'success_message' => 'The record was successfully updated!',
        'success_message_reply' => 'You have successfully reply to this contact message!',
        'error_message_reply' => 'There was an error when sending this message! Please try again and if the problem persist contact the administrator!',
        'error_message_update' => 'There was an error when updating the record! Please try again and if the problem persist contact the administrator!',
        'error_message_delete' => 'There was an error when deleting the record! Please try again and if the problem persist contact the administrator!',
        'search_results_label' => 'Search results',
        'modal_show_details_title' => 'Record details',
        'modal_update_details_title' => 'Record update',
        'welcome_message' => 'Welcome, :userName',
        'view_more_button_label' => 'View more',
        'add_new_button_label' => 'New record'
    ],
    'contact' => [
        'page_title' => 'Contact me messages',
        'contact_details_column_label' => 'Contact message details',
        'message_column_label' => 'Message',
        'full_name_column_label' => 'Full name',
        'contact_subject_column_label' => 'Subject',
        'phone_number_column_label' => 'Phone number',
        'email_column_label' => 'Email',
        'reply_message_label' => 'Reply message',
        'reply_message_title' => 'Reply to message',
        'reply_button_label' => 'Reply'
    ],
    'profile' => [
        'page_title' => 'Profile',
        'contact_details' => 'Contact details',
        'full_name_label' => 'Full name',
        'first_name_label' => 'First name',
        'last_name_label' => 'Last name',
        'profile_picture_label' => 'Profile picture',
        'view_image_label' => 'View image',
        'email_details' => 'Email details',
        'nickname_label' => 'Nickname',
        'email_address_label' => 'Email address',
        'password_details' => 'Password details',
        'password_label' => 'Password',
        'password_confirmation_label' => 'Confirm password'
    ],
    'users' => [
        'page_title' => 'All users',
        'full_name_column_label' => 'Full name',
        'email_column_label' => 'Email',
        'email_and_nickname_column_label' => 'Email address & Nickname',
        'nickname_column_label' => 'Nickname',
        'role_column_label' => 'Role',
        'first_name_column_label' => 'First name',
        'last_name_column_label' => 'Last name',
        'nickname_column_label' => 'Nickname',
        'user_role_label' => 'user role',
        'email_verified_at_column_label' => 'Email verified at',
        'choose_user_role_type_label' => 'Choose the user role type'
    ],
    'user_roles' => [
        'page_title' => 'User roles',
        'name_and_description_column_label' => 'Name & Description',
        'user_role_name_column_label' => 'Name',
        'user_role_description_column_label' => 'Description'
    ],
    'settings' => [
        'page_title' => 'Settings'
    ],
];
