export default interface AdminMenuInterface {
  count: number;
  menu: {
    path: string;
    name: string;
    component: string;
    children?: {
      path: string;
      name: string;
      component: string;
      meta: {
        title: string;
        caption: string;
        icon: string;
      };
    }[];
  };
}
