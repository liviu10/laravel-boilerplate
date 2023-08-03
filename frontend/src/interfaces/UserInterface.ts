import { UserPermissionInterface } from 'src/interfaces/UserPermissionInterface'

interface UserInterface {
  created_at: string,
  email: string,
  email_verified_at: string | null,
  first_name: string,
  full_name: string,
  id: number,
  last_name: string,
  nickname: string,
  phone: string | null,
  profile_image: null,
  role: {
    id: number,
    is_active: boolean,
    name: string,
    permissions: UserPermissionInterface[]
  },
  roles_and_permissions_id: number,
  updated_at: string,
}

export { UserInterface }
