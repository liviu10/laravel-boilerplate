import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface Permission {
  id: number
  name: string
  is_active: true
  role_id: number
}

interface Role {
  id: number
  name: string
  is_active: boolean
  permissions: Permission[]
}

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    full_name: string
    first_name: string
    last_name: string
    nickname: string
    email: string
    phone: string | null
    email_verified_at: string
    profile_image: string | null
    role_id: number
    role: Role
  })[]
}

interface CreateRecord {
  first_name: string
  last_name: string
  nickname: string
  email: string
  role_id: number
}

interface UpdateRecord {
  first_name: string
  last_name: string
  role_id: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
