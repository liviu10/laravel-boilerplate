import { UserPermissionInterface } from 'src/interfaces/UserPermissionInterface'

interface UserRoleInterface {
  bg_color: string,
  created_at: string,
  description: string,
  id: number,
  is_active: boolean,
  name: string,
  permissions: UserPermissionInterface[],
  slug: string | null,
  text_color: string,
  updated_at: string,
}

export { UserRoleInterface }
