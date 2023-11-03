import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

type TypeOptions = 'Menu' | 'API'

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    type: TypeOptions
    path: string
    name: string
    component: string
    layout: string
    title: string
    caption: string
    icon: string
    is_active: boolean
    requires_auth: boolean
    user_id: number
    user: IBaseUser
  })[]
}

interface ICreateRecord {
  type: TypeOptions
  path: string
  name: string
  component: string
  layout: string
  title: string
  caption: string
  icon: string
  is_active: boolean
  requires_auth: boolean
}

interface IUpdateRecord {
  type: TypeOptions
  path: string
  name: string
  component: string
  layout: string
  title: string
  caption: string
  icon: string
  is_active: boolean
  requires_auth: boolean
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
