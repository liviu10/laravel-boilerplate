import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    name: string
    description: string
    is_active: boolean
    valid_from: string
    valid_to: string
    occur_times: number
    occur_week: number
    occur_hour: string
  })[]
}

interface ICreateRecord {
  full_name: string
  rating: number
  comment: string
}

interface IUpdateRecord {
  is_active: boolean
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
