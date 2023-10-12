import { BaseSingleRecord } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: {
    id: number
    name: string
    description: string
    bg_color: string
    text_color: string
    slug: string
    is_active: boolean
    created_at: string
    updated_at: string
    permissions: unknown[]
  }[]
}

interface CreateRecord {
  type: string
  condition: string
  title: string
  content: string
}

interface UpdateRecord {
  type: string
  condition: string
  title: string
  content: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
