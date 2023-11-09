const defaultColumns = [
  {
    name: 'id',
    label: 'ID',
    field: 'id',
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 75px',
    headerStyle: 'width: 75px',
  },
  {
    name: 'title',
    label: 'title',
    field: 'title',
    format: (val: string) => `${val}`,
    sortable: true,
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
    sort: (a: string, b: string) => parseInt(a, 10) - parseInt(b, 10),
  },
  {
    name: 'actions',
    label: 'Actions',
    field: 'actions',
    align: 'center' as 'left' | 'right' | 'center',
    style: 'width: 100px',
    headerStyle: 'width: 100px',
  },
];

export { defaultColumns }
