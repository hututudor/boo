export const setInputError = (inputNode, value) => {
  inputNode.parentNode.querySelector('span').innerHTML = value;
};
