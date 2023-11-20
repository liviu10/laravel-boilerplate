import {
  LocationQueryRaw,
  NavigationFailure,
  RouteMeta,
  RouteRecordName,
  useRouter
} from 'vue-router';

interface IHandleRoute {
  handleRouteName: (name: RouteRecordName | null | undefined) => RouteRecordName
  handleRouteTitle: (meta: RouteMeta) => string
  handleRouteDescription: (meta: RouteMeta) => string
  handleNavigateToRoute: (resourceName: string, queryParams?: string) => Promise<void | NavigationFailure | undefined>
}

export class HandleRoute implements IHandleRoute {
  basicRouteName: string
  basicRouteTitle: string
  basicRouteDescription: string

  public constructor () {
    this.basicRouteName = 'BasicRouteName'
    this.basicRouteTitle = 'BasicRouteTitle'
    this.basicRouteDescription = 'BasicRouteDescription'
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
   * Handles navigation to a specified route.
   * @param {string} resourceName - The name of the route to navigate to.
   * @param {string} queryParams - The query parameters for the route.
   * @returns {Promise<void | NavigationFailure | undefined>} A promise that resolves when the navigation is successful,
   * or rejects with a NavigationFailure in case of an error. It may also resolve with undefined if the navigation does not result
   * in a state change (e.g., navigating to the current route).
   * @throws {NavigationFailure} If the navigation to the specified route fails.
   */
  public handleNavigateToRoute(resourceName: string, queryParams?: string): Promise<void | NavigationFailure | undefined> {
    const router = useRouter();
    return router.push({
      name: resourceName,
      query: queryParams || undefined as unknown as LocationQueryRaw,
    });
  }
}
