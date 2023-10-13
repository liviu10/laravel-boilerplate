interface BaseSingleRecord {
  title: string
  description: string
}

interface Timestamps {
  created_at: string
  updated_at: string
  deleted_at?: string
}

interface BaseUser {
  id: number
  full_name: string
}

export {
  BaseSingleRecord,
  Timestamps,
  BaseUser,
}
