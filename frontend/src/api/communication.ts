// Application's communication endpoints
const applicationCommunication: string | undefined = process.env.DEV_API_BASE_URL + '/admin/communication'
const contactMessageEndpoint = '/contact-messages'
const contactSubjectEndpoint = '/contact-subjects'
const newsletterEndpoint = '/newsletter'

export {
  applicationCommunication,
  contactMessageEndpoint,
  contactSubjectEndpoint,
  newsletterEndpoint,
}
