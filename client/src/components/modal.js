export const showModal = id => {
  const modalElement = document.getElementById(id);

  if (!modalElement) {
    console.warn(`no modal with id ${id} on this page`);
    return;
  }

  if (modalElement.classList.contains('modal__hidden')) {
    modalElement.classList.remove('modal__hidden');
  }
};

export const hideModal = id => {
  const modalElement = document.getElementById(id);

  if (!modalElement) {
    console.warn(`no modal with id ${id} on this page`);
    return;
  }

  if (!modalElement.classList.contains('modal__hidden')) {
    modalElement.classList.add('modal__hidden');
  }
};
