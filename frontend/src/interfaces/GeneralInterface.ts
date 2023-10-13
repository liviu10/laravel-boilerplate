import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

type GeneralOptions = 'General' | 'Writing' | 'Reading' | 'Discussion' | 'Media' | 'Performance' | 'Notifications'

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    type: GeneralOptions
    label: string
    value: string
    user_id: number
    user: BaseUser
  })[]
}

interface CreateRecord {
  type: GeneralOptions
  label: string
  value: string
}

interface UpdateRecord {
  type: GeneralOptions
  label: string
  value: string
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
