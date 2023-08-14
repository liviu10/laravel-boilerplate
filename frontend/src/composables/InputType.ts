import { computed } from 'vue';
import { InputType } from 'src/types/InputType';

/**
 * Get the type of the input.
 * @param {string} type
 * @returns {string} The type of the input.
 */
const inputType = computed(() => {
  return ((type: string): InputType => {
    switch (type) {
      case 'number':
        return 'number';
      case 'textarea':
        return 'textarea';
      case 'time':
        return 'time';
      case 'text':
        return 'text';
      case 'password':
        return 'password';
      case 'email':
        return 'email';
      case 'search':
        return 'search';
      case 'tel':
        return 'tel';
      case 'file':
        return 'file';
      case 'url':
        return 'url';
      case 'date':
        return 'date';
      default:
        return undefined;
    }
  })
});

export {
  inputType,
}
