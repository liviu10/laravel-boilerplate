import { IBaseUser, IBaseSingleRecord, IBaseTimestamps, IBasePagination } from './BaseInterface'

type AcceptedDomainTypeOptions = 'generic' | 'country-code' | 'sponsored' | 'infrastructure' | 'generic-restricted' | 'local-environment'

interface IAllRecords extends IBasePagination {
  data: {
    id: number
    domain: string
    type: AcceptedDomainTypeOptions
    is_active: boolean
  }[]
}

interface ISingleRecord extends IBaseSingleRecord {
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
  type: AcceptedDomainTypeOptions
  is_active: boolean
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
