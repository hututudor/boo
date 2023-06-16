import { hidePageLoading, showPageLoading } from '../components';
import { pagesConfig } from './pagesConfig';

export const load = async () => {
  const pageName = getPageName();

  if (!pageName) {
    console.error('** PAGE UNKNOWN! Please add meta tag **');
    return;
  }

  const pageConfig = pagesConfig[pageName];

  if (!pageConfig) {
    console.error(`** PAGE CONFIG UNKNOWN! Page: ${pageName} **`);
    return;
  }

  // load current page
  showPageLoading();
  await pageConfig.load();
  hidePageLoading();
};

export const getPageName = () =>
  document.querySelector('meta[name="page-name"]')?.getAttribute('content');
