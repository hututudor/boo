import { sleep } from '../utils/time';

export const login = async ({ email, password }) => {
  await sleep(500);

  return {
    token: '12344',
  };
};

export const register = async ({ email, name, password }) => {
  await sleep(500);

  return {
    token: '12344',
  };
};
