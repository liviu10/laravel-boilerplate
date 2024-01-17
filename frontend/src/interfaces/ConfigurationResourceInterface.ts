import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps,
  TColumn,
  TInput
} from './BaseInterface'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      resource: string
    }[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    resource: string
  }[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    resource: string
    user_id: number
    user: IBaseUser
    configuration_types: IConfigurationType[]
  })[]
}

interface IConfiguration extends IRootObject {
  results: {
    id: number
    configuration_types: IConfigurationType[]
  }[]
}

interface ICreateRecord {
  resource: string
  key: string
}

interface ICreateType {
  name: string
  is_active: boolean
  configuration_resource_id: number
}

interface ICreateColumn {
  align: string
  field: string
  header_style: string
  label: string
  name: string
  position: number
  style: string
  configuration_resource_id: number
  configuration_type_id: number
}

interface ICreateInput {
  accept?: string
  field: string
  is_active: boolean
  is_filter: boolean
  is_model: boolean
  key: string
  name: string
  position: number
  type: TInput
  configuration_resource_id: number
  configuration_type_id: number
}

interface ICreateOption {
  value: string
  label: string
  configuration_resource_id: number
  configuration_type_id: number
  configuration_input_id: number
}

interface IUpdateRecord {
  resource: string
  key: string
}

interface IUpdateType {
  name?: string
  is_active?: boolean
  configuration_resource_id?: number
}

interface IUpdateColumn {
  align?: string
  field?: string
  header_style?: string
  label?: string
  name?: string
  position?: number
  style?: string
  configuration_resource_id?: number
  configuration_type_id?: number
}

interface IUpdateInput {
  accept?: string
  field?: string
  is_active?: boolean
  is_filter?: boolean
  is_model?: boolean
  key?: string
  name?: string
  position?: number
  type?: TInput
  configuration_resource_id?: number
  configuration_type_id?: number
}

interface IUpdateOption {
  value?: string
  label?: string
  configuration_resource_id?: number
  configuration_type_id?: number
  configuration_input_id?: number
}

interface IConfigurationType {
  id: number
  name: string
  is_active: boolean
  configuration_resource_id: number
  configuration_columns: IConfigurationColumn[]
  configuration_inputs: IConfigurationInput[]
}

interface IConfigurationColumn {
  id: number
  align: TColumn
  field: string
  header_style: string
  label: string
  name: string
  position: number
  style: string
  configuration_resource_id: number
  configuration_type_id: number
}

interface IConfigurationInput {
  id: number
  accept?: string
  field: string
  is_active: boolean
  is_filter: boolean
  is_model: boolean
  key: string
  name: string
  position: number
  type: TInput
  configuration_resource_id: number
  configuration_type_id: number
  configuration_options?: Pick<IConfigurationOptions, 'value' | 'label'>[],
  value: null
}

interface IConfigurationOptions {
  id: number
  value: string
  label: string
  configuration_resource_id: number
  configuration_type_id: number
  configuration_input_id: number
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  IConfiguration,
  ICreateRecord,
  ICreateType,
  ICreateColumn,
  ICreateInput,
  ICreateOption,
  IUpdateRecord,
  IUpdateType,
  IUpdateColumn,
  IUpdateInput,
  IUpdateOption,
  IConfigurationType,
  IConfigurationColumn,
  IConfigurationInput,
  IConfigurationOptions,
}
