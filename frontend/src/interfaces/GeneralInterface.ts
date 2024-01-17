import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

type GeneralOptions = 'General' | 'Writing' | 'Reading' | 'Discussion' | 'Media' | 'Performance' | 'Notifications'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: (IBaseTimestamps & {
      id: number
      type: GeneralOptions
      label: string
      value: string
      user_id: number
      user: IBaseUser
    })[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    type: GeneralOptions
    label: string
    value: string
    user_id: number
    user: IBaseUser
  }[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    type: GeneralOptions
    label: string
    value: string
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  type: GeneralOptions
  label: string
  value: string
}

interface IUpdateRecord {
  type?: GeneralOptions
  label?: string
  value?: string
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
