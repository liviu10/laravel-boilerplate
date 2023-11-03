import { IBaseSingleRecord, IBaseTimestamps } from './BaseInterface'

interface INewsletterCampaign {
  id: number
  name: string
  valid_from: string
  valid_to: string
}

interface ISingleRecord extends IBaseSingleRecord {
  results: (IBaseTimestamps & {
    id: number
    full_name: string
    email: string
    privacy_policy: boolean
    valid_email: boolean
    newsletter_campaign_id: number
    newsletter_campaign: INewsletterCampaign
  })[]
}

interface ICreateRecord {
  full_name: string
  email: string
  privacy_policy: boolean
}

interface IUpdateRecord {
  newsletter_campaign_id: number
}

export {
  ISingleRecord,
  ICreateRecord,
  IUpdateRecord,
}
