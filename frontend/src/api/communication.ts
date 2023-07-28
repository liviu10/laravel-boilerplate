// Application's communication endpoints
const applicationCommunication: string | undefined = process.env.DEV_API_BASE_URL + '/admin/communication'
const contactMeMessageEndpoint = '/contact-me-messages'
const contactMeSubjectEndpoint = '/contact-me-subjects'
const newsletterEndpoint = '/newsletter'

export {
  applicationCommunication,
  contactMeMessageEndpoint,
  contactMeSubjectEndpoint,
  newsletterEndpoint,
}
