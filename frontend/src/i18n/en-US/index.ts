// English translations

export default {
  admin: {
    generic: {
      application_name: 'Generic boilerplate',
      designed_by: 'Designed by',
      all_rights_reserved: 'All rights reserved',
      page_title: 'Admin page title',
      welcome: 'Welcome {authUserName}',
      page_description: `
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
      documentation: `
        For a more comprehensive understanding and detailed insights into the
        {applicationName}, I recommend consulting the accompanying <a href="{documentationPageUrl}">documentation</a>,
        which provides in-depth information and visuals.
      `,
    },
    menu: {
      my_account: 'My account',
      sign_out: 'Sign out'
    },
    home: {
      title: 'Dashboard',
      description: `
        {applicationName}: customizable, intuitive UI, dynamic content, media integration, efficient management.
      `
    },
    settings: {
      title: 'Settings',
      description: `
        {applicationName} settings: users, roles, permissions and more.
      `,
      notifications: {
        title: 'Notifications',
        description: `
          The notifications page allows users to manage and track
          various notifications. Users can perform operations like adding,
          editing, and deleting records, ensuring efficient error handling and communication.
        `
      },
      users: {
        title: 'Users',
        description: `
          The users page displays a list of all users, and the administrator
          can perform basic operations on the list, such as listing,
          displaying details, and updating user information.
        `
      },
      roles_and_permissions: {
        title: 'Roles and permissions',
        description: `
          Roles and permissions define the level of access and actions a
          user can perform within a system. They ensure proper security and control
          by assigning specific privileges based on roles like webmaster,
          administrator, accountant, sales, client.
        `
      },
    }
  }
};
