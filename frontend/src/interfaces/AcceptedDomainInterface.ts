import {
  IRootObject,
  IBasePagination,
  IBaseTimestamps,
  IBaseUser
} from './BaseInterface'

type AcceptedDomainTypeOptions = 'generic' | 'country-code' | 'sponsored' | 'infrastructure' | 'generic-restricted' | 'local-environment'

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      domain: string
      type: AcceptedDomainTypeOptions
      is_active: boolean
    }[]
  })
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    domain: string
    type: AcceptedDomainTypeOptions
    is_active: boolean
  }[]
}

interface ISingleRecord extends IRootObject {
  results: (IBaseTimestamps & {
    id: number
    domain: string
    type: AcceptedDomainTypeOptions
    is_active: boolean
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  domain: string
  type: AcceptedDomainTypeOptions
  is_active: boolean
}

interface IUpdateRecord {
  domain?: string
  type?: AcceptedDomainTypeOptions
  is_active?: boolean
}

export {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
