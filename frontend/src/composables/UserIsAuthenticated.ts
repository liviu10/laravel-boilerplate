import { computed } from 'vue';
import { UserInterface } from 'src/interfaces/UserInterface';

/**
 * Check if a user is authenticated and return their full name if available.
 * @param {UserInterface | undefined} userObject - The user object.
 * @returns {string | boolean} The user's full name or false if not authenticated.
 */
const userIsAuthenticated = computed(() => {
  return ((userObject: UserInterface | undefined): string | boolean => {
    if (userObject && userObject !== undefined) {
      if (Object.keys(userObject).length && Object.hasOwnProperty('full_name')) {
        return userObject.full_name
      } else {
        return false;
      }
    } else {
      return false;
    }
  });
});

export {
  userIsAuthenticated
}
