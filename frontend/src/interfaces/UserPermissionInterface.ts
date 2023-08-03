interface UserPermissionInterface {
  created_at: string,
  description: string | null,
  id: number,
  is_active: boolean,
  name: string,
  role_id: number,
  updated_at: string,
}

export { UserPermissionInterface }
