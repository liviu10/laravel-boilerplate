import { BaseSingleRecord, Timestamps } from './BaseInterface'

interface NewsletterCampaign {
  id: number
  name: string
  valid_from: string
  valid_to: string
}

interface SingleRecord extends BaseSingleRecord {
  results: (Timestamps & {
    id: number
    full_name: string
    email: string
    privacy_policy: boolean
    valid_email: boolean
    newsletter_campaign_id: number
    newsletter_campaign: NewsletterCampaign
  })[]
}

interface CreateRecord {
  full_name: string
  email: string
  privacy_policy: boolean
}

interface UpdateRecord {
  newsletter_campaign_id: number
}

export {
  SingleRecord,
  CreateRecord,
  UpdateRecord,
}
