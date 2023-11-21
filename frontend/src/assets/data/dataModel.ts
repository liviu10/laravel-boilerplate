import { TInput } from 'src/interfaces/BaseInterface';

const defaultDataModel = [
  {
    id: 1,
    field: 'visibility',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'visibility',
    name: 'Visibility',
    position: 1,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    configuration_options: [
      {
        value: 'Public',
        label: 'Public'
      },
      {
        value: 'Private',
        label: 'Private'
      },
      {
        value: 'Draft',
        label: 'Draft'
      }
    ],
    value: null
  },
  {
    id: 2,
    field: 'content_url',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'content_url',
    name: 'Content url',
    position: 2,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
  {
    id: 3,
    field: 'title',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'title',
    name: 'Title',
    position: 3,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
  {
    id: 4,
    field: 'content_type',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'content_type',
    name: 'Content type',
    position: 4,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
  {
    id: 5,
    field: 'description',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'description',
    name: 'Description',
    position: 5,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
  {
    id: 6,
    field: 'content',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'content',
    name: 'Content',
    position: 6,
    type: 'textarea' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
  {
    id: 7,
    field: 'allow_comments',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'allow_comments',
    name: 'Allow comments',
    position: 7,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null
  },
];

export { defaultDataModel }
