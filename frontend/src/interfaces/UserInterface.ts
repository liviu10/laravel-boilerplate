import { BaseSingleRecord } from './BaseInterface'

interface PermissionInterface {
  id: number
  name: string
  is_active: true
  role_id: number
}

interface RoleInterface {
  id: number
  name: string
  is_active: boolean
  permissions: PermissionInterface[]
}

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    full_name: string
    first_name: string
    last_name: string
    nickname: string
    email: string
    phone: string | null
    email_verified_at: string
    profile_image: string | null
    created_at: string
    updated_at: string
    role_id: number
    role: RoleInterface
  }[]
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
  PermissionInterface,
  RoleInterface,
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
