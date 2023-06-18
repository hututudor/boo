import { getAnalytics } from '../api/analytics';
import { loadBookImages, renderSidebar } from '../components';

export const load = async () => {
  renderSidebar();

  await displayAnalytics();
};

const displayAnalytics = async () => {
  const { reading, read, toRead, reviews } = await getAnalytics();
  document.getElementById('analytics-progress').innerHTML = reading;
  document.getElementById('analytics-read').innerHTML = read;
  document.getElementById('analytics-want-to-read').innerHTML = toRead;
  document.getElementById('analytics-reviews').innerHTML = reviews;
};
