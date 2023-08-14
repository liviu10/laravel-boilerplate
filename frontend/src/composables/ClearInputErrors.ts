import { computed } from 'vue';
import { CreateModelInterface } from 'src/interfaces/ApiResponseInterface';

/**
 * Clear input type errors.
 * @param {CreateModelInterface} dataModel
 * @returns {void}.
 */
const clearInputErrors = computed(() => {
  return ((dataModel: CreateModelInterface[]): void => {
    dataModel.forEach((item: CreateModelInterface) => {
      if (item.errors && item.errors !== undefined) {
        item.errors = undefined
      }
    })
  })
});

export {
  clearInputErrors,
}
