interface UserRolesAndPermissionsInterface {
  id: number,
  name: string,
  description: string,
  bg_color: string,
  text_color: string,
  slug: string | null,
  is_active: boolean,
  created_at: string,
  updated_at: string,
}

export { UserRolesAndPermissionsInterface }
