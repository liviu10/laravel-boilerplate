import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface'

/**
 * Interface representing a user with various properties.
 * @property email
 * @property email_verified_at
 * @property first_name
 * @property full_name
 * @property last_name
 * @property nickname
 * @property phone
 * @property profile_image
 * @property role
 * @property roles_and_permissions_id
 * @interface UserInterface
 * @extends {SingleResultInterface}
 */
interface UserInterface extends SingleResultInterface {
  email: string
  email_verified_at: string | null
  first_name: string
  full_name: string
  last_name: string
  nickname: string
  phone: string | null
  profile_image: null
  role: {
    id: number
    is_active: boolean
    name: string
    permissions: UserPermissionInterface[]
  }
  roles_and_permissions_id: number
}

/**
 * Interface representing user permissions with various properties.
 * @property description
 * @property is_active
 * @property name
 * @property role_id
 * @interface UserPermissionInterface
 * @extends {SingleResultInterface}
 */
interface UserPermissionInterface extends SingleResultInterface {
  description: string | null
  is_active: boolean
  name: string
  role_id: number
}

/**
 * Interface representing user roles with various properties.
 * @property bg_color
 * @property description
 * @property is_active
 * @property name
 * @property permissions
 * @property slug
 * @property text_color
 * @interface UserRoleInterface
 * @extends {SingleResultInterface}
 */
interface UserRoleInterface extends SingleResultInterface {
  bg_color: string
  description: string
  is_active: boolean
  name: string
  permissions: UserPermissionInterface[]
  slug: string | null
  text_color: string
}

export {
  UserInterface,
  UserPermissionInterface,
  UserRoleInterface,
}
