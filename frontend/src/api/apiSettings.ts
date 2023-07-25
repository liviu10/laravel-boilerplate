// Application's settings endpoints
const applicationApiSettings: string | undefined = process.env.DEV_API_BASE_URL + '/admin/application-settings'
const generalEndpoint = '/general'
const performanceEndpoint = '/performance'
const acceptedDomainsEndpoint = '/accepted-domains'
const notificationsEndpoint = '/notifications'
const emailsEndpoint = '/emails'

export {
  applicationApiSettings,
  generalEndpoint,
  performanceEndpoint,
  acceptedDomainsEndpoint,
  notificationsEndpoint,
  emailsEndpoint,
}
