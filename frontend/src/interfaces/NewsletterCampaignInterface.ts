import {
  IRootObject,
  IBasePagination,
  IBaseUser,
  IBaseTimestamps
} from './BaseInterface'

interface INewsletterSubscriber {
  id: number
  newsletter_campaign_id: number
  full_name: string
  email_address: string
  privacy_policy: boolean
}

interface IAllRecords extends IRootObject {
  results: (IBasePagination & {
    data: {
      id: number
      name: string
      is_active: boolean
      valid_from: string
      valid_to: string
    }[]
  })
}

interface ISingleRecord extends IRootObject {
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
  name?: string
  description?: string
  is_active?: boolean
  valid_from?: string
  valid_to?: string
  occur_time?: number
  occur_week?: number
  occur_day?: number
  occur_hour?: number
}

export {
  IAllRecords,
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
