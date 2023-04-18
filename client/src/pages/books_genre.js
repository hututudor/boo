import { registerSidebarEvents, loadBookImages } from '../components';

export const load = () => {
  registerSidebarEvents();
  loadBookImages();
};
