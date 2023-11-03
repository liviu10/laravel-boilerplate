import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

type GeneralOptions = 'General' | 'Writing' | 'Reading' | 'Discussion' | 'Media' | 'Performance' | 'Notifications'

interface ISingleRecord extends IBaseSingleRecord {
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
  type: GeneralOptions
  label: string
  value: string
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
