import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface'

interface UserInterface extends SingleResultInterface {
  email: string,
  email_verified_at: string | null,
  first_name: string,
  full_name: string,
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
}

interface UserPermissionInterface extends SingleResultInterface {
  description: string | null,
  is_active: boolean,
  name: string,
  role_id: number,
}

interface UserRoleInterface extends SingleResultInterface {
  bg_color: string,
  description: string,
  is_active: boolean,
  name: string,
  permissions: UserPermissionInterface[],
  slug: string | null,
  text_color: string,
}

export {
  UserInterface,
  UserPermissionInterface,
  UserRoleInterface,
}
