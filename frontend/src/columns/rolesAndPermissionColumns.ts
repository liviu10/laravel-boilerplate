export default [
  {
    name: 'id',
    label: 'admin.generic.table.id',
    field: 'id',
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 75px',
    headerStyle: 'width: 75px',
  },
  {
    name: 'user_role_name',
    label: 'admin.user_settings.roles_and_permissions.table.user_role_name',
    field: 'user_role_name',
    format: (val: string) => `${val}`,
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
    sort: (a: string, b: string) => parseInt(a, 10) - parseInt(b, 10),
  },
  {
    name: 'user_role_description',
    label: 'admin.user_settings.roles_and_permissions.table.user_role_description',
    field: 'user_role_description',
    format: (val: string) => `${val}`,
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
    sort: (a: string, b: string) => parseInt(a, 10) - parseInt(b, 10),
  },
  {
    name: 'actions',
    label: 'admin.generic.table.actions',
    field: 'actions',
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
  },
];
