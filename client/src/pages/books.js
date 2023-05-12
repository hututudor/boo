import { registerSidebarEvents, loadBookImages } from '../components';
import { sleep } from '../utils/time';

export const load = async () => {
  registerSidebarEvents();
  loadBookImages();

  await sleep(1000);
};
