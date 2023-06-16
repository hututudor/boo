export const loadFormFiles = () => {
  const formFiles = document.getElementsByClassName('form-file');

  for (const formFile of formFiles) {
    const fileInput = formFile.getElementsByTagName('input')[0];

    if (!formFile.getElementsByTagName('input')[0]) {
      console.error('file input not found');
      return;
    }

    if (!formFile.getElementsByTagName('div')[0]) {
      console.error('file display not found');
      return;
    }

    formFile.addEventListener('click', handleFileOpen);
    fileInput.addEventListener('change', handleFileChange);
  }
};

const handleFileChange = event => {
  const formFile = event.currentTarget.parentElement;
  const formDisplay = formFile.getElementsByTagName('div')[0];
  const fileInput = formFile.getElementsByTagName('input')[0];

  formDisplay.innerHTML = fileInput.files[0].name;
};

const handleFileOpen = event => {
  const fileInput = event.currentTarget.getElementsByTagName('input')[0];

  fileInput.click();
};
