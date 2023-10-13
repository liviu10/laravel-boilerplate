import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

type TypeOptions = 'Menu' | 'API'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
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
    user: BaseUser
  })[]
}

interface CreateRecord {
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

interface UpdateRecord {
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
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
