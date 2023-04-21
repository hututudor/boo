export const isEmailValid = value =>
  /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value);
