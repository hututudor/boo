export const loadBookImages = () => {
  const elements = document.getElementsByClassName('book_card-image');

  for (const element of elements) {
    if (!element.dataset.src) {
      console.warn('book without source found');
      continue;
    }

    element.style.backgroundImage = `url(${element.dataset.src})`;
  }
};
