import { BaseUser, BaseSingleRecord, Timestamps } from './BaseInterface'

interface NewsletterSubscriber {
  id: number
  newsletter_campaign_id: number
  full_name: string
  email_address: string
  privacy_policy: boolean
}

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
    user_id: number
    user: BaseUser
    newsletter_subscribers_id: number
    newsletter_subscribers: NewsletterSubscriber[]
  })[]
}

interface CreateRecord {
  name: string
  description: string
  is_active: boolean
  valid_from: string
  valid_to: string
  occur_time: number
  occur_week: number
  occur_day: number
  occur_hour: number
}

interface UpdateRecord {
  name: string
  description: string
  is_active: boolean
  valid_from: string
  valid_to: string
  occur_time: number
  occur_week: number
  occur_day: number
  occur_hour: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
