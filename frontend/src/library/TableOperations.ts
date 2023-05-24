import { useRouter } from 'vue-router';

/**
 * This function will display a generic message when the table is loading.
 */
function displayTableNoDataLabel(): string {
  return 'Loading resource! Please wait!';
}

/**
 * This function will set a generic number of records per page.
 */
function displayTableRowsPerPage(): number[] {
  return [10, 20, 30, 50, 0];
}

/**
 * This function will display a generic table title.
 */
function displayTableTitle(): string {
  const router = useRouter();
  if (router && router.currentRoute.value.meta && typeof router.currentRoute.value.meta === 'object' && (router.currentRoute.value.meta as { title: string }).title) {
    const resourceTitle: string = (router.currentRoute.value.meta as { title: string }).title
    return resourceTitle;
  } else {
    return 'Table title';
  }
}

/**
 * This function will display a generic table description.
 */
function displayTableDescription(description: string | undefined): string {
  if (description !== undefined) {
    return description;
  } else {
    return 'Generic table description';
  }
}

/**
 * This function will check weather or not the selected record was deleted.
 */
function checkDeletedRecord(record: { [key: string]: unknown; }[] | undefined) {
  if (record && record.length) {
    if ('deleted_at' in record[0] && record[0].deleted_at !== null) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

export {
  displayTableNoDataLabel,
  displayTableRowsPerPage,
  displayTableTitle,
  displayTableDescription,
  checkDeletedRecord,
};
