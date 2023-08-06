import { SingleResultInterface } from 'src/interfaces/ApiResponseInterface';

interface ContactMessageInterface extends SingleResultInterface {
  full_name: string,
  email: string,
  phone: string,
  message: string,
  privacy_policy: boolean,
  contact_subject_id: number,
}

interface NewsletterCampaignInterface extends SingleResultInterface {
  is_active: boolean,
  name: string,
  valid_from: string,
  valid_to: string,
}

export {
  ContactMessageInterface,
  NewsletterCampaignInterface
}
