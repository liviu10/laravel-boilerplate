// Application's settings endpoints
const applicationUserSettings: string | undefined = process.env.DEV_API_BASE_URL + '/admin/settings'
const userProfileEndpoint = '/users/current-auth'
const usersEndpoint = '/users'
const userRolesEndpoint = '/roles'

export {
  applicationUserSettings,
  userProfileEndpoint,
  usersEndpoint,
  userRolesEndpoint,
}
