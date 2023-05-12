export const showPageLoading = () => {
  const loadingElement = getLoadingElement();

  if (!loadingElement) {
    console.warn('no loading element on this page');
    return;
  }

  if (loadingElement.classList.contains('loading__hidden')) {
    loadingElement.classList.remove('loading__hidden');
  }
};

export const hidePageLoading = () => {
  const loadingElement = getLoadingElement();

  if (!loadingElement) {
    console.warn('no loading element on this page');
    return;
  }

  if (!loadingElement.classList.contains('loading__hidden')) {
    loadingElement.classList.add('loading__hidden');
  }
};

const getLoadingElement = () => {
  return document.getElementById('loading');
};
