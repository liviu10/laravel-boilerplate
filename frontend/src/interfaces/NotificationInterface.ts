import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

type TypeOptions = 'SMS' | 'Email'

type ConditionOptions = 'Read' | 'Create' | 'Show' | 'Update' | 'Delete' | 'Restore'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    type: TypeOptions
    condition: ConditionOptions
    title: string
    content: string
    user_id: number
    user: BaseUser
  })[]
}

interface CreateRecord {
  type: TypeOptions
  condition: ConditionOptions
  title: string
  content: string
}

interface UpdateRecord {
  type: TypeOptions
  condition: ConditionOptions
  title: string
  content: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
