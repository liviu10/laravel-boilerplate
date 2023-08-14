// English translations

export default {
  admin: {
    generic: {
      welcome: 'Welcome {authUserName}',
      page_title: 'Admin page title',
      page_description: 'Replace this generic description',
      documentation: {
        first_part: `
          For a more comprehensive understanding and detailed insights into the
          {applicationName}, I recommend consulting the accompanying
        `,
        second_part: 'documentation',
        third_part: ', which provides in-depth information and visuals',
      },
      view_resource: 'View',
      table: {
        id: 'Id',
        is_active: 'Is active?',
        actions: 'Actions',
        no_data_label: 'No data available!',
        new_record_label: 'New record',
        default_column_name: 'Default label',
      },
      notification_warning_title: 'Warning',
      notification_warning_message: 'The operation could not be performed. Invalid record id: {recordId}',
      view_image_label: 'View image',
      ok_label: 'OK',
      cancel_label: 'Cancel',
      close_label: 'Close',
      save_label: 'Save',
      update_label: 'Update',
      delete_label: 'Delete',
      default_dialog_title: 'Default title',
      create_dialog_title: 'Create new record',
      show_dialog_title: 'Show record details',
      edit_dialog_title: 'Edit record',
      delete_dialog_title: 'Delete record',
      delete_confirmation_message: 'Are you sure you want delete this record?',
      advanced_filter_dialog_title: 'Advanced filters',
      filter: 'Filter table',
      filter_advanced: 'Advanced filters',
      clear_filters: 'Clear filters',
      apply_filters: 'Apply filters',
      notification_info_title: 'Info',
      no_filters_applied: 'There are no filters applied on table {resourceName}',
      no_filters_to_apply: 'There are no filters to be applied on table {resourceName}',
      filters_applied_remove: 'All the filters were successfully removed from table {resourceName}',
      notification_success_title: 'Success',
      filter_results_message: 'You are currently viewing results for: ',
    },
    menu: {
      my_account: 'User profile',
      documentation: 'Documentation',
      sign_out: 'Sign out',
    },
    home: {
      title: 'Dashboard',
      description: `
        {applicationName} dashboard application is a feature-rich and customizable
        platform that provides users with an extensive range of capabilities.
        Built with the combination of Vue.js and TypeScript, it offers a visually
        appealing and intuitive user interface. Users can effortlessly modify their profiles,
        including personal information and preferences, while also having control over
        user roles and permissions. This application empowers users to create dynamic
        and engaging pages and articles, enabling seamless content management.
        Additionally, the dashboard facilitates convenient media file uploads,
        ensuring smooth integration of multimedia elements. With its powerful tools
        and flexibility, this application serves as a comprehensive solution for efficient
        management and customization.
      `,
    },
    management: {
      title: 'Management',
      pages: {
        title: 'Pages',
        table: {
          field_1: 'Field 1',
          field_2: 'Field 2',
          field_3: 'Field 3',
        },
      },
      tags: {
        title: 'Tags',
      },
      articles: {
        title: 'Articles',
      },
      media: {
        title: 'Media',
      },
      comments: {
        title: 'Comments',
      },
    },
    communication: {
      title: 'Communication',
      contact: {
        title: 'Contact me',
        table: {
          full_name: 'Full name',
          email: 'Email address',
          subject: 'Subject',
        },
      },
      newsletter: {
        title: 'Newsletters and Campaigns',
        table: {
          name: 'Campaign name',
          valid_from: 'Valid from',
          valid_to: 'Valid to',
          is_active: 'Is active?',
        },
      },
    },
    reports: {
      title: 'Reports',
    },
    documentation: {
      title: 'Documentation',
    },
    user_settings: {
      title: 'User settings',
      user_profile: {
        title: 'User profile',
      },
      users: {
        title: 'All users',
        table: {
          full_name: 'Full name',
          email: 'Email address',
          nickname: 'Nickname',
          created_at: 'Joined date',
        },
      },
      roles_and_permissions: {
        title: 'Roles and permissions',
        table: {
          name: 'Name',
          slug: 'Slug'
        },
      },
    },
    application_settings: {
      title: 'Application settings',
      general: {
        title: 'General',
      },
      performance: {
        title: 'Performance',
      },
      accepted_domains: {
        title: 'Accepted domains',
        table: {
          domain: 'Domain',
          type: 'Type'
        },
      },
      notifications: {
        title: 'Notifications',
      },
      emails: {
        title: 'Emails',
      },
    },
  },
};
