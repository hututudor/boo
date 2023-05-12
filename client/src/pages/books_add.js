import { registerSidebarEvents, loadFormFiles } from '../components';

export const load = () => {
  registerSidebarEvents();
  loadFormFiles();
};
