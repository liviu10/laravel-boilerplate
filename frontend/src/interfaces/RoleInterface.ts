import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface Permission {
  id: number
  name: string
  role_id: number
}

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    name: string
    description: string
    bg_color: string
    text_color: string
    slug: string
    is_active: boolean
    permissions: Permission[]
  })[]
}

interface CreateRecord {
  name: string
  description: string
  bg_color: string
  text_color: string
  slug: string
  is_active: boolean
}

interface UpdateRecord {
  name: string
  description: string
  bg_color: string
  text_color: string
  slug: string
  is_active: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
