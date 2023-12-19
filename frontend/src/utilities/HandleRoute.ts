import {
  RouteParamsRaw,
  LocationQueryRaw,
  NavigationFailure,
  RouteMeta,
  RouteRecordName,
  Router
} from 'vue-router';

interface IHandleRoute {
  handleRouteName: (name: RouteRecordName | null | undefined) => RouteRecordName
  handleRouteTitle: (meta: RouteMeta) => string
  handleRouteDescription: (meta: RouteMeta) => string
  handleNavigateToRoute: (
    router: Router,
    resourceName: string,
    params?: RouteParamsRaw,
    query?: LocationQueryRaw
  ) => Promise<void | NavigationFailure | undefined>
  handleResourceNameFromRoute: () => string
  handleTranslationFromRoute: () => string
}

export class HandleRoute implements IHandleRoute {
  basicRouteName: string
  basicRouteTitle: string
  basicRouteDescription: string
  resourceName: string[] | string | undefined
  translationFromRoute: string

  public constructor () {
    this.basicRouteName = 'BasicRouteName'
    this.basicRouteTitle = 'BasicRouteTitle'
    this.basicRouteDescription = 'BasicRouteDescription'
    this.resourceName = ''
    this.translationFromRoute = ''
  }

  /**
   * Retrieves and validates a route name, returning a default if not provided.
   * @param {RouteRecordName | null | undefined} name - The route name to be validated.
   * @returns {RouteRecordName} The validated route name. If not provided, the default basic route name is returned.
   */
  public handleRouteName(name: RouteRecordName | null | undefined): RouteRecordName {
    if (name && name !== null && name !== undefined) {
      return name;
    } else {
      return this.basicRouteName;
    }
  }

  /**
   * Retrieves and validates a route title from the provided metadata, returning a default if not available.
   * @param {RouteMeta} meta - The route metadata object containing the title.
   * @returns {string} The validated route title. If not available in the metadata, the default basic route title is returned.
   */
  public handleRouteTitle(meta: RouteMeta): string {
    if (meta && meta.title) {
      return meta.title as string;
    } else {
      return this.basicRouteTitle;
    }
  }

  /**
   * Retrieves and validates a route description from the provided metadata, returning a default if not available.
   * @param {RouteMeta} meta - The route metadata object containing the description.
   * @returns {string} The validated route description. If not available in the metadata, the default basic route description is returned.
   */
  public handleRouteDescription(meta: RouteMeta): string {
    if (meta && meta.caption) {
      return meta.caption as string;
    } else {
      return this.basicRouteDescription;
    }
  }

  /**
   * Navigates to a specified route using the provided router instance.
   * @param {Router} router - The Vue Router instance used for navigation.
   * @param {string} resourceName - The name of the route to navigate to.
   * @param {RouteParamsRaw} [params] - Optional parameters for the route.
   * @param {LocationQueryRaw} [query] - Optional query parameters for the route.
   * @returns {Promise<void | NavigationFailure | undefined>} A promise that resolves when the navigation is successful,
   * rejects with a NavigationFailure in case of an error, or resolves with undefined if the navigation does not result
   * in a state change (e.g., navigating to the current route).
   * @throws {NavigationFailure} If the navigation to the specified route fails.
   */
  public handleNavigateToRoute(
    router: Router,
    resourceName: string,
    params?: RouteParamsRaw,
    query?: LocationQueryRaw
  ): Promise<void | NavigationFailure | undefined> {
    return router.push({
      name: resourceName,
      params: params || undefined as unknown as RouteParamsRaw,
      query: query || undefined as unknown as LocationQueryRaw,
    });
  }

  /**
   * Extracts a resource name from the current window location pathname.
   * @returns {string} The extracted resource name.
   */
  public handleResourceNameFromRoute(): string {
    const pathName = window.location.pathname
    if (pathName.includes('create') || pathName.includes('show') || pathName.includes('edit')) {
      this.resourceName = pathName.replace(/\b(create|show|edit)\b/g, '').split('/');
      if (this.resourceName[this.resourceName.length - 1] !== '') {
        this.resourceName = this.resourceName.slice(0, -2)
      } else {
        this.resourceName = this.resourceName.slice(0, -1)
      }
      this.resourceName = this.resourceName.pop();
    } else {
      this.resourceName = pathName.split('/').pop();
    }

    if (this.resourceName) {
      return this.resourceName
    } else {
      console.log('-> handleResourceNameFromRoute', this.resourceName);
      return ''
    }
  }

  /**
   * Extracts a translation key from the current window location pathname.
   * @returns {string} The translation key generated from the pathname.
   */
  public handleTranslationFromRoute(): string {
    this.translationFromRoute = window.location.pathname
      .replace(/\//g, '.')
      .replace(/-/g, '_')
      .substring(1)
      .replace(/\b(create|show|edit)\b/g, '')
      .replace(/\.$/, '');

      return this.translationFromRoute;
  }
}
