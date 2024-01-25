import {
  RouteParamsRaw,
  LocationQueryRaw,
  NavigationFailure,
  RouteMeta,
  RouteRecordName,
  Router,
} from 'vue-router';

interface IHandleRoute {
  handleRouteName: (
    name: RouteRecordName | null | undefined
  ) => RouteRecordName;
  handleRouteTitle: (meta: RouteMeta) => string;
  handleRouteDescription: (meta: RouteMeta) => string;
  handleNavigateToRoute: (
    router: Router,
    action: string,
    params?: RouteParamsRaw,
    query?: LocationQueryRaw
  ) => Promise<void | NavigationFailure | undefined>;
  handleResourceNameFromRoute: () => string;
  handleTranslationFromRoute: () => string;
  handleGetIdFromRoute: () => number | null;
}

export class HandleRoute implements IHandleRoute {
  basicRouteName: string;
  basicRouteTitle: string;
  basicRouteDescription: string;
  action: string;
  resourceName: string[] | string | undefined;
  translationFromRoute: string;
  recordId: number | null;

  public constructor() {
    this.basicRouteName = 'BasicRouteName';
    this.basicRouteTitle = 'BasicRouteTitle';
    this.basicRouteDescription = 'BasicRouteDescription';
    this.action = '';
    this.resourceName = '';
    this.translationFromRoute = '';
    this.recordId = null;
  }

  /**
   * Retrieves and validates a route name, returning a default if not provided.
   * @param {RouteRecordName | null | undefined} name - The route name to be validated.
   * @returns {RouteRecordName} The validated route name. If not provided, the default basic route name is returned.
   */
  public handleRouteName(
    name: RouteRecordName | null | undefined
  ): RouteRecordName {
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
   * Navigates to a specific route based on the provided action, parameters, and query.
   * @param {Router} router - The Vue Router instance.
   * @param {string} action - The action to be performed, used to construct the target route name.
   * @param {RouteParamsRaw} [params] - Optional route parameters.
   * @param {LocationQueryRaw} [query] - Optional query parameters.
   * @returns {Promise<void | NavigationFailure | undefined>} A promise that resolves when the navigation is complete.
   */
  public handleNavigateToRoute(
    router: Router,
    action: string,
    params?: RouteParamsRaw,
    query?: LocationQueryRaw
  ): Promise<void | NavigationFailure | undefined> {
    // Determine the action and construct the resource name
    // index, show, create, edit
    if (action.includes('-')) {
      this.action = action.split('-')[1].charAt(0).toUpperCase() + action.split('-')[1].slice(1);
    } else {
      this.action = action.charAt(0).toUpperCase() + action.slice(1);
    }

    // Extract the current component name from the router
    let currentComponentName = router.currentRoute.value.name
    if (currentComponentName) {
      currentComponentName = currentComponentName.toString().replace(/(Index|Show|Create|Edit)Page$/, '');
    } else {
      // TODO: what if the current component name does not exist?
    }
    this.resourceName = `${currentComponentName}${this.action}Page`

    return router.push({
      name: this.resourceName,
      params: params || (undefined as unknown as RouteParamsRaw),
      query: query || (undefined as unknown as LocationQueryRaw),
    });
  }

  /**
   * Extracts a resource name from the current window location pathname.
   * @returns {string} The extracted resource name.
   */
  public handleResourceNameFromRoute(): string {
    const pathName = window.location.pathname;
    if (
      pathName.includes('create') ||
      pathName.includes('show') ||
      pathName.includes('edit')
    ) {
      this.resourceName = pathName
        .replace(/\b(create|show|edit)\b/g, '')
        .split('/');
      if (this.resourceName[this.resourceName.length - 1] !== '') {
        this.resourceName = this.resourceName.slice(0, -2);
      } else {
        this.resourceName = this.resourceName.slice(0, -1);
      }
      this.resourceName = this.resourceName.pop();
    } else {
      this.resourceName = pathName.split('/').pop();
    }

    if (this.resourceName) {
      return this.resourceName;
    } else {
      console.log('-> handleResourceNameFromRoute', this.resourceName);
      return '';
    }
  }

  /**
   * Extracts a translation key from the current window location pathname.
   * @returns {string} The translation key generated from the pathname.
   */
  public handleTranslationFromRoute(): string {
    const pathSegments = window.location.pathname.split('/').filter(segment => segment !== '');
    while (pathSegments.length > 0 && !isNaN(Number(pathSegments[pathSegments.length - 1]))) {
      pathSegments.pop();
    }
    if (pathSegments.length > 0 && ['create', 'show', 'edit'].includes(pathSegments[pathSegments.length - 1])) {
      pathSegments.pop();
    }
    for (let i = 0; i < pathSegments.length; i++) {
      pathSegments[i] = pathSegments[i].replace(/-/g, '_');
    }
    this.translationFromRoute = pathSegments.join('.');

    return this.translationFromRoute;
  }

  /**
   * Extracts and returns the ID from the current window location pathname based on specified keywords.
   * @returns {number | null} The extracted ID, or null if no valid ID is found.
   */
  public handleGetIdFromRoute(): number | null {
    const pathSegments = window.location.pathname.split('/').filter(segment => segment !== '');
    const keywordsToFind = ['show', 'edit'];
    let id: number | null = null;

    for (let i = 0; i < pathSegments.length - 1; i++) {
      const currentSegment = pathSegments[i];
      if (keywordsToFind.includes(currentSegment)) {
        const nextSegment = pathSegments[i + 1];
        const parsedId = parseInt(nextSegment, 10);
        if (!isNaN(parsedId)) {
          id = parsedId;
        } else {
          id = null
        }
      }
    }
    this.recordId = id;

    return this.recordId;
  }
}
