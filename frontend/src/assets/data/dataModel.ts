import { TInput } from 'src/interfaces/BaseInterface';
import { IConfigurationOptions } from 'src/interfaces/ConfigurationResourceInterface';

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
    value: null,
    configuration_options: [
      {
        value: 'Published',
        label: 'Published'
      },
      {
        value: 'Draft',
        label: 'Draft'
      },
      {
        value: 'Scheduled',
        label: 'Scheduled'
      },
      {
        value: 'Trashed',
        label: 'Trashed'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
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
    value: null,
    configuration_options: [
      {
        value: 'Page',
        label: 'Page'
      },
      {
        value: 'Article',
        label: 'Article'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
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
    value: null,
    configuration_options: [
      {
        value: 'false',
        label: 'No'
      },
      {
        value: 'true',
        label: 'Yes'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
  },
];

const defaultFilterModel = [
  {
    id: 1,
    field: 'visibility',
    is_active: true,
    is_filter: true,
    is_model: false,
    key: 'visibility',
    name: 'Visibility',
    position: 1,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
    configuration_options: [
      {
        value: 'Published',
        label: 'Published'
      },
      {
        value: 'Draft',
        label: 'Draft'
      },
      {
        value: 'Scheduled',
        label: 'Scheduled'
      },
      {
        value: 'Trashed',
        label: 'Trashed'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
  },
  {
    id: 2,
    field: 'content_url',
    is_active: true,
    is_filter: true,
    is_model: false,
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
    is_filter: true,
    is_model: false,
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
    is_filter: true,
    is_model: false,
    key: 'content_type',
    name: 'Content type',
    position: 4,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
    configuration_options: [
      {
        value: 'Page',
        label: 'Page'
      },
      {
        value: 'Article',
        label: 'Article'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
  },
  {
    id: 5,
    field: 'description',
    is_active: true,
    is_filter: true,
    is_model: false,
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
    is_filter: true,
    is_model: false,
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
    is_filter: true,
    is_model: false,
    key: 'allow_comments',
    name: 'Allow comments',
    position: 7,
    type: 'text' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
    configuration_options: [
      {
        value: 'false',
        label: 'No'
      },
      {
        value: 'true',
        label: 'Yes'
      },
    ] as Pick<IConfigurationOptions, 'value' | 'label'>[],
  },
];

const defaultUploadModel = [
  {
    id: 1,
    accept: '.xls,.xlsx,.csv,.txt,.ods,.fods',
    field: 'upload_file',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'upload_file',
    name: 'Upload file',
    position: 1,
    type: 'file' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
  },
];

const defaultDownloadModel = [
  {
    id: 1,
    field: 'date_to',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'date_to',
    name: 'Date to',
    position: 1,
    type: 'date' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
  },
  {
    id: 2,
    field: 'date_from',
    is_active: true,
    is_filter: false,
    is_model: true,
    key: 'date_from',
    name: 'Date from',
    position: 2,
    type: 'date' as TInput,
    configuration_resource_id: 1,
    configuration_type_id: 1,
    value: null,
  },
];

export {
  defaultDataModel,
  defaultFilterModel,
  defaultUploadModel,
  defaultDownloadModel,
}
