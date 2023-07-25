// Application's communication endpoints
const applicationCommunication: string | undefined = process.env.DEV_API_BASE_URL + '/admin/communication'
const contactMeEndpoint = '/contact-me'
const newsletterEndpoint = '/newsletter'

export {
  applicationCommunication,
  contactMeEndpoint,
  newsletterEndpoint,
}
