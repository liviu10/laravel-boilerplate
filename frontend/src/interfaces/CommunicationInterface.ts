import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Interface representing a contact message with various properties.
 * @property full_name
 * @property email
 * @property phone
 * @property message
 * @property privacy_policy
 * @property contact_subject_id
 * @interface ContactMessageInterface
 * @extends {SingleResultInterface}
 */
interface ContactMessageInterface extends SingleResultInterface {
  full_name: string
  email: string
  phone: string
  message: string
  privacy_policy: boolean
  contact_subject_id: number
}

/**
 * Interface representing a newsletter campaign with various properties.
 * @property name
 * @property description
 * @property is_active
 * @property valid_from
 * @property valid_to
 * @property occur_times
 * @property occur_week
 * @property occur_day
 * @property occur_hour
 * @interface NewsletterCampaignInterface
 * @extends {SingleResultInterface}
 */
interface NewsletterCampaignInterface extends SingleResultInterface {
  id: number
  name: string
  description: string
  is_active: boolean
  valid_from: string
  valid_to: string
  occur_times: number
  occur_week: number
  occur_day: number
  occur_hour: string
}

export {
  ContactMessageInterface,
  NewsletterCampaignInterface
}
