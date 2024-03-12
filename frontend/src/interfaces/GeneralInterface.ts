import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

// type GeneralOptions = 'General' | 'Writing' | 'Reading' | 'Discussion' | 'Media' | 'Performance' | 'Notifications' | 'Page'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (IBaseTimestamps & {
      id: number
      instance_model: string
      path: string
      instance_field: string
      value: string
      label: string
      user_id: number
      user: IBaseUser
    })[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    instance_model: string
    path: string
    instance_field: string
    value: string
    label: string
    user_id: number
    user: IBaseUser
  }[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    instance_model: string
    path: string
    instance_field: string
    value: string
    label: string
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  instance_model: string
  path: string
  instance_field: string
  value: string
  label: string
}

interface IUpdateRecord {
  instance_model: string
  path: string
  instance_field: string
  value: string
  label: string
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
