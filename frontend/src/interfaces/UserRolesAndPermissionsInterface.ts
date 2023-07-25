interface UserRolesAndPermissionsInterface {
  id: number,
  user_role_name: string,
  user_role_description: string,
  user_role_slug: string | null,
  is_active: boolean,
  created_at: string,
  updated_at: string,
}

export { UserRolesAndPermissionsInterface }
