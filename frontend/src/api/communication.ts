// Application's communication endpoints
const applicationCommunication: string | undefined = process.env.DEV_API_BASE_URL + '/admin/communication'
const contactSubjectEndpoint = '/contact-subjects'
const contactMessageEndpoint = '/contact-messages'
const newsletterCampaignEndpoint = '/newsletter/campaigns'
const newsletterSubscriberEndpoint = '/newsletter/subscribers'

export {
  applicationCommunication,
  contactSubjectEndpoint,
  contactMessageEndpoint,
  newsletterCampaignEndpoint,
  newsletterSubscriberEndpoint,
}
