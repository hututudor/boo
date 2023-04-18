import { loadBookImages, registerSidebarEvents } from '../components';

export const load = () => {
  registerSidebarEvents();
  loadBookImages();
};
