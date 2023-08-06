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
    name: 'domain',
    label: 'admin.application_settings.accepted_domains.table.domain',
    field: 'domain',
    format: (val: string) => `${val}`,
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
    sort: (a: string, b: string) => parseInt(a, 10) - parseInt(b, 10),
  },
  {
    name: 'type',
    label: 'admin.application_settings.accepted_domains.table.type',
    field: 'type',
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