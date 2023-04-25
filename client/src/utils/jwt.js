export const decodeJWT = token => {
  if (token.split('.').length !== 3) {
    throw new Error('token is invalid');
  }

  const [, encodedPayload] = token.split('.');

  const payload = JSON.parse(atob(encodedPayload));

  return payload;
};
