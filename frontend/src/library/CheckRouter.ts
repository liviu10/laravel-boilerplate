import { RouteRecordName } from 'vue-router';

const adminHomePageName = 'HomePage'

function checkCurrentRouteName(currentRouteName: RouteRecordName | null | undefined): boolean {
  if (currentRouteName && typeof currentRouteName === 'string') {
    if (currentRouteName === adminHomePageName) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

export { checkCurrentRouteName };
