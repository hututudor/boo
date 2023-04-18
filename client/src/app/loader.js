import { pagesConfig } from './pagesConfig';

export const load = () => {
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
  pageConfig.load();
};

const getPageName = () =>
  document.querySelector('meta[name="page-name"]')?.getAttribute('content');
