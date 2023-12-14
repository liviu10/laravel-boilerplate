import { IRootObject, IBaseTimestamps, IBaseUser } from './BaseInterface'

type TypeOptions = 'Menu' | 'API'

interface IAllRecords extends IRootObject {
  results: {
    id: number
    type: TypeOptions
    path: string
    name: string | null
    component: string | null
    layout: string | null
    title: string | undefined
    caption: string | null
    icon: string | undefined
    is_active: boolean
    requires_auth: boolean
    resource_children: {
      id: number
      type: TypeOptions
      path: string
      name: string | null
      component: string | null
      layout: string | null
      title: string | undefined
      caption: string | null
      icon: string | undefined
      is_active: boolean
      requires_auth: boolean
    }[]
  }[]
}

interface IAllRecordsUnpaginated extends IRootObject {
  results: {
    id: number
    type: TypeOptions
    path: string
    name: string | null
    component: string | null
    layout: string | null
    title: string | undefined
    caption: string | null
    icon: string | undefined
    is_active: boolean
    requires_auth: boolean
    resource_children: {
      id: number
      type: TypeOptions
      path: string
      name: string | null
      component: string | null
      layout: string | null
      title: string | undefined
      caption: string | null
      icon: string | undefined
      is_active: boolean
      requires_auth: boolean
    }[]
  }[]
}

interface ISingleRecord extends IRootObject {
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
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
