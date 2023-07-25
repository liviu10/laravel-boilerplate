// Application's settings endpoints
const applicationUserSettings: string | undefined = process.env.DEV_API_BASE_URL + '/admin/settings'
const userProfileEndpoint = '/user-profile'
const usersEndpoint = '/users'
const userRolesAndPermissionsEndpoint = '/roles-and-permissions'

export {
  applicationUserSettings,
  userProfileEndpoint,
  usersEndpoint,
  userRolesAndPermissionsEndpoint,
}
