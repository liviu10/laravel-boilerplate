// Application's management endpoints
const applicationManagement: string | undefined = process.env.DEV_API_BASE_URL + '/admin/management'
const pagesEndpoint = '/pages'
const tagsEndpoint = '/tags'
const articlesEndpoint = '/articles'
const mediaEndpoint = '/media'
const commentsEndpoint = '/comments'

export {
  applicationManagement,
  pagesEndpoint,
  tagsEndpoint,
  articlesEndpoint,
  mediaEndpoint,
  commentsEndpoint,
}
