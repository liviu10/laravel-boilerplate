import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    name: string
    description: string
    is_active: boolean
    valid_from: string
    valid_to: string
    occur_times: number
    occur_week: number
    occur_hour: string
  })[]
}

interface CreateRecord {
  full_name: string
  rating: number
  comment: string
}

interface UpdateRecord {
  is_active: boolean
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
