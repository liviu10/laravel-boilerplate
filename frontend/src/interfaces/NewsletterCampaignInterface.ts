import { IBaseUser, IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface INewsletterSubscriber {
  id: number
  newsletter_campaign_id: number
  full_name: string
  email_address: string
  privacy_policy: boolean
}

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
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
    user: IBaseUser
    newsletter_subscribers_id: number
    newsletter_subscribers: INewsletterSubscriber[]
  })[]
}

interface ICreateRecord {
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

interface IUpdateRecord {
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
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
