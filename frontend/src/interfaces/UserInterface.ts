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
  updated_at: string,
  user_role_type: {
    id: number,
    is_active: boolean,
    user_role_name: string,
  },
  user_role_type_id: number,
}

export { UserInterface }
