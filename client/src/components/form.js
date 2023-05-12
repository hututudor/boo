export const setFormError = (formNode, value) => {
  formNode.querySelector('div[id=error]').innerHTML = value;
};
